<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventario::with(['producto.categoria']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('producto', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('categoria')) {
            $query->whereHas('producto', function ($q) use ($request) {
                $q->where('categoria_id', $request->categoria);
            });
        }

        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'bajo':
                    $query->join('productos', 'inventarios.producto_id', '=', 'productos.id')
                          ->whereRaw('inventarios.stock_actual <= productos.stock_minimo')
                          ->select('inventarios.*');
                    break;
                case 'sin_stock':
                    $query->where('stock_actual', '<=', 0);
                    break;
                case 'disponible':
                    $query->where('stock_actual', '>', 0);
                    break;
            }
        }

        if ($request->filled('vencimiento')) {
            switch ($request->vencimiento) {
                case 'vencido':
                    $query->where('fecha_vencimiento', '<', now());
                    break;
                case 'proximo':
                    $query->proximosVencer(30);
                    break;
            }
        }

        $inventarios = $query->orderBy('stock_actual', 'asc')
                             ->paginate(15)
                             ->appends($request->query());

        // Estadísticas
        $stats = [
            'total_productos' => Inventario::count(),
            'stock_total' => Inventario::sum('stock_actual'),
            'stock_bajo' => Inventario::join('productos', 'inventarios.producto_id', '=', 'productos.id')
                ->whereRaw('inventarios.stock_actual <= productos.stock_minimo')
                ->count(),
            'sin_stock' => Inventario::where('stock_actual', '<=', 0)->count(),
        ];

        // Categorías para filtro
        $categorias = DB::table('categorias')->get();

        return view('inventarios.index', compact('inventarios', 'stats', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener solo productos que NO tienen inventario
        $productosConInventario = Inventario::pluck('producto_id')->toArray();
        $productos = Producto::with('categoria')
            ->whereNotIn('id', $productosConInventario)
            ->get();

        return view('inventarios.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id|unique:inventarios,producto_id',
            'stock_actual' => 'required|numeric|min:0',
            'stock_reservado' => 'nullable|numeric|min:0',
            'fecha_vencimiento' => 'nullable|date|after:today',
            'lote' => 'nullable|string|max:100',
        ]);

        // Verificar si ya existe un inventario para este producto
        $inventarioExistente = Inventario::where('producto_id', $request->producto_id)->first();

        if ($inventarioExistente) {
            return redirect()->route('inventarios.edit', $inventarioExistente->id)
                ->with('warning', 'Este producto ya tiene un registro de inventario. Redirigido para editar el existente.');
        }

        DB::transaction(function () use ($request) {
            $stockReservado = $request->stock_reservado ?? 0;
            $stockDisponible = $request->stock_actual - $stockReservado;

            $inventario = Inventario::create([
                'producto_id' => $request->producto_id,
                'stock_actual' => $request->stock_actual,
                'stock_reservado' => $stockReservado,
                'stock_disponible' => $stockDisponible,
                'fecha_ultimo_movimiento' => now(),
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'lote' => $request->lote,
            ]);

            // Obtener el producto y su precio
            $producto = Producto::findOrFail($request->producto_id);

            // Crear movimiento de inventario
            MovimientoInventario::create([
                'producto_id' => $request->producto_id,
                'tipo_movimiento' => 'entrada',
                'cantidad' => $request->stock_actual,
                'precio_unitario' => $producto->precio_unitario,
                'precio_total' => $producto->precio_unitario * $request->stock_actual,
                'motivo' => 'stock_inicial',
                'observaciones' => 'Stock inicial del producto',
                'user_id' => Auth::id(),
                'fecha_movimiento' => now(),
            ]);
        });

        return redirect()->route('inventarios.index')
                        ->with('success', 'Inventario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventario = Inventario::with(['producto.categoria'])->findOrFail($id);

        $movimientos = MovimientoInventario::with(['user'])
                                         ->where('producto_id', $inventario->producto_id)
                                         ->orderBy('created_at', 'desc')
                                         ->limit(20)
                                         ->get();

        return view('inventarios.show', compact('inventario', 'movimientos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventario = Inventario::with(['producto.categoria'])->findOrFail($id);
        $productos = Producto::all();
        return view('inventarios.edit', compact('inventario', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventario = Inventario::findOrFail($id);

        $request->validate([
            'stock_actual' => 'required|numeric|min:0',
            'stock_reservado' => 'nullable|numeric|min:0',
            'fecha_vencimiento' => 'nullable|date',
            'lote' => 'nullable|string|max:100',
        ]);

        $stockReservado = $request->stock_reservado ?? 0;
        $stockDisponible = $request->stock_actual - $stockReservado;

        $inventario->update([
            'stock_actual' => $request->stock_actual,
            'stock_reservado' => $stockReservado,
            'stock_disponible' => $stockDisponible,
            'fecha_ultimo_movimiento' => now(),
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'lote' => $request->lote,
        ]);

        return redirect()->route('inventarios.index')
                        ->with('success', 'Inventario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        return redirect()->route('inventarios.index')
                        ->with('success', 'Inventario eliminado exitosamente.');
    }

    /**
     * Registrar entrada de stock
     */
    public function entrada(Request $request, $id)
    {
        $inventario = Inventario::with('producto')->findOrFail($id);

        $request->validate([
            'cantidad' => 'required|numeric|min:0.01',
            'precio_unitario' => 'nullable|numeric|min:0',
            'motivo' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:500',
            'documento_referencia' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($request, $inventario) {
            // Actualizar stock
            $inventario->increment('stock_actual', $request->cantidad);
            $inventario->increment('stock_disponible', $request->cantidad);
            $inventario->fecha_ultimo_movimiento = now();
            $inventario->save();

            // Obtener el precio unitario del producto si no se especificó uno
            $precioUnitario = $request->precio_unitario ?? $inventario->producto->precio_unitario;

            // Crear movimiento
            MovimientoInventario::create([
                'producto_id' => $inventario->producto_id,
                'tipo_movimiento' => 'entrada',
                'cantidad' => $request->cantidad,
                'precio_unitario' => $precioUnitario,
                'precio_total' => $precioUnitario * $request->cantidad,
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones,
                'user_id' => Auth::id(),
                'documento_referencia' => $request->documento_referencia,
                'fecha_movimiento' => now(),
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Entrada registrada exitosamente']);
    }

    /**
     * Registrar salida de stock
     */
    public function salida(Request $request, $id)
    {
        $inventario = Inventario::findOrFail($id);

        $request->validate([
            'cantidad' => 'required|numeric|min:0.01|max:' . $inventario->stock_disponible,
            'motivo' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:500',
            'documento_referencia' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($request, $inventario) {
            // Actualizar stock
            $inventario->decrement('stock_actual', $request->cantidad);
            $inventario->decrement('stock_disponible', $request->cantidad);
            $inventario->fecha_ultimo_movimiento = now();
            $inventario->save();

            // Crear movimiento
            MovimientoInventario::create([
                'producto_id' => $inventario->producto_id,
                'tipo_movimiento' => 'salida',
                'cantidad' => $request->cantidad,
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones,
                'user_id' => Auth::id(),
                'documento_referencia' => $request->documento_referencia,
                'fecha_movimiento' => now(),
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Salida registrada exitosamente']);
    }

    /**
     * Ver movimientos de un producto
     */
    public function movimientos($id)
    {
        $inventario = Inventario::with(['producto.categoria'])->findOrFail($id);

        $movimientos = MovimientoInventario::with(['user'])
                                         ->where('producto_id', $inventario->producto_id)
                                         ->orderBy('created_at', 'desc')
                                         ->paginate(15);

        return view('inventarios.movimientos', compact('inventario', 'movimientos'));
    }
}
