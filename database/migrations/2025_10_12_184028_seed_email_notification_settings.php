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
        // Configuración de notificaciones por email - Activadas por defecto
        $emailNotifications = [
            'email_stock_bajo' => ['value' => '1', 'description' => 'Enviar alerta cuando productos tengan stock bajo'],
            'email_productos_vencidos' => ['value' => '1', 'description' => 'Alerta de productos próximos a vencer'],
            'email_nuevos_pedidos' => ['value' => '1', 'description' => 'Notificar cuando se reciba un nuevo pedido'],
            'email_certificados_medicos' => ['value' => '1', 'description' => 'Alertas sobre certificados médicos por vencer'],
            'email_notificaciones' => ['value' => 'skeen6265@gmail.com', 'description' => 'Email de destino para notificaciones'],
        ];

        foreach ($emailNotifications as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'notificaciones',
                    'type' => in_array($key, ['email_stock_bajo', 'email_productos_vencidos', 'email_nuevos_pedidos', 'email_certificados_medicos']) ? 'boolean' : 'text',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Configuración de notificaciones del sistema - Activadas por defecto
        $systemNotifications = [
            'sistema_alertas_stock' => ['value' => '1', 'description' => 'Mostrar banner de productos con stock bajo'],
            'sistema_productos_vencer' => ['value' => '1', 'description' => 'Mostrar lista de productos próximos a vencer'],
            'sistema_pedidos_pendientes' => ['value' => '1', 'description' => 'Contador de pedidos pendientes por procesar'],
            'sistema_sonido_notificaciones' => ['value' => '0', 'description' => 'Reproducir sonido al recibir notificaciones'],
            'duracion_notificaciones' => ['value' => '5', 'description' => 'Duración de notificaciones en segundos'],
        ];

        foreach ($systemNotifications as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'notificaciones',
                    'type' => $key === 'duracion_notificaciones' ? 'number' : 'boolean',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Configuración de recordatorios automáticos
        $reminders = [
            'dias_aviso_vencimiento' => ['value' => '7', 'description' => 'Días de anticipación para avisar vencimiento de productos'],
            'stock_minimo_alerta' => ['value' => '10', 'description' => 'Cantidad mínima de stock para generar alerta'],
            'dias_aviso_certificados' => ['value' => '5', 'description' => 'Días de anticipación para avisar certificados médicos'],
        ];

        foreach ($reminders as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'notificaciones',
                    'type' => 'number',
                    'editable' => true,
                    'description' => $data['description'],
                ]
            );
        }

        // Configuración SMTP
        $smtpConfig = [
            'smtp_host' => ['value' => 'smtp.gmail.com', 'description' => 'Servidor SMTP'],
            'smtp_port' => ['value' => '587', 'description' => 'Puerto SMTP'],
            'smtp_usuario' => ['value' => 'skeen6265@gmail.com', 'description' => 'Usuario SMTP'],
            'smtp_password' => ['value' => 'chckdhgqtddzpxtr', 'description' => 'Contraseña SMTP'],
            'smtp_encryption' => ['value' => 'tls', 'description' => 'Tipo de encriptación'],
            'smtp_from_name' => ['value' => 'Sistema CESODO', 'description' => 'Nombre del remitente'],
        ];

        foreach ($smtpConfig as $key => $data) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'category' => 'notificaciones',
                    'type' => $key === 'smtp_port' ? 'number' : 'text',
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
        // Eliminar todas las configuraciones de notificaciones
        $keys = [
            'email_stock_bajo', 'email_productos_vencidos', 'email_nuevos_pedidos', 
            'email_certificados_medicos', 'email_notificaciones',
            'sistema_alertas_stock', 'sistema_productos_vencer', 'sistema_pedidos_pendientes',
            'sistema_sonido_notificaciones', 'duracion_notificaciones',
            'dias_aviso_vencimiento', 'stock_minimo_alerta', 'dias_aviso_certificados',
            'smtp_host', 'smtp_port', 'smtp_usuario', 'smtp_password', 
            'smtp_encryption', 'smtp_from_name',
        ];

        SystemSetting::whereIn('key', $keys)->delete();
    }
};
