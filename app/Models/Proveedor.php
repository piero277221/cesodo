<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'ruc',
        'razon_social',
        'nombre_comercial',
        'telefono',
        'email',
        'direccion',
        'contacto',
        'estado',
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    // Accessor para usar 'nombre' como alias de razon_social
    public function getNombreAttribute()
    {
        return $this->razon_social ?: $this->nombre_comercial;
    }

    // Accessor para 'activo' basado en estado
    public function getActivoAttribute()
    {
        return $this->estado === 'activo';
    }

    /**
     * Relaciones
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    /**
     * Scopes
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
