<form action="{{ route('configuraciones.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Logo de la Empresa -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-image me-2"></i>
                        Logo de la Empresa
                    </h5>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Este logo aparecerá en reportes, documentos PDF y en la parte superior del sistema
                    </p>

                    <!-- Preview del Logo -->
                    <div class="mb-3">
                        @php
                            $logoSetting = $configuraciones->where('key', 'company_logo')->first();
                            $logoPath = $logoSetting && $logoSetting->logo_path && Storage::disk('public')->exists($logoSetting->logo_path)
                                ? asset('storage/' . $logoSetting->logo_path)
                                : asset('images/default-logo.png');
                        @endphp
                        <div class="logo-preview-container mb-3" style="min-height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; padding: 20px;">
                            <img id="logoPreview"
                                 src="{{ $logoPath }}"
                                 alt="Logo"
                                 class="img-fluid"
                                 style="max-height: 180px; max-width: 100%; object-fit: contain;"
                                 loading="eager">
                        </div>
                    </div>

                    <!-- Input para subir logo -->
                    <div class="mb-3">
                        <label for="company_logo" class="btn btn-danger w-100">
                            <i class="bi bi-upload me-2"></i>
                            Seleccionar Nuevo Logo
                        </label>
                        <input type="file"
                               id="company_logo"
                               name="company_logo"
                               class="d-none"
                               accept="image/*"
                               onchange="previewImage(this, 'logoPreview')">
                    </div>

                    <div class="text-muted small">
                        <i class="bi bi-file-earmark-image me-1"></i>
                        Formatos: JPG, PNG, SVG (máx. 2MB)
                    </div>

                    @if($logoSetting && $logoSetting->logo_path)
                        <button type="button"
                                class="btn btn-sm btn-outline-danger mt-2"
                                onclick="deleteLogo('company_logo', 'logo_path')">
                            <i class="bi bi-trash me-1"></i>
                            Eliminar Logo
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Icono de la Empresa -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-app-indicator me-2"></i>
                        Icono del Sistema
                    </h5>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Este icono aparecerá en la esquina superior izquierda del sistema y en el login
                    </p>

                    <!-- Preview del Icono -->
                    <div class="mb-3">
                        @php
                            $iconSetting = $configuraciones->where('key', 'company_icon')->first();
                            $iconPath = $iconSetting && $iconSetting->icon_path && Storage::disk('public')->exists($iconSetting->icon_path)
                                ? asset('storage/' . $iconSetting->icon_path)
                                : asset('images/default-icon.png');
                        @endphp
                        <div class="icon-preview-container mb-3" style="min-height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; padding: 20px;">
                            <img id="iconPreview"
                                 src="{{ $iconPath }}"
                                 alt="Icono"
                                 class="img-fluid"
                                 style="max-height: 180px; max-width: 180px; object-fit: contain;"
                                 loading="eager">
                        </div>
                    </div>

                    <!-- Input para subir icono -->
                    <div class="mb-3">
                        <label for="company_icon" class="btn btn-danger w-100">
                            <i class="bi bi-upload me-2"></i>
                            Seleccionar Nuevo Icono
                        </label>
                        <input type="file"
                               id="company_icon"
                               name="company_icon"
                               class="d-none"
                               accept="image/*"
                               onchange="previewImage(this, 'iconPreview')">
                    </div>

                    <div class="text-muted small">
                        <i class="bi bi-file-earmark-image me-1"></i>
                        Formatos: JPG, PNG, SVG (máx. 2MB)
                    </div>

                    @if($iconSetting && $iconSetting->icon_path)
                        <button type="button"
                                class="btn btn-sm btn-outline-danger mt-2"
                                onclick="deleteLogo('company_icon', 'icon_path')">
                            <i class="bi bi-trash me-1"></i>
                            Eliminar Icono
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Información de la Empresa -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-building me-2"></i>
                        Información de la Empresa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($configuraciones as $config)
                            @if(!in_array($config->key, ['company_logo', 'company_icon']))
                                <div class="col-md-6 mb-3">
                                    <label for="config_{{ $config->key }}" class="form-label">
                                        <i class="bi bi-{{
                                            $config->key === 'company_name' ? 'building' :
                                            ($config->key === 'company_address' ? 'geo-alt' :
                                            ($config->key === 'company_phone' ? 'telephone' :
                                            ($config->key === 'company_email' ? 'envelope' : 'info-circle')))
                                        }} me-2"></i>
                                        {{ $config->description ?? ucfirst(str_replace('_', ' ', $config->key)) }}
                                    </label>

                                    @if($config->type === 'text')
                                        <textarea name="config_{{ $config->key }}"
                                                  id="config_{{ $config->key }}"
                                                  class="form-control"
                                                  rows="3"
                                                  placeholder="Ingrese {{ strtolower($config->description) }}">{{ old('config_' . $config->key, $config->value) }}</textarea>
                                    @else
                                        <input type="{{ $config->type === 'email' ? 'email' : 'text' }}"
                                               name="config_{{ $config->key }}"
                                               id="config_{{ $config->key }}"
                                               class="form-control"
                                               value="{{ old('config_' . $config->key, $config->value) }}"
                                               placeholder="Ingrese {{ strtolower($config->description) }}">
                                    @endif

                                    @if($config->description)
                                        <small class="text-muted d-block mt-1">
                                            <i class="bi bi-info-circle me-1"></i>
                                            {{ $config->description }}
                                        </small>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón Guardar -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-save me-2"></i>
                    Guardar Configuraciones
                </button>
            </div>
        </div>
    </div>
