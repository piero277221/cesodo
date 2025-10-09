<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Venta::with(['cliente', 'user']);

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('numero_venta', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function ($cq) use ($search) {
                      $cq->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->get('estado'));
        }

        if ($request->filled('tipo_pago')) {
            $query->where('tipo_pago', $request->get('tipo_pago'));
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->get('fecha_desde'));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->get('fecha_hasta'));
        }

        $ventas = $query->orderBy('fecha_venta', 'desc')
                       ->paginate(15);

        // Estadísticas para el dashboard
        $estadisticas = [
            'total_ventas_hoy' => Venta::whereDate('fecha_venta', today())->sum('total'),
            'cantidad_ventas_hoy' => Venta::whereDate('fecha_venta', today())->count(),
            'total_pendiente_cobro' => Venta::where('estado_pago', '!=', 'pagado')->sum('saldo_pendiente'),
        ];

        return view('ventas.index', compact('ventas', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre')->get();
        $productos = Producto::where('estado', 'activo')
                            ->with('categoria')
                            ->orderBy('nombre')
                            ->get();

        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_venta' => 'required|in:contado,credito,cortesia',
            'tipo_pago' => 'required|in:efectivo,tarjeta,transferencia,cheque,mixto',
            'fecha_venta' => 'required|date',
            'observaciones' => 'nullable|string|max:1000',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.001',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'productos.*.descuento' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Generar número de venta
            $numeroVenta = $this->generarNumeroVenta();

            // Crear la venta
            $venta = Venta::create([
                'numero_venta' => $numeroVenta,
                'cliente_id' => $validated['cliente_id'],
                'tipo_venta' => $validated['tipo_venta'],
                'tipo_pago' => $validated['tipo_pago'],
                'fecha_venta' => $validated['fecha_venta'],
                'observaciones' => $validated['observaciones'],
                'user_id' => Auth::id(),
                'estado' => 'procesada',
                'estado_pago' => $validated['tipo_venta'] === 'contado' ? 'pagado' : 'pendiente',
            ]);

            $subtotal = 0;

            // Crear los detalles de venta
            foreach ($validated['productos'] as $productoData) {
                $producto = Producto::find($productoData['id']);
                $cantidad = $productoData['cantidad'];
                $precioUnitario = $productoData['precio_unitario'];
                $descuento = $productoData['descuento'] ?? 0;
                $precioFinal = $precioUnitario - $descuento;
                $subtotalLinea = $cantidad * $precioFinal;

                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'descuento_unitario' => $descuento,
                    'precio_final' => $precioFinal,
                    'subtotal' => $subtotalLinea,
                ]);

                $subtotal += $subtotalLinea;

                // Actualizar stock si es necesario
                if ($producto->controla_stock) {
                    $producto->decrement('stock_actual', $cantidad);
                }
            }

            // Calcular totales
            $descuentoTotal = $request->get('descuento_total', 0);
            $impuestos = ($subtotal - $descuentoTotal) * 0.19; // IVA 19%
            $total = $subtotal - $descuentoTotal + $impuestos;

            $venta->update([
                'subtotal' => $subtotal,
                'descuento' => $descuentoTotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'saldo_pendiente' => $validated['tipo_venta'] === 'contado' ? 0 : $total,
                'total_pagado' => $validated['tipo_venta'] === 'contado' ? $total : 0,
            ]);

            DB::commit();

            return redirect()->route('ventas.show', $venta)
                ->with('success', 'Venta creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'detalles.producto', 'pagos', 'user']);

        return view('ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        // Solo permitir editar ventas en estado borrador
        if ($venta->estado !== 'borrador') {
            return redirect()->route('ventas.show', $venta)
                ->with('error', 'Solo se pueden editar ventas en estado borrador.');
        }

        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre')->get();
        $productos = Producto::where('estado', 'activo')
                            ->with('categoria')
                            ->orderBy('nombre')
                            ->get();

        $venta->load(['detalles.producto']);

        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        // Solo permitir actualizar ventas en estado borrador
        if ($venta->estado !== 'borrador') {
            return redirect()->route('ventas.show', $venta)
                ->with('error', 'Solo se pueden actualizar ventas en estado borrador.');
        }

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_venta' => 'required|in:contado,credito,cortesia',
            'tipo_pago' => 'required|in:efectivo,tarjeta,transferencia,cheque,mixto',
            'fecha_venta' => 'required|date',
            'observaciones' => 'nullable|string|max:1000',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.001',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'productos.*.descuento' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Revertir stock de productos anteriores
            foreach ($venta->detalles as $detalle) {
                if ($detalle->producto->controla_stock) {
                    $detalle->producto->increment('stock_actual', $detalle->cantidad);
                }
            }

            // Eliminar detalles anteriores
            $venta->detalles()->delete();

            $subtotal = 0;

            // Crear nuevos detalles
            foreach ($validated['productos'] as $productoData) {
                $producto = Producto::find($productoData['id']);
                $cantidad = $productoData['cantidad'];
                $precioUnitario = $productoData['precio_unitario'];
                $descuento = $productoData['descuento'] ?? 0;
                $precioFinal = $precioUnitario - $descuento;
                $subtotalLinea = $cantidad * $precioFinal;

                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'descuento_unitario' => $descuento,
                    'precio_final' => $precioFinal,
                    'subtotal' => $subtotalLinea,
                ]);

                $subtotal += $subtotalLinea;

                // Actualizar stock
                if ($producto->controla_stock) {
                    $producto->decrement('stock_actual', $cantidad);
                }
            }

            // Calcular totales
            $descuentoTotal = $request->get('descuento_total', 0);
            $impuestos = ($subtotal - $descuentoTotal) * 0.19;
            $total = $subtotal - $descuentoTotal + $impuestos;

            $venta->update([
                'cliente_id' => $validated['cliente_id'],
                'tipo_venta' => $validated['tipo_venta'],
                'tipo_pago' => $validated['tipo_pago'],
                'fecha_venta' => $validated['fecha_venta'],
                'observaciones' => $validated['observaciones'],
                'subtotal' => $subtotal,
                'descuento' => $descuentoTotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'saldo_pendiente' => $validated['tipo_venta'] === 'contado' ? 0 : $total,
                'total_pagado' => $validated['tipo_venta'] === 'contado' ? $total : 0,
                'estado_pago' => $validated['tipo_venta'] === 'contado' ? 'pagado' : 'pendiente',
            ]);

            DB::commit();

            return redirect()->route('ventas.show', $venta)
                ->with('success', 'Venta actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        // Solo permitir eliminar ventas en estado borrador
        if ($venta->estado !== 'borrador') {
            return redirect()->route('ventas.index')
                ->with('error', 'Solo se pueden eliminar ventas en estado borrador.');
        }

        DB::beginTransaction();

        try {
            // Revertir stock de productos
            foreach ($venta->detalles as $detalle) {
                if ($detalle->producto->controla_stock) {
                    $detalle->producto->increment('stock_actual', $detalle->cantidad);
                }
            }

            $venta->delete();

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('ventas.index')
                ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Generar número de venta secuencial
     */
    private function generarNumeroVenta()
    {
        $prefijo = 'V-' . date('Y') . '-';
        $ultimaVenta = Venta::where('numero_venta', 'like', $prefijo . '%')
                           ->orderBy('numero_venta', 'desc')
                           ->first();

        if ($ultimaVenta) {
            $ultimoNumero = (int) substr($ultimaVenta->numero_venta, strlen($prefijo));
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return $prefijo . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Confirmar venta (cambiar de borrador a procesada)
     */
    public function confirmar(Venta $venta)
    {
        if ($venta->estado !== 'borrador') {
            return redirect()->route('ventas.show', $venta)
                ->with('error', 'Solo se pueden confirmar ventas en estado borrador.');
        }

        $venta->update(['estado' => 'procesada']);

        return redirect()->route('ventas.show', $venta)
            ->with('success', 'Venta confirmada exitosamente.');
    }
}
