<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_items';

    protected $fillable = [
        'menu_id',
        'dia',          // lunes..domingo
        'tiempo',       // desayuno, almuerzo, cena
        'titulo',       // nombre del plato
        'descripcion',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'menu_item_producto')
            ->withPivot(['cantidad', 'unidad'])
            ->withTimestamps();
    }

    public function productosAlternativos()
    {
        return $this->hasMany(MenuItemProductoAlternativo::class);
    }

    // Obtener productos alternativos para una condición específica
    public function getProductosParaCondicion($condicionSaludId)
    {
        return $this->productosAlternativos()
            ->where('condicion_salud_id', $condicionSaludId)
            ->with('producto')
            ->get();
    }

    // Verificar si tiene alternativas para condiciones de salud
    public function tieneAlternativasEspeciales()
    {
        return $this->productosAlternativos()->count() > 0;
    }
}
