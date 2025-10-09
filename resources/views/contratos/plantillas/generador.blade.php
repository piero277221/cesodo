@extends('layouts.app')

@section('title', 'Generador de Plantillas de Contrato')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-file-word me-2"></i>Generador de Plantillas de Contrato
                        </h4>
                        <a href="{{ route('contratos.templates.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Volver a Plantillas
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Instrucciones -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>¿Cómo usar el generador?</h5>
                        <ul class="mb-0">
                            <li><strong>Edita el contenido:</strong> Usa el editor para modificar tu plantilla como si fuera Word</li>
                            <li><strong>Inserta marcadores:</strong> Usa los botones para agregar campos automáticos como &#123;&#123;nombre&#125;&#125;, &#123;&#123;cargo&#125;&#125;, etc.</li>
                            <li><strong>Sube tu logo:</strong> Opcional - agrega el logo de tu empresa</li>
                            <li><strong>Descarga:</strong> Genera un archivo .docx listo para usar</li>
                        </ul>
                    </div>

                    <form id="generadorForm" action="{{ route('plantillas.generar') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Panel izquierdo - Editor -->
                            <div class="col-lg-8">
                                <!-- Título de la plantilla -->
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">
                                        <i class="fas fa-heading me-1"></i>Título del Contrato
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="titulo"
                                           name="titulo"
                                           value="CONTRATO DE TRABAJO"
                                           required>
                                </div>

                                <!-- Logo opcional -->
                                <div class="mb-3">
                                    <label for="logo" class="form-label">
                                        <i class="fas fa-image me-1"></i>Logo de la Empresa (opcional)
                                    </label>
                                    <input type="file"
                                           class="form-control"
                                           id="logo"
                                           name="logo"
                                           accept="image/*">
                                    <small class="text-muted">Formatos: JPG, PNG, GIF (máximo 2MB)</small>
                                </div>

                                <!-- Barra de herramientas del editor -->
                                <div class="editor-toolbar bg-light p-2 rounded-top border">
                                    <div class="btn-group me-2" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('bold')" title="Negrita">
                                            <i class="fas fa-bold"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('italic')" title="Cursiva">
                                            <i class="fas fa-italic"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('underline')" title="Subrayado">
                                            <i class="fas fa-underline"></i>
                                        </button>
                                    </div>

                                    <div class="btn-group me-2" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('justifyLeft')" title="Alinear izquierda">
                                            <i class="fas fa-align-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('justifyCenter')" title="Centrar">
                                            <i class="fas fa-align-center"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('justifyRight')" title="Alinear derecha">
                                            <i class="fas fa-align-right"></i>
                                        </button>
                                    </div>

                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('insertOrderedList')" title="Lista numerada">
                                            <i class="fas fa-list-ol"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('insertUnorderedList')" title="Lista con viñetas">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Editor de contenido -->
                                <div class="mb-3">
                                    <label for="contenido" class="form-label">
                                        <i class="fas fa-edit me-1"></i>Contenido del Contrato
                                    </label>
                                    <div id="editor" class="form-control editor-content"
                                         contenteditable="true"
                                         style="min-height: 400px; font-family: 'Times New Roman', serif; font-size: 14px; line-height: 1.6;">
                                        <!-- El contenido se cargará aquí -->
                                    </div>
                                    <textarea id="contenido" name="contenido" class="d-none" required></textarea>
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex gap-2 flex-wrap">
                                    <button type="button" class="btn btn-primary" onclick="guardarPlantilla()">
                                        <i class="fas fa-save me-2"></i>Guardar Plantilla
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-download me-2"></i>Generar y Descargar Plantilla
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="cargarPlantillaBase()">
                                        <i class="fas fa-refresh me-2"></i>Cargar Plantilla Base
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="limpiarEditor()">
                                        <i class="fas fa-eraser me-2"></i>Limpiar Todo
                                    </button>
                                </div>
                            </div>

                            <!-- Panel derecho - Marcadores -->
                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-tags me-1"></i>Marcadores Disponibles
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="small mb-3">Haz clic para insertar marcadores en tu plantilla:</p>

                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertarMarcador('&#123;&#123;nombre&#125;&#125;')">
                                                <i class="fas fa-user me-1"></i>&#123;&#123;nombre&#125;&#125;</button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertarMarcador('&#123;&#123;cedula&#125;&#125;')">
                                                <i class="fas fa-id-card me-1"></i>&#123;&#123;cedula&#125;&#125;</button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertarMarcador('&#123;&#123;cargo&#125;&#125;')">
                                                <i class="fas fa-briefcase me-1"></i>&#123;&#123;cargo&#125;&#125;</button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertarMarcador('&#123;&#123;salario&#125;&#125;')">
                                                <i class="fas fa-dollar-sign me-1"></i>&#123;&#123;salario&#125;&#125;</button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertarMarcador('&#123;&#123;fecha_inicio&#125;&#125;')">
                                                <i class="fas fa-calendar me-1"></i>&#123;&#123;fecha_inicio&#125;&#125;</button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertarMarcador('&#123;&#123;empresa&#125;&#125;')">
                                                <i class="fas fa-building me-1"></i>&#123;&#123;empresa&#125;&#125;</button>
                                        </div>

                                        <hr>

                                        <div class="alert alert-warning py-2">
                                            <small>
                                                <i class="fas fa-lightbulb me-1"></i>
                                                <strong>Tip:</strong> Los marcadores se reemplazarán automáticamente con los datos del trabajador cuando generes un contrato.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vista previa -->
                                <div class="card mt-3">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-eye me-1"></i>Vista Previa
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <small class="text-muted">
                                            La plantilla generada será un archivo Word (.docx) que podrás:
                                        </small>
                                        <ul class="small mt-2">
                                            <li>Abrir en Microsoft Word</li>
                                            <li>Editar con formato completo</li>
                                            <li>Usar en el sistema de contratos</li>
                                            <li>Compartir con otros usuarios</li>
                                        </ul>
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
.editor-content {
    border: 1px solid #ced4da;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
    padding: 12px;
    background: white;
    filter: none !important;
    transform: none !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.editor-content:focus {
    outline: none;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    filter: none !important;
    transform: none !important;
}

.editor-content:hover {
    filter: none !important;
    transform: none !important;
}

/* Eliminar efectos borrosos de todo el contenido editable */
.editor-content *,
.editor-content *:hover,
.editor-content *:focus {
    filter: none !important;
    transform: none !important;
}

.editor-toolbar {
    border-bottom: none;
}

.marcador-btn {
    font-family: 'Courier New', monospace;
    font-size: 12px;
    filter: none !important;
    transform: none !important;
    transition: background-color 0.2s ease, border-color 0.2s ease;
}

.marcador-btn:hover {
    filter: none !important;
    transform: none !important;
}

.marcador-tag {
    position: relative;
    display: inline-block;
    background-color: #e3f2fd;
    padding: 2px 20px 2px 4px;
    border-radius: 3px;
    font-family: monospace;
    margin: 0 1px;
    filter: none !important;
    transform: none !important;
    transition: background-color 0.2s ease;
}

.marcador-tag:hover {
    background-color: #bbdefb;
    filter: none !important;
    transform: none !important;
}

.marcador-delete {
    position: absolute;
    top: -2px;
    right: 2px;
    background: #f44336;
    color: white;
    border: none;
    border-radius: 50%;
    width: 14px;
    height: 14px;
    font-size: 10px;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.marcador-delete:hover {
    background: #d32f2f;
    transform: scale(1.1);
}

/* Eliminar efectos borrosos de todos los botones */
.btn, button {
    filter: none !important;
    transform: none !important;
    transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
}

.btn:hover, button:hover {
    filter: none !important;
    transform: none !important;
}

.btn:focus, button:focus {
    filter: none !important;
    transform: none !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cargar plantilla base al iniciar
    cargarPlantillaBase();

    // Sincronizar contenido del editor con el textarea
    const editor = document.getElementById('editor');
    const textarea = document.getElementById('contenido');

    editor.addEventListener('input', function() {
        textarea.value = editor.innerHTML;
    });

    // Sincronizar al enviar el formulario
    document.getElementById('generadorForm').addEventListener('submit', function() {
        textarea.value = editor.innerHTML;
    });
});

function formatText(command) {
    document.execCommand(command, false, null);
    document.getElementById('editor').focus();
}

function insertarMarcador(marcador) {
    const editor = document.getElementById('editor');
    const selection = window.getSelection();

    // Decodificar la entidad HTML para obtener el marcador real
    const textarea = document.createElement('textarea');
    textarea.innerHTML = marcador;
    const marcadorDecodificado = textarea.value;

    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);

        // Crear el contenedor del marcador
        const span = document.createElement('span');
        span.className = 'marcador-tag';
        span.setAttribute('contenteditable', 'false');

        // Crear el texto del marcador
        const textNode = document.createTextNode(marcadorDecodificado);
        span.appendChild(textNode);

        // Crear el botón de eliminar
        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'marcador-delete';
        deleteBtn.innerHTML = '×';
        deleteBtn.type = 'button';
        deleteBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            span.remove();
            // Actualizar textarea después de eliminar
            document.getElementById('contenido').value = editor.innerHTML;
        };

        span.appendChild(deleteBtn);

        range.deleteContents();
        range.insertNode(span);

        // Mover el cursor después del marcador
        range.setStartAfter(span);
        range.collapse(true);
        selection.removeAllRanges();
        selection.addRange(range);

        editor.focus();

        // Actualizar textarea
        document.getElementById('contenido').value = editor.innerHTML;
    }
}

