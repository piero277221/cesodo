<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class WidgetType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'icon',
        'description',
        'default_config',
        'config_schema',
        'component_view',
        'requires_data',
        'data_source',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'default_config' => 'array',
        'config_schema' => 'array',
        'requires_data' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * Relación con widgets de usuarios
     */
    public function userWidgets(): HasMany
    {
        return $this->hasMany(UserDashboardWidget::class);
    }

    /**
     * Scope para widgets activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para widgets ordenados
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * Obtener datos del widget si requiere datos del backend
     */
    public function getData($config = null, $userId = null)
    {
        if (!$this->requires_data || !$this->data_source) {
            return null;
        }

        // Mapear data_sources a métodos
        $dataSources = [
            'dashboard_stats' => 'getDashboardStats',
            'recent_consumos' => 'getRecentConsumos',
            'consumos_chart' => 'getConsumosChart',
            'stock_alerts' => 'getStockAlerts',
            'quick_actions' => 'getQuickActions',
            'trabajadores_stats' => 'getTrabajadoresStats',
            'pedidos_pendientes' => 'getPedidosPendientes',
            'inventario_resumen' => 'getInventarioResumen',
            'ventas_hoy' => 'getVentasHoy',
            'calendario_consumos' => 'getCalendarioConsumos'
        ];

        if (isset($dataSources[$this->data_source])) {
            $method = $dataSources[$this->data_source];
            return $this->$method($config, $userId);
        }

        return null;
    }

    /**
     * Métodos para obtener datos específicos de cada widget
     */
    protected function getDashboardStats($config, $userId)
    {
        return [
            'consumos_hoy' => \App\Models\Consumo::whereDate('fecha_consumo', today())->count(),
            'trabajadores_activos' => \App\Models\Trabajador::where('activo', true)->count(),
            'productos_stock_bajo' => \App\Models\Inventario::where('stock', '<=', 5)->count(),
            'pedidos_pendientes' => \App\Models\Pedido::where('estado', 'pendiente')->count()
        ];
    }

    protected function getRecentConsumos($config, $userId)
    {
        $limit = $config['limit'] ?? 5;
        return \App\Models\Consumo::with('trabajador')
            ->orderBy('fecha_consumo', 'desc')
            ->limit($limit)
            ->get();
    }

    protected function getConsumosChart($config, $userId)
    {
        $period = $config['period'] ?? 'week';

        if ($period === 'week') {
            return \App\Models\Consumo::selectRaw('DATE(fecha_consumo) as fecha, COUNT(*) as total')
                ->where('fecha_consumo', '>=', now()->subWeek())
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->get();
        }

        return \App\Models\Consumo::selectRaw('tipo_comida, COUNT(*) as total')
            ->whereDate('fecha_consumo', today())
            ->groupBy('tipo_comida')
            ->get();
    }

    protected function getStockAlerts($config, $userId)
    {
        $threshold = $config['threshold'] ?? 5;
        return \App\Models\Inventario::with('producto')
            ->where('stock', '<=', $threshold)
            ->orderBy('stock')
            ->get();
    }

    protected function getQuickActions($config, $userId)
    {
        // Obtener acciones rápidas basadas en permisos del usuario
        $user = \App\Models\User::find($userId);
        $actions = [];

        if ($user && $user->can('crear-consumos')) {
            $actions[] = [
                'title' => 'Registrar Consumo',
                'url' => route('consumos.create'),
                'icon' => 'fas fa-utensils',
                'color' => 'primary'
            ];
        }

        if ($user && $user->can('ver-trabajadores')) {
            $actions[] = [
                'title' => 'Nuevo Trabajador',
                'url' => route('trabajadores.create'),
                'icon' => 'fas fa-user-plus',
                'color' => 'success'
            ];
        }

        if ($user && $user->can('ver-inventario')) {
            $actions[] = [
                'title' => 'Actualizar Stock',
                'url' => route('inventarios.index'),
                'icon' => 'fas fa-warehouse',
                'color' => 'info'
            ];
        }

        return $actions;
    }

    protected function getTrabajadoresStats($config, $userId)
    {
        return [
            'total' => \App\Models\Trabajador::count(),
            'activos' => \App\Models\Trabajador::where('activo', true)->count(),
            'nuevos_mes' => \App\Models\Trabajador::where('created_at', '>=', now()->startOfMonth())->count(),
            'consumos_hoy' => \App\Models\Consumo::whereDate('fecha_consumo', today())
                ->distinct('trabajador_id')
                ->count()
        ];
    }

    protected function getPedidosPendientes($config, $userId)
    {
        return \App\Models\Pedido::where('estado', 'pendiente')
            ->with('trabajador')
            ->orderBy('created_at', 'desc')
            ->limit($config['limit'] ?? 10)
            ->get();
    }

    protected function getInventarioResumen($config, $userId)
    {
        return [
            'total_productos' => \App\Models\Inventario::count(),
            'stock_total' => \App\Models\Inventario::sum('stock'),
            'productos_agotados' => \App\Models\Inventario::where('stock', 0)->count(),
            'valor_inventario' => \App\Models\Inventario::sum(DB::raw('stock * precio_unitario'))
        ];
    }

    protected function getVentasHoy($config, $userId)
    {
        return [
            'ventas_count' => 0, // Placeholder hasta implementar módulo de ventas
            'ventas_total' => 0,
            'productos_vendidos' => 0
        ];
    }

    protected function getCalendarioConsumos($config, $userId)
    {
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        return \App\Models\Consumo::selectRaw('DATE(fecha_consumo) as fecha, COUNT(*) as total')
            ->whereBetween('fecha_consumo', [$startDate, $endDate])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
    }
}
