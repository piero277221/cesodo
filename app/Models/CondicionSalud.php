<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CondicionSalud extends Model
{
    use HasFactory;

    protected $table = 'condiciones_salud';

    protected $fillable = [
        'nombre',
        'descripcion',
        'restricciones_alimentarias',
        'activo',
    ];

    protected $casts = [
        'restricciones_alimentarias' => 'array',
        'activo' => 'boolean',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_condiciones')
            ->withPivot('porciones', 'observaciones')
            ->withTimestamps();
    }

    public function productosAlternativos()
    {
        return $this->hasMany(MenuItemProductoAlternativo::class);
    }

    // Verificar si un producto está restringido
    public function esProductoRestringido($productoId)
    {
        if (!$this->restricciones_alimentarias) {
            return false;
        }

        return in_array($productoId, $this->restricciones_alimentarias);
    }

    // Obtener productos restringidos con nombres
    public function getProductosRestringidosAttribute()
    {
        if (!$this->restricciones_alimentarias) {
            return collect();
        }

        return Producto::whereIn('id', $this->restricciones_alimentarias)->get();
    }
}
