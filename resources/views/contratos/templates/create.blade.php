@extends('layouts.app')

@section('title', 'Subir Plantilla de Contrato')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-upload me-2"></i>
                            <span class="h5 mb-0">Subir Plantilla de Contrato</span>
                        </div>
                        <a href="{{ route('contratos.templates.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Instrucciones principales -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle text-primary me-3 mt-1"></i>
                            <div>
                                <h6 class="alert-heading mb-2">
                                    <i class="fas fa-file-upload me-2"></i>Cómo crear una plantilla que funcione
                                </h6>
                                <ol class="mb-2">
                                    <li><strong>Crea tu documento:</strong> Escribe tu contrato en Word (.docx) o PDF</li>
                                    <li><strong>Agrega marcadores:</strong> Donde quieras datos dinámicos, usa el formato <code>@{{"{{variable}}"}}</code></li>
                                    <li><strong>Ejemplo:</strong> "El empleado <code>@{{"{{nombre}}"}}</code> con cédula <code>@{{"{{cedula}}"}}</code>"</li>
                                    <li><strong>Sube el archivo:</strong> Arrastra o selecciona tu documento</li>
                                    <li><strong>El sistema detectará automáticamente:</strong> Todos los marcadores en tu documento</li>
                                </ol>
                                <div class="bg-warning bg-opacity-10 p-2 rounded border border-warning mt-2">
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <strong>Importante:</strong> Los marcadores deben tener exactamente el formato <code>@{{"{{variable}}"}}</code>
                                        (con llaves dobles y sin espacios dentro)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de subida -->
                    <form action="{{ route('contratos.templates.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <!-- Campo tipo oculto -->
                        <input type="hidden" id="tipo" name="tipo" value="word">

                        <div class="row">
                            <!-- Columna izquierda: Formulario -->
                            <div class="col-lg-8">
                                <!-- Nombre de la plantilla -->
                                <div class="mb-4">
                                    <label for="nombre" class="form-label">
                                        <i class="fas fa-tag me-1"></i>Nombre de la Plantilla *
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="nombre"
                                           name="nombre"
                                           value="{{ old('nombre') }}"
                                           placeholder="Ej: Contrato de Trabajo Básico"
                                           required>
                                    <div class="form-text">Este nombre aparecerá en la lista de plantillas disponibles.</div>
                                </div>

                                <!-- Descripción opcional -->
                                <div class="mb-4">
                                    <label for="descripcion" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>Descripción (opcional)
                                    </label>
                                    <textarea class="form-control"
                                              id="descripcion"
                                              name="descripcion"
                                              rows="3"
                                              placeholder="Descripción breve de la plantilla y cuándo usarla...">{{ old('descripcion') }}</textarea>
                                </div>

                                <!-- Zona de subida de archivo -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-file-upload me-1"></i>Archivo de Plantilla *
                                    </label>

                                    <div class="upload-zone border border-dashed border-2 rounded p-4 text-center"
                                         id="uploadZone"
                                         style="border-color: #dee2e6; cursor: pointer !important; transition: all 0.3s ease; position: relative; z-index: 1;">

                                        <input type="file"
                                               id="archivo"
                                               name="archivo"
                                               accept=".docx,.pdf"
                                               required
                                               style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">

                                        <div id="uploadContent" style="pointer-events: none; position: relative; z-index: 2;">
                                            <div class="mb-3">
                                                <i class="fas fa-cloud-upload-alt text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                            <h5 class="text-muted mb-2">Arrastra tu archivo aquí</h5>
                                            <p class="text-muted mb-3">o haz clic para seleccionar</p>
                                            <div class="d-flex justify-content-center gap-3">
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-file-word me-1"></i>.docx
                                                </span>
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-file-pdf me-1"></i>.pdf
                                                </span>
                                            </div>
                                        </div>

                                        <div id="filePreview" class="d-none">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fas fa-file text-primary me-2" style="font-size: 2rem;"></i>
                                                <div class="text-start">
                                                    <div class="fw-bold" id="fileName"></div>
                                                    <small class="text-muted" id="fileSize"></small>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-3" id="removeFile">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón de envío -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-upload me-2"></i>Subir Plantilla
                                    </button>
                                    <a href="{{ route('contratos.templates.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Cancelar
                                    </a>
                                </div>
                            </div>

                            <!-- Columna derecha: Ayuda y ejemplos -->
                            <div class="col-lg-4">
                                <!-- Panel de marcadores seleccionados -->
                                <div class="card bg-light mb-3">
                                    <div class="card-header bg-primary text-white py-2">
                                        <h6 class="mb-0">
                                            <i class="fas fa-check-square me-1"></i>Marcadores Seleccionados
                                        </h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div id="marcadoresSeleccionados" class="mb-2">
                                            <small class="text-muted">No hay marcadores seleccionados</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="limpiarSeleccion" style="display: none;">
                                            <i class="fas fa-trash"></i> Limpiar Todo
                                        </button>
                                        <!-- Campo oculto para enviar marcadores seleccionados -->
                                        <input type="hidden" id="marcadoresSeleccionadosInput" name="marcadores_seleccionados" value="">
                                    </div>
                                </div>

                                <!-- Panel de marcadores comunes -->
                                <div class="card bg-light">
                                    <div class="card-header bg-success text-white py-2">
                                        <h6 class="mb-0">
                                            <i class="fas fa-tags me-1"></i>Marcadores Disponibles
                                        </h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="small mb-3">Haz clic en "Seleccionar" para agregar marcadores a tu plantilla:</p>

                                        <div class="marcador-list">
                                            <div class="marcador-item mb-2 d-flex justify-content-between align-items-center marcador-clickeable"
                                                 data-marcador="&#123;&#123;nombre&#125;&#125;">
                                                <code class="bg-white px-2 py-1 rounded border small">@{{"{{nombre}}"}}</code>
                                                <button class="btn btn-sm btn-outline-success select-btn"
                                                        data-marcador="&#123;&#123;nombre&#125;&#125;"
                                                        title="Seleccionar marcador nombre">
                                                    <i class="fas fa-plus"></i> Seleccionar
                                                </button>
                                            </div>
                                            <div class="marcador-item mb-2 d-flex justify-content-between align-items-center marcador-clickeable"
                                                 data-marcador="&#123;&#123;cedula&#125;&#125;">
                                                <code class="bg-white px-2 py-1 rounded border small">@{{"{{cedula}}"}}</code>
                                                <button class="btn btn-sm btn-outline-success select-btn"
                                                        data-marcador="&#123;&#123;cedula&#125;&#125;"
                                                        title="Seleccionar marcador cedula">
                                                    <i class="fas fa-plus"></i> Seleccionar
                                                </button>
                                            </div>
                                            <div class="marcador-item mb-2 d-flex justify-content-between align-items-center marcador-clickeable"
                                                 data-marcador="&#123;&#123;cargo&#125;&#125;">
                                                <code class="bg-white px-2 py-1 rounded border small">@{{"{{cargo}}"}}</code>
                                                <button class="btn btn-sm btn-outline-success select-btn"
                                                        data-marcador="&#123;&#123;cargo&#125;&#125;"
                                                        title="Seleccionar marcador cargo">
                                                    <i class="fas fa-plus"></i> Seleccionar
                                                </button>
                                            </div>
                                            <div class="marcador-item mb-2 d-flex justify-content-between align-items-center marcador-clickeable"
                                                 data-marcador="&#123;&#123;salario&#125;&#125;">
                                                <code class="bg-white px-2 py-1 rounded border small">@{{"{{salario}}"}}</code>
                                                <button class="btn btn-sm btn-outline-success select-btn"
                                                        data-marcador="&#123;&#123;salario&#125;&#125;"
                                                        title="Seleccionar marcador salario">
                                                    <i class="fas fa-plus"></i> Seleccionar
                                                </button>
                                            </div>
                                            <div class="marcador-item mb-2 d-flex justify-content-between align-items-center marcador-clickeable"
                                                 data-marcador="&#123;&#123;fecha_inicio&#125;&#125;">
                                                <code class="bg-white px-2 py-1 rounded border small">@{{"{{fecha_inicio}}"}}</code>
                                                <button class="btn btn-sm btn-outline-success select-btn"
                                                        data-marcador="&#123;&#123;fecha_inicio&#125;&#125;"
                                                        title="Seleccionar marcador fecha_inicio">
                                                    <i class="fas fa-plus"></i> Seleccionar
                                                </button>
                                            </div>
                                            <div class="marcador-item mb-2 d-flex justify-content-between align-items-center marcador-clickeable"
                                                 data-marcador="&#123;&#123;empresa&#125;&#125;">
                                                <code class="bg-white px-2 py-1 rounded border small">@{{"{{empresa}}"}}</code>
                                                <button class="btn btn-sm btn-outline-success select-btn"
                                                        data-marcador="&#123;&#123;empresa&#125;&#125;"
                                                        title="Seleccionar marcador empresa">
                                                    <i class="fas fa-plus"></i> Seleccionar
                                                </button>
                                            </div>
                                        </div>

                                        <div class="alert alert-warning py-2 mt-3">
                                            <small>
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Los marcadores son case-sensitive (distinguen mayúsculas/minúsculas)
                                            </small>
                                        </div>
                                    </div>
                                </div>                                <!-- Panel de ejemplo -->
                                <div class="card bg-light mt-3">
                                    <div class="card-header bg-info text-white py-2">
                                        <h6 class="mb-0">
                                            <i class="fas fa-eye me-1"></i>Ejemplo Completo
                                        </h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="bg-white p-3 rounded border">
                                            <p class="small mb-2"><strong>📝 En tu documento Word/PDF escribes:</strong></p>
                                            <div class="bg-light p-3 rounded border">
                                                <small style="line-height: 1.6;">
                                                    <strong>CONTRATO DE TRABAJO</strong><br><br>
                                                    Entre la empresa <code>@{{"{{empresa}}"}}</code> y el trabajador <code>@{{"{{nombre}}"}}</code>,
                                                    identificado con cédula <code>@{{"{{cedula}}"}}</code>, se establece el siguiente acuerdo:<br><br>

                                                    <strong>CARGO:</strong> <code>@{{"{{cargo}}"}}</code><br>
                                                    <strong>SALARIO:</strong> <code>@{{"{{salario}}"}}</code><br>
                                                    <strong>FECHA DE INICIO:</strong> <code>@{{"{{fecha_inicio}}"}}</code><br><br>

                                                    El empleado se compromete a...
                                                </small>
                                            </div>

                                            <p class="small mb-2 mt-3"><strong>✅ Al generar el contrato, se convierte en:</strong></p>
                                            <div class="bg-success bg-opacity-10 p-3 rounded border border-success">
                                                <small style="line-height: 1.6;">
                                                    <strong>CONTRATO DE TRABAJO</strong><br><br>
                                                    Entre la empresa <strong>CESODO S.A.</strong> y el trabajador <strong>Juan Pérez</strong>,
                                                    identificado con cédula <strong>12345678</strong>, se establece el siguiente acuerdo:<br><br>

                                                    <strong>CARGO:</strong> <strong>Desarrollador Senior</strong><br>
                                                    <strong>SALARIO:</strong> <strong>$2,500.00</strong><br>
                                                    <strong>FECHA DE INICIO:</strong> <strong>01/09/2025</strong><br><br>

                                                    El empleado se compromete a...
                                                </small>
                                            </div>
                                        </div>

                                        <div class="alert alert-success py-2 mt-3">
                                            <small>
                                                <i class="fas fa-check-circle me-1"></i>
                                                <strong>Consejo:</strong> Guarda tu documento Word, súbelo aquí, y listo.
                                                El sistema hará el resto automáticamente.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.upload-zone:hover {
    border-color: #0d6efd !important;
    background-color: #f8f9fa;
}

