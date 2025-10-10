<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configuraciones = [
            // Configuraciones de Empresa
            [
                'key' => 'empresa_nombre',
                'value' => 'CESODO - Concesionaria de Comida',
                'type' => 'string',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Nombre oficial de la empresa que aparece en reportes y documentos',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 1
            ],
            [
                'key' => 'empresa_ruc',
                'value' => '20123456789',
                'type' => 'string',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Número RUC de la empresa',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 2
            ],
            [
                'key' => 'empresa_direccion',
                'value' => 'Av. Principal 123, Lima, Perú',
                'type' => 'text',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Dirección física de la empresa',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 3
            ],
            [
                'key' => 'empresa_telefono',
                'value' => '(01) 555-0123',
                'type' => 'string',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Teléfono principal de la empresa',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 4
            ],
            [
                'key' => 'empresa_email',
                'value' => 'contacto@cesodo.com',
                'type' => 'email',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Email de contacto de la empresa',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 5
            ],

            // Configuraciones de Inventario
            [
                'key' => 'inventario_stock_minimo_global',
                'value' => '10',
                'type' => 'number',
                'module' => 'inventario',
                'category' => 'general',
                'description' => 'Stock mínimo por defecto para productos nuevos',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 10
            ],
            [
                'key' => 'inventario_alertas_activas',
                'value' => '1',
                'type' => 'boolean',
                'module' => 'inventario',
                'category' => 'notificaciones',
                'description' => 'Activar alertas automáticas de stock bajo',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 11
            ],
            [
                'key' => 'inventario_dias_vencimiento_alerta',
                'value' => '7',
                'type' => 'number',
                'module' => 'inventario',
                'category' => 'notificaciones',
                'description' => 'Días antes de vencimiento para mostrar alerta',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 12
            ],

            // Configuraciones de Usuarios
            [
                'key' => 'usuarios_password_min_length',
                'value' => '8',
                'type' => 'number',
                'module' => 'usuarios',
                'category' => 'seguridad',
                'description' => 'Longitud mínima requerida para contraseñas',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 20
            ],
            [
                'key' => 'usuarios_session_timeout',
                'value' => '120',
                'type' => 'number',
                'module' => 'usuarios',
                'category' => 'seguridad',
                'description' => 'Tiempo límite de sesión en minutos',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 21
            ],
            [
                'key' => 'usuarios_intentos_login_max',
                'value' => '5',
                'type' => 'number',
                'module' => 'usuarios',
                'category' => 'seguridad',
                'description' => 'Número máximo de intentos de login fallidos',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 22
            ],

            // Configuraciones de Menús
            [
                'key' => 'menus_platos_por_defecto',
                'value' => '50',
                'type' => 'number',
                'module' => 'menus',
                'category' => 'general',
                'description' => 'Número de platos por defecto al crear un menú',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 30
            ],
            [
                'key' => 'menus_dias_adelanto_planificacion',
                'value' => '7',
                'type' => 'number',
                'module' => 'menus',
                'category' => 'general',
                'description' => 'Días de anticipación para planificar menús',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 31
            ],

            // Configuraciones de Reportes
            [
                'key' => 'reportes_formato_fecha',
                'value' => 'd/m/Y',
                'type' => 'string',
                'module' => 'reportes',
                'category' => 'general',
                'description' => 'Formato de fecha para reportes (d/m/Y, Y-m-d, etc.)',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 40
            ],
            [
                'key' => 'reportes_registros_por_pagina',
                'value' => '15',
                'type' => 'number',
                'module' => 'reportes',
                'category' => 'general',
                'description' => 'Número de registros por página en reportes',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 41
            ],
            [
                'key' => 'reportes_incluir_logo',
                'value' => '1',
                'type' => 'boolean',
                'module' => 'reportes',
                'category' => 'general',
                'description' => 'Incluir logo de la empresa en reportes PDF',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 42
            ],

            // Configuraciones de Interfaz
            [
                'key' => 'interfaz_tema',
                'value' => 'default',
                'type' => 'string',
                'module' => 'general',
                'category' => 'interfaz',
                'description' => 'Tema visual de la aplicación',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 50
            ],
            [
                'key' => 'interfaz_idioma',
                'value' => 'es',
                'type' => 'string',
                'module' => 'general',
                'category' => 'interfaz',
                'description' => 'Idioma por defecto del sistema',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 51
            ],
            [
                'key' => 'interfaz_registros_por_pagina',
                'value' => '15',
                'type' => 'number',
                'module' => 'general',
                'category' => 'interfaz',
                'description' => 'Número de registros por página en listados',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 52
            ],

            // Configuraciones del Sistema (No editables)
            [
                'key' => 'sistema_version',
                'value' => '1.0.0',
                'type' => 'string',
                'module' => 'general',
                'category' => 'general',
                'description' => 'Versión actual del sistema',
                'editable' => false,
                'is_system' => true,
                'sort_order' => 100
            ],
            [
                'key' => 'sistema_instalacion',
                'value' => now()->toDateString(),
                'type' => 'date',
                'module' => 'general',
                'category' => 'general',
                'description' => 'Fecha de instalación del sistema',
                'editable' => false,
                'is_system' => true,
                'sort_order' => 101
            ],
            [
                'key' => 'sistema_debug',
                'value' => '0',
                'type' => 'boolean',
                'module' => 'general',
                'category' => 'general',
                'description' => 'Modo debug del sistema (solo desarrollo)',
                'editable' => false,
                'is_system' => true,
                'sort_order' => 102
            ],

            // Configuraciones de Notificaciones
            [
                'key' => 'notificaciones_email_activo',
                'value' => '1',
                'type' => 'boolean',
                'module' => 'general',
                'category' => 'notificaciones',
                'description' => 'Activar notificaciones por email',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 60
            ],
            [
                'key' => 'notificaciones_admin_email',
                'value' => 'admin@cesodo.com',
                'type' => 'email',
                'module' => 'general',
                'category' => 'notificaciones',
                'description' => 'Email del administrador para notificaciones importantes',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 61
            ]
        ];

        foreach ($configuraciones as $config) {
            SystemSetting::updateOrCreate(
                ['key' => $config['key']],
                $config
            );
        }

        $this->command->info('Configuraciones básicas del sistema creadas exitosamente.');
    }
}
