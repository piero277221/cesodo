@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('contratos.templates.index') }}">Templates</a>
                    </li>
                    <li class="breadcrumb-item active">Vista Previa</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-eye text-info me-2"></i>
                Vista Previa: {{ $template->nombre }}
            </h1>
        </div>
        <div class="btn-group">
            <a href="{{ route('contratos.templates.edit', $template) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i>
                Editar
            </a>
            <a href="{{ route('contratos.templates.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <!-- Información del template -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Información del Template
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Nombre:</small>
                        <strong>{{ $template->nombre }}</strong>
                        @if($template->es_predeterminado)
                            <span class="badge bg-primary ms-1">Predeterminado</span>
                        @endif
                    </div>

                    @if($template->descripcion)
                        <div class="mb-3">
                            <small class="text-muted d-block">Descripción:</small>
                            <p class="mb-0">{{ $template->descripcion }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted d-block">Tipo:</small>
                        <span class="badge bg-info">{{ strtoupper($template->tipo) }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Estado:</small>
                        <span class="badge bg-{{ $template->activo ? 'success' : 'secondary' }}">
                            {{ $template->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Marcadores detectados:</small>
                        <strong>{{ count($template->marcadores ?? []) }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Creado por:</small>
                        <strong>{{ $template->creadoPor->name ?? 'Usuario eliminado' }}</strong>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted d-block">Fecha de creación:</small>
                        <strong>{{ $template->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Marcadores utilizados -->
            @if($template->marcadores && count($template->marcadores) > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-tags text-success me-2"></i>
                            Marcadores Utilizados
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($template->marcadores as $marcador)
                                <span class="badge bg-success" style="font-size: 0.7rem;">{{ $marcador }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Datos de ejemplo -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-user text-warning me-2"></i>
                        Datos de Ejemplo
                    </h6>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        Esta vista previa utiliza datos de ejemplo para mostrar cómo se verá el contrato final.
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <!-- Controles de vista previa -->
            <div class="card mb-3">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active" onclick="changeZoom(1)">
                                100%
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="changeZoom(0.8)">
                                80%
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="changeZoom(0.6)">
                                60%
                            </button>
                        </div>

                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-info" onclick="printPreview()">
                                <i class="fas fa-print me-1"></i>
                                Imprimir
                            </button>
                            <button type="button" class="btn btn-outline-success" onclick="downloadPreview()">
                                <i class="fas fa-download me-1"></i>
                                Descargar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vista previa del documento -->
            <div class="card">
                <div class="card-body p-0">
                    <div id="preview-container" style="overflow: auto; max-height: 800px;">
                        <div id="preview-content" style="transform: scale(1); transform-origin: top left; background: white; padding: 20px; margin: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                            {!! $contenidoProcesado !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advertencias y notas -->
            <div class="alert alert-info mt-3" role="alert">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>
                    Nota sobre la Vista Previa
                </h6>
                <p class="mb-0">
                    Esta vista previa utiliza datos de ejemplo. En el contrato real, estos datos serán reemplazados
                    automáticamente con la información específica de cada trabajador y contrato.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function changeZoom(scale) {
    const content = document.getElementById('preview-content');
    const container = document.getElementById('preview-container');

    content.style.transform = `scale(${scale})`;

    // Actualizar botones activos
    document.querySelectorAll('.btn-group button').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');

    // Ajustar altura del contenedor si es necesario
    if (scale < 1) {
        container.style.maxHeight = `${800 * scale}px`;
    } else {
        container.style.maxHeight = '800px';
    }
}

function printPreview() {
    const printWindow = window.open('', '_blank');
    const content = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Vista Previa - {{ $template->nombre }}</title>
            <style>
                body { margin: 0; padding: 20px; }
                @media print {
                    body { margin: 0; padding: 0; }
                }
            </style>
        </head>
        <body>
            {!! addslashes($contenidoProcesado) !!}
        </body>
        </html>
    `;

    printWindow.document.write(content);
    printWindow.document.close();
    printWindow.focus();

    setTimeout(() => {
        printWindow.print();
    }, 500);
}

function downloadPreview() {
    const content = `
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Vista Previa - {{ $template->nombre }}</title>
            <style>
                body { margin: 0; padding: 20px; font-family: Arial, sans-serif; }
            </style>
        </head>
        <body>
            {!! addslashes($contenidoProcesado) !!}
        </body>
        </html>
    `;

    const blob = new Blob([content], { type: 'text/html' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'preview-{{ Str::slug($template->nombre) }}.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>
@endsection