</form>

<script>
// Estado global para evitar múltiples submits
let isSubmitting = false;

// Preview de imagen al seleccionar
function previewImage(input, previewId) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];

    // Validar tamaño (máx 2MB)
    if (file.size > 2048 * 1024) {
        alert('⚠️ El archivo es demasiado grande. Tamaño máximo: 2MB');
        input.value = '';
        return;
    }

    // Validar formato
    const validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
    const extension = file.name.split('.').pop().toLowerCase();
    if (!validExtensions.includes(extension)) {
        alert('⚠️ Formato no válido. Use: JPG, PNG, GIF o SVG');
        input.value = '';
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {
        const img = document.getElementById(previewId);
        if (img) {
            img.src = e.target.result;
            showToast('✅ Imagen cargada. Recuerda hacer clic en "Guardar Configuraciones"', 'success');
        }
    }

    reader.onerror = function() {
        alert('❌ Error al leer el archivo. Intente nuevamente.');
        input.value = '';
    }

    reader.readAsDataURL(file);
}

// Eliminar logo
function deleteLogo(key, field) {
    if (!confirm('¿Estás seguro de que deseas eliminar esta imagen?')) return;

    const button = event.target.closest('button');
    if (button) button.disabled = true;

    fetch('{{ route("configuraciones.delete-logo") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ key: key, field: field })
    })
    .then(response => {
        if (!response.ok) throw new Error('Error en la respuesta del servidor');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('✅ Imagen eliminada correctamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast('❌ Error: ' + (data.message || 'No se pudo eliminar'), 'error');
            if (button) button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('❌ Error al eliminar: ' + error.message, 'error');
        if (button) button.disabled = false;
    });
}

// Función auxiliar para toasts
function showToast(message, type = 'info') {
    // Remover toasts anteriores
    const existingToasts = document.querySelectorAll('.custom-toast');
    existingToasts.forEach(t => t.remove());

    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show custom-toast`;
    toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 10000; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 5000);
}

// Event listener para el formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{ route('configuraciones.update') }}"]');

    if (form) {
        form.addEventListener('submit', function(e) {
            // Prevenir doble submit
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }

            // Verificar si hay archivos para subir
            const fileInputs = form.querySelectorAll('input[type="file"]');
            let hasFiles = false;

            fileInputs.forEach(input => {
                if (input.files && input.files.length > 0) {
                    hasFiles = true;
                }
            });

            if (hasFiles) {
                isSubmitting = true;

                // Deshabilitar botón de submit
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';
                }

                // Mostrar mensaje
                showToast('📤 Subiendo archivos...', 'info');
            }
        });
    }

    // Prevenir que el navegador bloquee el submit
    window.onbeforeunload = null;
});
</script>
