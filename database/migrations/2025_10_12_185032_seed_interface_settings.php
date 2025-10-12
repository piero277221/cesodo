<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SystemSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Configuración de Tema Visual
        $themeSettings = [
            'tema_sistema' => ['value' => 'light', 'description' => 'Tema del sistema (light, dark, auto)'],
            'color_primario' => ['value' => '#dc2626', 'description' => 'Color primario del sistema (Rojo CESODO)'],
            'color_secundario' => ['value' => '#1a1a1a', 'description' => 'Color secundario (Negro CESODO)'],
            'border_radius' => ['value' => 'medium', 'description' => 'Redondeo de esquinas (none, small, medium, large)'],
            'font_size_base' => ['value' => 'medium', 'description' => 'Tamaño de fuente base (small, medium, large)'],
            'densidad_interfaz' => ['value' => 'normal', 'description' => 'Densidad de interfaz (compact, normal, comfortable)'],
        ];

        foreach ($themeSettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'interfaz',
                    'type' => 'text',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Configuración de Navegación
        $navigationSettings = [
            'sidebar_tipo' => ['value' => 'fixed', 'description' => 'Tipo de menú lateral (fixed, collapsible, mini)'],
            'logo_position' => ['value' => 'left', 'description' => 'Posición del logo (left, center, right)'],
            'mostrar_breadcrumbs' => ['value' => '1', 'description' => 'Mostrar breadcrumbs de navegación'],
            'menu_mostrar_iconos' => ['value' => '1', 'description' => 'Mostrar iconos en menú'],
            'animaciones_habilitadas' => ['value' => '1', 'description' => 'Habilitar animaciones y transiciones'],
        ];

        foreach ($navigationSettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'interfaz',
                    'type' => in_array($key, ['mostrar_breadcrumbs', 'menu_mostrar_iconos', 'animaciones_habilitadas']) ? 'boolean' : 'text',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Configuración de Tablas
        $tableSettings = [
            'tabla_filas_alternas' => ['value' => '1', 'description' => 'Filas alternas en tablas'],
            'tabla_bordes' => ['value' => '1', 'description' => 'Bordes en tablas'],
            'tabla_hover' => ['value' => '1', 'description' => 'Efecto hover en filas'],
            'tabla_tamano' => ['value' => 'normal', 'description' => 'Tamaño de tablas (sm, normal, lg)'],
            'tabla_acciones_posicion' => ['value' => 'right', 'description' => 'Posición de acciones (left, right)'],
        ];

        foreach ($tableSettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'interfaz',
                    'type' => in_array($key, ['tabla_filas_alternas', 'tabla_bordes', 'tabla_hover']) ? 'boolean' : 'text',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Configuración de Dashboard
        $dashboardSettings = [
            'dashboard_card_style' => ['value' => 'shadow', 'description' => 'Estilo de cards (flat, shadow, bordered)'],
            'dashboard_layout' => ['value' => 'grid-3', 'description' => 'Distribución de widgets (grid-2, grid-3, grid-4)'],
            'dashboard_graficos_animados' => ['value' => '1', 'description' => 'Gráficos animados'],
            'dashboard_auto_refresh' => ['value' => '0', 'description' => 'Actualización automática cada 5 min'],
            'dashboard_widgets_compactos' => ['value' => '0', 'description' => 'Widgets compactos'],
        ];

        foreach ($dashboardSettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'interfaz',
                    'type' => in_array($key, ['dashboard_graficos_animados', 'dashboard_auto_refresh', 'dashboard_widgets_compactos']) ? 'boolean' : 'text',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Configuración de Accesibilidad
        $accessibilitySettings = [
            'alto_contraste' => ['value' => '0', 'description' => 'Modo alto contraste'],
            'texto_grande' => ['value' => '0', 'description' => 'Aumentar tamaño de texto'],
            'reducir_movimiento' => ['value' => '0', 'description' => 'Reducir animaciones'],
        ];

        foreach ($accessibilitySettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'interfaz',
                    'type' => 'boolean',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar todas las configuraciones de interfaz
        $keys = [
            'tema_sistema', 'color_primario', 'color_secundario', 'border_radius', 
            'font_size_base', 'densidad_interfaz',
            'sidebar_tipo', 'logo_position', 'mostrar_breadcrumbs', 'menu_mostrar_iconos', 
            'animaciones_habilitadas',
            'tabla_filas_alternas', 'tabla_bordes', 'tabla_hover', 'tabla_tamano', 
            'tabla_acciones_posicion',
            'dashboard_card_style', 'dashboard_layout', 'dashboard_graficos_animados', 
            'dashboard_auto_refresh', 'dashboard_widgets_compactos',
            'alto_contraste', 'texto_grande', 'reducir_movimiento',
        ];

        SystemSetting::whereIn('key', $keys)->delete();
    }
};
