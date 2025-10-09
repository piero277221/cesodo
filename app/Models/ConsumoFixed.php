<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consumo extends Model
{
    use HasFactory;

    protected $table = 'consumos';

    protected $fillable = [
        'trabajador_id',
        'fecha_consumo',
        'hora_consumo',
        'tipo_comida',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'fecha_consumo' => 'datetime:Y-m-d',
        'hora_consumo' => 'datetime:H:i',
    ];

    // Eventos automáticos
    protected static function boot()
    {
        parent::boot();

        static::created(function (self $consumo) {
            $consumo->registrarMovimientoKardex();
        });
    }

    // Registrar movimiento automático en el kardex de consumos
    public function registrarMovimientoKardex(): void
    {
        // Verificar que existan los modelos antes de usarlos
        if (!class_exists('App\Models\Producto') || !class_exists('App\Models\Kardex')) {
            return; // Salir silenciosamente si los modelos no existen
        }

        $productosAlimentos = \App\Models\Producto::whereHas('categoria', function($q) {
            $q->where('nombre', 'Alimentos');
        })->get();

        foreach ($productosAlimentos as $producto) {
            $cantidad = $this->getCantidadPorProducto($producto);

            $ultimoKardex = \App\Models\Kardex::where('producto_id', $producto->id)
                ->where('modulo', 'consumos')
                ->orderBy('fecha', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $saldoActual = $ultimoKardex?->saldo_cantidad ?? 0;

            if ($saldoActual < $cantidad) {
                $this->transferirDesdeInventario($producto, $cantidad);

                $ultimoKardex = \App\Models\Kardex::where('producto_id', $producto->id)
                    ->where('modulo', 'consumos')
                    ->orderBy('fecha', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();
                $saldoActual = $ultimoKardex?->saldo_cantidad ?? 0;
            }

            if ($saldoActual >= $cantidad) {
                $nuevoSaldo = $saldoActual - $cantidad;
                $precioUnitario = $ultimoKardex
                    ? ($ultimoKardex->saldo_cantidad > 0
                        ? ($ultimoKardex->saldo_valor / max(1, $ultimoKardex->saldo_cantidad))
                        : ($ultimoKardex->precio_unitario ?? ($producto->precio ?? 25)))
                    : ($producto->precio ?? 25);
                $nuevoValor = $nuevoSaldo * $precioUnitario;

                \App\Models\Kardex::create([
                    'producto_id' => $producto->id,
                    'fecha' => $this->fecha_consumo,
                    'tipo_movimiento' => 'salida',
                    'modulo' => 'consumos',
                    'concepto' => 'Consumo automático - ' . $this->tipo_comida,
                    'numero_documento' => 'CONS-AUTO-' . $this->id . '-' . $producto->id,
                    'cantidad_entrada' => 0,
                    'cantidad_salida' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'saldo_cantidad' => $nuevoSaldo,
                    'saldo_valor' => $nuevoValor,
                    'observaciones' => "Consumo automático: {$this->trabajador->nombres} - {$this->tipo_comida}",
                    'user_id' => $this->user_id,
                ]);
            }
        }
    }

    // Transferir automáticamente desde inventario
    private function transferirDesdeInventario($producto, float $cantidadMinima): void
    {
        if (!class_exists('App\Models\Kardex')) {
            return;
        }

        $cantidadTransferencia = max(50.0, $cantidadMinima * 10); // Transferir para varios días
        $precioUnitario = $producto->precio ?? 25;

        $ultimoKardexConsumos = \App\Models\Kardex::where('producto_id', $producto->id)
            ->where('modulo', 'consumos')
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $saldoActualConsumos = $ultimoKardexConsumos?->saldo_cantidad ?? 0;
        $saldoActualValor = $ultimoKardexConsumos?->saldo_valor ?? 0;

        $nuevoSaldoConsumos = $saldoActualConsumos + $cantidadTransferencia;
        $nuevoValorConsumos = $saldoActualValor + ($cantidadTransferencia * $precioUnitario);

        \App\Models\Kardex::create([
            'producto_id' => $producto->id,
            'fecha' => now(),
            'tipo_movimiento' => 'entrada',
            'modulo' => 'consumos',
            'concepto' => 'Transferencia automática desde inventario',
            'numero_documento' => 'TRANS-AUTO-' . time() . '-' . $producto->id,
            'cantidad_entrada' => $cantidadTransferencia,
            'cantidad_salida' => 0,
            'precio_unitario' => $precioUnitario,
            'saldo_cantidad' => $nuevoSaldoConsumos,
            'saldo_valor' => $nuevoValorConsumos,
            'observaciones' => 'Transferencia automática para cubrir consumos',
            'user_id' => $this->user_id,
        ]);
    }

    // Calcular cantidad estándar por producto según el tipo de comida
    private function getCantidadPorProducto($producto): float
    {
        $cantidades = [
            'desayuno' => [
                'pan' => 2.0,
                'leche' => 0.25,
                'café' => 0.02,
                'azúcar' => 0.02,
                'mantequilla' => 0.01,
                'mermelada' => 0.02
            ],
            'almuerzo' => [
                'arroz' => 0.15,
                'carne' => 0.12,
                'pollo' => 0.12,
                'verduras' => 0.1,
                'aceite' => 0.02,
                'sal' => 0.005
            ],
            'cena' => [
                'pan' => 1.0,
                'té' => 0.002,
                'queso' => 0.03,
                'jamón' => 0.03
            ]
        ];

        $tipoComida = strtolower($this->tipo_comida);
        $nombreProducto = strtolower($producto->nombre);

        foreach ($cantidades[$tipoComida] ?? [] as $nombre => $cantidad) {
            if (str_contains($nombreProducto, $nombre)) {
                return $cantidad;
            }
        }

        return 0.05; // Cantidad por defecto
    }

    // Relaciones
    public function trabajador(): BelongsTo
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_consumo', today());
    }

    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_consumo', [$fechaInicio, $fechaFin]);
    }

    public function scopePorTipoComida($query, $tipo)
    {
        return $query->where('tipo_comida', $tipo);
    }

    // Accessors
    public function getFechaHoraAttribute(): string
    {
        $f = $this->fecha_consumo instanceof \DateTimeInterface
            ? $this->fecha_consumo->format('d/m/Y')
            : (string) $this->fecha_consumo;
        $h = $this->hora_consumo instanceof \DateTimeInterface
            ? $this->hora_consumo->format('H:i')
            : (string) $this->hora_consumo;
        return $f . ' ' . $h;
    }
}
