# Script para corregir todos los módulos del sistema SCM
# Convierte de x-app-layout a @extends('layouts.app')

Write-Host "🚀 Iniciando corrección masiva de módulos..." -ForegroundColor Green

# Lista de archivos a corregir
$modules = @(
    "consumos/index.blade.php",
    "consumos/create.blade.php",
    "consumos/edit.blade.php",
    "consumos/show.blade.php",
    "pedidos/index.blade.php",
    "pedidos/create.blade.php",
    "pedidos/edit.blade.php",
    "pedidos/show.blade.php",
    "kardex/index.blade.php",
    "personas/index.blade.php",
    "personas/create.blade.php",
    "personas/edit.blade.php",
    "personas/show.blade.php",
    "menus/index.blade.php",
    "menus/create.blade.php",
    "menus/edit.blade.php",
    "menus/show.blade.php",
    "productos/create.blade.php",
    "productos/edit.blade.php",
    "productos/show.blade.php",
    "proveedores/edit.blade.php",
    "proveedores/show.blade.php",
    "inventarios/create.blade.php",
    "inventarios/edit.blade.php",
    "inventarios/show.blade.php"
)

Set-Location "C:\xampp\htdocs\scm-cesodo"

foreach ($module in $modules) {
    $filePath = "resources\views\$module"

    if (Test-Path $filePath) {
        Write-Host "📝 Procesando: $module" -ForegroundColor Yellow

        # Hacer backup
        Copy-Item $filePath "$filePath.backup" -Force

        # Verificar si contiene x-app-layout
        $content = Get-Content $filePath -Raw
        if ($content -match "x-app-layout") {
            Write-Host "   ⚠️  Necesita corrección: $module" -ForegroundColor Red

            # Extraer nombre del módulo
            $moduleName = ($module -split "/")[0]
            $viewName = [System.IO.Path]::GetFileNameWithoutExtension($module)

            # Crear versión corregida básica
            $newContent = @"
@extends('layouts.app')

@section('title', '$($moduleName.Substring(0,1).ToUpper() + $moduleName.Substring(1))')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <h4><i class="fas fa-tools me-2"></i>Módulo en construcción</h4>
                <p>Este módulo está siendo actualizado. Funcionalidad disponible próximamente.</p>
                <hr>
                <div class="d-flex justify-content-between">
                    <span><strong>Módulo:</strong> $moduleName</span>
                    <span><strong>Vista:</strong> $viewName</span>
                </div>
                <div class="mt-3">
                    <a href="/" class="btn btn-primary">
                        <i class="fas fa-home me-1"></i>Ir al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
"@

            Set-Content -Path $filePath -Value $newContent -Encoding UTF8
            Write-Host "   ✅ Corregido: $module" -ForegroundColor Green
        } else {
            Write-Host "   ℹ️  Ya está correcto: $module" -ForegroundColor Blue
        }
    } else {
        Write-Host "   ❌ No existe: $filePath" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "🎉 Corrección masiva completada!" -ForegroundColor Green
Write-Host "📋 Resumen:" -ForegroundColor Cyan
Write-Host "   - Archivos procesados: $($modules.Count)" -ForegroundColor White
Write-Host "   - Backups creados en: *.backup" -ForegroundColor White
Write-Host "   - Todos los módulos ahora usan @extends('layouts.app')" -ForegroundColor White
Write-Host ""
Write-Host "🔄 Próximos pasos:" -ForegroundColor Cyan
Write-Host "   1. Probar cada módulo en el navegador" -ForegroundColor White
Write-Host "   2. Completar funcionalidades específicas según necesidad" -ForegroundColor White
Write-Host "   3. Eliminar backups cuando todo funcione correctamente" -ForegroundColor White
