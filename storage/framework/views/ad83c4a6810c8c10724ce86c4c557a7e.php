<form action="<?php echo e(route('configuraciones.update')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

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
                        <?php
                            $logoSetting = $configuraciones->where('key', 'company_logo')->first();
                            $logoPath = $logoSetting && $logoSetting->logo_path
                                ? asset('storage/' . $logoSetting->logo_path)
                                : asset('images/default-logo.png');
                        ?>
                        <div class="logo-preview-container mb-3" style="min-height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; padding: 20px;">
                            <img id="logoPreview"
                                 src="<?php echo e($logoPath); ?>"
                                 alt="Logo"
                                 class="img-fluid"
                                 style="max-height: 180px; max-width: 100%; object-fit: contain;"
                                 onerror="this.src='<?php echo e(asset('images/default-logo.png')); ?>'">
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

                    <?php if($logoSetting && $logoSetting->logo_path): ?>
                        <button type="button"
                                class="btn btn-sm btn-outline-danger mt-2"
                                onclick="deleteLogo('company_logo', 'logo_path')">
                            <i class="bi bi-trash me-1"></i>
                            Eliminar Logo
                        </button>
                    <?php endif; ?>
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
                        <?php
                            $iconSetting = $configuraciones->where('key', 'company_icon')->first();
                            $iconPath = $iconSetting && $iconSetting->icon_path
                                ? asset('storage/' . $iconSetting->icon_path)
                                : asset('images/default-icon.png');
                        ?>
                        <div class="icon-preview-container mb-3" style="min-height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; padding: 20px;">
                            <img id="iconPreview"
                                 src="<?php echo e($iconPath); ?>"
                                 alt="Icono"
                                 class="img-fluid"
                                 style="max-height: 180px; max-width: 180px; object-fit: contain;"
                                 onerror="this.src='<?php echo e(asset('images/default-icon.png')); ?>'">
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

                    <?php if($iconSetting && $iconSetting->icon_path): ?>
                        <button type="button"
                                class="btn btn-sm btn-outline-danger mt-2"
                                onclick="deleteLogo('company_icon', 'icon_path')">
                            <i class="bi bi-trash me-1"></i>
                            Eliminar Icono
                        </button>
                    <?php endif; ?>
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
                        <?php $__currentLoopData = $configuraciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!in_array($config->key, ['company_logo', 'company_icon'])): ?>
                                <div class="col-md-6 mb-3">
                                    <label for="config_<?php echo e($config->key); ?>" class="form-label">
                                        <i class="bi bi-<?php echo e($config->key === 'company_name' ? 'building' :
                                            ($config->key === 'company_address' ? 'geo-alt' :
                                            ($config->key === 'company_phone' ? 'telephone' :
                                            ($config->key === 'company_email' ? 'envelope' : 'info-circle')))); ?> me-2"></i>
                                        <?php echo e($config->description ?? ucfirst(str_replace('_', ' ', $config->key))); ?>

                                    </label>

                                    <?php if($config->type === 'text'): ?>
                                        <textarea name="config_<?php echo e($config->key); ?>"
                                                  id="config_<?php echo e($config->key); ?>"
                                                  class="form-control"
                                                  rows="3"
                                                  placeholder="Ingrese <?php echo e(strtolower($config->description)); ?>"><?php echo e(old('config_' . $config->key, $config->value)); ?></textarea>
                                    <?php else: ?>
                                        <input type="<?php echo e($config->type === 'email' ? 'email' : 'text'); ?>"
                                               name="config_<?php echo e($config->key); ?>"
                                               id="config_<?php echo e($config->key); ?>"
                                               class="form-control"
                                               value="<?php echo e(old('config_' . $config->key, $config->value)); ?>"
                                               placeholder="Ingrese <?php echo e(strtolower($config->description)); ?>">
                                    <?php endif; ?>

                                    <?php if($config->description): ?>
                                        <small class="text-muted d-block mt-1">
                                            <i class="bi bi-info-circle me-1"></i>
                                            <?php echo e($config->description); ?>

                                        </small>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón Guardar -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
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
// Preview de imagen al seleccionar
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Eliminar logo
function deleteLogo(key, field) {
    if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
        fetch('<?php echo e(route("configuraciones.delete-logo")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ key: key, field: field })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    }
}
</script>
<?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/configuraciones/tabs/empresa.blade.php ENDPATH**/ ?>