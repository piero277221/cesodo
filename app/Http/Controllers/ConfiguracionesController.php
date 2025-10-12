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

        // Para el tab de notificaciones y sistema, obtener configuraciones como array
        $settings = [];
        if (in_array($tab, ['notificaciones', 'sistema'])) {
            $allSettings = SystemSetting::where('category', $tab)->get();
            foreach ($allSettings as $setting) {
                $settings[$setting->key] = $setting->value;
            }
        }

        return view('configuraciones.index', compact('configuraciones', 'categorias', 'tab', 'roles', 'permisos', 'settings'));
    }

    /**
     * Actualizar configuraciones (incluye upload de logos)
     */
    public function update(Request $request)
    {
        try {
            // Validar archivos si existen
            $request->validate([
                'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'company_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            DB::beginTransaction();

            // Lista de campos de notificaciones
            $notificationFields = [
                // Email notifications
                'email_stock_bajo',
                'email_productos_vencidos',
                'email_nuevos_pedidos',
                'email_certificados_medicos',
                'email_notificaciones',
                // Sistema notifications
                'sistema_alertas_stock',
                'sistema_productos_vencer',
                'sistema_pedidos_pendientes',
                'sistema_sonido_notificaciones',
                'duracion_notificaciones',
                // Recordatorios
                'dias_aviso_vencimiento',
                'stock_minimo_alerta',
                'dias_aviso_certificados',
                // SMTP Config
                'smtp_host',
                'smtp_port',
                'smtp_usuario',
                'smtp_password',
                'smtp_encryption',
                'smtp_from_name',
            ];

            // Lista de campos del sistema
            $systemFields = [
                'timezone',
                'language',
                'date_format',
                'currency',
                'maintenance_mode',
                'session_timeout',
                'max_login_attempts',
                'lockout_duration',
                'max_upload_size',
                'records_per_page',
                'require_strong_password',
                'two_factor_auth',
                'activity_log',
                'password_expiry_days',
                'auto_backup',
                'backup_frequency',
                'backup_retention_days',
                'auto_clean_logs',
                'log_retention_days',
            ];

            // Lista de campos de interfaz
            $interfaceFields = [
                'tema_sistema',
                'color_primario',
                'color_secundario',
                'border_radius',
                'font_size_base',
                'densidad_interfaz',
                'sidebar_tipo',
                'logo_position',
                'mostrar_breadcrumbs',
                'menu_mostrar_iconos',
                'animaciones_habilitadas',
                'tabla_filas_alternas',
                'tabla_bordes',
                'tabla_hover',
                'tabla_tamano',
                'tabla_acciones_posicion',
                'dashboard_card_style',
                'dashboard_layout',
                'dashboard_graficos_animados',
                'dashboard_auto_refresh',
                'dashboard_widgets_compactos',
                'alto_contraste',
                'texto_grande',
                'reducir_movimiento',
            ];

            // Procesar configuraciones del sistema
            foreach ($systemFields as $field) {
                if ($request->has($field)) {
                    $value = $request->input($field);

                    // Para checkboxes
                    if (in_array($field, ['maintenance_mode', 'require_strong_password', 'two_factor_auth',
                                          'activity_log', 'auto_backup', 'auto_clean_logs'])) {
                        $value = $value ? '1' : '0';
                    }

                    SystemSetting::updateOrCreate(
                        ['key' => $field],
                        [
                            'value' => $value,
                            'category' => 'sistema',
                            'type' => in_array($field, ['session_timeout', 'max_login_attempts', 'lockout_duration',
                                                        'max_upload_size', 'records_per_page', 'password_expiry_days',
                                                        'backup_retention_days', 'log_retention_days'])
                                     ? 'number'
                                     : (in_array($field, ['maintenance_mode', 'require_strong_password', 'two_factor_auth',
                                                         'activity_log', 'auto_backup', 'auto_clean_logs'])
                                        ? 'boolean'
                                        : 'text'),
                            'editable' => true,
                            'description' => ucfirst(str_replace('_', ' ', $field)),
                        ]
                    );
                }
            }

            // Para checkboxes del sistema desmarcados
            $systemCheckboxFields = [
                'maintenance_mode', 'require_strong_password', 'two_factor_auth',
                'activity_log', 'auto_backup', 'auto_clean_logs'
            ];

            foreach ($systemCheckboxFields as $field) {
                if (!$request->has($field)) {
                    SystemSetting::updateOrCreate(
                        ['key' => $field],
                        [
                            'value' => '0',
                            'category' => 'sistema',
                            'type' => 'boolean',
                            'editable' => true,
                            'description' => ucfirst(str_replace('_', ' ', $field)),
                        ]
                    );
                }
            }

            // Procesar configuraciones de notificaciones directamente
            foreach ($notificationFields as $field) {
                if ($request->has($field)) {
                    $value = $request->input($field);

                    // Para checkboxes que no están marcados
                    if (in_array($field, ['email_stock_bajo', 'email_productos_vencidos', 'email_nuevos_pedidos',
                                          'email_certificados_medicos', 'sistema_alertas_stock', 'sistema_productos_vencer',
                                          'sistema_pedidos_pendientes', 'sistema_sonido_notificaciones'])) {
                        $value = $value ? '1' : '0';
                    }

                    SystemSetting::updateOrCreate(
                        ['key' => $field],
                        [
                            'value' => $value,
                            'category' => 'notificaciones',
                            'type' => in_array($field, ['duracion_notificaciones', 'dias_aviso_vencimiento',
                                                        'stock_minimo_alerta', 'dias_aviso_certificados', 'smtp_port'])
                                     ? 'number'
                                     : (in_array($field, ['email_stock_bajo', 'email_productos_vencidos',
                                                         'sistema_alertas_stock', 'sistema_sonido_notificaciones'])
                                        ? 'boolean'
                                        : 'text'),
                            'editable' => true,
                            'description' => ucfirst(str_replace('_', ' ', $field)),
                        ]
                    );
                }
            }

            // Para checkboxes desmarcados (no vienen en el request)
            $checkboxFields = [
                'email_stock_bajo', 'email_productos_vencidos', 'email_nuevos_pedidos',
                'email_certificados_medicos', 'sistema_alertas_stock', 'sistema_productos_vencer',
                'sistema_pedidos_pendientes', 'sistema_sonido_notificaciones'
            ];

            foreach ($checkboxFields as $field) {
                if (!$request->has($field)) {
                    SystemSetting::updateOrCreate(
                        ['key' => $field],
                        [
                            'value' => '0',
                            'category' => 'notificaciones',
                            'type' => 'boolean',
                            'editable' => true,
                            'description' => ucfirst(str_replace('_', ' ', $field)),
                        ]
                    );
                }
            }

            // Procesar configuraciones de interfaz
            foreach ($interfaceFields as $field) {
                if ($request->has($field)) {
                    $value = $request->input($field);

                    // Para checkboxes
                    if (in_array($field, ['mostrar_breadcrumbs', 'menu_mostrar_iconos', 'animaciones_habilitadas',
                                          'tabla_filas_alternas', 'tabla_bordes', 'tabla_hover',
                                          'dashboard_graficos_animados', 'dashboard_auto_refresh', 'dashboard_widgets_compactos',
                                          'alto_contraste', 'texto_grande', 'reducir_movimiento'])) {
                        $value = $value ? '1' : '0';
                    }

                    SystemSetting::updateOrCreate(
                        ['key' => $field],
                        [
                            'value' => $value,
                            'category' => 'interfaz',
                            'type' => in_array($field, ['mostrar_breadcrumbs', 'menu_mostrar_iconos', 'animaciones_habilitadas',
                                                        'tabla_filas_alternas', 'tabla_bordes', 'tabla_hover',
                                                        'dashboard_graficos_animados', 'dashboard_auto_refresh', 'dashboard_widgets_compactos',
                                                        'alto_contraste', 'texto_grande', 'reducir_movimiento'])
                                     ? 'boolean'
                                     : 'text',
                            'editable' => true,
                            'description' => ucfirst(str_replace('_', ' ', $field)),
                        ]
                    );
                }
            }

            // Para checkboxes de interfaz desmarcados
            $interfaceCheckboxFields = [
                'mostrar_breadcrumbs', 'menu_mostrar_iconos', 'animaciones_habilitadas',
                'tabla_filas_alternas', 'tabla_bordes', 'tabla_hover',
                'dashboard_graficos_animados', 'dashboard_auto_refresh', 'dashboard_widgets_compactos',
                'alto_contraste', 'texto_grande', 'reducir_movimiento'
            ];

            foreach ($interfaceCheckboxFields as $field) {
                if (!$request->has($field)) {
                    SystemSetting::updateOrCreate(
                        ['key' => $field],
                        [
                            'value' => '0',
                            'category' => 'interfaz',
                            'type' => 'boolean',
                            'editable' => true,
                            'description' => ucfirst(str_replace('_', ' ', $field)),
                        ]
                    );
                }
            }

            // Procesar cada configuración enviada (para otros tabs)
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
                try {
                    $this->uploadLogo($request->file('company_logo'), 'company_logo', 'logo_path');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', '❌ Error al subir logo: ' . $e->getMessage())
                        ->withInput();
                }
            }

            // Procesar upload de icono
            if ($request->hasFile('company_icon')) {
                try {
                    $this->uploadLogo($request->file('company_icon'), 'company_icon', 'icon_path');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', '❌ Error al subir icono: ' . $e->getMessage())
                        ->withInput();
                }
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
        try {
            // Validar archivo
            $extension = $file->getClientOriginalExtension();
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

            if (!in_array(strtolower($extension), $allowedExtensions)) {
                throw new \Exception('Formato de imagen no válido. Use: ' . implode(', ', $allowedExtensions));
            }

            // Crear directorio si no existe
            if (!Storage::disk('public')->exists('logos')) {
                Storage::disk('public')->makeDirectory('logos');
            }

            // Buscar o crear setting
            $setting = SystemSetting::firstOrCreate(
                ['key' => $configKey],
                [
                    'category' => 'empresa',
                    'type' => 'file',
                    'editable' => true,
                    'description' => $configKey === 'company_logo' ? 'Logo de la empresa' : 'Icono del sistema'
                ]
            );

            // Eliminar logo anterior si existe
            if ($setting->$pathField && Storage::disk('public')->exists($setting->$pathField)) {
                Storage::disk('public')->delete($setting->$pathField);
            }

            // Guardar nuevo logo con nombre único
            $filename = $configKey . '_' . time() . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('logos', $filename, 'public');

            // Actualizar en base de datos
            $setting->$pathField = $path;
            $setting->value = $filename;
            $setting->save();

            // Limpiar caché
            SystemSetting::clearCache();

            return true;
        } catch (\Exception $e) {
            \Log::error('Error al subir logo: ' . $e->getMessage());
            throw $e;
        }
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

    /**
     * Limpiar caché del sistema
     */
    public function clearCache(Request $request)
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('view:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');

            return response()->json([
                'success' => true,
                'message' => '✅ Caché del sistema limpiada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Error al limpiar caché: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Optimizar sistema
     */
    public function optimize(Request $request)
    {
        try {
            \Artisan::call('optimize');
            \Artisan::call('config:cache');
            \Artisan::call('route:cache');
            \Artisan::call('view:cache');

            return response()->json([
                'success' => true,
                'message' => '✅ Sistema optimizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Error al optimizar: ' . $e->getMessage()
            ], 500);
        }
    }
}
