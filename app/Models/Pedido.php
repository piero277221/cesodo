<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_pedido',
        'proveedor_id',
        'fecha_pedido',
        'fecha_entrega_esperada',
        'fecha_entrega_real',
        'estado',
        'total',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'fecha_pedido' => 'date',
        'fecha_entrega_esperada' => 'date',
        'fecha_entrega_real' => 'date',
        'total' => 'decimal:2',
    ];

    /**
     * Relaciones
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    /**
     * Scopes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEntregados($query)
    {
        return $query->where('estado', 'entregado');
    }

    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_pedido', [$fechaInicio, $fechaFin]);
    }

    /**
     * Mutators
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($pedido) {
            if (empty($pedido->numero_pedido)) {
                $year = date('Y');
                $query = static::query();
                $count = \App\Helpers\DatabaseHelper::whereYear($query, 'created_at', $year)->count();
                $pedido->numero_pedido = 'PED-' . $year . '-' . str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}
