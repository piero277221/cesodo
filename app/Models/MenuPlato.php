<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MenuPlato extends Model
{
    use HasFactory;

    protected $table = 'menu_platos';

    protected $fillable = [
        'menu_id',
        'receta_id',
        'dia_semana',
        'tipo_comida',
        'fecha_programada',
        'porciones_planificadas',
        'costo_estimado',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
        'porciones_planificadas' => 'integer',
        'costo_estimado' => 'decimal:2'
    ];

    // Relaciones
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    // Accessors y Mutators
    public function getDiasSemanaAttribute()
    {
        return [
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miércoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sábado',
            'domingo' => 'Domingo'
        ];
    }

    public function getTiposComidaAttribute()
    {
        return [
            'desayuno' => 'Desayuno',
            'almuerzo' => 'Almuerzo',
            'cena' => 'Cena',
            'refrigerio' => 'Refrigerio'
        ];
    }

    public function getEstadosAttribute()
    {
        return [
            'planificado' => 'Planificado',
            'preparado' => 'Preparado',
            'servido' => 'Servido',
            'cancelado' => 'Cancelado'
        ];
    }

    public function getDiaSemanaTextoAttribute()
    {
        $dias = $this->dias_semana;
        return $dias[$this->dia_semana] ?? $this->dia_semana;
    }

    public function getTipoComidaTextoAttribute()
    {
        $tipos = $this->tipos_comida;
        return $tipos[$this->tipo_comida] ?? $this->tipo_comida;
    }

    public function getEstadoTextoAttribute()
    {
        $estados = $this->estados;
        return $estados[$this->estado] ?? $this->estado;
    }

    // Scopes
    public function scopePorFecha($query, $fecha)
    {
        return $query->where('fecha_programada', $fecha);
    }

    public function scopePorDiaSemana($query, $diaSemana)
    {
        return $query->where('dia_semana', $diaSemana);
    }

    public function scopePorTipoComida($query, $tipoComida)
    {
        return $query->where('tipo_comida', $tipoComida);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeEnRangoFecha($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_programada', [$fechaInicio, $fechaFin]);
    }

    // Métodos auxiliares
    public function calcularCostoEstimado()
    {
        if (!$this->receta) {
            return 0;
        }

        $costoReceta = $this->receta->calcularCostoTotal();
        $factorPorciones = $this->porciones_planificadas / $this->receta->porciones;
        $costoEstimado = $costoReceta * $factorPorciones;

        $this->update(['costo_estimado' => $costoEstimado]);

        return $costoEstimado;
    }

    public function verificarDisponibilidadIngredientes()
    {
        if (!$this->receta) {
            return [
                'disponible' => false,
                'motivo' => 'Receta no encontrada'
            ];
        }

        return $this->receta->verificarDisponibilidadIngredientes($this->porciones_planificadas);
    }

    public function marcarComoPreparado($observaciones = null)
    {
        $this->update([
            'estado' => 'preparado',
            'observaciones' => $observaciones ?
                ($this->observaciones ? $this->observaciones . "\n" . $observaciones : $observaciones) :
                $this->observaciones
        ]);

        // Opcional: Reducir inventario de ingredientes
        $this->reducirInventarioIngredientes();
    }

    public function marcarComoServido($observaciones = null)
    {
        $this->update([
            'estado' => 'servido',
            'observaciones' => $observaciones ?
                ($this->observaciones ? $this->observaciones . "\n" . $observaciones : $observaciones) :
                $this->observaciones
        ]);
    }

    public function cancelar($motivo = null)
    {
        $observacionesCancelacion = "Cancelado: " . ($motivo ?? 'Sin motivo especificado');

        $this->update([
            'estado' => 'cancelado',
            'observaciones' => $this->observaciones ?
                $this->observaciones . "\n" . $observacionesCancelacion :
                $observacionesCancelacion
        ]);
    }

    private function reducirInventarioIngredientes()
    {
        if (!$this->receta) {
            return false;
        }

        $factorPorciones = $this->porciones_planificadas / $this->receta->porciones;

        foreach ($this->receta->recetaIngredientes as $ingrediente) {
            $cantidadNecesaria = $ingrediente->cantidad * $factorPorciones;
            $producto = $ingrediente->producto;

            if ($producto && $producto->inventario) {
                $inventario = $producto->inventario;
                $nuevoStock = max(0, $inventario->stock_actual - $cantidadNecesaria);

                $inventario->update(['stock_actual' => $nuevoStock]);

                // Registrar movimiento de inventario
                MovimientoInventario::create([
                    'inventario_id' => $inventario->id,
                    'tipo_movimiento' => 'salida',
                    'cantidad' => $cantidadNecesaria,
                    'motivo' => 'Consumo por preparación de menú',
                    'referencia_id' => $this->id,
                    'referencia_tipo' => 'menu_plato',
                    'user_id' => auth()->id() ?? null
                ]);
            }
        }

        return true;
    }

    public function ajustarPorciones($nuevasPorciones)
    {
        $porcionesAntiguas = $this->porciones_planificadas;

        $this->update([
            'porciones_planificadas' => $nuevasPorciones
        ]);

        // Recalcular costo
        $this->calcularCostoEstimado();

        return [
            'porciones_anteriores' => $porcionesAntiguas,
            'porciones_nuevas' => $nuevasPorciones,
            'factor_cambio' => $nuevasPorciones / $porcionesAntiguas,
            'nuevo_costo' => $this->costo_estimado
        ];
    }

    public function obtenerTiempoPreparacion()
    {
        if (!$this->receta) {
            return 0;
        }

        $factorPorciones = $this->porciones_planificadas / $this->receta->porciones;
        return $this->receta->tiempo_preparacion * $factorPorciones;
    }

    public function esHoy()
    {
        return $this->fecha_programada->isToday();
    }

    public function esFuturo()
    {
        return $this->fecha_programada->isFuture();
    }

    public function esPasado()
    {
        return $this->fecha_programada->isPast();
    }

    public function diasRestantes()
    {
        if ($this->esPasado()) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->fecha_programada);
    }
}
