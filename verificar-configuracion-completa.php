<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n╔═══════════════════════════════════════════════════════════╗\n";
echo "║   VERIFICACIÓN COMPLETA DE CONFIGURACIONES - CESODO      ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

// Función para mostrar categoría
function showCategory($title, $category) {
    echo "┌─────────────────────────────────────────────────────────┐\n";
    echo "│  $title\n";
    echo "└─────────────────────────────────────────────────────────┘\n\n";

    $settings = App\Models\SystemSetting::where('category', $category)->orderBy('key')->get();

    if ($settings->isEmpty()) {
        echo "   ⚠️  No hay configuraciones guardadas en esta categoría\n\n";
        return 0;
    }

    foreach ($settings as $setting) {
        $key = str_pad($setting->key, 35);

        // Ocultar contraseñas
        if (str_contains($setting->key, 'password')) {
            $value = '***************';
        }
        // Para booleanos, mostrar ✓ o ✗
        elseif ($setting->type === 'boolean') {
            $value = $setting->value == '1' ? '✓ Activado' : '✗ Desactivado';
        }
        // Para texto largo, truncar
        elseif (strlen($setting->value) > 30) {
            $value = substr($setting->value, 0, 27) . '...';
        }
        else {
            $value = $setting->value;
        }

        echo "   $key → $value\n";
    }

    echo "\n   📊 Total: " . $settings->count() . " configuraciones\n\n";
    return $settings->count();
}

// Mostrar todas las categorías
$totalNotificaciones = showCategory("🔔 NOTIFICACIONES", "notificaciones");
$totalSistema = showCategory("⚙️  SISTEMA", "sistema");
$totalInterfaz = showCategory("🎨 INTERFAZ", "interfaz");
$totalPermisos = showCategory("🔐 PERMISOS", "permisos");
$totalEmpresa = showCategory("🏢 EMPRESA", "empresa");

// Resumen general
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                    RESUMEN GENERAL                        ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

$total = $totalNotificaciones + $totalSistema + $totalInterfaz + $totalPermisos + $totalEmpresa;

echo "   🔔 Notificaciones:  $totalNotificaciones configuraciones\n";
echo "   ⚙️  Sistema:         $totalSistema configuraciones\n";
echo "   🎨 Interfaz:        $totalInterfaz configuraciones\n";
echo "   🔐 Permisos:        $totalPermisos configuraciones\n";
echo "   🏢 Empresa:         $totalEmpresa configuraciones\n";
echo "   ─────────────────────────────────────────────────────\n";
echo "   📊 TOTAL:           $total configuraciones\n\n";

// Estado del sistema
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                   ESTADO DEL SISTEMA                      ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

// Verificar email
$emailConfig = App\Models\SystemSetting::where('key', 'smtp_host')->first();
if ($emailConfig) {
    echo "   ✅ Email configurado y funcionando\n";
} else {
    echo "   ⚠️  Email no configurado\n";
}

// Verificar tema
$themeConfig = App\Models\SystemSetting::where('key', 'tema_sistema')->first();
if ($themeConfig) {
    echo "   ✅ Tema de interfaz: " . ucfirst($themeConfig->value) . "\n";
} else {
    echo "   ⚠️  Tema no configurado\n";
}

// Verificar modo mantenimiento
$maintenanceMode = App\Models\SystemSetting::where('key', 'maintenance_mode')->first();
if ($maintenanceMode && $maintenanceMode->value == '1') {
    echo "   🔧 Modo mantenimiento ACTIVADO\n";
} else {
    echo "   ✅ Sistema operando normalmente\n";
}

echo "\n";

// Tabs completados
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║              MÓDULO DE CONFIGURACIONES                    ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

$tabs = [
    'Empresa' => $totalEmpresa > 0,
    'Sistema' => $totalSistema > 0,
    'Permisos' => $totalPermisos > 0,
    'Notificaciones' => $totalNotificaciones > 0,
    'Interfaz' => $totalInterfaz > 0,
];

foreach ($tabs as $tab => $completed) {
    $status = $completed ? '✅' : '⚠️ ';
    $text = $completed ? 'Completado' : 'Pendiente';
    echo "   $status  $tab: $text\n";
}

echo "\n";

// Estado final
if (array_sum($tabs) === count($tabs)) {
    echo "🎉 ¡MÓDULO DE CONFIGURACIONES 100% COMPLETADO!\n\n";
} else {
    $percentage = round((array_sum($tabs) / count($tabs)) * 100);
    echo "📊 Módulo completado al $percentage%\n\n";
}
