<?php

/**
 * Script de prueba para verificar la configuración de logos
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Storage;

echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║    VERIFICACIÓN DE CONFIGURACIÓN DE LOGOS - CESODO       ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

// Verificar que el directorio existe
echo "📁 Verificando directorio de logos...\n";
$logoPath = storage_path('app/public/logos');
if (file_exists($logoPath)) {
    echo "   ✅ Directorio existe: $logoPath\n";
    $files = scandir($logoPath);
    $files = array_diff($files, ['.', '..']);
    echo "   📄 Archivos encontrados: " . count($files) . "\n";
    if (count($files) > 0) {
        foreach ($files as $file) {
            echo "      - $file\n";
        }
    }
} else {
    echo "   ❌ Directorio NO existe: $logoPath\n";
    echo "   🔧 Creando directorio...\n";
    mkdir($logoPath, 0755, true);
    echo "   ✅ Directorio creado\n";
}

echo "\n";

// Verificar enlace simbólico
echo "🔗 Verificando enlace simbólico...\n";
$publicStorageLink = public_path('storage');
if (file_exists($publicStorageLink)) {
    if (is_link($publicStorageLink)) {
        echo "   ✅ Enlace simbólico existe: $publicStorageLink\n";
        echo "   📍 Apunta a: " . readlink($publicStorageLink) . "\n";
    } else {
        echo "   ⚠️  Existe pero no es un enlace simbólico\n";
    }
} else {
    echo "   ❌ Enlace simbólico NO existe\n";
    echo "   💡 Ejecuta: php artisan storage:link\n";
}

echo "\n";

// Verificar configuraciones en BD
echo "💾 Verificando configuraciones en base de datos...\n";
$companyLogo = SystemSetting::where('key', 'company_logo')->first();
$companyIcon = SystemSetting::where('key', 'company_icon')->first();

echo "   Logo de empresa:\n";
if ($companyLogo) {
    echo "      ✅ Registro existe\n";
    echo "      - Valor: " . ($companyLogo->value ?? 'null') . "\n";
    echo "      - logo_path: " . ($companyLogo->logo_path ?? 'null') . "\n";
    echo "      - Categoría: " . ($companyLogo->category ?? 'null') . "\n";

    if ($companyLogo->logo_path) {
        $fullPath = storage_path('app/public/' . $companyLogo->logo_path);
        if (file_exists($fullPath)) {
            echo "      ✅ Archivo existe en: $fullPath\n";
            echo "      📊 Tamaño: " . round(filesize($fullPath) / 1024, 2) . " KB\n";
        } else {
            echo "      ❌ Archivo NO existe en: $fullPath\n";
        }
    }
} else {
    echo "      ❌ Registro NO existe\n";
    echo "      🔧 Creando registro...\n";
    SystemSetting::create([
        'key' => 'company_logo',
        'value' => null,
        'logo_path' => null,
        'category' => 'empresa',
        'type' => 'file',
        'editable' => true,
        'description' => 'Logo de la empresa'
    ]);
    echo "      ✅ Registro creado\n";
}

echo "\n   Icono del sistema:\n";
if ($companyIcon) {
    echo "      ✅ Registro existe\n";
    echo "      - Valor: " . ($companyIcon->value ?? 'null') . "\n";
    echo "      - icon_path: " . ($companyIcon->icon_path ?? 'null') . "\n";
    echo "      - Categoría: " . ($companyIcon->category ?? 'null') . "\n";

    if ($companyIcon->icon_path) {
        $fullPath = storage_path('app/public/' . $companyIcon->icon_path);
        if (file_exists($fullPath)) {
            echo "      ✅ Archivo existe en: $fullPath\n";
            echo "      📊 Tamaño: " . round(filesize($fullPath) / 1024, 2) . " KB\n";
        } else {
            echo "      ❌ Archivo NO existe en: $fullPath\n";
        }
    }
} else {
    echo "      ❌ Registro NO existe\n";
    echo "      🔧 Creando registro...\n";
    SystemSetting::create([
        'key' => 'company_icon',
        'value' => null,
        'icon_path' => null,
        'category' => 'empresa',
        'type' => 'file',
        'editable' => true,
        'description' => 'Icono del sistema'
    ]);
    echo "      ✅ Registro creado\n";
}

echo "\n";

// Verificar imágenes por defecto
echo "🖼️  Verificando imágenes por defecto...\n";
$defaultLogo = public_path('images/default-logo.png');
$defaultIcon = public_path('images/default-icon.png');

if (file_exists($defaultLogo)) {
    echo "   ✅ default-logo.png existe\n";
} else {
    echo "   ❌ default-logo.png NO existe\n";
}

if (file_exists($defaultIcon)) {
    echo "   ✅ default-icon.png existe\n";
} else {
    echo "   ❌ default-icon.png NO existe\n";
}

echo "\n";

// Verificar permisos
echo "🔐 Verificando permisos...\n";
if (is_writable($logoPath)) {
    echo "   ✅ El directorio logos tiene permisos de escritura\n";
} else {
    echo "   ❌ El directorio logos NO tiene permisos de escritura\n";
    echo "   💡 Ejecuta: chmod 755 $logoPath\n";
}

echo "\n";

// Resumen
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                       RESUMEN                             ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

$issues = 0;

if (!file_exists($logoPath)) $issues++;
if (!file_exists($publicStorageLink)) $issues++;
if (!$companyLogo) $issues++;
if (!$companyIcon) $issues++;
if (!is_writable($logoPath)) $issues++;

if ($issues === 0) {
    echo "🎉 ¡Todo está configurado correctamente!\n";
    echo "✅ El sistema de carga de logos está listo para usar.\n\n";
    echo "📝 Próximos pasos:\n";
    echo "   1. Ve a Configuraciones → Empresa\n";
    echo "   2. Haz clic en 'Seleccionar Nuevo Logo'\n";
    echo "   3. Elige una imagen (JPG, PNG, SVG - máx 2MB)\n";
    echo "   4. Haz clic en 'Guardar Configuraciones'\n\n";
} else {
    echo "⚠️  Se encontraron $issues problemas.\n";
    echo "🔧 Por favor, revisa los mensajes anteriores para solucionarlos.\n\n";
}
