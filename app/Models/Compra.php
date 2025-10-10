<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_compra',
        'proveedor_id',
        'fecha_compra',
        'fecha_entrega',
        'tipo_comprobante',
        'numero_comprobante',
        'subtotal',
        'descuento',
        'igv',
        'total',
        'estado',
        'estado_pago',
        'saldo_pendiente',
        'fecha_vencimiento_pago',
        'observaciones',
        'comprador_id',
        'metodo_pago',
        'referencia_pago'
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_entrega' => 'date',
        'fecha_vencimiento_pago' => 'date',
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2'
    ];

    // Relaciones
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function comprador()
    {
        return $this->belongsTo(User::class, 'comprador_id');
    }

    public function detalles()
    {
        return $this->hasMany(CompraDetalle::class);
    }

    public function pagos()
    {
        return $this->hasMany(CompraPago::class);
    }

    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class, 'orden_compra_id');
    }

    // Accessors
    public function getTipoComprobanteTextoAttribute()
    {
        $tipos = [
            'factura' => 'Factura',
            'boleta' => 'Boleta',
            'recibo' => 'Recibo',
            'nota_credito' => 'Nota de Crédito',
            'nota_debito' => 'Nota de Débito'
        ];

        return $tipos[$this->tipo_comprobante] ?? 'No especificado';
    }

    public function getEstadoTextoAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente',
            'procesando' => 'Procesando',
            'recibido' => 'Recibido',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ];

        return $estados[$this->estado] ?? 'No especificado';
    }

    public function getEstadoPagoTextoAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente',
            'parcial' => 'Pago Parcial',
            'pagado' => 'Pagado',
            'vencido' => 'Vencido'
        ];

        return $estados[$this->estado_pago] ?? 'No especificado';
    }

    // Scopes
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopePendientes($query)
    {
        return $query->whereIn('estado', ['pendiente', 'procesando']);
    }

    public function scopePagadas($query)
    {
        return $query->where('estado_pago', 'pagado');
    }

    public function scopePorPagar($query)
    {
        return $query->whereIn('estado_pago', ['pendiente', 'parcial']);
    }

    public function scopeVencidas($query)
    {
        return $query->where('fecha_vencimiento_pago', '<', now())
                   ->where('estado_pago', '!=', 'pagado');
    }

    // Métodos
    public function calcularTotales()
    {
        $subtotal = $this->detalles->sum(function($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        });

        $descuento = $this->calcularDescuento($subtotal);
        $subtotalConDescuento = $subtotal - $descuento;
        $igv = $subtotalConDescuento * 0.18; // IGV 18%
        $total = $subtotalConDescuento + $igv;

        $this->update([
            'subtotal' => $subtotal,
            'descuento' => $descuento,
            'igv' => $igv,
            'total' => $total,
            'saldo_pendiente' => $total
        ]);

        return $this;
    }

    private function calcularDescuento($subtotal)
    {
        $descuentoProveedor = $this->proveedor->descuento_habitual ?? 0;
        return $subtotal * ($descuentoProveedor / 100);
    }

    public function aplicarPago($monto, $metodo = 'transferencia', $referencia = null)
    {
        $this->pagos()->create([
            'monto' => $monto,
            'metodo_pago' => $metodo,
            'referencia' => $referencia,
            'fecha_pago' => now()
        ]);

        $totalPagado = $this->pagos->sum('monto');
        $saldoPendiente = $this->total - $totalPagado;

        $this->update([
            'saldo_pendiente' => $saldoPendiente,
            'estado_pago' => $saldoPendiente <= 0 ? 'pagado' : 'parcial'
        ]);

        return $this;
    }

    public function recibirMercancia()
    {
        if ($this->estado !== 'recibido') {
            $this->update(['estado' => 'recibido']);

            // Actualizar inventario con los productos recibidos
            foreach ($this->detalles as $detalle) {
                if ($detalle->producto) {
                    $detalle->producto->aumentarStock($detalle->cantidad, 'compra', "Compra #{$this->numero_compra}");
                }
            }
        }

        return $this;
    }

    public function generarNumeroCompra()
    {
        $año = date('Y');
        $query = static::query();
        $ultimaCompra = \App\Helpers\DatabaseHelper::whereYear($query, 'created_at', $año)->orderBy('id', 'desc')->first();
        $siguiente = $ultimaCompra ? (int)substr($ultimaCompra->numero_compra, -6) + 1 : 1;

        return 'C' . $año . str_pad($siguiente, 6, '0', STR_PAD_LEFT);
    }
}
