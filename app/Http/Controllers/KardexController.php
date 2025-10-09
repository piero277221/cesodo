<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KardexController extends Controller
{
    /**
     * Mostrar el kardex general o por producto
     */
    public function index(Request $request)
    {
        $modulo = $request->get('modulo', 'inventario'); // default inventario

        $query = Kardex::with(['producto.categoria', 'user'])
                      ->where('modulo', $modulo);

        // Filtro por producto
        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        // Filtro por tipo de movimiento
        if ($request->filled('tipo_movimiento')) {
            $query->where('tipo_movimiento', $request->tipo_movimiento);
        }

        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->whereHas('producto', function($q) use ($request) {
                $q->where('categoria_id', $request->categoria_id);
            });
        }

        $movimientos = $query->orderBy('fecha', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        $productos = Producto::orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->get();

        // Estadísticas
        $estadisticas = $this->obtenerEstadisticas($request, $modulo);

        return view('kardex.index', compact('movimientos', 'productos', 'categorias', 'estadisticas', 'modulo'));
    }

    /**
     * Mostrar formulario para crear nuevo movimiento
     */
    public function create()
    {
        $productos = Producto::with('categoria')->orderBy('nombre')->get();
        return view('kardex.create', compact('productos'));
    }

    /**
     * Mostrar kardex de un producto específico
     */
    public function porProducto(Request $request, Producto $producto)
    {
        $modulo = $request->get('modulo', 'inventario'); // default inventario

        $query = Kardex::where('producto_id', $producto->id)
                      ->where('modulo', $modulo)
                      ->with(['user']);

        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }

        // Filtro por tipo de movimiento
        if ($request->filled('tipo_movimiento')) {
            $query->where('tipo_movimiento', $request->tipo_movimiento);
        }

        $movimientos = $query->orderBy('fecha', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Obtener saldos y estadísticas del producto
        $saldoActual = $this->obtenerSaldoActual($producto->id, $modulo);
        $estadisticasProducto = $this->obtenerEstadisticasProducto($producto->id, $request, $modulo);

        return view('kardex.producto', compact('producto', 'movimientos', 'saldoActual', 'estadisticasProducto', 'modulo'));
    }

    /**
     * Crear un nuevo movimiento de kardex
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'fecha' => 'required|date',
            'tipo_movimiento' => 'required|in:entrada,salida,ajuste',
            'modulo' => 'required|in:inventario,consumos,compras',
            'concepto' => 'required|string|max:255',
            'cantidad_entrada' => 'nullable|integer|min:0',
            'cantidad_salida' => 'nullable|integer|min:0',
            'precio_unitario' => 'nullable|numeric|min:0',
            'numero_documento' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
        ]);

        // Validar que solo uno de entrada o salida tenga valor
        if (($request->cantidad_entrada > 0 && $request->cantidad_salida > 0) ||
            ($request->cantidad_entrada == 0 && $request->cantidad_salida == 0)) {
            return back()->withErrors(['cantidad' => 'Debe especificar cantidad de entrada O salida, no ambas.']);
        }

        $modulo = $request->modulo;

        try {
            DB::transaction(function () use ($request, $modulo) {
                // Obtener saldo anterior
                $saldoAnterior = $this->obtenerSaldoActual($request->producto_id, $modulo);

                // Calcular nuevo saldo
                $cantidadMovimiento = $request->cantidad_entrada ?: -$request->cantidad_salida;
                $nuevoSaldo = $saldoAnterior['cantidad'] + $cantidadMovimiento;

                // Validar que no quede en negativo para inventario
                if ($modulo === 'inventario' && $nuevoSaldo < 0) {
                    throw new \Exception('El movimiento resultaría en stock negativo.');
                }

                // Para consumos, permitir saldo negativo pero advertir
                if ($modulo === 'consumos' && $nuevoSaldo < 0) {
                    $nuevoSaldo = 0; // Resetear a 0 en consumos
                }

                // Calcular valor del saldo
                $precioUnitario = $request->precio_unitario ?: $saldoAnterior['precio_promedio'];
                $nuevoValorSaldo = $nuevoSaldo * $precioUnitario;

                // Crear el movimiento
                Kardex::create([
                    'producto_id' => $request->producto_id,
                    'fecha' => $request->fecha,
                    'tipo_movimiento' => $request->tipo_movimiento,
                    'modulo' => $modulo,
                    'concepto' => $request->concepto,
                    'numero_documento' => $request->numero_documento,
                    'cantidad_entrada' => $request->cantidad_entrada ?: 0,
                    'cantidad_salida' => $request->cantidad_salida ?: 0,
                    'precio_unitario' => $precioUnitario,
                    'saldo_cantidad' => $nuevoSaldo,
                    'saldo_valor' => $nuevoValorSaldo,
                    'observaciones' => $request->observaciones,
                    'user_id' => Auth::id(),
                    'referencia_tipo' => 'manual',
                    'referencia_id' => null,
                ]);

                // Actualizar el stock del producto solo si es inventario
                if ($modulo === 'inventario') {
                    $this->actualizarInventario($request->producto_id, $nuevoSaldo);
                }
            });

            return redirect()->route('kardex.index', ['modulo' => $modulo])
                           ->with('success', 'Movimiento de kardex registrado exitosamente.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }    /**
     * Obtener el saldo actual de un producto
     */
    private function obtenerSaldoActual($productoId, $modulo = 'inventario')
    {
        $ultimoMovimiento = Kardex::where('producto_id', $productoId)
                                 ->where('modulo', $modulo)
                                 ->orderBy('fecha', 'desc')
                                 ->orderBy('created_at', 'desc')
                                 ->first();

        if (!$ultimoMovimiento) {
            return ['cantidad' => 0, 'valor' => 0, 'precio_promedio' => 0];
        }

        $precioPromedio = $ultimoMovimiento->saldo_cantidad > 0
                         ? $ultimoMovimiento->saldo_valor / $ultimoMovimiento->saldo_cantidad
                         : 0;

        return [
            'cantidad' => $ultimoMovimiento->saldo_cantidad,
            'valor' => $ultimoMovimiento->saldo_valor,
            'precio_promedio' => $precioPromedio
        ];
    }

    /**
     * Obtener estadísticas generales
     */
    private function obtenerEstadisticas($request, $modulo = 'inventario')
    {
        $query = Kardex::where('modulo', $modulo);

        // Aplicar mismos filtros que en el índice
        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        if ($request->filled('categoria_id')) {
            $query->whereHas('producto', function($q) use ($request) {
                $q->where('categoria_id', $request->categoria_id);
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }

        if ($request->filled('tipo_movimiento')) {
            $query->where('tipo_movimiento', $request->tipo_movimiento);
        }

        $totalIngresos = $query->clone()->sum('cantidad_entrada');
        $totalEgresos = $query->clone()->sum('cantidad_salida');
        $totalMovimientos = $query->count();
        $productosUnicos = $query->clone()->distinct('producto_id')->count();

        return [
            'total_ingresos' => $totalIngresos,
            'total_egresos' => $totalEgresos,
            'total_movimientos' => $totalMovimientos,
            'productos_unicos' => $productosUnicos,
            'valor_ingresos' => $query->clone()->where('cantidad_entrada', '>', 0)->sum(DB::raw('cantidad_entrada * precio_unitario')),
            'valor_egresos' => $query->clone()->where('cantidad_salida', '>', 0)->sum(DB::raw('cantidad_salida * precio_unitario')),
        ];
    }

    /**
     * Obtener estadísticas de un producto específico
     */
    private function obtenerEstadisticasProducto($productoId, $request, $modulo = 'inventario')
    {
        $query = Kardex::where('producto_id', $productoId)
                      ->where('modulo', $modulo);

        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }

        return [
            'total_entradas' => $query->clone()->sum('cantidad_entrada'),
            'total_salidas' => $query->clone()->sum('cantidad_salida'),
            'valor_entradas' => $query->clone()->where('cantidad_entrada', '>', 0)->sum(DB::raw('cantidad_entrada * precio_unitario')),
            'valor_salidas' => $query->clone()->where('cantidad_salida', '>', 0)->sum(DB::raw('cantidad_salida * precio_unitario')),
            'movimientos_count' => $query->count(),
        ];
    }

    /**
     * Actualizar el inventario después de un movimiento
     */
    private function actualizarInventario($productoId, $nuevaCantidad)
    {
        // Actualizar o crear registro en inventarios
        $inventario = \App\Models\Inventario::firstOrNew(['producto_id' => $productoId]);
        $inventario->stock_actual = $nuevaCantidad;
        $inventario->fecha_ultimo_movimiento = now();
        $inventario->save();
    }

    /**
     * Generar reporte de kardex
     */
    public function reporte(Request $request)
    {
        // Esta función se puede implementar para generar reportes en Excel/PDF
        return response()->json(['message' => 'Funcionalidad de reporte en desarrollo']);
    }

    /**
     * Exportar kardex de un producto específico
     */
    public function exportarProducto(Request $request, Producto $producto)
    {
        // Esta función se puede implementar para exportar el kardex de un producto específico
        return response()->json(['message' => 'Funcionalidad de exportación en desarrollo']);
    }

    /**
     * Registrar movimiento de kardex por consumo
     */
    public static function registrarConsumo($productoId, $cantidad, $trabajadorId, $fechaConsumo, $userId, $tipoComida = 'Consumo general')
    {
        $producto = Producto::find($productoId);
        if (!$producto) {
            return false;
        }

        // Obtener el último saldo del producto en consumos
        $ultimoMovimiento = Kardex::where('producto_id', $productoId)
                                 ->where('modulo', 'consumos')
                                 ->orderBy('fecha', 'desc')
                                 ->orderBy('created_at', 'desc')
                                 ->first();

        $saldoAnterior = $ultimoMovimiento ? $ultimoMovimiento->saldo_cantidad : 0;
        $nuevoSaldo = $saldoAnterior - $cantidad; // Los consumos son salidas

        // Validar que no quede en negativo
        if ($nuevoSaldo < 0) {
            $nuevoSaldo = 0; // Para consumos, permitimos que quede en 0
        }

        // Precio unitario del producto
        $precioUnitario = $producto->precio ?: 0;
        $valorSaldo = $nuevoSaldo * $precioUnitario;

        // Crear el movimiento en kardex
        Kardex::create([
            'producto_id' => $productoId,
            'fecha' => $fechaConsumo,
            'tipo_movimiento' => 'salida',
            'modulo' => 'consumos',
            'concepto' => "Consumo - {$tipoComida}",
            'numero_documento' => null,
            'cantidad_entrada' => 0,
            'cantidad_salida' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'saldo_cantidad' => $nuevoSaldo,
            'saldo_valor' => $valorSaldo,
            'observaciones' => "Consumo registrado por trabajador ID: {$trabajadorId}",
            'user_id' => $userId,
            'referencia_tipo' => 'consumo',
            'referencia_id' => null, // Se puede actualizar después con el ID del consumo si es necesario
        ]);

        return true;
    }

    /**
     * Transferir productos desde inventario a consumos
     */
    public function transferirAConsumos(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'concepto' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $productoId = $request->producto_id;
            $cantidad = $request->cantidad;

            // 1. Salida de inventario
            $saldoInventario = $this->obtenerSaldoActual($productoId, 'inventario');
            $nuevoSaldoInventario = $saldoInventario['cantidad'] - $cantidad;

            if ($nuevoSaldoInventario < 0) {
                throw new \Exception('No hay suficiente stock en inventario.');
            }

            // Registrar salida en inventario
            Kardex::create([
                'producto_id' => $productoId,
                'fecha' => now()->toDateString(),
                'tipo_movimiento' => 'salida',
                'modulo' => 'inventario',
                'concepto' => 'Transferencia a consumos: ' . $request->concepto,
                'cantidad_entrada' => 0,
                'cantidad_salida' => $cantidad,
                'precio_unitario' => $saldoInventario['precio_promedio'],
                'saldo_cantidad' => $nuevoSaldoInventario,
                'saldo_valor' => $nuevoSaldoInventario * $saldoInventario['precio_promedio'],
                'user_id' => Auth::id(),
            ]);

            // Actualizar inventario físico
            $this->actualizarInventario($productoId, $nuevoSaldoInventario);

            // 2. Entrada en consumos
            $saldoConsumos = $this->obtenerSaldoActual($productoId, 'consumos');
            $nuevoSaldoConsumos = $saldoConsumos['cantidad'] + $cantidad;

            Kardex::create([
                'producto_id' => $productoId,
                'fecha' => now()->toDateString(),
                'tipo_movimiento' => 'entrada',
                'modulo' => 'consumos',
                'concepto' => 'Transferencia desde inventario: ' . $request->concepto,
                'cantidad_entrada' => $cantidad,
                'cantidad_salida' => 0,
                'precio_unitario' => $saldoInventario['precio_promedio'],
                'saldo_cantidad' => $nuevoSaldoConsumos,
                'saldo_valor' => $nuevoSaldoConsumos * $saldoInventario['precio_promedio'],
                'user_id' => Auth::id(),
            ]);
        });

        return back()->with('success', 'Transferencia realizada exitosamente.');
    }
}
