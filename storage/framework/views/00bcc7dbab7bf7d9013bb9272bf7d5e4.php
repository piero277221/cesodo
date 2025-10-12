<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0">
            <i class="bi bi-palette-fill text-danger me-2"></i>
            Interfaz y Apariencia
        </h5>
    </div>
    <div class="card-body">
        <!-- Tema Visual -->
        <div class="mb-5">
            <h6 class="fw-bold mb-3 text-dark">
                <i class="bi bi-brush text-danger me-2"></i>
                Tema Visual
            </h6>
            
            <div class="row g-3">
                <!-- Tema del Sistema -->
                <div class="col-md-4">
                    <label class="form-label">Tema del Sistema</label>
                    <select name="tema_sistema" class="form-select">
                        <option value="light" <?php echo e((old('tema_sistema', $settings['tema_sistema'] ?? 'light') == 'light') ? 'selected' : ''); ?>>
                            🌞 Claro
                        </option>
                        <option value="dark" <?php echo e((old('tema_sistema', $settings['tema_sistema'] ?? 'light') == 'dark') ? 'selected' : ''); ?>>
                            🌙 Oscuro
                        </option>
                        <option value="auto" <?php echo e((old('tema_sistema', $settings['tema_sistema'] ?? 'light') == 'auto') ? 'selected' : ''); ?>>
                            🔄 Automático (según sistema)
                        </option>
                    </select>
                    <small class="text-muted">Cambiar entre tema claro y oscuro</small>
                </div>

                <!-- Color Primario -->
                <div class="col-md-4">
                    <label class="form-label">Color Primario</label>
                    <div class="input-group">
                        <input type="color" 
                               name="color_primario" 
                               class="form-control form-control-color" 
                               value="<?php echo e(old('color_primario', $settings['color_primario'] ?? '#dc2626')); ?>"
                               title="Seleccionar color primario">
                        <input type="text" 
                               class="form-control" 
                               value="<?php echo e(old('color_primario', $settings['color_primario'] ?? '#dc2626')); ?>"
                               readonly>
                    </div>
                    <small class="text-muted">Color principal del sistema (Rojo CESODO)</small>
                </div>

                <!-- Color Secundario -->
                <div class="col-md-4">
                    <label class="form-label">Color Secundario</label>
                    <div class="input-group">
                        <input type="color" 
                               name="color_secundario" 
                               class="form-control form-control-color" 
                               value="<?php echo e(old('color_secundario', $settings['color_secundario'] ?? '#1a1a1a')); ?>"
                               title="Seleccionar color secundario">
                        <input type="text" 
                               class="form-control" 
                               value="<?php echo e(old('color_secundario', $settings['color_secundario'] ?? '#1a1a1a')); ?>"
                               readonly>
                    </div>
                    <small class="text-muted">Color secundario (Negro CESODO)</small>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <!-- Esquinas Redondeadas -->
                <div class="col-md-4">
                    <label class="form-label">Bordes Redondeados</label>
                    <select name="border_radius" class="form-select">
                        <option value="none" <?php echo e((old('border_radius', $settings['border_radius'] ?? 'medium') == 'none') ? 'selected' : ''); ?>>
                            ▢ Sin redondeo
                        </option>
                        <option value="small" <?php echo e((old('border_radius', $settings['border_radius'] ?? 'medium') == 'small') ? 'selected' : ''); ?>>
                            ▢ Pequeño (4px)
                        </option>
                        <option value="medium" <?php echo e((old('border_radius', $settings['border_radius'] ?? 'medium') == 'medium') ? 'selected' : ''); ?>>
                            ▢ Medio (8px)
                        </option>
                        <option value="large" <?php echo e((old('border_radius', $settings['border_radius'] ?? 'medium') == 'large') ? 'selected' : ''); ?>>
                            ▢ Grande (12px)
                        </option>
                    </select>
                    <small class="text-muted">Redondeo de esquinas en elementos</small>
                </div>

                <!-- Tamaño de Fuente Base -->
                <div class="col-md-4">
                    <label class="form-label">Tamaño de Fuente Base</label>
                    <select name="font_size_base" class="form-select">
                        <option value="small" <?php echo e((old('font_size_base', $settings['font_size_base'] ?? 'medium') == 'small') ? 'selected' : ''); ?>>
                            Pequeña (14px)
                        </option>
                        <option value="medium" <?php echo e((old('font_size_base', $settings['font_size_base'] ?? 'medium') == 'medium') ? 'selected' : ''); ?>>
                            Media (16px)
                        </option>
                        <option value="large" <?php echo e((old('font_size_base', $settings['font_size_base'] ?? 'medium') == 'large') ? 'selected' : ''); ?>>
                            Grande (18px)
                        </option>
                    </select>
                    <small class="text-muted">Tamaño del texto en toda la interfaz</small>
                </div>

                <!-- Densidad de la Interfaz -->
                <div class="col-md-4">
                    <label class="form-label">Densidad de Interfaz</label>
                    <select name="densidad_interfaz" class="form-select">
                        <option value="compact" <?php echo e((old('densidad_interfaz', $settings['densidad_interfaz'] ?? 'normal') == 'compact') ? 'selected' : ''); ?>>
                            📦 Compacta
                        </option>
                        <option value="normal" <?php echo e((old('densidad_interfaz', $settings['densidad_interfaz'] ?? 'normal') == 'normal') ? 'selected' : ''); ?>>
                            📋 Normal
                        </option>
                        <option value="comfortable" <?php echo e((old('densidad_interfaz', $settings['densidad_interfaz'] ?? 'normal') == 'comfortable') ? 'selected' : ''); ?>>
                            📄 Cómoda
                        </option>
                    </select>
                    <small class="text-muted">Espaciado entre elementos</small>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Navegación -->
        <div class="mb-5">
            <h6 class="fw-bold mb-3 text-dark">
                <i class="bi bi-compass text-danger me-2"></i>
                Navegación
            </h6>
            
            <div class="row g-3">
                <!-- Tipo de Sidebar -->
                <div class="col-md-6">
                    <label class="form-label">Tipo de Menú Lateral</label>
                    <select name="sidebar_tipo" class="form-select">
                        <option value="fixed" <?php echo e((old('sidebar_tipo', $settings['sidebar_tipo'] ?? 'fixed') == 'fixed') ? 'selected' : ''); ?>>
                            📌 Fijo
                        </option>
                        <option value="collapsible" <?php echo e((old('sidebar_tipo', $settings['sidebar_tipo'] ?? 'fixed') == 'collapsible') ? 'selected' : ''); ?>>
                            📂 Plegable
                        </option>
                        <option value="mini" <?php echo e((old('sidebar_tipo', $settings['sidebar_tipo'] ?? 'fixed') == 'mini') ? 'selected' : ''); ?>>
                            📋 Mini (solo iconos)
                        </option>
                    </select>
                    <small class="text-muted">Comportamiento del menú de navegación</small>
                </div>

                <!-- Posición del Logo -->
                <div class="col-md-6">
                    <label class="form-label">Posición del Logo</label>
                    <select name="logo_position" class="form-select">
                        <option value="left" <?php echo e((old('logo_position', $settings['logo_position'] ?? 'left') == 'left') ? 'selected' : ''); ?>>
                            ← Izquierda
                        </option>
                        <option value="center" <?php echo e((old('logo_position', $settings['logo_position'] ?? 'left') == 'center') ? 'selected' : ''); ?>>
                            ↔ Centro
                        </option>
                        <option value="right" <?php echo e((old('logo_position', $settings['logo_position'] ?? 'left') == 'right') ? 'selected' : ''); ?>>
                            → Derecha
                        </option>
                    </select>
                    <small class="text-muted">Ubicación del logo en el header</small>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <!-- Mostrar Breadcrumbs -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="mostrar_breadcrumbs" 
                               id="mostrar_breadcrumbs"
                               value="1"
                               <?php echo e(old('mostrar_breadcrumbs', $settings['mostrar_breadcrumbs'] ?? '1') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="mostrar_breadcrumbs">
                            <span class="fw-semibold">Mostrar Breadcrumbs</span>
                            <small class="d-block text-muted">Ruta de navegación superior</small>
                        </label>
                    </div>
                </div>

                <!-- Iconos en Menú -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="menu_mostrar_iconos" 
                               id="menu_mostrar_iconos"
                               value="1"
                               <?php echo e(old('menu_mostrar_iconos', $settings['menu_mostrar_iconos'] ?? '1') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="menu_mostrar_iconos">
                            <span class="fw-semibold">Iconos en Menú</span>
                            <small class="d-block text-muted">Mostrar iconos junto a opciones</small>
                        </label>
                    </div>
                </div>

                <!-- Animaciones -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="animaciones_habilitadas" 
                               id="animaciones_habilitadas"
                               value="1"
                               <?php echo e(old('animaciones_habilitadas', $settings['animaciones_habilitadas'] ?? '1') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="animaciones_habilitadas">
                            <span class="fw-semibold">Animaciones</span>
                            <small class="d-block text-muted">Transiciones y efectos visuales</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Tablas y Listados -->
        <div class="mb-5">
            <h6 class="fw-bold mb-3 text-dark">
                <i class="bi bi-table text-danger me-2"></i>
                Tablas y Listados
            </h6>
            
            <div class="row g-3">
                <!-- Filas Alternas -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="tabla_filas_alternas" 
                               id="tabla_filas_alternas"
                               value="1"
                               <?php echo e(old('tabla_filas_alternas', $settings['tabla_filas_alternas'] ?? '1') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="tabla_filas_alternas">
                            <span class="fw-semibold">Filas Alternas</span>
                            <small class="d-block text-muted">Colores alternados en tablas</small>
                        </label>
                    </div>
                </div>

                <!-- Bordes en Tablas -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="tabla_bordes" 
                               id="tabla_bordes"
                               value="1"
                               <?php echo e(old('tabla_bordes', $settings['tabla_bordes'] ?? '1') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="tabla_bordes">
                            <span class="fw-semibold">Bordes en Tablas</span>
                            <small class="d-block text-muted">Líneas divisoras en celdas</small>
                        </label>
                    </div>
                </div>

                <!-- Hover en Filas -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="tabla_hover" 
                               id="tabla_hover"
                               value="1"
                               <?php echo e(old('tabla_hover', $settings['tabla_hover'] ?? '1') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="tabla_hover">
                            <span class="fw-semibold">Hover en Filas</span>
                            <small class="d-block text-muted">Resaltar fila al pasar mouse</small>
                        </label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <!-- Tamaño de Tabla -->
                <div class="col-md-6">
                    <label class="form-label">Tamaño de Tablas</label>
                    <select name="tabla_tamano" class="form-select">
                        <option value="sm" <?php echo e((old('tabla_tamano', $settings['tabla_tamano'] ?? 'normal') == 'sm') ? 'selected' : ''); ?>>
                            📋 Compacta
                        </option>
                        <option value="normal" <?php echo e((old('tabla_tamano', $settings['tabla_tamano'] ?? 'normal') == 'normal') ? 'selected' : ''); ?>>
                            📄 Normal
                        </option>
                        <option value="lg" <?php echo e((old('tabla_tamano', $settings['tabla_tamano'] ?? 'normal') == 'lg') ? 'selected' : ''); ?>>
                            📃 Grande
                        </option>
                    </select>
                    <small class="text-muted">Espaciado interno de las celdas</small>
                </div>

                <!-- Acciones en Tablas -->
                <div class="col-md-6">
                    <label class="form-label">Posición de Acciones</label>
                    <select name="tabla_acciones_posicion" class="form-select">
                        <option value="left" <?php echo e((old('tabla_acciones_posicion', $settings['tabla_acciones_posicion'] ?? 'right') == 'left') ? 'selected' : ''); ?>>
                            ← Primera Columna
                        </option>
                        <option value="right" <?php echo e((old('tabla_acciones_posicion', $settings['tabla_acciones_posicion'] ?? 'right') == 'right') ? 'selected' : ''); ?>>
                            → Última Columna
                        </option>
                    </select>
                    <small class="text-muted">Ubicación de botones de acción</small>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Dashboard -->
        <div class="mb-5">
            <h6 class="fw-bold mb-3 text-dark">
                <i class="bi bi-speedometer2 text-danger me-2"></i>
                Dashboard
            </h6>
            
            <div class="row g-3">
                <!-- Diseño de Cards -->
                <div class="col-md-6">
                    <label class="form-label">Estilo de Cards</label>
                    <select name="dashboard_card_style" class="form-select">
                        <option value="flat" <?php echo e((old('dashboard_card_style', $settings['dashboard_card_style'] ?? 'shadow') == 'flat') ? 'selected' : ''); ?>>
                            ▭ Plano
                        </option>
                        <option value="shadow" <?php echo e((old('dashboard_card_style', $settings['dashboard_card_style'] ?? 'shadow') == 'shadow') ? 'selected' : ''); ?>>
                            ▢ Con Sombra
                        </option>
                        <option value="bordered" <?php echo e((old('dashboard_card_style', $settings['dashboard_card_style'] ?? 'shadow') == 'bordered') ? 'selected' : ''); ?>>
                            ▯ Con Bordes
                        </option>
                    </select>
                    <small class="text-muted">Apariencia de las tarjetas</small>
                </div>

                <!-- Layout de Dashboard -->
                <div class="col-md-6">
                    <label class="form-label">Distribución de Widgets</label>
                    <select name="dashboard_layout" class="form-select">
                        <option value="grid-2" <?php echo e((old('dashboard_layout', $settings['dashboard_layout'] ?? 'grid-3') == 'grid-2') ? 'selected' : ''); ?>>
                            📱 2 Columnas
                        </option>
                        <option value="grid-3" <?php echo e((old('dashboard_layout', $settings['dashboard_layout'] ?? 'grid-3') == 'grid-3') ? 'selected' : ''); ?>>
                            💻 3 Columnas
                        </option>
                        <option value="grid-4" <?php echo e((old('dashboard_layout', $settings['dashboard_layout'] ?? 'grid-3') == 'grid-4') ? 'selected' : ''); ?>>
                            🖥️ 4 Columnas
                        </option>
                    </select>
                    <small class="text-muted">Cantidad de columnas en dashboard</small>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <!-- Gráficos Animados -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="dashboard_graficos_animados" 
                               id="dashboard_graficos_animados"
                               value="1"
                               <?php echo e(old('dashboard_graficos_animados', $settings['dashboard_graficos_animados'] ?? '1') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="dashboard_graficos_animados">
                            <span class="fw-semibold">Gráficos Animados</span>
                            <small class="d-block text-muted">Animación al cargar gráficos</small>
                        </label>
                    </div>
                </div>

                <!-- Actualización Automática -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="dashboard_auto_refresh" 
                               id="dashboard_auto_refresh"
                               value="1"
                               <?php echo e(old('dashboard_auto_refresh', $settings['dashboard_auto_refresh'] ?? '0') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="dashboard_auto_refresh">
                            <span class="fw-semibold">Actualización Automática</span>
                            <small class="d-block text-muted">Refrescar datos cada 5 min</small>
                        </label>
                    </div>
                </div>

                <!-- Widgets Compactos -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="dashboard_widgets_compactos" 
                               id="dashboard_widgets_compactos"
                               value="1"
                               <?php echo e(old('dashboard_widgets_compactos', $settings['dashboard_widgets_compactos'] ?? '0') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="dashboard_widgets_compactos">
                            <span class="fw-semibold">Widgets Compactos</span>
                            <small class="d-block text-muted">Vista reducida de widgets</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Accesibilidad -->
        <div class="mb-4">
            <h6 class="fw-bold mb-3 text-dark">
                <i class="bi bi-universal-access text-danger me-2"></i>
                Accesibilidad
            </h6>
            
            <div class="row g-3">
                <!-- Alto Contraste -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="alto_contraste" 
                               id="alto_contraste"
                               value="1"
                               <?php echo e(old('alto_contraste', $settings['alto_contraste'] ?? '0') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="alto_contraste">
                            <span class="fw-semibold">Alto Contraste</span>
                            <small class="d-block text-muted">Mejora visibilidad de elementos</small>
                        </label>
                    </div>
                </div>

                <!-- Texto Grande -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="texto_grande" 
                               id="texto_grande"
                               value="1"
                               <?php echo e(old('texto_grande', $settings['texto_grande'] ?? '0') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="texto_grande">
                            <span class="fw-semibold">Texto Grande</span>
                            <small class="d-block text-muted">Aumentar tamaño de fuente</small>
                        </label>
                    </div>
                </div>

                <!-- Reducir Movimiento -->
                <div class="col-md-4">
                    <div class="form-check form-switch d-flex align-items-center" style="min-height: 50px;">
                        <input class="form-check-input me-3" 
                               type="checkbox" 
                               name="reducir_movimiento" 
                               id="reducir_movimiento"
                               value="1"
                               <?php echo e(old('reducir_movimiento', $settings['reducir_movimiento'] ?? '0') == '1' ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="reducir_movimiento">
                            <span class="fw-semibold">Reducir Movimiento</span>
                            <small class="d-block text-muted">Desactivar animaciones</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Vista Previa -->
        <div class="alert alert-info border-0 shadow-sm mb-0">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle fs-4 me-3"></i>
                <div class="flex-grow-1">
                    <strong>Vista Previa</strong>
                    <p class="mb-0 small">Los cambios se aplicarán después de guardar. Puedes restaurar la configuración por defecto en cualquier momento.</p>
                </div>
                <button type="button" class="btn btn-outline-dark btn-sm ms-3" onclick="resetInterfazDefaults()">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Restaurar Valores por Defecto
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function resetInterfazDefaults() {
    if (confirm('¿Estás seguro de restaurar todos los valores de interfaz a su configuración por defecto?')) {
        // Tema Visual
        document.querySelector('select[name="tema_sistema"]').value = 'light';
        document.querySelector('input[name="color_primario"]').value = '#dc2626';
        document.querySelector('input[name="color_secundario"]').value = '#1a1a1a';
        document.querySelector('select[name="border_radius"]').value = 'medium';
        document.querySelector('select[name="font_size_base"]').value = 'medium';
        document.querySelector('select[name="densidad_interfaz"]').value = 'normal';
        
        // Navegación
        document.querySelector('select[name="sidebar_tipo"]').value = 'fixed';
        document.querySelector('select[name="logo_position"]').value = 'left';
        document.getElementById('mostrar_breadcrumbs').checked = true;
        document.getElementById('menu_mostrar_iconos').checked = true;
        document.getElementById('animaciones_habilitadas').checked = true;
        
        // Tablas
        document.getElementById('tabla_filas_alternas').checked = true;
        document.getElementById('tabla_bordes').checked = true;
        document.getElementById('tabla_hover').checked = true;
        document.querySelector('select[name="tabla_tamano"]').value = 'normal';
        document.querySelector('select[name="tabla_acciones_posicion"]').value = 'right';
        
        // Dashboard
        document.querySelector('select[name="dashboard_card_style"]').value = 'shadow';
        document.querySelector('select[name="dashboard_layout"]').value = 'grid-3';
        document.getElementById('dashboard_graficos_animados').checked = true;
        document.getElementById('dashboard_auto_refresh').checked = false;
        document.getElementById('dashboard_widgets_compactos').checked = false;
        
        // Accesibilidad
        document.getElementById('alto_contraste').checked = false;
        document.getElementById('texto_grande').checked = false;
        document.getElementById('reducir_movimiento').checked = false;
        
        // Actualizar inputs de texto junto a color pickers
        document.querySelectorAll('input[type="color"]').forEach(input => {
            const textInput = input.nextElementSibling;
            if (textInput && textInput.type === 'text') {
                textInput.value = input.value;
            }
        });
        
        alert('✅ Valores restaurados a configuración por defecto');
    }
}

// Sincronizar color picker con input de texto
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
        const textInput = colorInput.nextElementSibling;
        if (textInput && textInput.type === 'text') {
            colorInput.addEventListener('input', function() {
                textInput.value = this.value;
            });
        }
    });
});
</script>
<?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/configuraciones/tabs/interfaz.blade.php ENDPATH**/ ?>