.marcador-item {
    transition: background-color 0.3s ease;
    cursor: pointer;
}

.marcador-clickeable {
    border: 1px solid transparent;
    border-radius: 5px;
    padding: 8px;
    margin: 2px 0;
    transform: none !important;
    filter: none !important;
    transition: background-color 0.2s ease, border-color 0.2s ease;
}

.marcador-clickeable:hover {
    background-color: #e8f5e8;
    border-color: #28a745;
    transform: none !important;
    filter: none !important;
}

.select-btn {
    transition: all 0.3s ease;
    transform: none !important;
    filter: none !important;
}

.select-btn:hover {
    background-color: #198754;
    border-color: #198754;
    color: white;
    transform: none !important;
    filter: none !important;
}

.marcador-seleccionado {
    background-color: #d4edda !important;
    border-color: #c3e6cb !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, iniciando script'); // Para debug

    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('archivo');
    const uploadContent = document.getElementById('uploadContent');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFileBtn = document.getElementById('removeFile');
    const submitBtn = document.getElementById('submitBtn');

    // Debug: verificar que los elementos existen
    console.log('Upload zone:', uploadZone);
    console.log('File input:', fileInput);
    console.log('Upload zone style:', uploadZone ? uploadZone.style.cursor : 'No uploadZone');

    // Variables para marcadores seleccionados
    const marcadoresSeleccionados = new Set();
    const marcadoresContainer = document.getElementById('marcadoresSeleccionados');
    const marcadoresInput = document.getElementById('marcadoresSeleccionadosInput');
    const limpiarBtn = document.getElementById('limpiarSeleccion');

    // ÁREA DE SUBIDA DE ARCHIVOS
    // Ahora el input file está superpuesto, no necesitamos listeners de click
    console.log('Input file configurado con overlay - debería funcionar directamente');

    // Eventos de drag and drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadZone.style.borderColor = '#0d6efd';
        uploadZone.style.backgroundColor = '#f8f9fa';
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadZone.style.borderColor = '#dee2e6';
        uploadZone.style.backgroundColor = 'transparent';
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadZone.style.borderColor = '#dee2e6';
        uploadZone.style.backgroundColor = 'transparent';

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    // Event listener para cuando se selecciona archivo
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            console.log('File input CHANGE detectado:', e.target.files); // Para debug
            if (e.target.files.length > 0) {
                console.log('Archivo seleccionado:', e.target.files[0].name);
                handleFile(e.target.files[0]);
            }
        });
    }

    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        document.getElementById('tipo').value = 'word'; // Reset al valor por defecto
        uploadContent.classList.remove('d-none');
        filePreview.classList.add('d-none');
    });

    function handleFile(file) {
        console.log('Handling file:', file.name); // Para debug

        // Validar tipo de archivo
        const allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            alert('Solo se permiten archivos Word (.docx) y PDF (.pdf)');
            return;
        }

        // Determinar el tipo y actualizar el campo oculto
        const tipoInput = document.getElementById('tipo');
        if (file.type === 'application/pdf') {
            tipoInput.value = 'pdf';
        } else if (file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            tipoInput.value = 'word';
        }

        // Mostrar información del archivo
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        uploadContent.classList.add('d-none');
        filePreview.classList.remove('d-none');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // SELECCIÓN DE MARCADORES
    // Hacer que toda el área del marcador sea clickeable
    document.querySelectorAll('.marcador-clickeable').forEach(marcadorArea => {
        marcadorArea.addEventListener('click', function(e) {
            // Si se hace click en el botón, no hacer nada (el botón maneja su propio click)
            if (e.target.closest('.select-btn')) {
                return;
            }

            // Buscar el botón dentro de esta área y hacer click en él
            const button = this.querySelector('.select-btn');
            if (button) {
                button.click();
            }
        });
    });

    // Event listeners para los botones
    document.querySelectorAll('.select-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Evitar que se propague al área padre
            const marcador = this.dataset.marcador;
            console.log('Click en botón, marcador:', marcador);
            const marcadorArea = this.closest('.marcador-clickeable');

            if (marcadoresSeleccionados.has(marcador)) {
                // Deseleccionar
                console.log('Deseleccionando:', marcador);
                marcadoresSeleccionados.delete(marcador);
                this.innerHTML = '<i class="fas fa-plus"></i> Seleccionar';
                this.className = 'btn btn-sm btn-outline-success select-btn';
                if (marcadorArea) {
                    marcadorArea.style.backgroundColor = '';
                    marcadorArea.style.borderColor = '';
                }
            } else {
                // Seleccionar
                console.log('Seleccionando:', marcador);
                marcadoresSeleccionados.add(marcador);
                this.innerHTML = '<i class="fas fa-check"></i> Seleccionado';
                this.className = 'btn btn-sm btn-success select-btn';
                if (marcadorArea) {
                    marcadorArea.style.backgroundColor = '#d4edda';
                    marcadorArea.style.borderColor = '#c3e6cb';
                }
            }

            console.log('Set después del click:', Array.from(marcadoresSeleccionados));
            actualizarMarcadoresSeleccionados();
        });
    });

    limpiarBtn.addEventListener('click', function() {
        marcadoresSeleccionados.clear();

        // Resetear todos los botones y áreas
        document.querySelectorAll('.select-btn').forEach(btn => {
            btn.innerHTML = '<i class="fas fa-plus"></i> Seleccionar';
            btn.className = 'btn btn-sm btn-outline-success select-btn';

            // Resetear estilo del área padre
            const marcadorArea = btn.closest('.marcador-clickeable');
            if (marcadorArea) {
                marcadorArea.style.backgroundColor = '';
                marcadorArea.style.borderColor = '';
            }
        });

        actualizarMarcadoresSeleccionados();
    });

    function actualizarMarcadoresSeleccionados() {
        console.log('Actualizando marcadores. Set size:', marcadoresSeleccionados.size);
        console.log('Marcadores en el Set:', Array.from(marcadoresSeleccionados));
        console.log('Container encontrado:', !!marcadoresContainer);

        if (marcadoresSeleccionados.size === 0) {
            marcadoresContainer.innerHTML = '<small class="text-muted">No hay marcadores seleccionados</small>';
            limpiarBtn.style.display = 'none';
            marcadoresInput.value = '';
        } else {
            const marcadoresArray = Array.from(marcadoresSeleccionados);
            console.log('Array de marcadores:', marcadoresArray);

            const badgesHtml = marcadoresArray.map(marcador => {
                console.log('Procesando marcador:', marcador);
                return `<span class="badge bg-primary me-1 mb-1">${marcador}</span>`;
            }).join('');

            console.log('HTML generado:', badgesHtml);
            marcadoresContainer.innerHTML = badgesHtml;
            limpiarBtn.style.display = 'inline-block';
            marcadoresInput.value = JSON.stringify(marcadoresArray);
        }
    }
});
</script>
@endsection
