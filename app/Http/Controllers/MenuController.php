<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Receta;
use App\Models\MenuPlato;
use App\Models\Producto;
use App\Models\Kardex;
use App\Traits\KardexTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MenuController extends Controller
{
    use KardexTrait;

    public function consumir(Menu $menu)
    {
        return view('menus.consumir', compact('menu'));
    }

    public function registrarConsumo(Request $request, Menu $menu)
    {
        if (!$menu->estaDisponible()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Este menú no está disponible para consumos.']);
            }
            return back()->with('error', 'Este menú no está disponible para consumos.');
        }

        $request->validate([
            'cantidad' => ['required', 'integer', 'min:1', 'max:' . $menu->platos_disponibles],
            'notas' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            // Crear el registro de consumo
            $consumo = new \App\Models\Consumo([
                'menu_id' => $menu->id,
                'cantidad' => $request->cantidad,
                'notas' => $request->notas,
                'created_by' => Auth::id()
            ]);
            $consumo->save();

            // Actualizar la disponibilidad del menú y obtener el nuevo stock
            $disponibles = $menu->actualizarDisponibilidad($request->cantidad);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'disponibles' => $disponibles
                ]);
            }
            return redirect()->route('menus.index')
                ->with('success', "Se han consumido {$request->cantidad} platos exitosamente.");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error al registrar consumo: " . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            return back()->with('error', 'Hubo un error al registrar el consumo. Por favor, inténtelo de nuevo.');
        }
    }

    public function checkDisponibilidad(Menu $menu)
    {
        return response()->json([
            'disponibles' => $menu->platos_disponibles,
            'totales' => $menu->platos_totales
        ]);
    }

    public function index(Request $request)
    {
        try {
            $query = Menu::with(['createdBy', 'menuPlatos.receta'])
                         ->orderByDesc('created_at');

            // Filtros
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('descripcion', 'like', "%{$search}%");
                });
            }

            if ($request->filled('tipo_menu')) {
                $query->where('tipo_menu', $request->tipo_menu);
            }

            if ($request->filled('estado')) {
                $query->where('estado', $request->estado);
            }

            if ($request->filled('fecha_desde')) {
                $query->whereDate('fecha_inicio', '>=', $request->fecha_desde);
            }

            if ($request->filled('fecha_hasta')) {
                $query->whereDate('fecha_fin', '<=', $request->fecha_hasta);
            }

            $menus = $query->paginate(10)->withQueryString();

            // Estadísticas para el dashboard
            $estadisticas = [
                'total_menus' => Menu::count(),
                'menus_activos' => Menu::where('estado', 'activo')->count(),
                'menus_planificados' => Menu::whereIn('estado', ['planificado', 'borrador'])->count(),
                'menus_completados' => Menu::where('estado', 'completado')->count(),
                'costo_total_mes' => Menu::whereMonth('fecha_inicio', date('m'))
                                         ->whereYear('fecha_inicio', date('Y'))
                                         ->sum('costo_estimado') ?? 0
            ];

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('menus.partials.menu-cards', compact('menus'))->render(),
                    'pagination' => view('vendor.pagination.bootstrap-4', ['paginator' => $menus])->render()
                ]);
            }

            return view('menus.index', compact('menus', 'estadisticas'));
        } catch (\Exception $e) {
            Log::error('Error en MenuController@index: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['error' => 'Error al cargar los menús'], 500);
            }

            return back()->with('error', 'Error al cargar los menús: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $recetas = Receta::where('estado', 'activo')
                         ->with(['ingredientes.producto'])
                         ->orderBy('nombre')
                         ->get();

        $tiposMenu = [
            'semanal' => 'Menú Semanal',
            'semanal_especial' => 'Menú Semanal Especial'
        ];

        $tiposComida = [
            'desayuno' => 'Desayuno',
            'almuerzo' => 'Almuerzo',
            'cena' => 'Cena',
            'refrigerio' => 'Refrigerio'
        ];

        // Obtener productos para el formulario
        $productos = Producto::with(['inventarios'])
                             ->orderBy('nombre')
                             ->get();

        // Por ahora inicializamos una colección vacía para condiciones de salud
        $condicionesSalud = collect();

        return view('menus.create', compact('recetas', 'tiposMenu', 'tiposComida', 'productos', 'condicionesSalud'));
    }

    public function verificarIngredientes(Request $request)
    {
        $recetas = $request->get('recetas');
        $faltantes = [];

        foreach ($recetas as $tipo => $recetaId) {
            if (!empty($recetaId)) {
                $receta = Receta::with('ingredientes.producto.inventario')->find($recetaId);
                if ($receta) {
                    foreach ($receta->ingredientes as $ingrediente) {
                        // Calcular cantidad necesaria considerando número de personas y porciones por persona
                        $cantidad_necesaria = $ingrediente->cantidad *
                            $request->input('numero_personas', 1) *
                            $request->input('porciones_por_persona', 1);

                        $inventario = $ingrediente->producto->inventario;
                        $stock_disponible = $inventario ? $inventario->stock_disponible : 0;

                        if (!$inventario || $stock_disponible < $cantidad_necesaria) {
                            $faltantes[] = $ingrediente->producto->nombre .
                                " (Disponible: " . number_format($stock_disponible, 2) .
                                ", Necesario: " . number_format($cantidad_necesaria, 2) . ")";
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => empty($faltantes),
            'faltantes' => $faltantes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_menu' => 'required|in:semanal,semanal_especial',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'numero_personas' => 'required|integer|min:1|max:1000',
            'descripcion' => 'nullable|string|max:1000',
            'observaciones' => 'nullable|string|max:2000',
            'dias_seleccionados' => 'required|array',
            'dias_seleccionados.*' => 'in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            'tipos_comida' => 'required|array',
            'tipos_comida.*' => 'in:desayuno,almuerzo,cena',
            'recetas' => 'required|array',
            'recetas.*.*.*' => 'nullable|exists:recetas,id'
        ]);

        try {
            DB::beginTransaction();

            // Verificar disponibilidad de ingredientes antes de crear el menú
            $recetas = $request->input('recetas', []);
            $ingredientesFaltantes = [];

            foreach ($recetas as $dia => $comidas) {
                foreach ($comidas as $tipoComida => $recetaId) {
                    if (!empty($recetaId)) {
                        $receta = Receta::with('ingredientes.producto.inventario')->findOrFail($recetaId);
                        foreach ($receta->ingredientes as $ingrediente) {
                            $cantidad_necesaria = $ingrediente->cantidad *
                                $request->input('numero_personas', 1) *
                                $request->input('porciones_por_persona', 1);

                            $inventario = $ingrediente->producto->inventario;
                            $stock_disponible = $inventario ? $inventario->stock_disponible : 0;

                            if (!$inventario || $stock_disponible < $cantidad_necesaria) {
                                $ingredientesFaltantes[] = $ingrediente->producto->nombre;
                            }
                        }
                    }
                }
            }

            if (!empty($ingredientesFaltantes)) {
                throw new \Exception('Stock insuficiente para el producto: ' . implode(', ', array_unique($ingredientesFaltantes)));
            }

            // Calcular total de platos basado en personas y días
            $diasMenu = Carbon::parse($request->fecha_inicio)
                ->diffInDays(Carbon::parse($request->fecha_fin)) + 1;
            $platosTotal = $request->numero_personas * $diasMenu;

            $menu = Menu::create([
                'nombre' => $request->nombre,
                'tipo_menu' => $request->tipo_menu,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'numero_personas' => $request->numero_personas,
                'platos_totales' => $platosTotal,
                'platos_disponibles' => $platosTotal,
                'descripcion' => $request->descripcion,
                'observaciones' => $request->observaciones,
                'estado' => 'activo',
                'created_by' => Auth::id()
            ]);

            // Si se solicita generación automática
            if ($request->boolean('auto_generar')) {
                $configuracion = [
                    'tipos_comida' => $request->input('tipos_comida_auto', ['desayuno', 'almuerzo', 'cena']),
                    'evitar_repeticion' => $request->boolean('evitar_repeticion', true),
                    'balancear_tipos' => $request->boolean('balancear_tipos', true)
                ];

                $menu->generarMenuAutomatico($configuracion);
            } else {
                // Procesar las recetas seleccionadas manualmente
                $recetas = $request->input('recetas', []);
                foreach ($recetas as $dia => $comidas) {
                    foreach ($comidas as $tipoComida => $recetaId) {
                        if (!empty($recetaId)) {
                            // Obtener la receta con sus ingredientes
                            $receta = Receta::with('ingredientes.producto')->findOrFail($recetaId);

                            // Crear el plato del menú
                            $menuPlato = $menu->menuPlatos()->create([
                                'receta_id' => $recetaId,
                                'dia_semana' => $dia,
                                'tipo_comida' => $tipoComida,
                                'fecha_programada' => Carbon::parse($menu->fecha_inicio)->addDays($this->getDayNumber($dia)),
                                'porciones_planificadas' => $menu->numero_personas,
                                'estado' => 'planificado'
                            ]);
                        }
                    }
                }
            }

            // Verificar que el menú tenga al menos un plato
            if ($menu->menuPlatos()->count() === 0) {
                throw new \Exception('El menú debe tener al menos un plato');
            }

            // Descontar productos del inventario y registrar en kardex
            $this->actualizarInventario($menu);

            DB::commit();

            return redirect()
                ->route('menus.index')
                ->with('success', 'Menú creado exitosamente' .
                    ($request->boolean('auto_generar') ? ' con generación automática' : ''));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear menú: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al crear el menú: ' . $e->getMessage());
        }
    }

    public function show(Menu $menu)
    {
        try {
            $menu->load([
                'createdBy',
                'menuPlatos.receta.recetaIngredientes.producto.inventario',
                'menuPlatos' => function($query) {
                    $query->orderBy('fecha_programada')->orderBy('tipo_comida');
                }
            ]);

            // Agrupar platos por fecha y tipo de comida
            $menuPorFecha = $menu->menuPlatos->groupBy('fecha_programada');

            // Verificar disponibilidad de ingredientes
            $verificacionDisponibilidad = $menu->verificarDisponibilidadCompleta();

            // Calcular estadísticas del menú
            $estadisticas = [
                'total_platos' => $menu->menuPlatos->count(),
                'costo_total' => $menu->costo_estimado,
                'costo_por_persona' => $menu->numero_personas > 0 ? $menu->costo_estimado / $menu->numero_personas : 0,
                'costo_por_dia' => $menu->duracion_dias > 0 ? $menu->costo_estimado / $menu->duracion_dias : 0,
                'duracion_dias' => $menu->duracion_dias,
                'platos_por_estado' => $menu->menuPlatos->groupBy('estado')->map->count()
            ];

            return view('menus.show', compact('menu', 'menuPorFecha', 'verificacionDisponibilidad', 'estadisticas'));

        } catch (\Exception $e) {
            Log::error('Error al mostrar menú: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el menú: ' . $e->getMessage());
        }
    }

    public function edit(Menu $menu)
    {
        $recetas = Receta::activo()
                         ->with(['recetaIngredientes.producto'])
                         ->orderBy('nombre')
                         ->get()
                         ->groupBy('tipo_plato');

        // Obtener todos los productos para los selects
        $productos = Producto::with('inventarios')
                             ->orderBy('nombre')
                             ->get();

        $tiposMenu = [
            'semanal' => 'Menú Semanal',
            'semanal_especial' => 'Menú Semanal Especial'
        ];

        $tiposComida = [
            'desayuno' => 'Desayuno',
            'almuerzo' => 'Almuerzo',
            'cena' => 'Cena',
            'refrigerio' => 'Refrigerio'
        ];

        // Cargar todas las relaciones necesarias para la vista
        $menu->load([
            'menuPlatos.receta',
            'items.productos.producto', // Cargar items con sus productos
            'condiciones' // Cargar condiciones del menú
        ]);

        return view('menus.edit', compact('menu', 'recetas', 'productos', 'tiposMenu', 'tiposComida'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_menu' => 'required|in:semanal,semanal_especial',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'numero_personas' => 'required|integer|min:1|max:1000',
            'descripcion' => 'nullable|string|max:1000',
            'observaciones' => 'nullable|string|max:2000',
            'estado' => 'required|in:borrador,planificado,activo,completado,cancelado'
        ]);

        try {
            DB::beginTransaction();

            $menu->update([
                'nombre' => $request->nombre,
                'tipo_menu' => $request->tipo_menu,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'numero_personas' => $request->numero_personas,
                'descripcion' => $request->descripcion,
                'observaciones' => $request->observaciones,
                'estado' => $request->estado
            ]);

            // Recalcular costo si es necesario
            if ($request->boolean('recalcular_costo')) {
                $menu->calcularCostoTotal();
            }

            DB::commit();

            return redirect()
                ->route('menus.show', $menu)
                ->with('success', 'Menú actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar menú: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el menú: ' . $e->getMessage());
        }
    }

    public function destroy(Menu $menu)
    {
        try {
            // Verificar que el menú no esté activo
            if ($menu->estado === 'activo') {
                return back()->with('error', 'No se puede eliminar un menú activo. Por favor, cambia el estado del menú primero.');
            }

            DB::beginTransaction();

            // Eliminar platos del menú
            $menu->menuPlatos()->delete();

            // Eliminar el menú
            $menu->delete();

            DB::commit();

            return redirect()
                ->route('menus.index')
                ->with('success', 'Menú eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar menú: ' . $e->getMessage());

            return back()->with('error', 'Error al eliminar el menú: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar el estado de un menú
     */
    public function cambiarEstado(Request $request, Menu $menu)
    {
        try {
            $request->validate([
                'estado' => 'required|in:borrador,planificado,activo,completado,cancelado'
            ]);

            $estadoAnterior = $menu->estado;
            $menu->estado = $request->estado;
            $menu->save();

            return back()->with('success', "Estado del menú cambiado de '{$estadoAnterior}' a '{$request->estado}' exitosamente");

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado del menú: ' . $e->getMessage());
            return back()->with('error', 'Error al cambiar el estado del menú: ' . $e->getMessage());
        }
    }

    // Métodos adicionales específicos del sistema de gestión de menús

    public function generarAutomatico(Request $request, Menu $menu)
    {
        $request->validate([
            'tipos_comida' => 'required|array|min:1',
            'tipos_comida.*' => 'in:desayuno,almuerzo,cena,refrigerio',
            'evitar_repeticion' => 'boolean',
            'balancear_tipos' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Limpiar platos existentes si es necesario
            if ($request->boolean('limpiar_existentes')) {
                $menu->menuPlatos()->delete();
            }

            $configuracion = [
                'tipos_comida' => $request->tipos_comida,
                'evitar_repeticion' => $request->boolean('evitar_repeticion', true),
                'balancear_tipos' => $request->boolean('balancear_tipos', true)
            ];

            $platosGenerados = $menu->generarMenuAutomatico($configuracion);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Menú generado automáticamente',
                'platos_generados' => count($platosGenerados),
                'costo_total' => $menu->fresh()->costo_estimado
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al generar menú automáticamente: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al generar el menú: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verificarDisponibilidad(Menu $menu)
    {
        try {
            $verificacion = $menu->verificarDisponibilidadCompleta();

            return response()->json([
                'disponible' => $verificacion['disponible'],
                'problemas' => $verificacion['problemas_por_fecha'],
                'resumen_ingredientes' => $verificacion['resumen_ingredientes']
            ]);

        } catch (\Exception $e) {
            Log::error('Error al verificar disponibilidad: ' . $e->getMessage());

            return response()->json([
                'error' => 'Error al verificar disponibilidad: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clonar(Request $request, Menu $menu)
    {
        $request->validate([
            'nuevo_nombre' => 'required|string|max:255',
            'nueva_fecha_inicio' => 'required|date|after_or_equal:today'
        ]);

        try {
            DB::beginTransaction();

            $nuevoMenu = $menu->clonar(
                $request->nuevo_nombre,
                $request->nueva_fecha_inicio
            );

            DB::commit();

            return redirect()
                ->route('menus.show', $nuevoMenu)
                ->with('success', 'Menú clonado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al clonar menú: ' . $e->getMessage());

            return back()->with('error', 'Error al clonar el menú: ' . $e->getMessage());
        }
    }

    public function exportarPDF(Menu $menu)
    {
        try {
            // Esta funcionalidad se implementará cuando se configure la librería PDF
            return response()->json([
                'message' => 'Funcionalidad de exportación PDF pendiente de implementar'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al exportar PDF: ' . $e->getMessage());

            return response()->json([
                'error' => 'Error al exportar PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function activar(Menu $menu)
    {
        try {
            // Verificar que el menú esté planificado
            if ($menu->estado !== 'planificado') {
                return back()->with('error', 'Solo se pueden activar menús planificados');
            }

            // Verificar disponibilidad de ingredientes
            $verificacion = $menu->verificarDisponibilidadCompleta();
            if (!$verificacion['disponible']) {
                return back()->with('error', 'No se puede activar el menú debido a falta de ingredientes');
            }

            $menu->update(['estado' => 'activo']);

            return back()->with('success', 'Menú activado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al activar menú: ' . $e->getMessage());
            return back()->with('error', 'Error al activar el menú: ' . $e->getMessage());
        }
    }

    protected function getDayNumber($dia)
    {
        $dias = [
            'lunes' => 0,
            'martes' => 1,
            'miercoles' => 2,
            'jueves' => 3,
            'viernes' => 4,
            'sabado' => 5,
            'domingo' => 6
        ];
        return $dias[strtolower($dia)] ?? 0;
    }

    protected function actualizarInventario(Menu $menu)
    {
        try {
            // Cargar las relaciones necesarias
            $menu->load('menuPlatos.receta.ingredientes.producto.inventario');

            // Procesar cada plato del menú
            foreach ($menu->menuPlatos as $plato) {
                if (!$plato->receta) continue;

                // Procesar los ingredientes de cada receta
                foreach ($plato->receta->ingredientes as $ingrediente) {
                    $producto = $ingrediente->producto;
                    $cantidadNecesaria = $ingrediente->cantidad *
                        $menu->numero_personas *
                        ($menu->porciones_por_persona ?? 1);

                    if (!$producto->inventario) {
                        throw new \Exception("No hay inventario registrado para el producto: {$producto->nombre}");
                    }

                    $inventario = $producto->inventario;

                    // Verificar stock disponible
                    if ($inventario->stock_disponible < $cantidadNecesaria) {
                        throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}. Disponible: {$inventario->stock_disponible}, Necesario: {$cantidadNecesaria}");
                    }

                    // Actualizar inventario
                    $inventario->stock_actual -= $cantidadNecesaria;
                    $inventario->stock_disponible -= $cantidadNecesaria;
                    $inventario->fecha_ultimo_movimiento = now();
                    $inventario->save();

                    // Registrar en kardex usando el trait
                    $this->registrarKardex([
                        'producto_id' => $producto->id,
                        'fecha' => now(),
                        'tipo_movimiento' => 'salida',
                        'modulo' => 'menu',
                        'concepto' => "Consumo por menú: {$menu->nombre}",
                        'numero_documento' => "MENU-{$menu->id}",
                        'cantidad_salida' => $cantidadNecesaria,
                        'precio_unitario' => $producto->precio_unitario ?? 0,
                        'observaciones' => "Consumo para {$plato->receta->nombre} - {$plato->tipo_comida}",
                        'user_id' => Auth::id(),
                        'referencia_tipo' => 'menu',
                        'referencia_id' => $menu->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Error al actualizar inventario: " . $e->getMessage());
        }
    }

    public function completar(Menu $menu)
    {
        try {
            if ($menu->estado !== 'activo') {
                return back()->with('error', 'Solo se pueden completar menús activos');
            }

            $menu->update(['estado' => 'completado']);

            return back()->with('success', 'Menú marcado como completado');

        } catch (\Exception $e) {
            Log::error('Error al completar menú: ' . $e->getMessage());
            return back()->with('error', 'Error al completar el menú: ' . $e->getMessage());
        }
    }

    public function publicar(Menu $menu)
    {
        try {
            if ($menu->estado === 'borrador') {
                $menu->update(['estado' => 'planificado']);
                return back()->with('success', 'Menú publicado exitosamente');
            }

            return back()->with('error', 'Solo se pueden publicar menús en estado borrador');

        } catch (\Exception $e) {
            Log::error('Error al publicar menú: ' . $e->getMessage());
            return back()->with('error', 'Error al publicar el menú: ' . $e->getMessage());
        }
    }
}
