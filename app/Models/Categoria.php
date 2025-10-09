<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    /**
     * Relaciones
     */
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
