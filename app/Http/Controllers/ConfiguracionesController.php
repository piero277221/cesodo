<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ConfiguracionesController extends Controller
{
    /**
     * Mostrar dashboard de configuraciones con tabs
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'empresa');

        // Obtener configuraciones según el tab activo
        $configuraciones = SystemSetting::where('category', $tab)
                                      ->orderBy('sort_order')
                                      ->get();

        // Si no hay configuraciones, mostrar todas las editables
        if ($configuraciones->isEmpty() && $tab === 'empresa') {
            $configuraciones = SystemSetting::where('category', 'empresa')
                                          ->orWhere('key', 'like', 'company_%')
                                          ->orderBy('sort_order')
                                          ->get();
        }

        // Obtener todas las categorías disponibles
        $categorias = [
            'empresa' => [
                'nombre' => 'Información de Empresa',
                'icono' => 'bi-building',
                'descripcion' => 'Datos básicos y logo de tu empresa'
            ],
            'sistema' => [
                'nombre' => 'Configuración del Sistema',
                'icono' => 'bi-gear',
                'descripcion' => 'Ajustes generales del sistema'
            ],
            'permisos' => [
                'nombre' => 'Permisos y Roles',
                'icono' => 'bi-shield-check',
                'descripcion' => 'Gestión de roles y permisos de usuarios'
            ],
            'notificaciones' => [
                'nombre' => 'Notificaciones',
                'icono' => 'bi-bell',
                'descripcion' => 'Configurar alertas y notificaciones'
            ],
            'interfaz' => [
                'nombre' => 'Apariencia',
                'icono' => 'bi-palette',
                'descripcion' => 'Personalizar la apariencia del sistema'
            ]
        ];

        // Para el tab de permisos, obtener roles y permisos
        $roles = null;
        $permisos = null;
        if ($tab === 'permisos') {
            $roles = Role::with('permissions')->get();
            $permisos = Permission::all()->groupBy(function($permission) {
                // Agrupar por módulo (primera parte del nombre)
                $parts = explode('-', $permission->name);
                return count($parts) > 1 ? $parts[1] : 'general';
            });
        }

        return view('configuraciones.index', compact('configuraciones', 'categorias', 'tab', 'roles', 'permisos'));
    }

    /**
     * Actualizar configuraciones (incluye upload de logos)
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            // Procesar cada configuración enviada
            foreach ($request->except(['_token', '_method', 'logo_file', 'icon_file']) as $key => $value) {
                if (str_starts_with($key, 'config_')) {
                    $configKey = str_replace('config_', '', $key);
                    $setting = SystemSetting::where('key', $configKey)->first();

                    if ($setting && $setting->editable) {
                        // Procesar según tipo
                        if ($setting->type === 'boolean') {
                            $value = $value === '1' || $value === 'on' ? '1' : '0';
                        }

                        $setting->value = $value;
                        $setting->save();
                    }
                }
            }

            // Procesar upload de logo
            if ($request->hasFile('company_logo')) {
                $this->uploadLogo($request->file('company_logo'), 'company_logo', 'logo_path');
            }

            // Procesar upload de icono
            if ($request->hasFile('company_icon')) {
                $this->uploadLogo($request->file('company_icon'), 'company_icon', 'icon_path');
            }

            DB::commit();
            SystemSetting::clearCache();

            return redirect()->back()
                ->with('success', '✅ Configuraciones actualizadas correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', '❌ Error al actualizar: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Helper para subir logos/iconos
     */
    private function uploadLogo($file, $configKey, $pathField)
    {
        $setting = SystemSetting::where('key', $configKey)->first();

        if (!$setting) {
            return;
        }

        // Validar archivo
        $extension = $file->getClientOriginalExtension();
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            throw new \Exception('Formato de imagen no válido. Use: ' . implode(', ', $allowedExtensions));
        }

        // Eliminar logo anterior si existe
        if ($setting->$pathField && Storage::disk('public')->exists($setting->$pathField)) {
            Storage::disk('public')->delete($setting->$pathField);
        }

        // Guardar nuevo logo
        $filename = $configKey . '_' . time() . '.' . $extension;
        $path = $file->storeAs('logos', $filename, 'public');

        // Actualizar en base de datos
        $setting->$pathField = $path;
        $setting->value = $filename;
        $setting->save();
    }

    /**
     * Eliminar logo
     */
    public function deleteLogo(Request $request)
    {
        $configKey = $request->input('key');
        $pathField = $request->input('field', 'logo_path');

        $setting = SystemSetting::where('key', $configKey)->first();

        if ($setting && $setting->$pathField) {
            // Eliminar archivo
            if (Storage::disk('public')->exists($setting->$pathField)) {
                Storage::disk('public')->delete($setting->$pathField);
            }

            // Limpiar base de datos
            $setting->$pathField = null;
            $setting->value = null;
            $setting->save();

            SystemSetting::clearCache();

            return response()->json(['success' => true, 'message' => 'Logo eliminado']);
        }

        return response()->json(['success' => false, 'message' => 'No se encontró el logo'], 404);
    }

    /**
     * Actualizar permisos de un rol
     */
    public function updatePermissions(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array'
        ]);

        try {
            $role = Role::findOrFail($request->role_id);
            $permissions = $request->permissions ?? [];

            // Sincronizar permisos
            $role->syncPermissions($permissions);

            return redirect()->back()
                ->with('success', '✅ Permisos actualizados para el rol: ' . $role->name);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Error al actualizar permisos: ' . $e->getMessage());
        }
    }

    /**
     * Obtener logo de empresa para uso en vistas
     */
    public static function getLogo($tipo = 'logo')
    {
        $key = $tipo === 'icon' ? 'company_icon' : 'company_logo';
        $pathField = $tipo === 'icon' ? 'icon_path' : 'logo_path';

        $setting = SystemSetting::where('key', $key)->first();

        if ($setting && $setting->$pathField && Storage::disk('public')->exists($setting->$pathField)) {
            return asset('storage/' . $setting->$pathField);
        }

        // Logo por defecto
        return $tipo === 'icon'
            ? asset('images/default-icon.png')
            : asset('images/default-logo.png');
    }

    /**
     * Obtener configuración de empresa
     */
    public static function getCompanyInfo()
    {
        return [
            'name' => SystemSetting::getValue('company_name', 'Mi Empresa'),
            'address' => SystemSetting::getValue('company_address', ''),
            'phone' => SystemSetting::getValue('company_phone', ''),
            'email' => SystemSetting::getValue('company_email', ''),
            'logo' => self::getLogo('logo'),
            'icon' => self::getLogo('icon'),
        ];
    }
}
