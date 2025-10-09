<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumo;
use App\Models\Trabajador;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Consumo::with(['trabajador', 'user']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('trabajador', function($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_consumo', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_consumo', '<=', $request->fecha_fin);
        }

        if ($request->filled('tipo_comida')) {
            $query->where('tipo_comida', $request->tipo_comida);
        }

        if ($request->filled('trabajador_id')) {
            $query->where('trabajador_id', $request->trabajador_id);
        }

        $consumos = $query->orderBy('fecha_consumo', 'desc')
                         ->orderBy('hora_consumo', 'desc')
                         ->paginate(15)
                         ->withQueryString();

        // Calculamos estadísticas simples
        $totalHoy = Consumo::whereDate('fecha_consumo', today())->count();
        $totalSemana = Consumo::whereBetween('fecha_consumo', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $trabajadoresActivos = Consumo::distinct('trabajador_id')->count('trabajador_id');
        $totalRegistros = Consumo::count();

        $trabajadores = Trabajador::orderBy('nombres')->get();

        // Iconos para tipos de comida
        $iconos = [
            'desayuno' => 'fas fa-coffee',
            'almuerzo' => 'fas fa-utensils',
            'cena' => 'fas fa-moon'
        ];

        // Estilos para tipos de comida
        $tipoStyles = [
            'desayuno' => 'bg-yellow-100 text-yellow-800',
            'almuerzo' => 'bg-green-100 text-green-800',
            'cena' => 'bg-blue-100 text-blue-800'
        ];

        return view('consumos.index_new', compact('consumos', 'trabajadores', 'totalHoy', 'totalSemana', 'trabajadoresActivos', 'totalRegistros', 'iconos', 'tipoStyles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trabajadores = Trabajador::orderBy('nombres')->get();
        // Selecciona el menú activo (puedes ajustar la lógica según tu flujo)
        $menu = \App\Models\Menu::where('estado', 'activo')->orderByDesc('id')->first();
        return view('consumos.create_new', compact('trabajadores', 'menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha_consumo' => 'required|date',
            'hora_consumo' => 'required|date_format:H:i',
            'tipo_comida' => 'required|in:desayuno,almuerzo,cena',
            'observaciones' => 'nullable|string|max:500',
            'menu_id' => 'required|exists:menus,id',
        ]);

        $menu = \App\Models\Menu::find($request->menu_id);
        if (!$menu || $menu->platos_disponibles <= 0) {
            $msg = 'No hay platos disponibles para este menú.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return back()->with('error', $msg);
        }

        try {
            $menu->registrarConsumo(1, $request->observaciones); // Descuenta 1 plato

            $consumo = Consumo::create([
                'trabajador_id' => $request->trabajador_id,
                'fecha_consumo' => $request->fecha_consumo,
                'hora_consumo' => $request->fecha_consumo . ' ' . $request->hora_consumo,
                'tipo_comida' => $request->tipo_comida,
                'observaciones' => $request->observaciones,
                'user_id' => Auth::id(),
                'menu_id' => $menu->id,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'disponibles' => $menu->fresh()->platos_disponibles
                ]);
            }
            return redirect()->route('consumos.index')
                            ->with('success', 'Consumo registrado exitosamente.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            return back()->with('error', 'Error al registrar el consumo: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Consumo $consumo)
    {
        $consumo->load(['trabajador', 'user']);
        return view('consumos.show', compact('consumo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consumo $consumo)
    {
        $trabajadores = Trabajador::where('estado', 'activo')->orderBy('nombres')->get();
        return view('consumos.edit', compact('consumo', 'trabajadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consumo $consumo)
    {
        $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha_consumo' => 'required|date',
            'hora_consumo' => 'required|date_format:H:i',
            'tipo_comida' => 'required|in:desayuno,almuerzo,cena',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $consumo->update([
            'trabajador_id' => $request->trabajador_id,
            'fecha_consumo' => $request->fecha_consumo,
            'hora_consumo' => $request->fecha_consumo . ' ' . $request->hora_consumo,
            'tipo_comida' => $request->tipo_comida,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('consumos.index')
                        ->with('success', 'Consumo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consumo $consumo)
    {
        $consumo->delete();
        return redirect()->route('consumos.index')
                        ->with('success', 'Consumo eliminado exitosamente.');
    }

    /**
     * Buscar trabajador por código
     */
    public function buscarTrabajador($codigo)
    {
        $trabajador = Trabajador::where('codigo', $codigo)
                               ->where('estado', 'activo')
                               ->first();

        if ($trabajador) {
            return response()->json([
                'success' => true,
                'trabajador' => $trabajador
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Trabajador no encontrado o inactivo'
        ]);
    }

    /**
     * Registro rápido de consumo
     */
    public function registroRapido()
    {
        return view('consumos.registro-rapido');
    }
}
