<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    public function actualizarDisponibilidad($cantidadConsumida)
    {
        return DB::transaction(function () use ($cantidadConsumida) {
            $this->refresh();  // Recargar el modelo para tener los datos más recientes

            if ($this->platos_disponibles < $cantidadConsumida) {
                throw new \Exception('No hay suficientes platos disponibles');
            }

            $this->platos_disponibles -= $cantidadConsumida;

            if ($this->platos_disponibles <= 0) {
                $this->platos_disponibles = 0;
                $this->estado = 'terminado';
            }

            $this->save();
            return $this->platos_disponibles;
        });
    }

    public function estaDisponible()
    {
        return $this->platos_disponibles > 0 && in_array($this->estado, ['activo', 'borrador']);
    }

    public function getBadgeDisponibilidadHtml()
    {
        if ($this->platos_disponibles <= 0) {
            return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Agotado</span>';
        }

        return sprintf(
            '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">%d platos disponibles</span>',
            $this->platos_disponibles
        );
    }

    protected $fillable = [
        'nombre',
        'tipo_menu',
        'fecha_inicio',
        'fecha_fin',

        'descripcion',
        'numero_personas',
        'platos_disponibles',
        'platos_totales',
        'auto_generado',
        'estado',
        'costo_estimado',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',

        'numero_personas' => 'integer',
        'auto_generado' => 'boolean',
        'costo_estimado' => 'decimal:2'
    ];

    public function consumos()
    {
        return $this->hasMany(Consumo::class);
    }

    public function registrarConsumo($cantidad = 1, $observaciones = null)
    {
        if ($this->platos_disponibles < $cantidad) {
            throw new \Exception('No hay suficientes platos disponibles');
        }

        if ($this->estado === 'cerrado') {
            throw new \Exception('Este menú está cerrado y no acepta más consumos');
        }

        return DB::transaction(function () use ($cantidad) {
            // Actualizar platos disponibles
            $this->decrement('platos_disponibles', $cantidad);

            // Si ya no quedan platos, marcar como cerrado
            if ($this->fresh()->platos_disponibles <= 0) {
                $this->update(['estado' => 'cerrado']);
            }

            // Solo retornar true (el consumo se crea en el controlador con todos los datos)
            return true;
        });
    }

    protected static function boot()
    {
        parent::boot();
    }

    // Relaciones
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'menu_platos')
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

    public function menuPlatos()
    {
        return $this->hasMany(MenuPlato::class);
    }

    // Relación con items del menú (MenuItem)
    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu_id');
    }

    // Relación con condiciones de salud del menú
    // Nota: Si la tabla menu_condiciones no existe, esta relación retornará vacío
    public function condiciones()
    {
        // Verificar si existe la clase MenuCondicion
        if (class_exists(\App\Models\MenuCondicion::class)) {
            return $this->hasMany(\App\Models\MenuCondicion::class, 'menu_id');
        }
        // Si no existe, retornar una relación vacía usando un modelo genérico
        return $this->hasMany(MenuItem::class, 'menu_id')->whereRaw('1 = 0');
    }

    public function platosDelDia($fecha)
    {
        return $this->menuPlatos()
                    ->where('fecha_programada', $fecha)
                    ->with('receta')
                    ->get();
    }

    public function platosPorTipoComida($fecha, $tipoComida)
    {
        return $this->menuPlatos()
                    ->where('fecha_programada', $fecha)
                    ->where('tipo_comida', $tipoComida)
                    ->with('receta')
                    ->get();
    }

    // Accessors y Mutators
    public function getCostoTotalAttribute()
    {
        return $this->costo_estimado;
    }
    public function getTiposMenuAttribute()
    {
        return [
            'semanal' => 'Menú Semanal',
            'semanal_especial' => 'Menú Semanal Especial'
        ];
    }

    public function getEstadosAttribute()
    {
        return [
            'borrador' => 'Borrador',
            'planificado' => 'Planificado',
            'activo' => 'Activo',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
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

    public function getDuracionDiasAttribute()
    {
        if (!$this->fecha_inicio || !$this->fecha_fin) {
            return 0;
        }
        return $this->fecha_inicio->diffInDays($this->fecha_fin) + 1;
    }

    public function getTotalPorcionesAttribute()
    {
        return $this->numero_personas * $this->duracion_dias;
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_menu', $tipo);
    }

    public function scopeEnRangoFecha($query, $fechaInicio, $fechaFin)
    {
        return $query->where(function($q) use ($fechaInicio, $fechaFin) {
            $q->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
              ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
              ->orWhere(function($q2) use ($fechaInicio, $fechaFin) {
                  $q2->where('fecha_inicio', '<=', $fechaInicio)
                     ->where('fecha_fin', '>=', $fechaFin);
              });
        });
    }

    // Métodos auxiliares
    public function calcularCostoTotal()
    {
        $costoTotal = 0;

        foreach ($this->menuPlatos as $plato) {
            $costoTotal += $plato->costo_estimado ?? 0;
        }

        $this->update(['costo_estimado' => $costoTotal]);
        return $costoTotal;
    }

    public function verificarDisponibilidadCompleta()
    {
        $problemas = [];
        $resumenIngredientes = [];

        foreach ($this->menuPlatos as $plato) {
            $receta = $plato->receta;
            if (!$receta) continue;

            $verificacion = $receta->verificarDisponibilidadIngredientes($plato->porciones_planificadas);

            if (!$verificacion['disponible']) {
                $problemas[$plato->fecha_programada][$plato->tipo_comida] = [
                    'receta' => $receta->nombre,
                    'ingredientes_faltantes' => $verificacion['ingredientes_faltantes']
                ];
            }

            // Acumular ingredientes necesarios
            foreach ($receta->recetaIngredientes as $ingrediente) {
                $productoId = $ingrediente->producto_id;
                $cantidadNecesaria = $ingrediente->cantidad * ($plato->porciones_planificadas / $receta->porciones);

                if (!isset($resumenIngredientes[$productoId])) {
                    $resumenIngredientes[$productoId] = [
                        'nombre' => $ingrediente->producto->nombre ?? 'Producto desconocido',
                        'cantidad_total' => 0,
                        'unidad' => $ingrediente->unidad_medida
                    ];
                }

                $resumenIngredientes[$productoId]['cantidad_total'] += $cantidadNecesaria;
            }
        }

        return [
            'disponible' => empty($problemas),
            'problemas_por_fecha' => $problemas,
            'resumen_ingredientes' => $resumenIngredientes
        ];
    }

    public function generarMenuAutomatico($configuracion = [])
    {
        $fechaActual = Carbon::parse($this->fecha_inicio);
        $fechaFin = Carbon::parse($this->fecha_fin);

        $recetasDisponibles = Receta::activo()->get()->groupBy('tipo_plato');
        $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

        // Configuración por defecto
        $tiposComidaPorDia = $configuracion['tipos_comida'] ?? ['desayuno', 'almuerzo', 'cena'];
        $evitarRepeticion = $configuracion['evitar_repeticion'] ?? true;
        $balancearTipos = $configuracion['balancear_tipos'] ?? true;

        $recetasUsadas = [];
        $menuGenerado = [];

        while ($fechaActual->lte($fechaFin)) {
            $diaSemana = $diasSemana[$fechaActual->dayOfWeek === 0 ? 6 : $fechaActual->dayOfWeek - 1];

            foreach ($tiposComidaPorDia as $tipoComida) {
                // Seleccionar tipo de plato según el tipo de comida
                $tipoPlato = $this->seleccionarTipoPlato($tipoComida);

                $recetasDisponiblesParaTipo = $recetasDisponibles->get($tipoPlato, collect());

                if ($evitarRepeticion) {
                    $recetasDisponiblesParaTipo = $recetasDisponiblesParaTipo->reject(function($receta) use ($recetasUsadas) {
                        return in_array($receta->id, $recetasUsadas);
                    });
                }

                if ($recetasDisponiblesParaTipo->isEmpty()) {
                    // Si no hay recetas disponibles, usar cualquiera
                    $recetasDisponiblesParaTipo = $recetasDisponibles->get($tipoPlato, collect());
                }

                $recetaSeleccionada = $recetasDisponiblesParaTipo->random();

                $menuGenerado[] = [
                    'receta_id' => $recetaSeleccionada->id,
                    'dia_semana' => $diaSemana,
                    'tipo_comida' => $tipoComida,
                    'fecha_programada' => $fechaActual->format('Y-m-d'),
                    'porciones_planificadas' => $this->numero_personas,
                    'costo_estimado' => $recetaSeleccionada->calcularCostoTotal() * ($this->numero_personas / $recetaSeleccionada->porciones),
                    'estado' => 'planificado'
                ];

                $recetasUsadas[] = $recetaSeleccionada->id;

                // Limpiar lista de usadas si es muy larga
                if (count($recetasUsadas) > 10) {
                    array_shift($recetasUsadas);
                }
            }

            $fechaActual->addDay();
        }

        // Guardar el menú generado
        foreach ($menuGenerado as $plato) {
            $this->menuPlatos()->create($plato);
        }

        $this->update(['auto_generado' => true, 'estado' => 'planificado']);
        $this->calcularCostoTotal();

        return $menuGenerado;
    }

    private function seleccionarTipoPlato($tipoComida)
    {
        $mapeoTipos = [
            'desayuno' => ['entrada', 'bebida'],
            'almuerzo' => ['entrada', 'plato_principal', 'postre'],
            'cena' => ['plato_principal', 'ensalada'],
            'refrigerio' => ['postre', 'bebida']
        ];

        $tiposDisponibles = $mapeoTipos[$tipoComida] ?? ['plato_principal'];
        return $tiposDisponibles[array_rand($tiposDisponibles)];
    }

    public function exportarPDF()
    {
        // Este método se implementará cuando se configure la librería PDF
        return "Funcionalidad de PDF pendiente de implementar";
    }

    public function clonar($nuevoNombre, $nuevaFechaInicio)
    {
        $nuevoMenu = $this->replicate(['nombre', 'fecha_inicio', 'fecha_fin']);
        $nuevoMenu->nombre = $nuevoNombre;
        $nuevoMenu->fecha_inicio = Carbon::parse($nuevaFechaInicio);
        $nuevoMenu->fecha_fin = Carbon::parse($nuevaFechaInicio)->addDays($this->duracion_dias - 1);
        $nuevoMenu->estado = 'borrador';
        $nuevoMenu->auto_generado = false;
        $nuevoMenu->save();

        // Clonar los platos del menú
        foreach ($this->menuPlatos as $plato) {
            $nuevoPlato = $plato->replicate(['menu_id']);
            $nuevoPlato->menu_id = $nuevoMenu->id;

            // Ajustar fechas
            $diasDiferencia = Carbon::parse($plato->fecha_programada)->diffInDays($this->fecha_inicio);
            $nuevoPlato->fecha_programada = $nuevoMenu->fecha_inicio->copy()->addDays($diasDiferencia);

            $nuevoPlato->save();
        }

        return $nuevoMenu;
    }
}
