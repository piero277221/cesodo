<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetaIngrediente extends Model
{
    use HasFactory;

    protected $table = 'receta_ingredientes';

    protected $fillable = [
        'receta_id',
        'producto_id',
        'cantidad',
        'unidad_medida',
        'es_principal',
        'observaciones'
    ];

    protected $casts = [
        'cantidad' => 'decimal:3',
        'es_principal' => 'boolean'
    ];

    // Relaciones
    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Accessors y Mutators
    public function getUnidadesMedidaAttribute()
    {
        return [
            'gramos' => 'Gramos (g)',
            'kilogramos' => 'Kilogramos (kg)',
            'mililitros' => 'Mililitros (ml)',
            'litros' => 'Litros (l)',
            'unidades' => 'Unidades',
            'tazas' => 'Tazas',
            'cucharadas' => 'Cucharadas',
            'cucharaditas' => 'Cucharaditas',
            'pizca' => 'Pizca',
            'onzas' => 'Onzas (oz)',
            'libras' => 'Libras (lb)'
        ];
    }

    // Métodos auxiliares
    public function calcularCosto()
    {
        if (!$this->producto || !$this->producto->inventario) {
            return 0;
        }

        $precioUnitario = $this->producto->inventario->precio_compra;
        return $precioUnitario * $this->cantidad;
    }

    public function verificarDisponibilidad($multiplicador = 1)
    {
        $cantidadNecesaria = $this->cantidad * $multiplicador;

        if (!$this->producto || !$this->producto->inventario) {
            return [
                'disponible' => false,
                'cantidad_necesaria' => $cantidadNecesaria,
                'cantidad_disponible' => 0,
                'motivo' => 'Sin inventario registrado'
            ];
        }

        $stockDisponible = $this->producto->inventario->stock_actual;

        return [
            'disponible' => $stockDisponible >= $cantidadNecesaria,
            'cantidad_necesaria' => $cantidadNecesaria,
            'cantidad_disponible' => $stockDisponible,
            'motivo' => $stockDisponible < $cantidadNecesaria ? 'Stock insuficiente' : null
        ];
    }

    public function convertirUnidad($nuevaUnidad)
    {
        // Tabla básica de conversiones (se puede expandir)
        $conversiones = [
            'gramos' => [
                'kilogramos' => 0.001,
                'onzas' => 0.035274,
                'libras' => 0.00220462
            ],
            'kilogramos' => [
                'gramos' => 1000,
                'onzas' => 35.274,
                'libras' => 2.20462
            ],
            'mililitros' => [
                'litros' => 0.001,
                'tazas' => 0.00422675,
                'cucharadas' => 0.067628,
                'cucharaditas' => 0.202884
            ],
            'litros' => [
                'mililitros' => 1000,
                'tazas' => 4.22675,
                'cucharadas' => 67.628,
                'cucharaditas' => 202.884
            ]
        ];

        $unidadActual = $this->unidad_medida;

        if ($unidadActual === $nuevaUnidad) {
            return $this->cantidad;
        }

        if (isset($conversiones[$unidadActual][$nuevaUnidad])) {
            return $this->cantidad * $conversiones[$unidadActual][$nuevaUnidad];
        }

        // Si no hay conversión disponible, retornar cantidad original
        return $this->cantidad;
    }
}
