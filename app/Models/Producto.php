<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria_id',
        'unidad_medida',
        'precio_unitario',
        'stock_minimo',
        'estado',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'stock_minimo' => 'integer',
        'estado' => 'string',
    ];

    /**
     * Relaciones
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class);
    }

    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function recetaIngredientes()
    {
        return $this->hasMany(RecetaIngrediente::class);
    }

    /**
     * Scopes
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeStockBajo($query)
    {
        return $query->whereHas('inventario', function ($q) {
            $q->whereRaw('stock_disponible <= productos.stock_minimo');
        });
    }

    /**
     * Accessors
     */
    public function getStockActualAttribute()
    {
        return $this->inventario ? $this->inventario->stock_actual : 0;
    }

    public function getStockDisponibleAttribute()
    {
        return $this->inventario ? $this->inventario->stock_disponible : 0;
    }
}
