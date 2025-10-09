<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'pasos_preparacion',
        'tipo_plato',
        'porciones',
        'tiempo_preparacion',
        'dificultad',
        'ingredientes_especiales',
        'es_especial',
        'estado',
        'costo_aproximado',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'pasos_preparacion' => 'array',
        'ingredientes_especiales' => 'array',
        'es_especial' => 'boolean',
        'costo_aproximado' => 'decimal:2',
        'tiempo_preparacion' => 'integer',
        'porciones' => 'integer'
    ];

    // Relaciones
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ingredientes()
    {
        return $this->hasMany(RecetaIngrediente::class);
    }

    public function recetaIngredientes()
    {
        return $this->hasMany(RecetaIngrediente::class);
    }

    public function menuPlatos()
    {
        return $this->hasMany(MenuPlato::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_platos')
                    ->withPivot([
                        'dia_semana',
                        'tipo_comida',
                        'fecha_programada',
                        'porciones_planificadas',
                        'costo_estimado',
                        'estado',
                        'observaciones'
                    ])
                    ->withTimestamps();
    }

    // Accessors y Mutators
    public function getTiposPlatoAttribute()
    {
        return [
            'entrada' => 'Entrada',
            'plato_principal' => 'Plato Principal',
            'postre' => 'Postre',
            'bebida' => 'Bebida',
            'guarnicion' => 'Guarnición',
            'sopa' => 'Sopa',
            'ensalada' => 'Ensalada'
        ];
    }

    public function getDificultadesAttribute()
    {
        return [
            'facil' => 'Fácil',
            'intermedio' => 'Intermedio',
            'dificil' => 'Difícil',
            'muy_dificil' => 'Muy Difícil'
        ];
    }

    public function getEstadosAttribute()
    {
        return [
            'activo' => 'Activo',
            'inactivo' => 'Inactivo',
            'revision' => 'En Revisión',
            'archivado' => 'Archivado'
        ];
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_plato', $tipo);
    }

    public function scopeEspeciales($query)
    {
        return $query->where('es_especial', true);
    }

    public function scopePorDificultad($query, $dificultad)
    {
        return $query->where('dificultad', $dificultad);
    }

    // Métodos auxiliares
    public function calcularCostoTotal()
    {
        $costoTotal = 0;

        foreach ($this->recetaIngredientes as $ingrediente) {
            $producto = $ingrediente->producto;
            if ($producto && $producto->inventario) {
                $costoUnitario = $producto->inventario->precio_compra;
                $costoTotal += $costoUnitario * $ingrediente->cantidad;
            }
        }

        return $costoTotal;
    }

    public function verificarDisponibilidadIngredientes($porciones = null)
    {
        $porciones = $porciones ?? $this->porciones;
        $factorMultiplicacion = $porciones / $this->porciones;

        $ingredientesNoDisponibles = [];

        foreach ($this->recetaIngredientes as $ingrediente) {
            $cantidadNecesaria = $ingrediente->cantidad * $factorMultiplicacion;
            $producto = $ingrediente->producto;

            if (!$producto || !$producto->inventario) {
                $ingredientesNoDisponibles[] = [
                    'producto' => $producto->nombre ?? 'Producto desconocido',
                    'necesario' => $cantidadNecesaria,
                    'disponible' => 0,
                    'motivo' => 'Sin inventario registrado'
                ];
                continue;
            }

            $stockDisponible = $producto->inventario->stock_actual;

            if ($stockDisponible < $cantidadNecesaria) {
                $ingredientesNoDisponibles[] = [
                    'producto' => $producto->nombre,
                    'necesario' => $cantidadNecesaria,
                    'disponible' => $stockDisponible,
                    'motivo' => 'Stock insuficiente'
                ];
            }
        }

        return [
            'disponible' => empty($ingredientesNoDisponibles),
            'ingredientes_faltantes' => $ingredientesNoDisponibles
        ];
    }

    public function puedeSerPreparada($porciones = null)
    {
        $verificacion = $this->verificarDisponibilidadIngredientes($porciones);
        return $verificacion['disponible'];
    }

    public function getIngredientesPrincipales()
    {
        return $this->recetaIngredientes()->where('es_principal', true)->get();
    }

    public function getTiempoPorPorcion()
    {
        return $this->tiempo_preparacion / $this->porciones;
    }

    public function ajustarPorciones($nuevasPorciones)
    {
        $factor = $nuevasPorciones / $this->porciones;

        $ingredientesAjustados = [];
        foreach ($this->recetaIngredientes as $ingrediente) {
            $ingredientesAjustados[] = [
                'producto_id' => $ingrediente->producto_id,
                'cantidad_original' => $ingrediente->cantidad,
                'cantidad_ajustada' => $ingrediente->cantidad * $factor,
                'unidad_medida' => $ingrediente->unidad_medida
            ];
        }

        return [
            'porciones_nuevas' => $nuevasPorciones,
            'tiempo_estimado' => $this->tiempo_preparacion * $factor,
            'costo_estimado' => $this->calcularCostoTotal() * $factor,
            'ingredientes' => $ingredientesAjustados
        ];
    }
}
