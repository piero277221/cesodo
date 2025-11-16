<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pedido::with(['proveedor', 'user']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_pedido', 'LIKE', "%{$search}%")
                  ->orWhereHas('proveedor', function($q2) use ($search) {
                      $q2->where('razon_social', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->proveedor_id);
        }

        $pedidos = $query->orderBy('created_at', 'desc')->paginate(15);
        $proveedores = Proveedor::where('estado', 'activo')->orderBy('razon_social')->get();

        // Estadísticas
        $estadisticas = [
            'pendientes' => Pedido::where('estado', 'pendiente')->count(),
            'confirmados' => Pedido::where('estado', 'confirmado')->count(),
            'entregados' => Pedido::where('estado', 'entregado')->count(),
            'total_mes' => Pedido::whereMonth('created_at', now()->month)->sum('total'),
        ];

        return view('pedidos.index', compact('pedidos', 'proveedores', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::where('estado', 'activo')->orderBy('razon_social')->get();
        $productos = Producto::where('estado', 'activo')->orderBy('nombre')->get();

        return view('pedidos.create', compact('proveedores', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_entrega_esperada' => 'required|date|after:today',
            'observaciones' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Generar número de pedido
        $ultimoPedido = Pedido::latest()->first();
        $numeroSecuencial = $ultimoPedido ? (int)substr($ultimoPedido->numero_pedido, -4) + 1 : 1;
        $numeroPedido = 'PED-' . date('Y') . '-' . str_pad($numeroSecuencial, 4, '0', STR_PAD_LEFT);

        // Calcular total
        $total = 0;
        foreach ($validated['productos'] as $producto) {
            $total += $producto['cantidad'] * $producto['precio_unitario'];
        }

        // Crear pedido
        $pedido = Pedido::create([
            'numero_pedido' => $numeroPedido,
            'proveedor_id' => $validated['proveedor_id'],
            'fecha_pedido' => now(),
            'fecha_entrega_esperada' => $validated['fecha_entrega_esperada'],
            'estado' => 'pendiente',
            'total' => $total,
            'observaciones' => $validated['observaciones'],
            'user_id' => Auth::id() ?? 1,
        ]);

        // Crear detalles del pedido
        foreach ($validated['productos'] as $producto) {
            $pedido->detalles()->create([
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $producto['cantidad'] * $producto['precio_unitario'],
            ]);
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(['proveedor', 'detalles.producto', 'user']);
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        if ($pedido->estado !== 'pendiente') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Solo se pueden editar pedidos en estado pendiente');
        }

        $proveedores = Proveedor::where('estado', 'activo')->orderBy('razon_social')->get();
        $productos = Producto::where('estado', 'activo')->orderBy('nombre')->get();
        $pedido->load('detalles.producto');

        return view('pedidos.edit', compact('pedido', 'proveedores', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        if ($pedido->estado !== 'pendiente') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Solo se pueden editar pedidos en estado pendiente');
        }

        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_entrega_esperada' => 'required|date',
            'observaciones' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Calcular nuevo total
        $total = 0;
        foreach ($validated['productos'] as $producto) {
            $total += $producto['cantidad'] * $producto['precio_unitario'];
        }

        // Actualizar pedido
        $pedido->update([
            'proveedor_id' => $validated['proveedor_id'],
            'fecha_entrega_esperada' => $validated['fecha_entrega_esperada'],
            'total' => $total,
            'observaciones' => $validated['observaciones'],
        ]);

        // Eliminar detalles existentes y crear nuevos
        $pedido->detalles()->delete();
        foreach ($validated['productos'] as $producto) {
            $pedido->detalles()->create([
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $producto['cantidad'] * $producto['precio_unitario'],
            ]);
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        if ($pedido->estado !== 'pendiente') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Solo se pueden eliminar pedidos en estado pendiente');
        }

        $numeroPedido = $pedido->numero_pedido;
        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('success', "Pedido {$numeroPedido} eliminado exitosamente");
    }

    /**
     * Confirmar pedido
     */
    public function confirmar(Pedido $pedido)
    {
        if ($pedido->estado !== 'pendiente') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Solo se pueden confirmar pedidos pendientes');
        }

        $pedido->update(['estado' => 'confirmado']);

        return redirect()->route('pedidos.index')
            ->with('success', "Pedido {$pedido->numero_pedido} confirmado exitosamente");
    }

    /**
     * Marcar como entregado
     */
    public function entregar(Pedido $pedido)
    {
        if ($pedido->estado !== 'confirmado') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Solo se pueden entregar pedidos confirmados');
        }

        $pedido->update([
            'estado' => 'entregado',
            'fecha_entrega_real' => now(),
        ]);

        return redirect()->route('pedidos.index')
            ->with('success', "Pedido {$pedido->numero_pedido} marcado como entregado");
    }
}
