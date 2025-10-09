<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'producto_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'descuento_item',
        'subtotal'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'descuento_item' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    // Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class);
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
}

class VentaPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
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
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    // Accessors
    public function getMetodoPagoTextoAttribute()
    {
        $metodos = [
            'efectivo' => 'Efectivo',
            'tarjeta' => 'Tarjeta',
            'transferencia' => 'Transferencia',
            'cheque' => 'Cheque',
            'credito' => 'Crédito'
        ];

        return $metodos[$this->metodo_pago] ?? 'No especificado';
    }
}
