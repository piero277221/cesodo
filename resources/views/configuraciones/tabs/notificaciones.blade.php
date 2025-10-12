<div class="row">
    <div class="col-12 mb-4">
        <div class="alert alert-info">
            <i class="bi bi-bell-fill me-2"></i>
            <strong>¿Qué son las notificaciones?</strong><br>
            Configura cómo y cuándo el sistema enviará alertas y notificaciones a los usuarios. Esto incluye notificaciones por email, alertas en el sistema y recordatorios automáticos.
        </div>
    </div>
</div>

<div class="row">
    <!-- Notificaciones por Email -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Notificaciones por Email
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Configura qué eventos generarán notificaciones por email
                </p>

                <!-- Stock bajo -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="email_stock_bajo" name="email_stock_bajo" 
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           {{ old('email_stock_bajo', $settings['email_stock_bajo'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="email_stock_bajo" style="cursor: pointer;">
                        <i class="bi bi-box-seam text-warning me-2"></i>
                        <strong>Stock Bajo</strong>
                        <div class="text-muted small mt-1">Enviar alerta cuando un producto esté por agotarse</div>
                    </label>
                </div>

                <!-- Productos vencidos -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="email_productos_vencidos" name="email_productos_vencidos"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           {{ old('email_productos_vencidos', $settings['email_productos_vencidos'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="email_productos_vencidos" style="cursor: pointer;">
                        <i class="bi bi-calendar-x text-danger me-2"></i>
                        <strong>Productos por Vencer</strong>
                        <div class="text-muted small mt-1">Alerta de productos próximos a vencer (7 días antes)</div>
                    </label>
                </div>

                <!-- Nuevos pedidos -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="email_nuevos_pedidos" name="email_nuevos_pedidos"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           {{ old('email_nuevos_pedidos', $settings['email_nuevos_pedidos'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="email_nuevos_pedidos" style="cursor: pointer;">
                        <i class="bi bi-cart-check text-success me-2"></i>
                        <strong>Nuevos Pedidos</strong>
                        <div class="text-muted small mt-1">Notificar cuando se reciba un nuevo pedido</div>
                    </label>
                </div>

                <!-- Certificados médicos -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="email_certificados_medicos" name="email_certificados_medicos"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           {{ old('email_certificados_medicos', $settings['email_certificados_medicos'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="email_certificados_medicos" style="cursor: pointer;">
                        <i class="bi bi-file-earmark-medical text-primary me-2"></i>
                        <strong>Certificados Médicos</strong>
                        <div class="text-muted small mt-1">Alertas sobre certificados médicos por vencer</div>
                    </label>
                </div>

                <!-- Email de destino -->
                <div class="mt-4">
                    <label for="email_notificaciones" class="form-label fw-bold">
                        <i class="bi bi-at me-1"></i>
                        Email de Notificaciones
                    </label>
                    <input type="email" class="form-control form-control-lg" id="email_notificaciones" 
                           name="email_notificaciones" 
                           value="{{ old('email_notificaciones', $settings['email_notificaciones'] ?? '') }}"
                           placeholder="admin@ejemplo.com">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Este email recibirá todas las notificaciones del sistema
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Notificaciones del Sistema -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #198754 0%, #157347 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-bell-fill me-2"></i>
                    Notificaciones en el Sistema
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Alertas que aparecerán en el sistema para los usuarios
                </p>

                <!-- Mostrar alertas de stock -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="sistema_alertas_stock" name="sistema_alertas_stock"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           {{ old('sistema_alertas_stock', $settings['sistema_alertas_stock'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="sistema_alertas_stock" style="cursor: pointer;">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                        <strong>Alertas de Stock en Dashboard</strong>
                        <div class="text-muted small mt-1">Mostrar banner de productos con stock bajo</div>
                    </label>
                </div>

                <!-- Mostrar productos por vencer -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="sistema_productos_vencer" name="sistema_productos_vencer"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           {{ old('sistema_productos_vencer', $settings['sistema_productos_vencer'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="sistema_productos_vencer" style="cursor: pointer;">
                        <i class="bi bi-calendar-event text-danger me-2"></i>
                        <strong>Productos por Vencer</strong>
                        <div class="text-muted small mt-1">Mostrar lista de productos próximos a vencer</div>
                    </label>
                </div>

                <!-- Notificaciones de pedidos pendientes -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="sistema_pedidos_pendientes" name="sistema_pedidos_pendientes"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           {{ old('sistema_pedidos_pendientes', $settings['sistema_pedidos_pendientes'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="sistema_pedidos_pendientes" style="cursor: pointer;">
                        <i class="bi bi-clipboard-check text-info me-2"></i>
                        <strong>Pedidos Pendientes</strong>
                        <div class="text-muted small mt-1">Contador de pedidos pendientes por procesar</div>
                    </label>
                </div>

                <!-- Sonido de notificaciones -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="sistema_sonido_notificaciones" name="sistema_sonido_notificaciones"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           {{ old('sistema_sonido_notificaciones', $settings['sistema_sonido_notificaciones'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="sistema_sonido_notificaciones" style="cursor: pointer;">
                        <i class="bi bi-volume-up text-primary me-2"></i>
                        <strong>Sonido en Notificaciones</strong>
                        <div class="text-muted small mt-1">Reproducir sonido al recibir nuevas notificaciones</div>
                    </label>
                </div>

                <!-- Duración de las notificaciones -->
                <div class="mt-4">
                    <label for="duracion_notificaciones" class="form-label fw-bold">
                        <i class="bi bi-clock me-1"></i>
                        Duración de Notificaciones (segundos)
                    </label>
                    <input type="number" class="form-control form-control-lg" id="duracion_notificaciones" 
                           name="duracion_notificaciones" 
                           value="{{ old('duracion_notificaciones', $settings['duracion_notificaciones'] ?? 5) }}"
                           min="3" max="15" step="1">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Tiempo que las notificaciones permanecerán visibles (3-15 segundos)
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recordatorios Automáticos -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #6610f2 0%, #520dc2 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Recordatorios Automáticos
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Configura los días de anticipación para los recordatorios automáticos
                </p>

                <div class="row">
                    <!-- Recordatorio productos por vencer -->
                    <div class="col-md-4 mb-3">
                        <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #dc3545;">
                            <label for="dias_aviso_vencimiento" class="form-label fw-bold">
                                <i class="bi bi-calendar-x text-danger me-2"></i>
                                Productos por Vencer
                            </label>
                            <input type="number" class="form-control" id="dias_aviso_vencimiento" 
                                   name="dias_aviso_vencimiento" 
                                   value="{{ old('dias_aviso_vencimiento', $settings['dias_aviso_vencimiento'] ?? 7) }}"
                                   min="1" max="30">
                            <small class="text-muted">Días antes del vencimiento</small>
                        </div>
                    </div>

                    <!-- Recordatorio stock mínimo -->
                    <div class="col-md-4 mb-3">
                        <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                            <label for="stock_minimo_alerta" class="form-label fw-bold">
                                <i class="bi bi-box-seam text-warning me-2"></i>
                                Stock Mínimo
                            </label>
                            <input type="number" class="form-control" id="stock_minimo_alerta" 
                                   name="stock_minimo_alerta" 
                                   value="{{ old('stock_minimo_alerta', $settings['stock_minimo_alerta'] ?? 10) }}"
                                   min="1" max="100">
                            <small class="text-muted">Cantidad mínima de alerta</small>
                        </div>
                    </div>

                    <!-- Recordatorio certificados médicos -->
                    <div class="col-md-4 mb-3">
                        <div class="p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #0d6efd;">
                            <label for="dias_aviso_certificados" class="form-label fw-bold">
                                <i class="bi bi-file-earmark-medical text-primary me-2"></i>
                                Certificados Médicos
                            </label>
                            <input type="number" class="form-control" id="dias_aviso_certificados" 
                                   name="dias_aviso_certificados" 
                                   value="{{ old('dias_aviso_certificados', $settings['dias_aviso_certificados'] ?? 5) }}"
                                   min="1" max="15">
                            <small class="text-muted">Días antes del vencimiento</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Configuración de Email (SMTP) -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-gear-fill me-2"></i>
                    Configuración de Email (SMTP)
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Configura el servidor SMTP para enviar notificaciones por email. Si no sabes estos datos, contacta a tu proveedor de email.
                </p>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="smtp_host" class="form-label fw-bold">
                            <i class="bi bi-server me-1"></i>
                            Servidor SMTP
                        </label>
                        <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                               value="{{ old('smtp_host', $settings['smtp_host'] ?? 'smtp.gmail.com') }}"
                               placeholder="smtp.gmail.com">
                        <small class="text-muted">Ejemplo: smtp.gmail.com, smtp.office365.com</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="smtp_port" class="form-label fw-bold">
                            <i class="bi bi-diagram-3 me-1"></i>
                            Puerto SMTP
                        </label>
                        <input type="number" class="form-control" id="smtp_port" name="smtp_port" 
                               value="{{ old('smtp_port', $settings['smtp_port'] ?? 587) }}"
                               placeholder="587">
                        <small class="text-muted">Común: 587 (TLS) o 465 (SSL)</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="smtp_usuario" class="form-label fw-bold">
                            <i class="bi bi-person-circle me-1"></i>
                            Usuario SMTP
                        </label>
                        <input type="email" class="form-control" id="smtp_usuario" name="smtp_usuario" 
                               value="{{ old('smtp_usuario', $settings['smtp_usuario'] ?? '') }}"
                               placeholder="tu-email@ejemplo.com">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="smtp_password" class="form-label fw-bold">
                            <i class="bi bi-key me-1"></i>
                            Contraseña SMTP
                        </label>
                        <input type="password" class="form-control" id="smtp_password" name="smtp_password" 
                               value="{{ old('smtp_password', $settings['smtp_password'] ?? '') }}"
                               placeholder="••••••••">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Para Gmail, usa una "Contraseña de aplicación"
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="smtp_encryption" class="form-label fw-bold">
                            <i class="bi bi-shield-lock me-1"></i>
                            Encriptación
                        </label>
                        <select class="form-select" id="smtp_encryption" name="smtp_encryption">
                            <option value="tls" {{ old('smtp_encryption', $settings['smtp_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ old('smtp_encryption', $settings['smtp_encryption'] ?? 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="smtp_from_name" class="form-label fw-bold">
                            <i class="bi bi-tag me-1"></i>
                            Nombre del Remitente
                        </label>
                        <input type="text" class="form-control" id="smtp_from_name" name="smtp_from_name" 
                               value="{{ old('smtp_from_name', $settings['smtp_from_name'] ?? 'Sistema CESODO') }}"
                               placeholder="Sistema CESODO">
                    </div>
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Importante:</strong> Asegúrate de que la configuración SMTP sea correcta antes de guardar. Un servidor mal configurado puede impedir el envío de notificaciones.
                </div>

                <button type="button" class="btn btn-outline-info mt-2" onclick="testEmailConfig()">
                    <i class="bi bi-envelope-check me-2"></i>
                    Probar Configuración de Email
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .form-check-input:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .form-check-input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    .form-switch .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .form-control:focus, .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
    }
</style>

<script>
function testEmailConfig() {
    // Obtener valores del formulario
    const smtp_host = document.getElementById('smtp_host').value;
    const smtp_port = document.getElementById('smtp_port').value;
    const smtp_usuario = document.getElementById('smtp_usuario').value;
    const smtp_password = document.getElementById('smtp_password').value;
    
    if (!smtp_host || !smtp_port || !smtp_usuario || !smtp_password) {
        alert('Por favor completa todos los campos de configuración SMTP antes de probar.');
        return;
    }
    
    // Aquí puedes implementar una llamada AJAX para probar la configuración
    alert('Función de prueba de email en desarrollo.\nPor ahora, guarda la configuración y el sistema intentará enviar emails con estos datos.');
}
</script>
