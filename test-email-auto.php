<?php

/**
 * Script de Prueba Automática para Envío de Emails
 * Configurado para skeen6265@gmail.com
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

// Email de destino configurado
$destinatario = 'skeen6265@gmail.com';

echo "🚀 Enviando email de prueba a: {$destinatario}\n";
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
        "- Remitente: {$from_address}\n" .
        "- Fecha: " . date('Y-m-d H:i:s') . "\n\n" .
        "A partir de ahora, recibirás notificaciones automáticas cuando:\n" .
        "✅ El stock de productos esté bajo\n" .
        "✅ Productos estén por vencer\n" .
        "✅ Lleguen nuevos pedidos\n" .
        "✅ Certificados médicos estén por vencer\n\n" .
        "Saludos,\n" .
        "Sistema CESODO",
        function ($message) use ($destinatario) {
            $message->to($destinatario)
                    ->subject('✅ Prueba de Email - Sistema CESODO Configurado');
        }
    );

    echo "╔═══════════════════════════════════════════════════════════╗\n";
    echo "║                    ✅ ÉXITO                               ║\n";
    echo "╚═══════════════════════════════════════════════════════════╝\n\n";
    echo "✅ Email enviado correctamente a: {$destinatario}\n";
    echo "📥 Por favor, revisa tu bandeja de entrada de Gmail.\n";
    echo "   (También revisa la carpeta de SPAM por si acaso)\n\n";
    echo "🎉 La configuración de email está funcionando correctamente!\n\n";
    echo "📋 Próximos pasos:\n";
    echo "   1. Revisa tu email para confirmar la recepción\n";
    echo "   2. Las notificaciones automáticas ya están configuradas\n";
    echo "   3. Recibirás alertas en skeen6265@gmail.com\n\n";

} catch (Exception $e) {
    echo "╔═══════════════════════════════════════════════════════════╗\n";
    echo "║                    ❌ ERROR                               ║\n";
    echo "╚═══════════════════════════════════════════════════════════╝\n\n";
    echo "❌ Error al enviar el email:\n";
    echo "───────────────────────────────────────────────────────────\n";
    echo $e->getMessage() . "\n\n";
    echo "🔍 Verificando configuración:\n";
    echo "   Usuario: {$username}\n";
    echo "   Host: {$host}\n";
    echo "   Puerto: {$port}\n\n";
    echo "💡 Posibles soluciones:\n";
    echo "   1. Verifica que la contraseña de aplicación sea correcta\n";
    echo "   2. Asegúrate de que la verificación en 2 pasos esté activada\n";
    echo "   3. Revisa los logs en storage/logs/laravel.log\n\n";
    exit(1);
}
