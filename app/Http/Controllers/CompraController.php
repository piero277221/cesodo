<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Compra::with(['proveedor', 'user']);

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('numero_compra', 'like', "%{$search}%")
                  ->orWhereHas('proveedor', function ($pq) use ($search) {
                      $pq->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->get('estado'));
        }

        if ($request->filled('tipo_compra')) {
            $query->where('tipo_compra', $request->get('tipo_compra'));
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_compra', '>=', $request->get('fecha_desde'));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_compra', '<=', $request->get('fecha_hasta'));
        }

        $compras = $query->orderBy('fecha_compra', 'desc')
                        ->paginate(15);

        // Estadísticas
        $totalComprasQuery = Compra::whereMonth('fecha_compra', date('m'))
                                   ->whereYear('fecha_compra', date('Y'));

        $estadisticas = [
            'total_compras_mes' => $totalComprasQuery->sum('total'),
            'compras_pendientes' => Compra::where('estado', 'enviado')->count(),
            'total_por_recibir' => Compra::whereIn('estado', ['enviado', 'confirmado'])->sum('total'),
        ];

        return view('compras.index', compact('compras', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::where('estado', 'activo')->orderBy('razon_social')->get();
        $productos = Producto::where('estado', 'activo')
                            ->with('categoria')
                            ->orderBy('nombre')
                            ->get();

        return view('compras.create', compact('proveedores', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'tipo_compra' => 'required|in:productos,insumos,equipos,servicios',
            'fecha_compra' => 'required|date',
            'fecha_entrega_esperada' => 'nullable|date|after:fecha_compra',
            'observaciones' => 'nullable|string|max:1000',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.001',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'productos.*.descuento' => 'nullable|numeric|min:0',
            'productos.*.fecha_vencimiento' => 'nullable|date',
            'productos.*.lote' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            // Generar número de compra
            $numeroCompra = $this->generarNumeroCompra();

            // Crear la compra
            $compra = Compra::create([
                'numero_compra' => $numeroCompra,
                'proveedor_id' => $validated['proveedor_id'],
                'tipo_compra' => $validated['tipo_compra'],
                'fecha_compra' => $validated['fecha_compra'],
                'fecha_entrega_esperada' => $validated['fecha_entrega_esperada'],
                'observaciones' => $validated['observaciones'],
                'user_id' => Auth::id(),
                'estado' => 'borrador',
                'estado_pago' => 'pendiente',
            ]);

            $subtotal = 0;

            // Crear los detalles de compra
            foreach ($validated['productos'] as $productoData) {
                $producto = Producto::find($productoData['id']);
                $cantidad = $productoData['cantidad'];
                $precioUnitario = $productoData['precio_unitario'];
                $descuento = $productoData['descuento'] ?? 0;
                $precioFinal = $precioUnitario - $descuento;
                $subtotalLinea = $cantidad * $precioFinal;

                CompraDetalle::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'unidad_medida' => $producto->unidad_medida ?? 'unidad',
                    'precio_unitario' => $precioUnitario,
                    'descuento_unitario' => $descuento,
                    'precio_final' => $precioFinal,
                    'subtotal' => $subtotalLinea,
                    'cantidad_pendiente' => $cantidad,
                    'fecha_vencimiento' => $productoData['fecha_vencimiento'] ?? null,
                    'lote' => $productoData['lote'] ?? null,
                    'estado' => 'pendiente',
                ]);

                $subtotal += $subtotalLinea;
            }

            // Calcular totales
            $descuentoTotal = $request->get('descuento_total', 0);
            $impuestos = ($subtotal - $descuentoTotal) * 0.19; // IVA 19%
            $total = $subtotal - $descuentoTotal + $impuestos;

            $compra->update([
                'subtotal' => $subtotal,
                'descuento' => $descuentoTotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'saldo_pendiente' => $total,
            ]);

            DB::commit();

            return redirect()->route('compras.show', $compra)
                ->with('success', 'Compra creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear la compra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        $compra->load(['proveedor', 'detalles.producto', 'user']);

        return view('compras.show', compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compra $compra)
    {
        // Solo permitir editar compras en estado borrador
        if ($compra->estado !== 'borrador') {
            return redirect()->route('compras.show', $compra)
                ->with('error', 'Solo se pueden editar compras en estado borrador.');
        }

        $proveedores = Proveedor::where('estado', 'activo')->orderBy('razon_social')->get();
        $productos = Producto::where('estado', 'activo')
                            ->with('categoria')
                            ->orderBy('nombre')
                            ->get();

        $compra->load(['detalles.producto']);

        return view('compras.edit', compact('compra', 'proveedores', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compra $compra)
    {
        // Solo permitir actualizar compras en estado borrador
        if ($compra->estado !== 'borrador') {
            return redirect()->route('compras.show', $compra)
                ->with('error', 'Solo se pueden actualizar compras en estado borrador.');
        }

        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'tipo_compra' => 'required|in:productos,insumos,equipos,servicios',
            'fecha_compra' => 'required|date',
            'fecha_entrega_esperada' => 'nullable|date|after:fecha_compra',
            'observaciones' => 'nullable|string|max:1000',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.001',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'productos.*.descuento' => 'nullable|numeric|min:0',
            'productos.*.fecha_vencimiento' => 'nullable|date',
            'productos.*.lote' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            // Eliminar detalles anteriores
            $compra->detalles()->delete();

            $subtotal = 0;

            // Crear nuevos detalles
            foreach ($validated['productos'] as $productoData) {
                $producto = Producto::find($productoData['id']);
                $cantidad = $productoData['cantidad'];
                $precioUnitario = $productoData['precio_unitario'];
                $descuento = $productoData['descuento'] ?? 0;
                $precioFinal = $precioUnitario - $descuento;
                $subtotalLinea = $cantidad * $precioFinal;

                CompraDetalle::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'unidad_medida' => $producto->unidad_medida ?? 'unidad',
                    'precio_unitario' => $precioUnitario,
                    'descuento_unitario' => $descuento,
                    'precio_final' => $precioFinal,
                    'subtotal' => $subtotalLinea,
                    'cantidad_pendiente' => $cantidad,
                    'fecha_vencimiento' => $productoData['fecha_vencimiento'] ?? null,
                    'lote' => $productoData['lote'] ?? null,
                    'estado' => 'pendiente',
                ]);

                $subtotal += $subtotalLinea;
            }

            // Calcular totales
            $descuentoTotal = $request->get('descuento_total', 0);
            $impuestos = ($subtotal - $descuentoTotal) * 0.19;
            $total = $subtotal - $descuentoTotal + $impuestos;

            $compra->update([
                'proveedor_id' => $validated['proveedor_id'],
                'tipo_compra' => $validated['tipo_compra'],
                'fecha_compra' => $validated['fecha_compra'],
                'fecha_entrega_esperada' => $validated['fecha_entrega_esperada'],
                'observaciones' => $validated['observaciones'],
                'subtotal' => $subtotal,
                'descuento' => $descuentoTotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'saldo_pendiente' => $total,
            ]);

            DB::commit();

            return redirect()->route('compras.show', $compra)
                ->with('success', 'Compra actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al actualizar la compra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compra $compra)
    {
        // Solo permitir eliminar compras en estado borrador
        if ($compra->estado !== 'borrador') {
            return redirect()->route('compras.index')
                ->with('error', 'Solo se pueden eliminar compras en estado borrador.');
        }

        $compra->delete();

        return redirect()->route('compras.index')
            ->with('success', 'Compra eliminada exitosamente.');
    }

    /**
     * Generar número de compra secuencial
     */
    private function generarNumeroCompra()
    {
        $prefijo = 'C-' . date('Y') . '-';
        $ultimaCompra = Compra::where('numero_compra', 'like', $prefijo . '%')
                             ->orderBy('numero_compra', 'desc')
                             ->first();

        if ($ultimaCompra) {
            $ultimoNumero = (int) substr($ultimaCompra->numero_compra, strlen($prefijo));
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return $prefijo . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Enviar compra al proveedor (cambiar de borrador a enviado)
     */
    public function enviar(Compra $compra)
    {
        if ($compra->estado !== 'borrador') {
            return redirect()->route('compras.show', $compra)
                ->with('error', 'Solo se pueden enviar compras en estado borrador.');
        }

        $compra->update(['estado' => 'enviado']);

        return redirect()->route('compras.show', $compra)
            ->with('success', 'Compra enviada al proveedor exitosamente.');
    }

    /**
     * Recibir mercadería de la compra
     */
    public function recibir(Request $request, Compra $compra)
    {
        if (!in_array($compra->estado, ['enviado', 'confirmado'])) {
            return redirect()->route('compras.show', $compra)
                ->with('error', 'Solo se pueden recibir compras enviadas o confirmadas.');
        }

        $validated = $request->validate([
            'productos' => 'required|array',
            'productos.*.detalle_id' => 'required|exists:compra_detalles,id',
            'productos.*.cantidad_recibida' => 'required|numeric|min:0',
            'productos.*.fecha_vencimiento' => 'nullable|date',
            'productos.*.lote' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $totalRecibido = true;

            foreach ($validated['productos'] as $prodData) {
                $detalle = CompraDetalle::find($prodData['detalle_id']);
                $cantidadRecibida = $prodData['cantidad_recibida'];

                // Actualizar detalle
                $detalle->cantidad_recibida += $cantidadRecibida;
                $detalle->cantidad_pendiente = $detalle->cantidad - $detalle->cantidad_recibida;

                if ($detalle->cantidad_pendiente > 0) {
                    $detalle->estado = 'parcial';
                    $totalRecibido = false;
                } else {
                    $detalle->estado = 'recibido';
                }

                if ($prodData['fecha_vencimiento']) {
                    $detalle->fecha_vencimiento = $prodData['fecha_vencimiento'];
                }

                if ($prodData['lote']) {
                    $detalle->lote = $prodData['lote'];
                }

                $detalle->save();

                // Actualizar stock del producto
                if ($detalle->producto->controla_stock) {
                    $detalle->producto->increment('stock_actual', $cantidadRecibida);
                }
            }

            // Actualizar estado de la compra
            if ($totalRecibido) {
                $compra->update([
                    'estado' => 'recibido',
                    'fecha_entrega_real' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('compras.show', $compra)
                ->with('success', 'Mercadería recibida exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al recibir mercadería: ' . $e->getMessage());
        }
    }
}
