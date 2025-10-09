@extends('layouts.app')

@section('title', 'Editar Consumo')

@section('content')
<div class="container-fluid">
    <!-- Header del módulo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-edit text-warning me-2"></i>
                        Editar Consumo
                    </h1>
                    <p class="text-muted mt-1">Modifique la información del consumo</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('consumos.show', $consumo) }}" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i>
                        Ver detalles
                    </a>
                    <a href="{{ route('consumos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Modificar Información del Consumo
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

                    <form action="{{ route('consumos.update', $consumo) }}" method="POST" id="editConsumoForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Trabajador -->
                            <div class="col-12">
                                <label for="trabajador_id" class="form-label fw-bold">
                                    <i class="fas fa-user me-1"></i>
                                    Trabajador *
                                </label>
                                <select name="trabajador_id"
                                        id="trabajador_id"
                                        class="form-select @error('trabajador_id') is-invalid @enderror"
                                        required>
                                    <option value="">Seleccione un trabajador...</option>
                                    @foreach(\App\Models\Trabajador::with('persona')->orderBy('nombres')->get() as $trabajador)
                                        <option value="{{ $trabajador->id }}"
                                                {{ (old('trabajador_id') ?? $consumo->trabajador_id) == $trabajador->id ? 'selected' : '' }}
                                                data-codigo="{{ $trabajador->codigo }}"
                                                data-nombres="{{ $trabajador->nombres }} {{ $trabajador->apellidos }}">
                                            {{ $trabajador->codigo }} - {{ $trabajador->nombres }} {{ $trabajador->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('trabajador_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Seleccione el trabajador que realizó el consumo
                                </div>
                            </div>

                            <!-- Fecha y Hora -->
                            <div class="col-md-6">
                                <label for="fecha_consumo" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-1"></i>
                                    Fecha del Consumo *
                                </label>
                                <input type="date"
                                       name="fecha_consumo"
                                       id="fecha_consumo"
                                       class="form-control @error('fecha_consumo') is-invalid @enderror"
                                       value="{{ old('fecha_consumo') ?? $consumo->fecha_consumo?->format('Y-m-d') }}"
                                       required>
                                @error('fecha_consumo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="hora_consumo" class="form-label fw-bold">
                                    <i class="fas fa-clock me-1"></i>
                                    Hora del Consumo *
                                </label>
                                <input type="time"
                                       name="hora_consumo"
                                       id="hora_consumo"
                                       class="form-control @error('hora_consumo') is-invalid @enderror"
                                       value="{{ old('hora_consumo') ?? $consumo->hora_consumo?->format('H:i') }}"
                                       required>
                                @error('hora_consumo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo de Comida -->
                            <div class="col-12">
                                <label for="tipo_comida" class="form-label fw-bold">
                                    <i class="fas fa-utensils me-1"></i>
                                    Tipo de Comida *
                                </label>
                                <div class="row g-2">
                                    @php
                                        $tiposComida = [
                                            'desayuno' => ['icon' => 'fas fa-sun', 'color' => 'warning', 'label' => 'Desayuno'],
                                            'almuerzo' => ['icon' => 'fas fa-utensils', 'color' => 'success', 'label' => 'Almuerzo'],
                                            'cena' => ['icon' => 'fas fa-moon', 'color' => 'primary', 'label' => 'Cena'],
                                            'refrigerio' => ['icon' => 'fas fa-cookie-bite', 'color' => 'info', 'label' => 'Refrigerio']
                                        ];
                                        $tipoSeleccionado = old('tipo_comida') ?? $consumo->tipo_comida;
                                    @endphp
                                    @foreach($tiposComida as $tipo => $config)
                                        <div class="col-md-3">
                                            <input type="radio"
                                                   class="btn-check"
                                                   name="tipo_comida"
                                                   id="tipo_{{ $tipo }}"
                                                   value="{{ $tipo }}"
                                                   {{ $tipoSeleccionado == $tipo ? 'checked' : '' }}
                                                   required>
                                            <label class="btn btn-outline-{{ $config['color'] }} w-100 py-3"
                                                   for="tipo_{{ $tipo }}">
                                                <i class="{{ $config['icon'] }} fa-2x d-block mb-2"></i>
                                                {{ $config['label'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('tipo_comida')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Observaciones -->
                            <div class="col-12">
                                <label for="observaciones" class="form-label fw-bold">
                                    <i class="fas fa-comment me-1"></i>
                                    Observaciones
                                </label>
                                <textarea name="observaciones"
                                          id="observaciones"
                                          class="form-control @error('observaciones') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Detalles adicionales del consumo (opcional)...">{{ old('observaciones') ?? $consumo->observaciones }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Información adicional sobre el consumo, menú especial, restricciones, etc.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Información adicional -->
                        <div class="bg-light rounded p-3 mb-4">
                            <h6 class="mb-2">
                                <i class="fas fa-info-circle text-info me-2"></i>
                                Información de registro
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Registrado por:</small>
                                    <div class="fw-bold">{{ $consumo->user?->name ?? 'Sistema' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Fecha de registro:</small>
                                    <div class="fw-bold">{{ $consumo->created_at?->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('consumos.show', $consumo) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </a>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i>
                                    Actualizar Consumo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.btn-check:checked + .btn {
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    transform: translateY(-2px);
}
.card {
    transition: all 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
// Marcar tipo de comida seleccionado al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const selectedRadio = document.querySelector('input[name="tipo_comida"]:checked');
    if (selectedRadio) {
        const label = document.querySelector(`label[for="${selectedRadio.id}"]`);
        if (label) {
            // Obtener el color del botón
            const colorClass = Array.from(label.classList).find(cls => cls.includes('btn-outline-'));
            if (colorClass) {
                const color = colorClass.replace('btn-outline-', 'border-');
                label.classList.add(color, 'bg-light');
            }
        }
    }
});

// Actualizar confirmación antes de enviar
document.getElementById('editConsumoForm').addEventListener('submit', function(e) {
    const trabajador = document.getElementById('trabajador_id');
    const trabajadorNombre = trabajador.options[trabajador.selectedIndex].text;
    const fecha = document.getElementById('fecha_consumo').value;
    const hora = document.getElementById('hora_consumo').value;
    const tipo = document.querySelector('input[name="tipo_comida"]:checked');

    if (!confirm(`¿Confirma actualizar el consumo?\n\nTrabajador: ${trabajadorNombre}\nFecha: ${fecha}\nHora: ${hora}\nTipo: ${tipo ? tipo.value : 'No seleccionado'}`)) {
        e.preventDefault();
    }
});
</script>
@endpush
@endsection
        justify-content: center;
        margin-right: 15px;
    }
</style>
@endpush

<div class="container-fluid my-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('consumos.index') }}">Consumos</a></li>
                    <li class="breadcrumb-item active">Editar Consumo</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-card">
                <div class="card-header form-header">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-edit fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Editar Consumo</h4>
                            <small class="opacity-75">Modifique la información del consumo</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('consumos.update', $consumo) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Información del Trabajador -->
                            <div class="col-12">
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <div>
                                        <strong>Trabajador:</strong> {{ $consumo->trabajador->nombres }} {{ $consumo->trabajador->apellidos }}
                                        <span class="badge bg-primary ms-2">{{ $consumo->trabajador->codigo }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Trabajador (oculto, pero enviamos el ID) -->
                            <input type="hidden" name="trabajador_id" value="{{ $consumo->trabajador_id }}">

                            <!-- Fecha de Consumo -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2 text-primary"></i>Fecha de Consumo *
                                </label>
                                <input type="date" name="fecha_consumo"
                                       class="form-control @error('fecha_consumo') is-invalid @enderror"
                                       value="{{ old('fecha_consumo', $consumo->fecha_consumo->format('Y-m-d')) }}" required>
                                @error('fecha_consumo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora de Consumo -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clock me-2 text-primary"></i>Hora de Consumo *
                                </label>
                                <input type="time" name="hora_consumo"
                                       class="form-control @error('hora_consumo') is-invalid @enderror"
                                       value="{{ old('hora_consumo', $consumo->hora_consumo->format('H:i')) }}" required>
                                @error('hora_consumo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo de Comida -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-hamburger me-2 text-primary"></i>Tipo de Comida *
                                </label>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="form-check form-check-inline w-100">
                                            <input class="form-check-input" type="radio" name="tipo_comida"
                                                   id="desayuno" value="desayuno"
                                                   {{ old('tipo_comida', $consumo->tipo_comida) == 'desayuno' ? 'checked' : '' }}>
                                            <label class="form-check-label w-100 p-3 border rounded text-center" for="desayuno">
                                                <i class="fas fa-coffee fa-2x text-warning d-block mb-2"></i>
                                                <strong>Desayuno</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-check-inline w-100">
                                            <input class="form-check-input" type="radio" name="tipo_comida"
                                                   id="almuerzo" value="almuerzo"
                                                   {{ old('tipo_comida', $consumo->tipo_comida) == 'almuerzo' ? 'checked' : '' }}>
                                            <label class="form-check-label w-100 p-3 border rounded text-center" for="almuerzo">
                                                <i class="fas fa-hamburger fa-2x text-success d-block mb-2"></i>
                                                <strong>Almuerzo</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-check-inline w-100">
                                            <input class="form-check-input" type="radio" name="tipo_comida"
                                                   id="cena" value="cena"
                                                   {{ old('tipo_comida', $consumo->tipo_comida) == 'cena' ? 'checked' : '' }}>
                                            <label class="form-check-label w-100 p-3 border rounded text-center" for="cena">
                                                <i class="fas fa-moon fa-2x text-info d-block mb-2"></i>
                                                <strong>Cena</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('tipo_comida')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Observaciones -->
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-sticky-note me-2 text-primary"></i>Observaciones
                                </label>
                                <textarea name="observaciones" rows="3"
                                          class="form-control @error('observaciones') is-invalid @enderror"
                                          placeholder="Observaciones adicionales sobre el consumo (opcional)">{{ old('observaciones', $consumo->observaciones) }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Información de registro -->
                            <div class="col-12">
                                <div class="alert alert-light">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Registrado:</strong> {{ $consumo->created_at->format('d/m/Y H:i') }} por {{ $consumo->user->name }}
                                        @if($consumo->updated_at != $consumo->created_at)
                                            <br><strong>Última modificación:</strong> {{ $consumo->updated_at->format('d/m/Y H:i') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('consumos.index') }}" class="btn btn-outline-secondary btn-floating">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <a href="{{ route('consumos.show', $consumo) }}" class="btn btn-outline-info btn-floating">
                                    <i class="fas fa-eye me-2"></i>Ver Detalle
                                </a>
                                <button type="submit" class="btn btn-primary btn-floating">
                                    <i class="fas fa-save me-2"></i>Actualizar Consumo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Mejorar estilo de radio buttons
document.querySelectorAll('input[name="tipo_comida"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('label[for="desayuno"], label[for="almuerzo"], label[for="cena"]').forEach(label => {
            label.classList.remove('border-primary', 'bg-light');
        });

        if (this.checked) {
            document.querySelector(`label[for="${this.id}"]`).classList.add('border-primary', 'bg-light');
        }
    });
});

// Aplicar estilo inicial al valor seleccionado
document.addEventListener('DOMContentLoaded', function() {
    const selectedRadio = document.querySelector('input[name="tipo_comida"]:checked');
    if (selectedRadio) {
        document.querySelector(`label[for="${selectedRadio.id}"]`).classList.add('border-primary', 'bg-light');
    }
});
</script>
@endpush

</x-app-layout>
