<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WidgetType;
use App\Models\UserDashboardWidget;
use App\Models\DashboardLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardWidgetController extends Controller
{
    /**
     * Mostrar el editor de dashboard
     */
    public function editor()
    {
        $user = Auth::user();
        $availableWidgets = WidgetType::active()->ordered()->get();
        $userWidgets = $user->dashboardWidgets()->with('widgetType')->visible()->ordered()->get();
        $layouts = DashboardLayout::accessibleBy($user->id)->get();

        return view('dashboard.editor', compact('availableWidgets', 'userWidgets', 'layouts'));
    }

    /**
     * Obtener configuración del dashboard del usuario
     */
    public function getConfig()
    {
        $user = Auth::user();
        $widgets = $user->dashboardWidgets()
            ->with('widgetType')
            ->visible()
            ->ordered()
            ->get()
            ->map(function ($widget) {
                return [
                    'id' => $widget->widget_id,
                    'type' => $widget->widgetType->name,
                    'title' => $widget->display_title,
                    'config' => $widget->full_config,
                    'position' => $widget->position,
                    'is_collapsed' => $widget->is_collapsed,
                    'content' => $widget->render()
                ];
            });

        return response()->json([
            'widgets' => $widgets,
            'grid_config' => [
                'columns' => 12,
                'row_height' => 150,
                'margin' => 10
            ]
        ]);
    }

    /**
     * Agregar widget al dashboard del usuario
     */
    public function addWidget(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'widget_type_id' => 'required|exists:widget_types,id',
            'title' => 'nullable|string|max:255',
            'config' => 'nullable|array',
            'position' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = Auth::user();
            $widgetType = WidgetType::findOrFail($request->widget_type_id);

            // Obtener el próximo sort_order
            $maxOrder = $user->dashboardWidgets()->max('sort_order') ?? 0;

            $widget = UserDashboardWidget::create([
                'user_id' => $user->id,
                'widget_type_id' => $widgetType->id,
                'title' => $request->title,
                'config' => $request->config ?? [],
                'position' => $request->position ?? ['x' => 0, 'y' => 0, 'w' => 6, 'h' => 4],
                'sort_order' => $maxOrder + 1
            ]);

            $widget->load('widgetType');

            return response()->json([
                'success' => true,
                'widget' => [
                    'id' => $widget->widget_id,
                    'type' => $widget->widgetType->name,
                    'title' => $widget->display_title,
                    'config' => $widget->full_config,
                    'position' => $widget->position,
                    'is_collapsed' => $widget->is_collapsed,
                    'content' => $widget->render()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar widget: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar configuración de widget
     */
    public function updateWidget(Request $request, $widgetId)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'config' => 'nullable|array',
            'position' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = Auth::user();
            $widget = $user->dashboardWidgets()->where('widget_id', $widgetId)->firstOrFail();

            if ($request->has('title')) {
                $widget->title = $request->title;
            }

            if ($request->has('config')) {
                $widget->updateConfig($request->config);
            }

            if ($request->has('position')) {
                $widget->updatePosition($request->position);
            }

            $widget->save();
            $widget->load('widgetType');

            return response()->json([
                'success' => true,
                'widget' => [
                    'id' => $widget->widget_id,
                    'type' => $widget->widgetType->name,
                    'title' => $widget->display_title,
                    'config' => $widget->full_config,
                    'position' => $widget->position,
                    'is_collapsed' => $widget->is_collapsed,
                    'content' => $widget->render()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar widget: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar posiciones de múltiples widgets
     */
    public function updatePositions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'widgets' => 'required|array',
            'widgets.*.id' => 'required|string',
            'widgets.*.position' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();

            foreach ($request->widgets as $widgetData) {
                $widget = $user->dashboardWidgets()
                    ->where('widget_id', $widgetData['id'])
                    ->first();

                if ($widget) {
                    $widget->updatePosition($widgetData['position']);
                }
            }

            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar posiciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar widget del dashboard
     */
    public function removeWidget($widgetId)
    {
        try {
            $user = Auth::user();
            $widget = $user->dashboardWidgets()->where('widget_id', $widgetId)->firstOrFail();

            $widget->delete();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar widget: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Alternar visibilidad de widget
     */
    public function toggleVisibility($widgetId)
    {
        try {
            $user = Auth::user();
            $widget = $user->dashboardWidgets()->where('widget_id', $widgetId)->firstOrFail();

            $widget->toggleVisibility();

            return response()->json([
                'success' => true,
                'is_visible' => $widget->is_visible
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar visibilidad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Alternar estado colapsado de widget
     */
    public function toggleCollapsed($widgetId)
    {
        try {
            $user = Auth::user();
            $widget = $user->dashboardWidgets()->where('widget_id', $widgetId)->firstOrFail();

            $widget->toggleCollapsed();

            return response()->json([
                'success' => true,
                'is_collapsed' => $widget->is_collapsed
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener datos actualizados de un widget
     */
    public function getWidgetData($widgetId)
    {
        try {
            $user = Auth::user();
            $widget = $user->dashboardWidgets()
                ->with('widgetType')
                ->where('widget_id', $widgetId)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $widget->getData(),
                'content' => $widget->render()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restablecer dashboard a configuración por defecto
     */
    public function resetToDefault()
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();

            // Eliminar widgets actuales
            $user->dashboardWidgets()->delete();

            // Crear widgets por defecto
            $defaultWidgets = [
                ['type' => 'welcome_banner', 'position' => ['x' => 0, 'y' => 0, 'w' => 12, 'h' => 3]],
                ['type' => 'dashboard_stats', 'position' => ['x' => 0, 'y' => 3, 'w' => 12, 'h' => 4]],
                ['type' => 'consumos_chart', 'position' => ['x' => 0, 'y' => 7, 'w' => 6, 'h' => 6]],
                ['type' => 'recent_consumos', 'position' => ['x' => 6, 'y' => 7, 'w' => 6, 'h' => 6]],
                ['type' => 'quick_actions', 'position' => ['x' => 0, 'y' => 13, 'w' => 12, 'h' => 4]]
            ];

            foreach ($defaultWidgets as $index => $widgetData) {
                $widgetType = WidgetType::where('name', $widgetData['type'])->first();

                if ($widgetType) {
                    UserDashboardWidget::create([
                        'user_id' => $user->id,
                        'widget_type_id' => $widgetType->id,
                        'position' => $widgetData['position'],
                        'sort_order' => $index + 1
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al restablecer dashboard: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar configuración actual como layout
     */
    public function saveAsLayout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_public' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = Auth::user();

            $layout = DashboardLayout::createFromUser(
                $user,
                $request->name,
                $request->description
            );

            if ($request->is_public) {
                $layout->is_public = true;
                $layout->save();
            }

            return response()->json([
                'success' => true,
                'layout' => $layout
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar layout: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Aplicar layout al dashboard del usuario
     */
    public function applyLayout(Request $request, $layoutId)
    {
        try {
            $user = Auth::user();
            $layout = DashboardLayout::accessibleBy($user->id)->findOrFail($layoutId);

            $layout->applyToUser($user);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aplicar layout: ' . $e->getMessage()
            ], 500);
        }
    }
}
