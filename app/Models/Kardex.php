<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';

    protected $fillable = [
        'producto_id',
        'fecha',
        'tipo_movimiento',
        'modulo',
        'concepto',
        'numero_documento',
        'cantidad_entrada',
        'cantidad_salida',
        'precio_unitario',
        'saldo_cantidad',
        'saldo_valor',
        'observaciones',
        'user_id',
        'referencia_tipo',
        'referencia_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'cantidad_entrada' => 'integer',
        'cantidad_salida' => 'integer',
        'precio_unitario' => 'decimal:2',
        'saldo_cantidad' => 'integer',
        'saldo_valor' => 'decimal:2',
    ];

    // Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeEntradas($query)
    {
        return $query->where('tipo_movimiento', 'entrada');
    }

    public function scopeSalidas($query)
    {
        return $query->where('tipo_movimiento', 'salida');
    }

    public function scopeAjustes($query)
    {
        return $query->where('tipo_movimiento', 'ajuste');
    }

    public function scopePorProducto($query, $productoId)
    {
        return $query->where('producto_id', $productoId);
    }

    public function scopePorFecha($query, $fechaDesde, $fechaHasta = null)
    {
        $query->where('fecha', '>=', $fechaDesde);

        if ($fechaHasta) {
            $query->where('fecha', '<=', $fechaHasta);
        }

        return $query;
    }

    // Accessors para la UI
    public function getColorTipoAttribute()
    {
        return match($this->tipo_movimiento) {
            'entrada' => 'success',
            'salida' => 'danger',
            'ajuste' => 'warning',
            default => 'secondary'
        };
    }

    public function getIconoTipoAttribute()
    {
        return match($this->tipo_movimiento) {
            'entrada' => 'fas fa-arrow-up',
            'salida' => 'fas fa-arrow-down',
            'ajuste' => 'fas fa-balance-scale',
            default => 'fas fa-circle'
        };
    }
}
