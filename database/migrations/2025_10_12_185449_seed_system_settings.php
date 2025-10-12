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
        // Configuración General del Sistema
        $generalSettings = [
            'timezone' => ['value' => 'America/Lima', 'description' => 'Zona horaria del sistema'],
            'language' => ['value' => 'es', 'description' => 'Idioma del sistema'],
            'date_format' => ['value' => 'd/m/Y', 'description' => 'Formato de fecha'],
            'currency' => ['value' => 'S/', 'description' => 'Símbolo de moneda'],
            'maintenance_mode' => ['value' => '0', 'description' => 'Modo de mantenimiento'],
        ];

        foreach ($generalSettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'sistema',
                    'type' => $key === 'maintenance_mode' ? 'boolean' : 'text',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Límites y Restricciones
        $limitSettings = [
            'session_timeout' => ['value' => '30', 'description' => 'Timeout de sesión en minutos'],
            'max_login_attempts' => ['value' => '5', 'description' => 'Máximo de intentos de login'],
            'lockout_duration' => ['value' => '15', 'description' => 'Duración de bloqueo en minutos'],
            'max_upload_size' => ['value' => '10', 'description' => 'Tamaño máximo de archivo en MB'],
            'records_per_page' => ['value' => '15', 'description' => 'Registros por página'],
        ];

        foreach ($limitSettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'sistema',
                    'type' => 'number',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Seguridad y Privacidad
        $securitySettings = [
            'require_strong_password' => ['value' => '1', 'description' => 'Requerir contraseñas fuertes'],
            'two_factor_auth' => ['value' => '0', 'description' => 'Autenticación de dos factores'],
            'activity_log' => ['value' => '1', 'description' => 'Registro de actividad'],
            'password_expiry_days' => ['value' => '90', 'description' => 'Días de expiración de contraseña'],
        ];

        foreach ($securitySettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'sistema',
                    'type' => $key === 'password_expiry_days' ? 'number' : 'boolean',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Backup y Mantenimiento
        $backupSettings = [
            'auto_backup' => ['value' => '1', 'description' => 'Backup automático'],
            'backup_frequency' => ['value' => 'daily', 'description' => 'Frecuencia de backup'],
            'backup_retention_days' => ['value' => '30', 'description' => 'Días de retención de backups'],
            'auto_clean_logs' => ['value' => '1', 'description' => 'Limpieza automática de logs'],
            'log_retention_days' => ['value' => '90', 'description' => 'Días de retención de logs'],
        ];

        foreach ($backupSettings as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'sistema',
                    'type' => in_array($key, ['auto_backup', 'auto_clean_logs'])
                            ? 'boolean'
                            : (in_array($key, ['backup_retention_days', 'log_retention_days'])
                                ? 'number'
                                : 'text'),
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
        // Eliminar todas las configuraciones del sistema
        $keys = [
            'timezone', 'language', 'date_format', 'currency', 'maintenance_mode',
            'session_timeout', 'max_login_attempts', 'lockout_duration',
            'max_upload_size', 'records_per_page',
            'require_strong_password', 'two_factor_auth', 'activity_log',
            'password_expiry_days',
            'auto_backup', 'backup_frequency', 'backup_retention_days',
            'auto_clean_logs', 'log_retention_days',
        ];

        SystemSetting::whereIn('key', $keys)->delete();
    }
};