function cargarPlantillaBase() {
    fetch('{{ route("plantillas.base") }}')
        .then(response => response.json())
        .then(data => {
            const editor = document.getElementById('editor');
            // Convertir saltos de línea a HTML y decodificar entidades HTML
            let contenidoHtml = data.plantilla.replace(/\n/g, '<br>');

            // Decodificar entidades HTML para mostrar los marcadores correctamente
            const textarea = document.createElement('textarea');
            textarea.innerHTML = contenidoHtml;
            contenidoHtml = textarea.value;

            // Volver a convertir saltos de línea
            contenidoHtml = contenidoHtml.replace(/\n/g, '<br>');

            editor.innerHTML = contenidoHtml;

            // Procesar marcadores existentes para agregarles la X de eliminación
            procesarMarcadoresExistentes();

            document.getElementById('contenido').value = editor.innerHTML;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar la plantilla base');
        });
}

function procesarMarcadoresExistentes() {
    const editor = document.getElementById('editor');
    const contenido = editor.innerHTML;

    // Buscar marcadores con el patrón que tienen llaves dobles
    const patron = /\{\{([^}]+)\}\}/g;
    let nuevoContenido = contenido;

    // Reemplazar cada marcador encontrado con la versión que incluye X
    nuevoContenido = nuevoContenido.replace(patron, function(match, variable) {
        return '<span class="marcador-tag" contenteditable="false">' + match + '<button class="marcador-delete" type="button" onclick="this.parentElement.remove(); document.getElementById(\'contenido\').value = document.getElementById(\'editor\').innerHTML;">×</button></span>';
    });

    editor.innerHTML = nuevoContenido;
}

