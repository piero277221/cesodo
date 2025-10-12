@extends('layouts.app')

@section('title', 'Nuevo Consumo')

@section('content')
<div class="container-fluid">
    <!-- Header del módulo -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle text-success me-2"></i>
                Registrar Nuevo Consumo
            </h1>
            <p class="text-muted mt-1">Complete la información del consumo del trabajador</p>
        </div>
        <div>
            <a href="{{ route('consumos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Volver al listado
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- Contador visual de platos disponibles -->
            <div class="mb-4">
                <div class="bg-green-100 border border-green-400 rounded-lg px-6 py-4 shadow text-center">
                    <span class="d-block text-lg fw-bold text-green-800">Platos disponibles</span>
                    <span class="d-block display-4 fw-bold text-green-700" id="contadorPlatos">
                        {{ $menu->platos_disponibles ?? 0 }}
                    </span>
                    <span class="d-block text-sm text-gray-600">de {{ $menu->platos_totales ?? 0 }} totales</span>
                </div>
            </div>
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-utensils me-2"></i>
                        Información del Consumo
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Por favor corrige los siguientes errores:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('consumos.store') }}" method="POST" id="consumoForm">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id ?? '' }}">

                        <div class="row">
                            <!-- Selección de Trabajador -->
                            <div class="col-md-6 mb-3">
                                <label for="trabajador_id" class="form-label fw-bold">
                                    <i class="fas fa-user me-1 text-primary"></i>
                                    Trabajador *
                                </label>
                                <select name="trabajador_id" id="trabajador_id" class="form-select @error('trabajador_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un trabajador</option>
                                    @foreach($trabajadores as $trabajador)
                                        <option value="{{ $trabajador->id }}"
                                                data-codigo="{{ $trabajador->codigo }}"
                                                data-nombres="{{ $trabajador->nombres }}"
                                                data-apellidos="{{ $trabajador->apellidos }}"
                                                {{ old('trabajador_id') == $trabajador->id ? 'selected' : '' }}>
                                            {{ $trabajador->nombres }} {{ $trabajador->apellidos }} - {{ $trabajador->codigo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('trabajador_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Busque por nombre o código del trabajador</small>
                            </div>

                            <!-- Tipo de Comida -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-utensils me-1 text-primary"></i>
                                    Tipo de Comida *
                                </label>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="tipo_comida" id="desayuno" value="desayuno"
                                               {{ old('tipo_comida') == 'desayuno' ? 'checked' : '' }} required>
                                        <label class="btn btn-outline-warning w-100 py-2" for="desayuno">
                                            <i class="fas fa-coffee d-block mb-1"></i>
                                            <small>Desayuno</small>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="tipo_comida" id="almuerzo" value="almuerzo"
                                               {{ old('tipo_comida') == 'almuerzo' ? 'checked' : '' }} required>
                                        <label class="btn btn-outline-success w-100 py-2" for="almuerzo">
                                            <i class="fas fa-utensils d-block mb-1"></i>
                                            <small>Almuerzo</small>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="tipo_comida" id="cena" value="cena"
                                               {{ old('tipo_comida') == 'cena' ? 'checked' : '' }} required>
                                        <label class="btn btn-outline-info w-100 py-2" for="cena">
                                            <i class="fas fa-moon d-block mb-1"></i>
                                            <small>Cena</small>
                                        </label>
                                    </div>
                                </div>
                                @error('tipo_comida')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Fecha de Consumo -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_consumo" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-1 text-primary"></i>
                                    Fecha de Consumo *
                                </label>
                                <input type="date"
                                       name="fecha_consumo"
                                       id="fecha_consumo"
                                       class="form-control @error('fecha_consumo') is-invalid @enderror"
                                       value="{{ old('fecha_consumo', date('Y-m-d')) }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('fecha_consumo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">La fecha no puede ser futura</small>
                            </div>

                            <!-- Hora de Consumo -->
                            <div class="col-md-6 mb-3">
                                <label for="hora_consumo" class="form-label fw-bold">
                                    <i class="fas fa-clock me-1 text-primary"></i>
                                    Hora de Consumo *
                                    <span class="badge bg-success ms-2" id="autoUpdateBadge" style="cursor: pointer;" title="Click para cambiar modo">
                                        <i class="fas fa-sync-alt fa-spin"></i> Auto
                                    </span>
                                </label>
                                <input type="time"
                                       name="hora_consumo"
                                       id="hora_consumo"
                                       class="form-control @error('hora_consumo') is-invalid @enderror"
                                       value="{{ old('hora_consumo', date('H:i')) }}"
                                       required
                                       title="Doble clic para sincronizar con hora actual">
                                @error('hora_consumo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Click en badge</strong> para cambiar modo. <strong>Doble click en campo</strong> para re-sincronizar.
                                </small>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="mb-4">
                            <label for="observaciones" class="form-label fw-bold">
                                <i class="fas fa-comment me-1 text-primary"></i>
                                Observaciones
                            </label>
                            <textarea name="observaciones"
                                      id="observaciones"
                                      class="form-control @error('observaciones') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Ingrese cualquier observación adicional sobre el consumo..."
                                      maxlength="500">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Máximo 500 caracteres. <span id="charCount">0</span>/500</small>
                        </div>

                        <!-- Vista previa de datos -->
                        <div class="card bg-light border-0 mb-4" id="preview" style="display: none;">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="fas fa-eye me-1"></i>
                                    Vista Previa del Registro
                                </h6>
                                <div class="row text-sm">
                                    <div class="col-md-6">
                                        <strong>Trabajador:</strong> <span id="preview-trabajador">-</span><br>
                                        <strong>Fecha:</strong> <span id="preview-fecha">-</span><br>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Tipo:</strong> <span id="preview-tipo">-</span><br>
                                        <strong>Hora:</strong> <span id="preview-hora">-</span><br>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Observaciones:</strong> <span id="preview-observaciones">Sin observaciones</span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('consumos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" id="previewBtn">
                                    <i class="fas fa-eye me-1"></i>
                                    Vista Previa
                                </button>
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="fas fa-save me-1"></i>
                                    Registrar Consumo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #20c997);
}

.btn-check:checked + .btn-outline-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
}

.btn-check:checked + .btn-outline-success {
    background-color: #28a745;
    border-color: #28a745;
    color: #fff;
}

.btn-check:checked + .btn-outline-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: #fff;
}

.card {
    border-radius: 10px;
}

.form-control:focus,
.form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.btn:hover {
    transform: translateY(-1px);
    transition: all 0.2s;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('consumoForm');
    const previewDiv = document.getElementById('preview');
    const previewBtn = document.getElementById('previewBtn');
    const observacionesTextarea = document.getElementById('observaciones');
    const charCount = document.getElementById('charCount');

    // Contador de caracteres
    observacionesTextarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });

    // Vista previa
    previewBtn.addEventListener('click', function() {
        updatePreview();
        previewDiv.style.display = previewDiv.style.display === 'none' ? 'block' : 'none';
        this.innerHTML = previewDiv.style.display === 'none'
            ? '<i class="fas fa-eye me-1"></i>Vista Previa'
            : '<i class="fas fa-eye-slash me-1"></i>Ocultar Vista Previa';
    });

    // Actualizar vista previa en tiempo real
    form.addEventListener('change', updatePreview);
    form.addEventListener('input', updatePreview);

    // Auto-actualizar hora actual cada segundo
    const horaInput = document.getElementById('hora_consumo');
    const autoUpdateBadge = document.getElementById('autoUpdateBadge');
    let autoUpdateEnabled = true;

    // Función para actualizar la hora automáticamente
    function updateCurrentTime() {
        if (autoUpdateEnabled) {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            horaInput.value = `${hours}:${minutes}`;
        }
    }

    // Actualizar hora cada segundo
    setInterval(updateCurrentTime, 1000);

    // Función para cambiar a modo manual
    function setManualMode() {
        autoUpdateEnabled = false;
        horaInput.style.borderColor = '#ffc107';
        horaInput.style.borderWidth = '2px';
        autoUpdateBadge.className = 'badge bg-warning ms-2';
        autoUpdateBadge.innerHTML = '<i class="fas fa-edit"></i> Manual';
        autoUpdateBadge.style.cursor = 'pointer';
        autoUpdateBadge.title = 'Click para volver a modo automático';
    }

    // Función para cambiar a modo automático
    function setAutoMode() {
        autoUpdateEnabled = true;
        updateCurrentTime();
        horaInput.style.borderColor = '';
        horaInput.style.borderWidth = '';
        autoUpdateBadge.className = 'badge bg-success ms-2';
        autoUpdateBadge.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Auto';
        autoUpdateBadge.style.cursor = 'pointer';
        autoUpdateBadge.title = 'Click para cambiar a modo manual';
        // Mostrar mensaje temporal
        const existingMsg = horaInput.parentElement.querySelector('.sync-message');
        if (existingMsg) existingMsg.remove();

        const msg = document.createElement('small');
        msg.className = 'text-success d-block mt-1 sync-message';
        msg.innerHTML = '<i class="fas fa-check me-1"></i>Hora sincronizada con reloj actual';
        horaInput.parentElement.appendChild(msg);
        setTimeout(() => msg.remove(), 2000);
    }

    // Configurar badge como clickeable
    autoUpdateBadge.style.cursor = 'pointer';
    autoUpdateBadge.title = 'Click para cambiar a modo manual';

    // Event listener para el badge con prevención de propagación
    autoUpdateBadge.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log('Badge clicked. Estado actual:', autoUpdateEnabled ? 'Auto' : 'Manual');

        if (autoUpdateEnabled) {
            console.log('Cambiando a modo Manual');
            setManualMode();
        } else {
            console.log('Cambiando a modo Auto');
            setAutoMode();
        }
    });

    // Deshabilitar auto-actualización cuando el usuario edita manualmente
    horaInput.addEventListener('focus', function() {
        setManualMode();
    });

    // Re-habilitar auto-actualización con doble clic
    horaInput.addEventListener('dblclick', function() {
        setAutoMode();
    });

    // Inicializar con la hora actual
    updateCurrentTime();

    function updatePreview() {
        const trabajadorSelect = document.getElementById('trabajador_id');
        const selectedOption = trabajadorSelect.options[trabajadorSelect.selectedIndex];
        const trabajadorText = selectedOption.value ? selectedOption.text : '-';

        const fecha = document.getElementById('fecha_consumo').value;
        const hora = document.getElementById('hora_consumo').value;
        const tipoComida = document.querySelector('input[name="tipo_comida"]:checked');
        const observaciones = document.getElementById('observaciones').value;

        document.getElementById('preview-trabajador').textContent = trabajadorText;
        document.getElementById('preview-fecha').textContent = fecha ? new Date(fecha).toLocaleDateString() : '-';
        document.getElementById('preview-hora').textContent = hora || '-';
        document.getElementById('preview-tipo').textContent = tipoComida ? tipoComida.value.charAt(0).toUpperCase() + tipoComida.value.slice(1) : '-';
        document.getElementById('preview-observaciones').textContent = observaciones || 'Sin observaciones';
    }

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        const trabajador = document.getElementById('trabajador_id').value;
        const fecha = document.getElementById('fecha_consumo').value;
        const hora = document.getElementById('hora_consumo').value;
        const tipoComida = document.querySelector('input[name="tipo_comida"]:checked');

        if (!trabajador || !fecha || !hora || !tipoComida) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
            return false;
        }

        // Confirmar envío
        if (!confirm('¿Está seguro de que desea registrar este consumo?')) {
            e.preventDefault();
            return false;
        }
    });

    // Inicializar contador
    charCount.textContent = observacionesTextarea.value.length;
});
</script>
@endsection
