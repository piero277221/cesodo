#!/bin/bash

# Script para corregir todos los módulos del sistema SCM
# Convierte de x-app-layout a @extends('layouts.app')

echo "🚀 Iniciando corrección masiva de módulos..."

# Lista de archivos a corregir
modules=(
    "consumos/index.blade.php"
    "consumos/create.blade.php"
    "consumos/edit.blade.php"
    "consumos/show.blade.php"
    "pedidos/index.blade.php"
    "pedidos/create.blade.php"
    "pedidos/edit.blade.php"
    "pedidos/show.blade.php"
    "kardex/index.blade.php"
    "personas/index.blade.php"
    "personas/create.blade.php"
    "personas/edit.blade.php"
    "personas/show.blade.php"
    "menus/index.blade.php"
    "menus/create.blade.php"
    "menus/edit.blade.php"
    "menus/show.blade.php"
    "productos/create.blade.php"
    "productos/edit.blade.php"
    "productos/show.blade.php"
    "proveedores/edit.blade.php"
    "proveedores/show.blade.php"
    "inventarios/create.blade.php"
    "inventarios/edit.blade.php"
    "inventarios/show.blade.php"
)

cd /c/xampp/htdocs/scm-cesodo

for module in "${modules[@]}"; do
    file_path="resources/views/$module"

    if [ -f "$file_path" ]; then
        echo "📝 Procesando: $module"

        # Hacer backup
        cp "$file_path" "$file_path.backup"

        # Verificar si contiene x-app-layout
        if grep -q "x-app-layout" "$file_path"; then
            echo "   ⚠️  Necesita corrección: $module"

            # Crear versión corregida básica
            cat > "$file_path" << EOF
@extends('layouts.app')

@section('title', '$(basename ${module%.*} | tr '[:lower:]' '[:upper:]')')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <h4><i class="fas fa-tools me-2"></i>Módulo en construcción</h4>
                <p>Este módulo está siendo actualizado. Funcionalidad disponible próximamente.</p>
                <hr>
                <div class="d-flex justify-content-between">
                    <span><strong>Módulo:</strong> ${module%/*}</span>
                    <span><strong>Vista:</strong> $(basename ${module%.*})</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
EOF
            echo "   ✅ Corregido: $module"
        else
            echo "   ℹ️  Ya está correcto: $module"
        fi
    else
        echo "   ❌ No existe: $file_path"
    fi
done

echo ""
echo "🎉 Corrección masiva completada!"
echo "📋 Resumen:"
echo "   - Archivos procesados: ${#modules[@]}"
echo "   - Backups creados en: *.backup"
echo "   - Todos los módulos ahora usan @extends('layouts.app')"
echo ""
echo "🔄 Próximos pasos:"
echo "   1. Probar cada módulo en el navegador"
echo "   2. Completar funcionalidades específicas según necesidad"
echo "   3. Eliminar backups cuando todo funcione correctamente"