function limpiarEditor() {
    if (confirm('¿Estás seguro de que quieres limpiar todo el contenido?')) {
        const editor = document.getElementById('editor');
        editor.innerHTML = '';
        document.getElementById('contenido').value = '';
        document.getElementById('titulo').value = 'CONTRATO DE TRABAJO';
        document.getElementById('logo').value = '';
        editor.focus();
    }
}

function guardarPlantilla() {
    const editor = document.getElementById('editor');
    const titulo = document.getElementById('titulo').value;
    const contenido = editor.innerHTML;

    if (!contenido.trim()) {
        alert('No hay contenido para guardar');
        return;
    }

    // Preparar datos para enviar
    const formData = new FormData();
    formData.append('titulo', titulo);
    formData.append('contenido', contenido);
    formData.append('_token', '{{ csrf_token() }}');

    // Mostrar indicador de carga
    const btnGuardar = event.target;
    const textoOriginal = btnGuardar.innerHTML;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
    btnGuardar.disabled = true;

    fetch('{{ route("plantillas.guardar") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Plantilla guardada exitosamente!\nAhora podrás usarla para generar contratos.');
        } else {
            alert('Error al guardar la plantilla: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la plantilla');
    })
    .finally(() => {
        // Restaurar botón
        btnGuardar.innerHTML = textoOriginal;
        btnGuardar.disabled = false;
    });
}
</script>
@endsection
