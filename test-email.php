<?php

/**
 * Script de Prueba para Envío de Emails
 *
 * Este script prueba la configuración SMTP del sistema
 * y envía un email de prueba.
 *
 * Uso: php test-email.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║    PRUEBA DE CONFIGURACIÓN DE EMAIL - Sistema CESODO     ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

// Obtener configuración actual
$mailer = config('mail.default');
$host = config('mail.mailers.smtp.host');
$port = config('mail.mailers.smtp.port');
$encryption = config('mail.mailers.smtp.encryption');
$username = config('mail.mailers.smtp.username');
$from_address = config('mail.from.address');
$from_name = config('mail.from.name');

echo "📧 Configuración SMTP Actual:\n";
echo "───────────────────────────────────────────────────────────\n";
echo "Mailer:        {$mailer}\n";
echo "Host:          {$host}\n";
echo "Puerto:        {$port}\n";
echo "Encriptación:  {$encryption}\n";
echo "Usuario:       {$username}\n";
echo "Desde:         {$from_name} <{$from_address}>\n";
echo "───────────────────────────────────────────────────────────\n\n";

// Validar que no sea 'log' (modo de desarrollo)
if ($mailer === 'log') {
    echo "⚠️  ADVERTENCIA: El mailer está configurado como 'log'\n";
    echo "   Los emails no se enviarán, solo se guardarán en los logs.\n";
    echo "   Por favor, configura el archivo .env con datos SMTP reales.\n\n";
    exit(1);
}

// Solicitar email de destino
echo "📬 Ingresa el email de destino para la prueba: ";
$handle = fopen("php://stdin", "r");
$destinatario = trim(fgets($handle));
fclose($handle);

if (empty($destinatario) || !filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
    echo "❌ Email inválido. Por favor ingresa un email válido.\n";
    exit(1);
}

echo "\n🚀 Enviando email de prueba a: {$destinatario}\n";
echo "   Esto puede tomar unos segundos...\n\n";

try {
    Mail::raw(
        "¡Hola!\n\n" .
        "Este es un email de prueba del Sistema CESODO.\n\n" .
        "Si estás leyendo este mensaje, significa que la configuración de email está funcionando correctamente.\n\n" .
        "Detalles de la configuración:\n" .
        "- Servidor SMTP: {$host}\n" .
        "- Puerto: {$port}\n" .
        "- Encriptación: {$encryption}\n" .
        "- Fecha: " . date('Y-m-d H:i:s') . "\n\n" .
        "Saludos,\n" .
        "Sistema CESODO",
        function ($message) use ($destinatario) {
            $message->to($destinatario)
                    ->subject('✅ Prueba de Email - Sistema CESODO');
        }
    );

    echo "╔═══════════════════════════════════════════════════════════╗\n";
    echo "║                    ✅ ÉXITO                               ║\n";
    echo "╚═══════════════════════════════════════════════════════════╝\n\n";
    echo "✅ Email enviado correctamente a: {$destinatario}\n";
    echo "📥 Por favor, revisa tu bandeja de entrada.\n";
    echo "   (También revisa la carpeta de SPAM por si acaso)\n\n";
    echo "🎉 La configuración de email está funcionando correctamente!\n\n";

} catch (Exception $e) {
    echo "╔═══════════════════════════════════════════════════════════╗\n";
    echo "║                    ❌ ERROR                               ║\n";
    echo "╚═══════════════════════════════════════════════════════════╝\n\n";
    echo "❌ Error al enviar el email:\n";
    echo "───────────────────────────────────────────────────────────\n";
    echo $e->getMessage() . "\n\n";
    echo "🔍 Posibles soluciones:\n";
    echo "   1. Verifica que los datos SMTP en .env sean correctos\n";
    echo "   2. Si usas Gmail, asegúrate de usar una contraseña de aplicación\n";
    echo "   3. Verifica que la verificación en 2 pasos esté activada (Gmail)\n";
    echo "   4. Revisa los logs en storage/logs/laravel.log\n";
    echo "   5. Consulta la documentación en docs/Configuracion-Email-Notificaciones.md\n\n";
    exit(1);
}

echo "📝 Nota: Los logs detallados están en storage/logs/laravel.log\n\n";
