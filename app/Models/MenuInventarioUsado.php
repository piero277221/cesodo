<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuInventarioUsado extends Model
{
    use HasFactory;

    protected $table = 'menu_inventario_usado';

    protected $fillable = [
        'menu_id',
        'producto_id',
        'cantidad_total_usada',
        'cantidad_disponible_antes',
        'cantidad_disponible_despues',
        'fecha_uso',
        'user_id',
    ];

    protected $casts = [
        'cantidad_total_usada' => 'decimal:3',
        'cantidad_disponible_antes' => 'decimal:3',
        'cantidad_disponible_despues' => 'decimal:3',
        'fecha_uso' => 'datetime',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
