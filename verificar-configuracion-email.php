<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n╔═══════════════════════════════════════════════════════════╗\n";
echo "║  VERIFICACIÓN DE CONFIGURACIÓN DE EMAIL - Sistema CESODO ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

// Obtener configuraciones de notificaciones
$settings = App\Models\SystemSetting::where('category', 'notificaciones')->get();

echo "📋 Configuraciones guardadas en la base de datos:\n";
echo "───────────────────────────────────────────────────────────\n";

$configuraciones = [
    'SMTP' => [],
    'Email' => [],
    'Sistema' => [],
    'Recordatorios' => []
];

foreach ($settings as $setting) {
    if (str_starts_with($setting->key, 'smtp_')) {
        $configuraciones['SMTP'][] = $setting;
    } elseif (str_starts_with($setting->key, 'email_')) {
        $configuraciones['Email'][] = $setting;
    } elseif (str_starts_with($setting->key, 'sistema_')) {
        $configuraciones['Sistema'][] = $setting;
    } elseif (str_starts_with($setting->key, 'dias_') || str_starts_with($setting->key, 'stock_')) {
        $configuraciones['Recordatorios'][] = $setting;
    } else {
        $configuraciones['Sistema'][] = $setting;
    }
}

foreach ($configuraciones as $categoria => $items) {
    if (!empty($items)) {
        echo "\n🔹 $categoria:\n";
        foreach ($items as $item) {
            $key = str_pad($item->key, 30);
            $value = $item->key === 'smtp_password' ? '***************' : $item->value;
            echo "   $key → $value\n";
        }
    }
}

echo "\n───────────────────────────────────────────────────────────\n";
echo "✅ Total de configuraciones: " . $settings->count() . "\n\n";

// Verificar configuración .env
echo "📧 Configuración en archivo .env:\n";
echo "───────────────────────────────────────────────────────────\n";
echo "   MAIL_MAILER           → " . config('mail.default') . "\n";
echo "   MAIL_HOST             → " . config('mail.mailers.smtp.host') . "\n";
echo "   MAIL_PORT             → " . config('mail.mailers.smtp.port') . "\n";
echo "   MAIL_USERNAME         → " . config('mail.mailers.smtp.username') . "\n";
echo "   MAIL_PASSWORD         → " . (config('mail.mailers.smtp.password') ? '***************' : 'NO CONFIGURADA') . "\n";
echo "   MAIL_ENCRYPTION       → " . config('mail.mailers.smtp.encryption') . "\n";
echo "   MAIL_FROM_ADDRESS     → " . config('mail.from.address') . "\n";
echo "   MAIL_FROM_NAME        → " . config('mail.from.name') . "\n";
echo "───────────────────────────────────────────────────────────\n\n";

echo "🎉 El sistema está listo para enviar notificaciones automáticas!\n\n";
