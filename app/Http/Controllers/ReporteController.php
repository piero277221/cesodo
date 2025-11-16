<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumo;
use App\Models\Producto;
use App\Models\Trabajador;
use App\Models\Proveedor;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    /**
     * Muestra el reporte de ventas
     */
    public function ventas(Request $request)
    {
        $query = DB::table('ventas')
            ->select(
                'ventas.*',
                'clientes.nombre as cliente_nombre'
            )
            ->leftJoin('clientes', 'ventas.cliente_id', '=', 'clientes.id');

        // Aplicar filtros de fecha si están presentes
        if ($request->has('fecha_inicio')) {
            $query->where('fecha_venta', '>=', $request->fecha_inicio);
        }
        if ($request->has('fecha_fin')) {
            $query->where('fecha_venta', '<=', $request->fecha_fin);
        }

        // Obtener las ventas paginadas
        $ventas = $query->orderBy('fecha_venta', 'desc')
            ->paginate(15);

        // Calcular estadísticas
        $totalVentas = $ventas->sum('total');
        $cantidadVentas = $ventas->count();
        $promedioVentas = $cantidadVentas > 0 ? $totalVentas / $cantidadVentas : 0;

        return view('reportes.ventas', compact(
            'ventas',
            'totalVentas',
            'cantidadVentas',
            'promedioVentas'
        ));
    }

    /**
     * Página principal de reportes con dashboard de estadísticas
     */
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_consumos' => Consumo::count(),
            'total_productos' => Producto::count(),
            'total_trabajadores' => Trabajador::count(),
            'total_proveedores' => Proveedor::count(),
            'total_pedidos' => Pedido::count(),
        ];

        // Consumos por mes (últimos 12 meses) - solo conteo de registros
        $consumosPorMes = Consumo::select(
            DB::raw('YEAR(fecha_consumo) as año'),
            DB::raw('MONTH(fecha_consumo) as mes'),
            DB::raw('COUNT(*) as total')
        )
        ->where('fecha_consumo', '>=', Carbon::now()->subMonths(12))
        ->groupBy('año', 'mes')
        ->orderBy('año', 'desc')
        ->orderBy('mes', 'desc')
        ->get();

        // Top 5 tipos de comida más consumidos
        $topTiposComida = Consumo::select(
            'tipo_comida',
            DB::raw('COUNT(*) as total_consumos')
        )
        ->groupBy('tipo_comida')
        ->orderBy('total_consumos', 'desc')
        ->limit(5)
        ->get();

        // Top 5 trabajadores con más consumos
        $topTrabajadores = Consumo::select(
            'trabajadores.nombres',
            'trabajadores.apellidos',
            DB::raw('COUNT(*) as total_consumos')
        )
        ->join('trabajadores', 'consumos.trabajador_id', '=', 'trabajadores.id')
        ->groupBy('trabajadores.id', 'trabajadores.nombres', 'trabajadores.apellidos')
        ->orderBy('total_consumos', 'desc')
        ->limit(5)
        ->get();

        // Productos con stock bajo (menos de 10 unidades)
        $productosStockBajo = Producto::with('inventario')
            ->whereHas('inventario', function($query) {
                $query->where('stock_actual', '<', 10);
            })
            ->orderBy('inventarios.stock_actual', 'asc')
            ->join('inventarios', 'productos.id', '=', 'inventarios.producto_id')
            ->select('productos.*', 'inventarios.stock_actual')
            ->limit(10)
            ->get();

        return view('reportes.index', compact(
            'stats',
            'consumosPorMes',
            'topTiposComida',
            'topTrabajadores',
            'productosStockBajo'
        ));
    }

    /**
     * Reporte de consumos con filtros
     */
    public function consumos(Request $request)
    {
        $query = Consumo::with(['trabajador']);

        // Filtros
        if ($request->filled('fecha_inicio')) {
            $query->where('fecha_consumo', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->where('fecha_consumo', '<=', $request->fecha_fin);
        }

        if ($request->filled('tipo_comida')) {
            $query->where('tipo_comida', $request->tipo_comida);
        }

        if ($request->filled('trabajador_id')) {
            $query->where('trabajador_id', $request->trabajador_id);
        }

        $consumos = $query->orderBy('fecha_consumo', 'desc')->paginate(20);

        // Datos para los filtros
        $tiposComida = Consumo::distinct()->pluck('tipo_comida')->filter();
        $trabajadores = Trabajador::orderBy('apellidos')->get();

        return view('reportes.consumos', compact('consumos', 'tiposComida', 'trabajadores'));
    }

    /**
     * Reporte de inventario
     */
    public function inventario(Request $request)
    {
        $query = Producto::with('inventario');

        // Filtros
        if ($request->filled('categoria')) {
            $query->whereHas('categoria', function($q) use ($request) {
                $q->where('nombre', $request->categoria);
            });
        }

        if ($request->filled('stock_minimo')) {
            $query->whereHas('inventario', function($q) use ($request) {
                $q->where('stock_actual', '<=', $request->stock_minimo);
            });
        }

        $productos = $query->orderBy('nombre')->paginate(20);

        // Categorías para el filtro - usar la relación con categorias
        $categorias = \App\Models\Categoria::distinct()->pluck('nombre')->filter();

        // Estadísticas de inventario
        $inventarioStats = [
            'total_productos' => Producto::count(),
            'productos_sin_stock' => Producto::whereHas('inventario', function($query) {
                $query->where('stock_actual', 0);
            })->count(),
            'productos_stock_bajo' => Producto::whereHas('inventario', function($query) {
                $query->where('stock_actual', '<', 10);
            })->count(),
            'valor_total_inventario' => DB::table('productos')
                ->join('inventarios', 'productos.id', '=', 'inventarios.producto_id')
                ->sum(DB::raw('inventarios.stock_actual * productos.precio_unitario')),
        ];

        return view('reportes.inventario', compact('productos', 'categorias', 'inventarioStats'));
    }

    /**
     * Reporte de proveedores
     */
    public function proveedores(Request $request)
    {
        $query = Proveedor::withCount(['pedidos', 'productos']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('ruc', 'like', "%{$search}%")
                  ->orWhere('contacto', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->orderBy('razon_social')->paginate(20);

        return view('reportes.proveedores', compact('proveedores'));
    }

    // Métodos de exportación (implementación básica)
    public function exportarConsumosExcel(Request $request)
    {
        // Implementar exportación a Excel
        return redirect()->back()->with('info', 'Funcionalidad de exportación en desarrollo');
    }

    public function exportarConsumosPdf(Request $request)
    {
        // Implementar exportación a PDF
        return redirect()->back()->with('info', 'Funcionalidad de exportación en desarrollo');
    }

    public function exportarInventarioExcel(Request $request)
    {
        // Implementar exportación a Excel
        return redirect()->back()->with('info', 'Funcionalidad de exportación en desarrollo');
    }

    public function exportarInventarioPdf(Request $request)
    {
        // Implementar exportación a PDF
        return redirect()->back()->with('info', 'Funcionalidad de exportación en desarrollo');
    }
}
