<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'stock_actual',
        'stock_reservado',
        'stock_disponible',
        'fecha_ultimo_movimiento',
        'fecha_vencimiento',
        'lote',
    ];

    protected $casts = [
        'stock_actual' => 'decimal:2',
        'stock_reservado' => 'decimal:2',
        'stock_disponible' => 'decimal:2',
        'fecha_ultimo_movimiento' => 'date',
        'fecha_vencimiento' => 'date',
    ];

    /**
     * Boot del modelo para eventos automáticos
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($inventario) {
            $inventario->registrarMovimientoKardexEntrada();
        });

        static::updated(function ($inventario) {
            if ($inventario->isDirty('stock_actual')) {
                $inventario->registrarMovimientoKardexActualizacion();
            }
        });
    }

    /**
     * Registrar movimiento automático en el kardex de inventario al crear
     */
    public function registrarMovimientoKardexEntrada()
    {
        if ($this->stock_actual > 0) {
            // Asegurar que la relación producto esté cargada
            if (!$this->relationLoaded('producto')) {
                $this->load('producto');
            }
            $user = auth()->user() ?: \App\Models\User::first();

            Kardex::create([
                'producto_id' => $this->producto_id,
                'fecha' => $this->fecha_ultimo_movimiento ?: now(),
                'tipo_movimiento' => 'entrada',
                'modulo' => 'inventario',
                'concepto' => 'Entrada inicial de inventario',
                'numero_documento' => 'INV-AUTO-' . $this->id,
                'cantidad_entrada' => $this->stock_actual,
                'cantidad_salida' => 0,
                'precio_unitario' => $this->producto->precio_unitario,
                'saldo_cantidad' => $this->stock_actual,
                'saldo_valor' => $this->stock_actual * $this->producto->precio_unitario,
                'observaciones' => 'Entrada automática por registro de inventario',
                'user_id' => $user->id,
            ]);
        }
    }

    /**
     * Registrar movimiento automático en el kardex de inventario al actualizar
     */
    public function registrarMovimientoKardexActualizacion()
    {
        // Asegurar que la relación producto esté cargada
        if (!$this->relationLoaded('producto')) {
            $this->load('producto');
        }

        $stockAnterior = $this->getOriginal('stock_actual');
        $stockActual = $this->stock_actual;
        $diferencia = $stockActual - $stockAnterior;

        if ($diferencia != 0) {
            $user = auth()->user() ?: \App\Models\User::first();

            // Obtener último saldo del kardex de inventario
            $ultimoKardex = Kardex::where('producto_id', $this->producto_id)
                ->where('modulo', 'inventario')
                ->orderBy('fecha', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $saldoActual = $ultimoKardex ? $ultimoKardex->saldo_cantidad : 0;
            $nuevoSaldo = $saldoActual + $diferencia;
            $precioUnitario = $ultimoKardex ? $ultimoKardex->precio_unitario : $this->producto->precio_unitario;
            $nuevoValor = $nuevoSaldo * $precioUnitario;

            Kardex::create([
                'producto_id' => $this->producto_id,
                'fecha' => now(),
                'tipo_movimiento' => $diferencia > 0 ? 'entrada' : 'salida',
                'modulo' => 'inventario',
                'concepto' => $diferencia > 0 ? 'Ajuste positivo de inventario' : 'Ajuste negativo de inventario',
                'numero_documento' => 'AJU-AUTO-' . $this->id . '-' . time(),
                'cantidad_entrada' => $diferencia > 0 ? $diferencia : 0,
                'cantidad_salida' => $diferencia < 0 ? abs($diferencia) : 0,
                'precio_unitario' => $precioUnitario,
                'saldo_cantidad' => $nuevoSaldo,
                'saldo_valor' => $nuevoValor,
                'observaciones' => 'Ajuste automático por actualización de inventario',
                'user_id' => $user->id,
            ]);
        }
    }

    /**
     * Relaciones
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Scopes
     */
    public function scopeStockBajo($query)
    {
        return $query->whereHas('producto', function ($q) {
            $q->whereRaw('inventarios.stock_disponible <= productos.stock_minimo');
        });
    }

    public function scopeProximosVencer($query, $dias = 30)
    {
        return $query->where('fecha_vencimiento', '<=', now()->addDays($dias))
                    ->where('fecha_vencimiento', '>=', now());
    }
}
