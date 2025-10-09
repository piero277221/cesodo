<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItemProductoAlternativo extends Model
{
    use HasFactory;

    protected $table = 'menu_item_producto_alternativo';

    protected $fillable = [
        'menu_item_id',
        'condicion_salud_id',
        'producto_id',
        'cantidad',
        'unidad',
        'observaciones',
    ];

    protected $casts = [
        'cantidad' => 'decimal:3',
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function condicionSalud()
    {
        return $this->belongsTo(CondicionSalud::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
