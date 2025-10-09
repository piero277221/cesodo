<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_venta',
        'cliente_id',
        'fecha_venta',
        'tipo_comprobante',
        'numero_comprobante',
        'subtotal',
        'descuento',
        'igv',
        'total',
        'estado',
        'estado_pago',
        'saldo_pendiente',
        'fecha_vencimiento',
        'observaciones',
        'vendedor_id',
        'metodo_pago',
        'referencia_pago'
    ];

    protected $casts = [
        'fecha_venta' => 'date',
        'fecha_vencimiento' => 'date',
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2'
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    public function pagos()
    {
        return $this->hasMany(VentaPago::class);
    }

    // Accessors
    public function getTipoComprobanteTextoAttribute()
    {
        $tipos = [
            'boleta' => 'Boleta de Venta',
            'factura' => 'Factura',
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
            'completado' => 'Completado',
            'cancelado' => 'Cancelado',
            'anulado' => 'Anulado'
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
        return $query->where('fecha_vencimiento', '<', now())
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
            'total' => $total
        ]);

        return $this;
    }

    private function calcularDescuento($subtotal)
    {
        $descuentoCliente = $this->cliente->descuento_habitual ?? 0;
        return $subtotal * ($descuentoCliente / 100);
    }

    public function aplicarPago($monto, $metodo = 'efectivo', $referencia = null)
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
}
