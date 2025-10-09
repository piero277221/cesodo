<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'producto_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'descuento_item',
        'subtotal',
        'cantidad_recibida',
        'fecha_vencimiento'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'cantidad_recibida' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'descuento_item' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'fecha_vencimiento' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        // Cuando se crea un detalle de compra, registrar movimiento de kardex
        static::created(function ($detalle) {
            $detalle->registrarMovimientoKardexCompra();
        });

        // Cuando se actualiza un detalle de compra, ajustar kardex
        static::updated(function ($detalle) {
            if ($detalle->wasChanged(['cantidad', 'cantidad_recibida', 'precio_unitario'])) {
                $detalle->registrarMovimientoKardexActualizacion();
            }
        });
    }

    /**
     * Registrar movimiento de kardex cuando se crea una compra
     */
    public function registrarMovimientoKardexCompra()
    {
        if ($this->cantidad > 0 && $this->producto_id) {
            $user = auth()->user() ?: \App\Models\User::first();

            // Obtener último saldo del kardex
            $ultimoKardex = \App\Models\Kardex::where('producto_id', $this->producto_id)
                ->orderBy('fecha', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $saldoActual = $ultimoKardex ? $ultimoKardex->saldo_cantidad : 0;
            $nuevoSaldo = $saldoActual + $this->cantidad;
            $precioUnitario = $this->precio_unitario;
            $valorIngreso = $this->cantidad * $precioUnitario;
            $valorAnterior = $ultimoKardex ? $ultimoKardex->saldo_valor : 0;
            $nuevoValor = $valorAnterior + $valorIngreso;

            \App\Models\Kardex::create([
                'producto_id' => $this->producto_id,
                'fecha' => $this->compra->fecha_compra ?? now(),
                'tipo_movimiento' => 'entrada',
                'modulo' => 'compras',
                'concepto' => 'Compra - ' . ($this->compra->numero_compra ?? 'Sin número'),
                'numero_documento' => $this->compra->numero_comprobante ?? ('COMP-' . $this->compra_id),
                'cantidad_entrada' => $this->cantidad,
                'cantidad_salida' => 0,
                'precio_unitario' => $precioUnitario,
                'saldo_cantidad' => $nuevoSaldo,
                'saldo_valor' => $nuevoValor,
                'observaciones' => 'Ingreso automático por compra - ' . ($this->descripcion ?? $this->producto->nombre ?? 'Producto'),
                'user_id' => $user->id,
                'referencia_tipo' => 'compra_detalle',
                'referencia_id' => $this->id,
            ]);

            // Actualizar stock en inventario si existe
            $this->actualizarStockInventario($this->cantidad);
        }
    }

    /**
     * Registrar movimiento de kardex cuando se actualiza una compra
     */
    public function registrarMovimientoKardexActualizacion()
    {
        if (!$this->producto_id) return;

        $cantidadAnterior = $this->getOriginal('cantidad') ?? 0;
        $cantidadActual = $this->cantidad;
        $diferencia = $cantidadActual - $cantidadAnterior;

        if ($diferencia != 0) {
            $user = auth()->user() ?: \App\Models\User::first();

            // Obtener último saldo del kardex
            $ultimoKardex = \App\Models\Kardex::where('producto_id', $this->producto_id)
                ->orderBy('fecha', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $saldoActual = $ultimoKardex ? $ultimoKardex->saldo_cantidad : 0;
            $nuevoSaldo = $saldoActual + $diferencia;
            $precioUnitario = $this->precio_unitario;
            $valorMovimiento = abs($diferencia) * $precioUnitario;
            $valorAnterior = $ultimoKardex ? $ultimoKardex->saldo_valor : 0;
            $nuevoValor = $diferencia > 0
                ? $valorAnterior + $valorMovimiento
                : $valorAnterior - $valorMovimiento;

            \App\Models\Kardex::create([
                'producto_id' => $this->producto_id,
                'fecha' => now(),
                'tipo_movimiento' => $diferencia > 0 ? 'entrada' : 'salida',
                'modulo' => 'compras',
                'concepto' => $diferencia > 0
                    ? 'Ajuste positivo - Compra modificada'
                    : 'Ajuste negativo - Compra modificada',
                'numero_documento' => ($this->compra->numero_comprobante ?? 'COMP-' . $this->compra_id) . '-AJU',
                'cantidad_entrada' => $diferencia > 0 ? $diferencia : 0,
                'cantidad_salida' => $diferencia < 0 ? abs($diferencia) : 0,
                'precio_unitario' => $precioUnitario,
                'saldo_cantidad' => $nuevoSaldo,
                'saldo_valor' => $nuevoValor,
                'observaciones' => 'Ajuste automático por modificación de compra',
                'user_id' => $user->id,
                'referencia_tipo' => 'compra_detalle',
                'referencia_id' => $this->id,
            ]);

            // Actualizar stock en inventario
            $this->actualizarStockInventario($diferencia);
        }
    }

    /**
     * Actualizar stock en inventario
     */
    private function actualizarStockInventario($cantidad)
    {
        $inventario = \App\Models\Inventario::where('producto_id', $this->producto_id)->first();

        if ($inventario) {
            $inventario->increment('stock_actual', $cantidad);
            $inventario->update(['fecha_ultimo_movimiento' => now()]);
        } else {
            // Crear registro de inventario si no existe
            \App\Models\Inventario::create([
                'producto_id' => $this->producto_id,
                'stock_actual' => max(0, $cantidad),
                'stock_minimo' => 10,
                'fecha_ultimo_movimiento' => now(),
            ]);
        }
    }

    // Relaciones
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Métodos
    public function calcularSubtotal()
    {
        $subtotal = $this->cantidad * $this->precio_unitario - $this->descuento_item;
        $this->update(['subtotal' => $subtotal]);
        return $subtotal;
    }

    public function getPendienteRecepcionAttribute()
    {
        return $this->cantidad - ($this->cantidad_recibida ?? 0);
    }
}

class CompraPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'monto',
        'metodo_pago',
        'referencia',
        'fecha_pago',
        'observaciones'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime'
    ];

    // Relaciones
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    // Accessors
    public function getMetodoPagoTextoAttribute()
    {
        $metodos = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia',
            'cheque' => 'Cheque',
            'tarjeta' => 'Tarjeta',
            'credito' => 'Crédito'
        ];

        return $metodos[$this->metodo_pago] ?? 'No especificado';
    }
}

class OrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'ordenes_compra';

    protected $fillable = [
        'numero_orden',
        'proveedor_id',
        'fecha_orden',
        'fecha_entrega_esperada',
        'estado',
        'total_estimado',
        'observaciones',
        'solicitante_id',
        'aprobador_id',
        'fecha_aprobacion'
    ];

    protected $casts = [
        'fecha_orden' => 'date',
        'fecha_entrega_esperada' => 'date',
        'fecha_aprobacion' => 'datetime',
        'total_estimado' => 'decimal:2'
    ];

    // Relaciones
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobador_id');
    }

    public function detalles()
    {
        return $this->hasMany(OrdenCompraDetalle::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    // Accessors
    public function getEstadoTextoAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente de Aprobación',
            'aprobada' => 'Aprobada',
            'enviada' => 'Enviada al Proveedor',
            'recibida' => 'Mercancía Recibida',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada'
        ];

        return $estados[$this->estado] ?? 'No especificado';
    }

    // Métodos
    public function aprobar($aprobadorId)
    {
        $this->update([
            'estado' => 'aprobada',
            'aprobador_id' => $aprobadorId,
            'fecha_aprobacion' => now()
        ]);

        return $this;
    }

    public function convertirACompra()
    {
        if ($this->estado !== 'aprobada') {
            throw new \Exception('La orden debe estar aprobada para convertir a compra');
        }

        $compra = Compra::create([
            'numero_compra' => (new Compra())->generarNumeroCompra(),
            'orden_compra_id' => $this->id,
            'proveedor_id' => $this->proveedor_id,
            'fecha_compra' => now(),
            'fecha_entrega' => $this->fecha_entrega_esperada,
            'estado' => 'pendiente',
            'estado_pago' => 'pendiente',
            'observaciones' => $this->observaciones,
            'comprador_id' => auth()->id()
        ]);

        // Copiar detalles
        foreach ($this->detalles as $detalle) {
            $compra->detalles()->create([
                'producto_id' => $detalle->producto_id,
                'descripcion' => $detalle->descripcion,
                'cantidad' => $detalle->cantidad,
                'precio_unitario' => $detalle->precio_unitario
            ]);
        }

        $compra->calcularTotales();

        $this->update(['estado' => 'enviada']);

        return $compra;
    }
}

class OrdenCompraDetalle extends Model
{
    use HasFactory;

    protected $table = 'orden_compra_detalles';

    protected $fillable = [
        'orden_compra_id',
        'producto_id',
        'descripcion',
        'cantidad',
        'precio_unitario_estimado',
        'subtotal_estimado'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario_estimado' => 'decimal:2',
        'subtotal_estimado' => 'decimal:2'
    ];

    // Relaciones
    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
