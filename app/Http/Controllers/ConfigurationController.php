<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $module = $request->get('module', 'all');
        $category = $request->get('category', 'all');

        $query = SystemSetting::query();

        // Filtrar por módulo
        if ($module !== 'all') {
            $query->where('module', $module);
        }

        // Filtrar por categoría
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $configurations = $query->orderBy('module')
                               ->orderBy('category')
                               ->orderBy('sort_order')
                               ->orderBy('key')
                               ->paginate(15);

        // Obtener módulos y categorías únicos para filtros
        $modules = SystemSetting::select('module')
                              ->whereNotNull('module')
                              ->distinct()
                              ->orderBy('module')
                              ->pluck('module');

        $categories = SystemSetting::select('category')
                                 ->distinct()
                                 ->orderBy('category')
                                 ->pluck('category');

        return view('configurations.index', compact('configurations', 'modules', 'categories', 'module', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = ['general', 'usuarios', 'trabajadores', 'productos', 'inventario', 'proveedores', 'pedidos', 'consumos', 'menus', 'reportes'];
        $categories = ['general', 'empresa', 'seguridad', 'interfaz', 'notificaciones', 'reportes', 'integración'];
        $types = ['string', 'number', 'boolean', 'json', 'text', 'date', 'email', 'url'];

        return view('configurations.create', compact('modules', 'categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:100|unique:system_settings,key',
            'value' => 'nullable',
            'type' => 'required|in:string,number,boolean,json,text,date,email,url',
            'module' => 'nullable|string|max:50',
            'category' => 'required|string|max:50',
            'description' => 'nullable|string',
            'editable' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        // Procesar valor según tipo
        $value = $request->value;
        if ($request->type === 'boolean') {
            $value = $request->has('value') ? '1' : '0';
        } elseif ($request->type === 'json' && is_string($value)) {
            // Validar que sea JSON válido
            json_decode($value);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['value' => 'El valor debe ser un JSON válido'])->withInput();
            }
        }

        SystemSetting::create([
            'key' => $request->key,
            'value' => $value,
            'type' => $request->type,
            'module' => $request->module,
            'category' => $request->category,
            'description' => $request->description,
            'editable' => $request->boolean('editable', true),
            'is_system' => false,
            'sort_order' => $request->sort_order ?? 0
        ]);

        return redirect()->route('configurations.index')
            ->with('success', 'Configuración creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemSetting $configuration)
    {
        return view('configurations.show', compact('configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SystemSetting $configuration)
    {
        // No permitir editar configuraciones del sistema
        if ($configuration->is_system || !$configuration->editable) {
            return redirect()->route('configurations.index')
                ->with('error', 'Esta configuración no puede ser editada');
        }

        $modules = ['general', 'usuarios', 'trabajadores', 'productos', 'inventario', 'proveedores', 'pedidos', 'consumos', 'menus', 'reportes'];
        $categories = ['general', 'empresa', 'seguridad', 'interfaz', 'notificaciones', 'reportes', 'integración'];
        $types = ['string', 'number', 'boolean', 'json', 'text', 'date', 'email', 'url'];

        return view('configurations.edit', compact('configuration', 'modules', 'categories', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SystemSetting $configuration)
    {
        // No permitir editar configuraciones del sistema
        if ($configuration->is_system || !$configuration->editable) {
            return redirect()->route('configurations.index')
                ->with('error', 'Esta configuración no puede ser editada');
        }

        $request->validate([
            'key' => 'required|string|max:100|unique:system_settings,key,' . $configuration->id,
            'value' => 'nullable',
            'type' => 'required|in:string,number,boolean,json,text,date,email,url',
            'module' => 'nullable|string|max:50',
            'category' => 'required|string|max:50',
            'description' => 'nullable|string',
            'editable' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        // Procesar valor según tipo
        $value = $request->value;
        if ($request->type === 'boolean') {
            $value = $request->has('value') ? '1' : '0';
        } elseif ($request->type === 'json' && is_string($value)) {
            json_decode($value);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['value' => 'El valor debe ser un JSON válido'])->withInput();
            }
        }

        $configuration->update([
            'key' => $request->key,
            'value' => $value,
            'type' => $request->type,
            'module' => $request->module,
            'category' => $request->category,
            'description' => $request->description,
            'editable' => $request->boolean('editable', true),
            'sort_order' => $request->sort_order ?? 0
        ]);

        // Limpiar caché
        SystemSetting::clearCache();

        return redirect()->route('configurations.index')
            ->with('success', 'Configuración actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemSetting $configuration)
    {
        // No permitir eliminar configuraciones del sistema
        if ($configuration->is_system) {
            return redirect()->route('configurations.index')
                ->with('error', 'Esta configuración del sistema no puede ser eliminada');
        }

        $configuration->delete();

        // Limpiar caché
        SystemSetting::clearCache();

        return redirect()->route('configurations.index')
            ->with('success', 'Configuración eliminada exitosamente');
    }

    /**
     * Actualización masiva de configuraciones
     */
    public function bulkUpdate(Request $request)
    {
        $configurations = $request->input('configurations', []);

        try {
            DB::beginTransaction();

            foreach ($configurations as $id => $data) {
                $config = SystemSetting::findOrFail($id);

                if ($config->editable && !$config->is_system) {
                    $value = $data['value'] ?? '';

                    // Procesar según tipo
                    if ($config->type === 'boolean') {
                        $value = isset($data['value']) ? '1' : '0';
                    }

                    $config->update(['value' => $value]);
                }
            }

            DB::commit();
            SystemSetting::clearCache();

            return redirect()->route('configurations.index')
                ->with('success', 'Configuraciones actualizadas exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('configurations.index')
                ->with('error', 'Error al actualizar configuraciones: ' . $e->getMessage());
        }
    }

    /**
     * Exportar configuraciones
     */
    public function export()
    {
        $configurations = SystemSetting::where('editable', true)->get();

        $exportData = $configurations->map(function ($config) {
            return [
                'key' => $config->key,
                'value' => $config->value,
                'type' => $config->type,
                'module' => $config->module,
                'category' => $config->category,
                'description' => $config->description,
            ];
        });

        $filename = 'configuraciones_sistema_' . date('Y-m-d_H-i-s') . '.json';

        return response()->json($exportData, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}
