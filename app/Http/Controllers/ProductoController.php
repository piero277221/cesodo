<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'inventario']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por stock
        if ($request->filled('stock_estado')) {
            if ($request->stock_estado === 'bajo') {
                $query->whereHas('inventario', function($q) {
                    $q->whereRaw('stock_disponible <= productos.stock_minimo');
                });
            } elseif ($request->stock_estado === 'alto') {
                $query->whereHas('inventario', function($q) {
                    $q->whereRaw('stock_disponible > productos.stock_minimo');
                });
            }
        }

        $productos = $query->orderBy('nombre')->paginate(15);
        $categorias = Categoria::orderBy('nombre')->get();

        // Estadísticas para el dashboard
        $estadisticas = [
            'activos' => Producto::where('estado', 'activo')->count(),
            'stock_bajo' => Producto::whereHas('inventario', function($q) {
                $q->whereRaw('stock_disponible <= productos.stock_minimo');
            })->count(),
            'categorias' => Categoria::count(),
        ];

        return view('productos.index', compact('productos', 'categorias', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'unidad_medida' => 'required|string|max:50',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'cantidad_inicial' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $cantidadInicial = $validated['cantidad_inicial'];
        unset($validated['cantidad_inicial']); // Remover del array ya que no es campo del modelo Producto

        $producto = Producto::create($validated);

        // Crear registro inicial en inventario con la cantidad inicial
        Inventario::create([
            'producto_id' => $producto->id,
            'stock_actual' => $cantidadInicial,
            'stock_reservado' => 0,
            'stock_disponible' => $cantidadInicial,
            'fecha_ultimo_movimiento' => now(),
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente con stock inicial de ' . $cantidadInicial . ' unidades.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto->load(['categoria', 'inventario', 'movimientosInventario.user']);
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $producto->load('inventario'); // Cargar relación con inventario
        $categorias = Categoria::orderBy('nombre')->get();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'unidad_medida' => 'required|string|max:50',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $stockActual = $validated['stock_actual'];
        unset($validated['stock_actual']); // Remover del array ya que no es campo del modelo Producto

        $producto->update($validated);

        // Actualizar inventario si existe
        if ($producto->inventario) {
            $producto->inventario->update([
                'stock_actual' => $stockActual,
                'stock_disponible' => $stockActual - $producto->inventario->stock_reservado,
                'fecha_ultimo_movimiento' => now(),
            ]);
        } else {
            // Crear inventario si no existe
            Inventario::create([
                'producto_id' => $producto->id,
                'stock_actual' => $stockActual,
                'stock_reservado' => 0,
                'stock_disponible' => $stockActual,
                'fecha_ultimo_movimiento' => now(),
            ]);
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto y stock actualizados exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        try {
            // Verificar si tiene movimientos de inventario
            if ($producto->movimientosInventario()->count() > 0) {
                return redirect()->route('productos.index')
                    ->with('error', 'No se puede eliminar el producto porque tiene movimientos de inventario asociados.');
            }

            // Eliminar inventario asociado
            $producto->inventario()->delete();

            $producto->delete();

            return redirect()->route('productos.index')
                ->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}
