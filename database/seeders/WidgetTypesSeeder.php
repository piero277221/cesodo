<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WidgetType;

class WidgetTypesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $widgets = [
            [
                'name' => 'dashboard_stats',
                'title' => 'Estadísticas Principales',
                'icon' => 'fas fa-chart-bar',
                'description' => 'Muestra las estadísticas principales del sistema: consumos, trabajadores, stock y pedidos',
                'default_config' => [
                    'show_consumos' => true,
                    'show_trabajadores' => true,
                    'show_stock' => true,
                    'show_pedidos' => true,
                    'refresh_interval' => 300 // 5 minutos
                ],
                'config_schema' => [
                    'show_consumos' => 'boolean',
                    'show_trabajadores' => 'boolean',
                    'show_stock' => 'boolean',
                    'show_pedidos' => 'boolean',
                    'refresh_interval' => 'integer'
                ],
                'component_view' => 'dashboard.widgets.stats',
                'requires_data' => true,
                'data_source' => 'dashboard_stats',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'consumos_chart',
                'title' => 'Gráfico de Consumos',
                'icon' => 'fas fa-chart-pie',
                'description' => 'Gráfico circular de consumos por tipo de comida del día actual',
                'default_config' => [
                    'chart_type' => 'doughnut',
                    'show_labels' => true,
                    'show_legend' => true,
                    'period' => 'today'
                ],
                'config_schema' => [
                    'chart_type' => 'string',
                    'show_labels' => 'boolean',
                    'show_legend' => 'boolean',
                    'period' => 'string'
                ],
                'component_view' => 'dashboard.widgets.consumos-chart',
                'requires_data' => true,
                'data_source' => 'consumos_chart',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'recent_consumos',
                'title' => 'Últimos Consumos',
                'icon' => 'fas fa-history',
                'description' => 'Lista de los consumos más recientes registrados en el sistema',
                'default_config' => [
                    'limit' => 5,
                    'show_trabajador' => true,
                    'show_fecha' => true,
                    'show_tipo' => true
                ],
                'config_schema' => [
                    'limit' => 'integer',
                    'show_trabajador' => 'boolean',
                    'show_fecha' => 'boolean',
                    'show_tipo' => 'boolean'
                ],
                'component_view' => 'dashboard.widgets.recent-consumos',
                'requires_data' => true,
                'data_source' => 'recent_consumos',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'quick_actions',
                'title' => 'Acciones Rápidas',
                'icon' => 'fas fa-rocket',
                'description' => 'Botones de acceso rápido a las funciones más utilizadas del sistema',
                'default_config' => [
                    'layout' => 'grid',
                    'show_icons' => true,
                    'items_per_row' => 6
                ],
                'config_schema' => [
                    'layout' => 'string',
                    'show_icons' => 'boolean',
                    'items_per_row' => 'integer'
                ],
                'component_view' => 'dashboard.widgets.quick-actions',
                'requires_data' => true,
                'data_source' => 'quick_actions',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'stock_alerts',
                'title' => 'Alertas de Stock',
                'icon' => 'fas fa-exclamation-triangle',
                'description' => 'Alertas de productos con stock bajo o agotado',
                'default_config' => [
                    'threshold' => 5,
                    'show_agotados' => true,
                    'limit' => 10
                ],
                'config_schema' => [
                    'threshold' => 'integer',
                    'show_agotados' => 'boolean',
                    'limit' => 'integer'
                ],
                'component_view' => 'dashboard.widgets.stock-alerts',
                'requires_data' => true,
                'data_source' => 'stock_alerts',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'trabajadores_stats',
                'title' => 'Estadísticas de Trabajadores',
                'icon' => 'fas fa-users',
                'description' => 'Resumen estadístico de trabajadores activos y consumos',
                'default_config' => [
                    'show_total' => true,
                    'show_activos' => true,
                    'show_nuevos' => true,
                    'show_consumos' => true
                ],
                'config_schema' => [
                    'show_total' => 'boolean',
                    'show_activos' => 'boolean',
                    'show_nuevos' => 'boolean',
                    'show_consumos' => 'boolean'
                ],
                'component_view' => 'dashboard.widgets.trabajadores-stats',
                'requires_data' => true,
                'data_source' => 'trabajadores_stats',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'pedidos_pendientes',
                'title' => 'Pedidos Pendientes',
                'icon' => 'fas fa-clock',
                'description' => 'Lista de pedidos pendientes de procesar',
                'default_config' => [
                    'limit' => 10,
                    'show_trabajador' => true,
                    'show_fecha' => true,
                    'auto_refresh' => true
                ],
                'config_schema' => [
                    'limit' => 'integer',
                    'show_trabajador' => 'boolean',
                    'show_fecha' => 'boolean',
                    'auto_refresh' => 'boolean'
                ],
                'component_view' => 'dashboard.widgets.pedidos-pendientes',
                'requires_data' => true,
                'data_source' => 'pedidos_pendientes',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'inventario_resumen',
                'title' => 'Resumen de Inventario',
                'icon' => 'fas fa-warehouse',
                'description' => 'Resumen general del estado del inventario',
                'default_config' => [
                    'show_total_productos' => true,
                    'show_stock_total' => true,
                    'show_valor' => true,
                    'currency' => 'PEN'
                ],
                'config_schema' => [
                    'show_total_productos' => 'boolean',
                    'show_stock_total' => 'boolean',
                    'show_valor' => 'boolean',
                    'currency' => 'string'
                ],
                'component_view' => 'dashboard.widgets.inventario-resumen',
                'requires_data' => true,
                'data_source' => 'inventario_resumen',
                'is_active' => true,
                'sort_order' => 8
            ],
            [
                'name' => 'calendario_consumos',
                'title' => 'Calendario de Consumos',
                'icon' => 'fas fa-calendar-alt',
                'description' => 'Vista de calendario con consumos del mes actual',
                'default_config' => [
                    'view_mode' => 'month',
                    'show_totals' => true,
                    'color_scheme' => 'blue'
                ],
                'config_schema' => [
                    'view_mode' => 'string',
                    'show_totals' => 'boolean',
                    'color_scheme' => 'string'
                ],
                'component_view' => 'dashboard.widgets.calendario-consumos',
                'requires_data' => true,
                'data_source' => 'calendario_consumos',
                'is_active' => true,
                'sort_order' => 9
            ],
            [
                'name' => 'welcome_banner',
                'title' => 'Banner de Bienvenida',
                'icon' => 'fas fa-home',
                'description' => 'Banner personalizable de bienvenida con información del usuario',
                'default_config' => [
                    'show_user_name' => true,
                    'show_date' => true,
                    'show_time' => true,
                    'custom_message' => '',
                    'background_gradient' => true
                ],
                'config_schema' => [
                    'show_user_name' => 'boolean',
                    'show_date' => 'boolean',
                    'show_time' => 'boolean',
                    'custom_message' => 'string',
                    'background_gradient' => 'boolean'
                ],
                'component_view' => 'dashboard.widgets.welcome-banner',
                'requires_data' => false,
                'data_source' => null,
                'is_active' => true,
                'sort_order' => 0
            ]
        ];

        foreach ($widgets as $widget) {
            WidgetType::updateOrCreate(
                ['name' => $widget['name']],
                $widget
            );
        }

        $this->command->info('✅ Tipos de widgets creados exitosamente:');
        foreach ($widgets as $widget) {
            $this->command->info("  - {$widget['title']} ({$widget['name']})");
        }
    }
}
