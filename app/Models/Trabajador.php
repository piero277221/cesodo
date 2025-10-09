<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajadores';

    protected $fillable = [
    'codigo',
    'nombres',
    'apellidos',
    'dni',
    'persona_id',
        'area',
        'cargo',
        'estado',
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    /**
     * Relaciones
     */
    public function consumos()
    {
        return $this->hasMany(Consumo::class);
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function usuario()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Scopes
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Accessors
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}
