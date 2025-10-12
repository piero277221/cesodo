<div class="row">
    <div class="col-12 mb-4">
        <div class="alert alert-info">
            <i class="bi bi-gear-fill me-2"></i>
            <strong>¿Qué son las configuraciones del sistema?</strong><br>
            Ajustes técnicos y operativos que afectan el comportamiento general del sistema. Incluye límites, timeouts, formatos y otras opciones avanzadas.
        </div>
    </div>
</div>

<div class="row">
    <!-- Configuración General -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-sliders me-2"></i>
                    Configuración General
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Ajustes básicos del funcionamiento del sistema
                </p>

                <!-- Zona horaria -->
                <div class="mb-4">
                    <label for="timezone" class="form-label fw-bold">
                        <i class="bi bi-clock text-primary me-2"></i>
                        Zona Horaria
                    </label>
                    <select class="form-select form-select-lg" id="timezone" name="timezone">
                        <option value="America/Lima" <?php echo e(old('timezone', $settings['timezone'] ?? 'America/Lima') == 'America/Lima' ? 'selected' : ''); ?>>Lima (UTC-5)</option>
                        <option value="America/New_York" <?php echo e(old('timezone', $settings['timezone'] ?? 'America/Lima') == 'America/New_York' ? 'selected' : ''); ?>>New York (UTC-5)</option>
                        <option value="America/Mexico_City" <?php echo e(old('timezone', $settings['timezone'] ?? 'America/Lima') == 'America/Mexico_City' ? 'selected' : ''); ?>>Ciudad de México (UTC-6)</option>
                        <option value="America/Bogota" <?php echo e(old('timezone', $settings['timezone'] ?? 'America/Lima') == 'America/Bogota' ? 'selected' : ''); ?>>Bogotá (UTC-5)</option>
                        <option value="America/Santiago" <?php echo e(old('timezone', $settings['timezone'] ?? 'America/Lima') == 'America/Santiago' ? 'selected' : ''); ?>>Santiago (UTC-4)</option>
                        <option value="America/Buenos_Aires" <?php echo e(old('timezone', $settings['timezone'] ?? 'America/Lima') == 'America/Buenos_Aires' ? 'selected' : ''); ?>>Buenos Aires (UTC-3)</option>
                        <option value="Europe/Madrid" <?php echo e(old('timezone', $settings['timezone'] ?? 'America/Lima') == 'Europe/Madrid' ? 'selected' : ''); ?>>Madrid (UTC+1)</option>
                    </select>
                    <small class="text-muted">
                        <i class="bi bi-globe me-1"></i>
                        Afecta la visualización de fechas y horas en el sistema
                    </small>
                </div>

                <!-- Idioma del sistema -->
                <div class="mb-4">
                    <label for="language" class="form-label fw-bold">
                        <i class="bi bi-translate text-success me-2"></i>
                        Idioma del Sistema
                    </label>
                    <select class="form-select form-select-lg" id="language" name="language">
                        <option value="es" <?php echo e(old('language', $settings['language'] ?? 'es') == 'es' ? 'selected' : ''); ?>>Español</option>
                        <option value="en" <?php echo e(old('language', $settings['language'] ?? 'es') == 'en' ? 'selected' : ''); ?>>English</option>
                    </select>
                    <small class="text-muted">
                        <i class="bi bi-chat-square-text me-1"></i>
                        Idioma predeterminado de la interfaz
                    </small>
                </div>

                <!-- Formato de fecha -->
                <div class="mb-4">
                    <label for="date_format" class="form-label fw-bold">
                        <i class="bi bi-calendar3 text-info me-2"></i>
                        Formato de Fecha
                    </label>
                    <select class="form-select form-select-lg" id="date_format" name="date_format">
                        <option value="d/m/Y" <?php echo e(old('date_format', $settings['date_format'] ?? 'd/m/Y') == 'd/m/Y' ? 'selected' : ''); ?>>DD/MM/YYYY (25/12/2025)</option>
                        <option value="Y-m-d" <?php echo e(old('date_format', $settings['date_format'] ?? 'd/m/Y') == 'Y-m-d' ? 'selected' : ''); ?>>YYYY-MM-DD (2025-12-25)</option>
                        <option value="m/d/Y" <?php echo e(old('date_format', $settings['date_format'] ?? 'd/m/Y') == 'm/d/Y' ? 'selected' : ''); ?>>MM/DD/YYYY (12/25/2025)</option>
                        <option value="d-m-Y" <?php echo e(old('date_format', $settings['date_format'] ?? 'd/m/Y') == 'd-m-Y' ? 'selected' : ''); ?>>DD-MM-YYYY (25-12-2025)</option>
                    </select>
                    <small class="text-muted">
                        <i class="bi bi-calendar-check me-1"></i>
                        Cómo se mostrarán las fechas en todo el sistema
                    </small>
                </div>

                <!-- Moneda -->
                <div class="mb-4">
                    <label for="currency" class="form-label fw-bold">
                        <i class="bi bi-currency-dollar text-warning me-2"></i>
                        Moneda del Sistema
                    </label>
                    <select class="form-select form-select-lg" id="currency" name="currency">
                        <option value="PEN" <?php echo e(old('currency', $settings['currency'] ?? 'PEN') == 'PEN' ? 'selected' : ''); ?>>Soles Peruanos (S/)</option>
                        <option value="USD" <?php echo e(old('currency', $settings['currency'] ?? 'PEN') == 'USD' ? 'selected' : ''); ?>>Dólares (USD $)</option>
                        <option value="EUR" <?php echo e(old('currency', $settings['currency'] ?? 'PEN') == 'EUR' ? 'selected' : ''); ?>>Euros (EUR €)</option>
                        <option value="MXN" <?php echo e(old('currency', $settings['currency'] ?? 'PEN') == 'MXN' ? 'selected' : ''); ?>>Pesos Mexicanos (MXN $)</option>
                        <option value="COP" <?php echo e(old('currency', $settings['currency'] ?? 'PEN') == 'COP' ? 'selected' : ''); ?>>Pesos Colombianos (COP $)</option>
                        <option value="CLP" <?php echo e(old('currency', $settings['currency'] ?? 'PEN') == 'CLP' ? 'selected' : ''); ?>>Pesos Chilenos (CLP $)</option>
                        <option value="ARS" <?php echo e(old('currency', $settings['currency'] ?? 'PEN') == 'ARS' ? 'selected' : ''); ?>>Pesos Argentinos (ARS $)</option>
                    </select>
                    <small class="text-muted">
                        <i class="bi bi-cash-coin me-1"></i>
                        Moneda para precios y transacciones
                    </small>
                </div>

                <!-- Modo mantenimiento -->
                <div class="form-check form-switch p-3 mb-3" style="background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                    <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           <?php echo e(old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : ''); ?>>
                    <label class="form-check-label ms-2" for="maintenance_mode" style="cursor: pointer;">
                        <i class="bi bi-cone-striped text-warning me-2"></i>
                        <strong>Modo Mantenimiento</strong>
                        <div class="text-muted small mt-1">Desactiva el acceso al sistema temporalmente (solo administradores pueden acceder)</div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Límites y Restricciones -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Límites y Restricciones
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Controla los límites de operación del sistema
                </p>

                <!-- Timeout de sesión -->
                <div class="mb-4">
                    <label for="session_timeout" class="form-label fw-bold">
                        <i class="bi bi-clock-history text-danger me-2"></i>
                        Timeout de Sesión (minutos)
                    </label>
                    <input type="number" class="form-control form-control-lg" id="session_timeout"
                           name="session_timeout"
                           value="<?php echo e(old('session_timeout', $settings['session_timeout'] ?? 120)); ?>"
                           min="5" max="1440" step="5">
                    <small class="text-muted">
                        <i class="bi bi-hourglass-split me-1"></i>
                        Tiempo de inactividad antes de cerrar sesión automáticamente (5-1440 minutos)
                    </small>
                </div>

                <!-- Intentos de login -->
                <div class="mb-4">
                    <label for="max_login_attempts" class="form-label fw-bold">
                        <i class="bi bi-shield-lock text-warning me-2"></i>
                        Intentos Máximos de Login
                    </label>
                    <input type="number" class="form-control form-control-lg" id="max_login_attempts"
                           name="max_login_attempts"
                           value="<?php echo e(old('max_login_attempts', $settings['max_login_attempts'] ?? 5)); ?>"
                           min="3" max="10" step="1">
                    <small class="text-muted">
                        <i class="bi bi-lock me-1"></i>
                        Intentos fallidos antes de bloquear cuenta temporalmente
                    </small>
                </div>

                <!-- Tiempo de bloqueo -->
                <div class="mb-4">
                    <label for="lockout_duration" class="form-label fw-bold">
                        <i class="bi bi-ban text-danger me-2"></i>
                        Duración del Bloqueo (minutos)
                    </label>
                    <input type="number" class="form-control form-control-lg" id="lockout_duration"
                           name="lockout_duration"
                           value="<?php echo e(old('lockout_duration', $settings['lockout_duration'] ?? 15)); ?>"
                           min="5" max="60" step="5">
                    <small class="text-muted">
                        <i class="bi bi-stopwatch me-1"></i>
                        Tiempo que permanece bloqueada una cuenta tras exceder intentos
                    </small>
                </div>

                <!-- Tamaño máximo de archivos -->
                <div class="mb-4">
                    <label for="max_upload_size" class="form-label fw-bold">
                        <i class="bi bi-file-earmark-arrow-up text-primary me-2"></i>
                        Tamaño Máximo de Archivo (MB)
                    </label>
                    <input type="number" class="form-control form-control-lg" id="max_upload_size"
                           name="max_upload_size"
                           value="<?php echo e(old('max_upload_size', $settings['max_upload_size'] ?? 10)); ?>"
                           min="1" max="50" step="1">
                    <small class="text-muted">
                        <i class="bi bi-cloud-upload me-1"></i>
                        Tamaño máximo permitido para subir archivos (logos, documentos, etc.)
                    </small>
                </div>

                <!-- Registros por página -->
                <div class="mb-4">
                    <label for="records_per_page" class="form-label fw-bold">
                        <i class="bi bi-list-ol text-success me-2"></i>
                        Registros por Página
                    </label>
                    <select class="form-select form-select-lg" id="records_per_page" name="records_per_page">
                        <option value="10" <?php echo e(old('records_per_page', $settings['records_per_page'] ?? 25) == 10 ? 'selected' : ''); ?>>10 registros</option>
                        <option value="25" <?php echo e(old('records_per_page', $settings['records_per_page'] ?? 25) == 25 ? 'selected' : ''); ?>>25 registros</option>
                        <option value="50" <?php echo e(old('records_per_page', $settings['records_per_page'] ?? 25) == 50 ? 'selected' : ''); ?>>50 registros</option>
                        <option value="100" <?php echo e(old('records_per_page', $settings['records_per_page'] ?? 25) == 100 ? 'selected' : ''); ?>>100 registros</option>
                    </select>
                    <small class="text-muted">
                        <i class="bi bi-table me-1"></i>
                        Cantidad de registros a mostrar en tablas y listados
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Seguridad y Privacidad -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #198754 0%, #157347 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-shield-check me-2"></i>
                    Seguridad y Privacidad
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Opciones de seguridad y protección de datos
                </p>

                <!-- Requerir contraseña fuerte -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="require_strong_password" name="require_strong_password"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           <?php echo e(old('require_strong_password', $settings['require_strong_password'] ?? true) ? 'checked' : ''); ?>>
                    <label class="form-check-label ms-2" for="require_strong_password" style="cursor: pointer;">
                        <i class="bi bi-key-fill text-success me-2"></i>
                        <strong>Requerir Contraseña Fuerte</strong>
                        <div class="text-muted small mt-1">Obligar al menos 8 caracteres, mayúsculas, números y símbolos</div>
                    </label>
                </div>

                <!-- Autenticación de dos factores -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="two_factor_auth" name="two_factor_auth"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           <?php echo e(old('two_factor_auth', $settings['two_factor_auth'] ?? false) ? 'checked' : ''); ?>>
                    <label class="form-check-label ms-2" for="two_factor_auth" style="cursor: pointer;">
                        <i class="bi bi-phone-vibrate text-primary me-2"></i>
                        <strong>Autenticación de Dos Factores (2FA)</strong>
                        <div class="text-muted small mt-1">Requerir código adicional para mayor seguridad</div>
                    </label>
                </div>

                <!-- Registro de actividad -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="activity_log" name="activity_log"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           <?php echo e(old('activity_log', $settings['activity_log'] ?? true) ? 'checked' : ''); ?>>
                    <label class="form-check-label ms-2" for="activity_log" style="cursor: pointer;">
                        <i class="bi bi-journal-text text-info me-2"></i>
                        <strong>Registro de Actividad</strong>
                        <div class="text-muted small mt-1">Guardar historial de acciones de usuarios (login, cambios, etc.)</div>
                    </label>
                </div>

                <!-- Expiración de contraseña -->
                <div class="mb-3">
                    <label for="password_expiry_days" class="form-label fw-bold">
                        <i class="bi bi-calendar-x text-warning me-2"></i>
                        Expiración de Contraseña (días)
                    </label>
                    <input type="number" class="form-control form-control-lg" id="password_expiry_days"
                           name="password_expiry_days"
                           value="<?php echo e(old('password_expiry_days', $settings['password_expiry_days'] ?? 0)); ?>"
                           min="0" max="365" step="30">
                    <small class="text-muted">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Días antes de requerir cambio de contraseña (0 = nunca expira)
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup y Mantenimiento -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #6610f2 0%, #520dc2 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-database-fill-gear me-2"></i>
                    Backup y Mantenimiento
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Configuración de respaldos automáticos y limpieza
                </p>

                <!-- Backup automático -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="auto_backup" name="auto_backup"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           <?php echo e(old('auto_backup', $settings['auto_backup'] ?? false) ? 'checked' : ''); ?>>
                    <label class="form-check-label ms-2" for="auto_backup" style="cursor: pointer;">
                        <i class="bi bi-cloud-arrow-up text-primary me-2"></i>
                        <strong>Backup Automático</strong>
                        <div class="text-muted small mt-1">Realizar respaldo automático de la base de datos</div>
                    </label>
                </div>

                <!-- Frecuencia de backup -->
                <div class="mb-4">
                    <label for="backup_frequency" class="form-label fw-bold">
                        <i class="bi bi-arrow-repeat text-success me-2"></i>
                        Frecuencia de Backup
                    </label>
                    <select class="form-select form-select-lg" id="backup_frequency" name="backup_frequency">
                        <option value="daily" <?php echo e(old('backup_frequency', $settings['backup_frequency'] ?? 'weekly') == 'daily' ? 'selected' : ''); ?>>Diario</option>
                        <option value="weekly" <?php echo e(old('backup_frequency', $settings['backup_frequency'] ?? 'weekly') == 'weekly' ? 'selected' : ''); ?>>Semanal</option>
                        <option value="monthly" <?php echo e(old('backup_frequency', $settings['backup_frequency'] ?? 'weekly') == 'monthly' ? 'selected' : ''); ?>>Mensual</option>
                    </select>
                </div>

                <!-- Retención de backups -->
                <div class="mb-4">
                    <label for="backup_retention_days" class="form-label fw-bold">
                        <i class="bi bi-archive text-warning me-2"></i>
                        Retención de Backups (días)
                    </label>
                    <input type="number" class="form-control form-control-lg" id="backup_retention_days"
                           name="backup_retention_days"
                           value="<?php echo e(old('backup_retention_days', $settings['backup_retention_days'] ?? 30)); ?>"
                           min="7" max="365" step="7">
                    <small class="text-muted">
                        <i class="bi bi-trash me-1"></i>
                        Días que se conservan los backups antes de eliminarse automáticamente
                    </small>
                </div>

                <!-- Limpieza automática de logs -->
                <div class="form-check form-switch mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                    <input class="form-check-input" type="checkbox" id="auto_clean_logs" name="auto_clean_logs"
                           style="width: 3em; height: 1.5em; cursor: pointer;"
                           <?php echo e(old('auto_clean_logs', $settings['auto_clean_logs'] ?? true) ? 'checked' : ''); ?>>
                    <label class="form-check-label ms-2" for="auto_clean_logs" style="cursor: pointer;">
                        <i class="bi bi-trash3 text-danger me-2"></i>
                        <strong>Limpieza Automática de Logs</strong>
                        <div class="text-muted small mt-1">Eliminar automáticamente logs antiguos para liberar espacio</div>
                    </label>
                </div>

                <!-- Días de retención de logs -->
                <div class="mb-3">
                    <label for="log_retention_days" class="form-label fw-bold">
                        <i class="bi bi-calendar3 text-info me-2"></i>
                        Retención de Logs (días)
                    </label>
                    <input type="number" class="form-control form-control-lg" id="log_retention_days"
                           name="log_retention_days"
                           value="<?php echo e(old('log_retention_days', $settings['log_retention_days'] ?? 30)); ?>"
                           min="7" max="180" step="7">
                    <small class="text-muted">
                        <i class="bi bi-file-earmark-text me-1"></i>
                        Días que se conservan los logs del sistema
                    </small>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="bi bi-lightbulb me-2"></i>
                    <strong>Tip:</strong> Los backups se guardan en storage/backups y se pueden descargar manualmente desde el servidor.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Información del Sistema -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Información del Sistema
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="p-3 text-center" style="background: #f8f9fa; border-radius: 8px;">
                            <i class="bi bi-code-square text-primary" style="font-size: 2rem;"></i>
                            <h6 class="mt-2 mb-0">Versión</h6>
                            <p class="text-muted mb-0"><?php echo e(config('app.version', '1.0.0')); ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 text-center" style="background: #f8f9fa; border-radius: 8px;">
                            <i class="bi bi-hdd-stack text-success" style="font-size: 2rem;"></i>
                            <h6 class="mt-2 mb-0">Base de Datos</h6>
                            <p class="text-muted mb-0"><?php echo e(config('database.default', 'mysql')); ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 text-center" style="background: #f8f9fa; border-radius: 8px;">
                            <i class="bi bi-braces text-warning" style="font-size: 2rem;"></i>
                            <h6 class="mt-2 mb-0">PHP</h6>
                            <p class="text-muted mb-0"><?php echo e(PHP_VERSION); ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 text-center" style="background: #f8f9fa; border-radius: 8px;">
                            <i class="bi bi-speedometer2 text-danger" style="font-size: 2rem;"></i>
                            <h6 class="mt-2 mb-0">Laravel</h6>
                            <p class="text-muted mb-0"><?php echo e(app()->version()); ?></p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Importante:</strong> Algunos cambios pueden requerir reiniciar el servidor o limpiar la caché para aplicarse correctamente.
                </div>

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline-danger me-2" onclick="clearCache()">
                        <i class="bi bi-trash3 me-2"></i>
                        Limpiar Caché del Sistema
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="optimizeSystem()">
                        <i class="bi bi-lightning-charge me-2"></i>
                        Optimizar Sistema
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
    }

    .form-switch .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .form-check-input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
</style>

<script>
function clearCache() {
    if (confirm('¿Estás seguro de que deseas limpiar la caché del sistema?')) {
        // Aquí puedes implementar una llamada AJAX para limpiar la caché
        fetch('/configuraciones/clear-cache', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Caché limpiada correctamente');
            location.reload();
        })
        .catch(error => {
            alert('Error al limpiar la caché. Por favor, intenta usando el comando: php artisan cache:clear');
        });
    }
}

function optimizeSystem() {
    if (confirm('¿Deseas optimizar el sistema? Esto limpiará cachés y optimizará rutas y configuraciones.')) {
        // Aquí puedes implementar una llamada AJAX para optimizar
        fetch('/configuraciones/optimize', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Sistema optimizado correctamente');
            location.reload();
        })
        .catch(error => {
            alert('Error al optimizar. Por favor, intenta usando el comando: php artisan optimize');
        });
    }
}
</script>
<?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/configuraciones/tabs/sistema.blade.php ENDPATH**/ ?>