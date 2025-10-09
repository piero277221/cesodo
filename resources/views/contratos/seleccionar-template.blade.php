@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('contratos.index') }}">Contratos</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('contratos.show', $contrato) }}">{{ $contrato->numero_contrato }}</a>
                    </li>
                    <li class="breadcrumb-item active">Seleccionar Template</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-contract text-primary me-2"></i>
                Seleccionar Template para PDF
            </h1>
            <p class="text-muted">Contrato: <strong>{{ $contrato->numero_contrato }}</strong> - {{ $contrato->trabajador->nombre ?? 'Trabajador no asignado' }}</p>
        </div>
        <a href="{{ route('contratos.show', $contrato) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Volver al Contrato
        </a>
    </div>

    <form action="{{ route('contratos.generar-pdf', $contrato) }}" method="POST" id="templateForm">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                @if($templates->count() > 0)
                    <div class="row" id="templateCards">
                        @foreach($templates as $template)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card template-card h-100" data-template-id="{{ $template->id }}">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">{{ $template->nombre }}</h6>
                                        @if($template->es_predeterminado)
                                            <span class="badge bg-primary">Predeterminado</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        @if($template->descripcion)
                                            <p class="card-text text-muted small">{{ Str::limit($template->descripcion, 100) }}</p>
                                        @endif

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-file text-info me-1"></i>
                                                {{ strtoupper($template->tipo) }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-tags text-success me-1"></i>
                                                {{ count($template->marcadores ?? []) }} marcadores
                                            </small>
                                        </div>

                                        @if($template->marcadores && count($template->marcadores) > 0)
                                            <div class="mb-3">
                                                <small class="text-muted d-block mb-1">Marcadores principales:</small>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach(array_slice($template->marcadores, 0, 6) as $marcador)
                                                        <span class="badge bg-light text-dark" style="font-size: 0.6rem;">{{ $marcador }}</span>
                                                    @endforeach
                                                    @if(count($template->marcadores) > 6)
                                                        <span class="badge bg-secondary" style="font-size: 0.6rem;">+{{ count($template->marcadores) - 6 }} más</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $template->created_at->diffForHumans() }}
                                            </small>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('contratos.templates.preview', $template) }}"
                                                   class="btn btn-outline-info btn-sm"
                                                   target="_blank"
                                                   title="Vista previa">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-check">
                                            <input class="form-check-input template-radio"
                                                   type="radio"
                                                   name="template_id"
                                                   value="{{ $template->id }}"
                                                   id="template_{{ $template->id }}"
                                                   {{ $template->es_predeterminado ? 'checked' : '' }}>
                                            <label class="form-check-label" for="template_{{ $template->id }}">
                                                Usar este template
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay templates disponibles</h5>
                            <p class="text-muted">No existen templates activos para generar el PDF.</p>
                            <a href="{{ route('contratos.templates.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear Primer Template
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Opción de template por defecto del sistema -->
                <div class="col-12 mb-4">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0">
                                <i class="fas fa-cog me-2"></i>
                                Template del Sistema (Original)
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Utilizar el template original del sistema. Este es el formato que se ha estado utilizando
                                antes de implementar los templates personalizados.
                            </p>
                            <div class="form-check">
                                <input class="form-check-input template-radio"
                                       type="radio"
                                       name="template_id"
                                       value=""
                                       id="template_sistema"
                                       {{ $templates->count() == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="template_sistema">
                                    Usar template del sistema
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Panel de información del contrato -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            Información del Contrato
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Número de Contrato:</small>
                            <strong>{{ $contrato->numero_contrato }}</strong>
                        </div>

                        @if($contrato->trabajador)
                            <div class="mb-3">
                                <small class="text-muted d-block">Trabajador:</small>
                                <strong>{{ $contrato->trabajador->nombre }}</strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Documento:</small>
                                <strong>{{ $contrato->trabajador->numero_documento }}</strong>
                            </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted d-block">Tipo de Contrato:</small>
                            <strong>{{ $contrato->tipo_contrato }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Fecha de Inicio:</small>
                            <strong>{{ $contrato->fecha_inicio ? \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') : 'No definida' }}</strong>
                        </div>

                        @if($contrato->fecha_fin)
                            <div class="mb-3">
                                <small class="text-muted d-block">Fecha de Fin:</small>
                                <strong>{{ \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</strong>
                            </div>
                        @endif

                        <div class="mb-0">
                            <small class="text-muted d-block">Salario:</small>
                            <strong>S/. {{ number_format($contrato->salario_base ?? 0, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Marcadores que se reemplazarán -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-exchange-alt text-success me-2"></i>
                            Datos que se Reemplazarán
                        </h6>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">
                            Los siguientes marcadores serán reemplazados automáticamente con los datos del contrato:
                        </small>
                        <div class="mt-2">
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge bg-success" style="font-size: 0.7rem;">{NOMBRE_TRABAJADOR}</span>
                                <span class="badge bg-success" style="font-size: 0.7rem;">{DOCUMENTO_TRABAJADOR}</span>
                                <span class="badge bg-success" style="font-size: 0.7rem;">{NUMERO_CONTRATO}</span>
                                <span class="badge bg-success" style="font-size: 0.7rem;">{TIPO_CONTRATO}</span>
                                <span class="badge bg-success" style="font-size: 0.7rem;">{SALARIO_BASE}</span>
                                <span class="badge bg-success" style="font-size: 0.7rem;">{FECHA_INICIO}</span>
                                <span class="badge bg-secondary" style="font-size: 0.7rem;">+30 más</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card mt-3">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2" id="generateBtn">
                            <i class="fas fa-file-pdf me-2"></i>
                            Generar PDF
                        </button>
                        <a href="{{ route('contratos.templates.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-cog me-1"></i>
                            Administrar Templates
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const templateCards = document.querySelectorAll('.template-card');
    const templateRadios = document.querySelectorAll('.template-radio');
    const generateBtn = document.getElementById('generateBtn');

    // Función para actualizar el estado visual de las tarjetas
    function updateCardStates() {
        templateCards.forEach(card => {
            const radio = card.querySelector('.template-radio');
            if (radio && radio.checked) {
                card.classList.add('border-primary');
                card.style.boxShadow = '0 0 10px rgba(0,123,255,0.25)';
            } else {
                card.classList.remove('border-primary');
                card.style.boxShadow = '';
            }
        });

        // Actualizar texto del botón según la selección
        const selectedRadio = document.querySelector('.template-radio:checked');
        if (selectedRadio) {
            if (selectedRadio.value === '') {
                generateBtn.innerHTML = '<i class="fas fa-file-pdf me-2"></i>Generar PDF (Template Sistema)';
            } else {
                const templateName = selectedRadio.closest('.template-card')?.querySelector('h6')?.textContent || 'Template Personalizado';
                generateBtn.innerHTML = `<i class="fas fa-file-pdf me-2"></i>Generar PDF (${templateName})`;
            }
        }
    }

    // Event listeners para los radio buttons
    templateRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateCardStates();
        });
    });

    // Event listeners para hacer clic en las tarjetas
    templateCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.type !== 'radio' && !e.target.closest('a')) {
                const radio = this.querySelector('.template-radio');
                if (radio) {
                    radio.checked = true;
                    updateCardStates();
                }
            }
        });
    });

    // Inicializar estado
    updateCardStates();

    // Validación del formulario
    document.getElementById('templateForm').addEventListener('submit', function(e) {
        const selectedTemplate = document.querySelector('.template-radio:checked');
        if (!selectedTemplate) {
            e.preventDefault();
            alert('Por favor, selecciona un template para generar el PDF.');
            return false;
        }
    });
});
</script>

<style>
.template-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.template-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.template-card.border-primary {
    border-color: #007bff !important;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}
</style>
@endsection
