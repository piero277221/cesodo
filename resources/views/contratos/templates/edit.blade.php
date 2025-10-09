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
                    <li class="breadcrumb-item active">Editar Template</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit text-primary me-2"></i>
                Editar Template: {{ $template->nombre }}
            </h1>
        </div>
        <div class="btn-group">
            <a href="{{ route('contratos.templates.preview', $template) }}" class="btn btn-info">
                <i class="fas fa-eye me-1"></i>
                Vista Previa
            </a>
            <a href="{{ route('contratos.templates.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Información del Template</h5>
                    @if($template->es_predeterminado)
                        <span class="badge bg-primary">
                            <i class="fas fa-star me-1"></i>
                            Predeterminado
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('contratos.templates.update', $template) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nombre" class="form-label">Nombre del Template *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                       id="nombre" name="nombre" value="{{ old('nombre', $template->nombre) }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <input type="text" class="form-control" value="{{ strtoupper($template->tipo) }}" disabled>
                                <small class="text-muted">El tipo no se puede cambiar después de la creación</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                      id="descripcion" name="descripcion" rows="2">{{ old('descripcion', $template->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="es_predeterminado"
                                   name="es_predeterminado" value="1"
                                   {{ old('es_predeterminado', $template->es_predeterminado) ? 'checked' : '' }}>
                            <label class="form-check-label" for="es_predeterminado">
                                <strong>Establecer como template predeterminado</strong>
                                <small class="text-muted d-block">Se usará automáticamente al generar PDFs</small>
                            </label>
                        </div>

                        <hr>

                        <!-- Interfaz WYSIWYG como el generador -->
                        <div class="mb-3">
                            <label for="contenido_html" class="form-label">
                                <i class="fas fa-edit me-1"></i>
                                Contenido del Contrato
                            </label>

                            <!-- Barra de herramientas -->
                            <div class="btn-toolbar editor-toolbar bg-light border border-bottom-0 rounded-top p-2" role="toolbar">
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
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('insertUnorderedList')" title="Lista con viñetas">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('insertOrderedList')" title="Lista numerada">
                                        <i class="fas fa-list-ol"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Editor visual -->
                            <div id="editor" class="editor-content" contenteditable="true" style="min-height: 400px;">
                                @php echo $template->contenido @endphp
                            </div>

                            <!-- Campo oculto para enviar el contenido -->
                            <textarea id="contenido_html" name="contenido_html" class="d-none" required>@php echo old('contenido_html', $template->contenido) @endphp</textarea>

                            @error('contenido_html')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Usa el editor visual para modificar la plantilla. Los marcadores se mostrarán con una X para eliminarlos.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('contratos.templates.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Actualizar Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Información Adicional
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Creado por:</small>
                            <strong>{{ $template->creadoPor->name ?? 'Usuario eliminado' }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Fecha de creación:</small>
                            <strong>{{ $template->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                    </div>

                    @if($template->updated_at != $template->created_at)
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Última actualización:</small>
                                <strong>{{ $template->updated_at->format('d/m/Y H:i') }}</strong>
                            </div>
                        </div>
                    @endif

                    @if($template->archivo_original)
                        <div class="row mt-2">
                            <div class="col-12">
                                <small class="text-muted d-block">Archivo original:</small>
                                <strong>{{ basename($template->archivo_original) }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Marcadores detectados -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-tags text-success me-2"></i>
                        Marcadores Detectados ({{ count($template->marcadores ?? []) }})
                    </h6>
                    <button type="button" class="btn btn-sm btn-primary" id="editMarcadoresBtn">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                </div>
                <div class="card-body">
                    <div id="marcadoresView">
                        @if($template->marcadores && count($template->marcadores) > 0)
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($template->marcadores as $marcador)
                                    <span class="badge bg-success">@php echo htmlspecialchars($marcador) @endphp</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                No se detectaron marcadores en este template.
                            </p>
                        @endif
                    </div>

                    <div id="marcadoresEdit" class="d-none">
                        <form id="updateMarcadoresForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small">Marcadores (uno por línea):</label>
                                <textarea class="form-control" id="marcadoresTextarea" rows="8"
                                          placeholder="&#123;&#123;nombre&#125;&#125;&#10;&#123;&#123;cedula&#125;&#125;&#10;&#123;&#123;cargo&#125;&#125;&#10;&#123;&#123;salario&#125;&#125;">@php echo implode("\n", $template->marcadores ?? []) @endphp</textarea>
                                <small class="text-muted">Formato: &#123;&#123;variable&#125;&#125; - uno por línea</small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary" id="cancelEditBtn">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de marcadores disponibles -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-list text-primary me-2"></i>
                        Marcadores Disponibles
                    </h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <p class="small text-muted mb-3">
                        Haz clic en cualquier marcador para copiarlo al portapapeles.
                    </p>

                    @foreach($marcadores as $categoria => $descripcion)
                        @if(str_contains($categoria, '_TRABAJADOR'))
                            @if(!isset($trabajadorPrinted))
                                <h6 class="text-primary mt-3 mb-2">Datos del Trabajador</h6>
                                @php $trabajadorPrinted = true @endphp
                            @endif
                        @elseif(str_contains($categoria, 'FECHA_'))
                            @if(!isset($fechaPrinted))
                                <h6 class="text-primary mt-3 mb-2">Fechas</h6>
                                @php $fechaPrinted = true @endphp
                            @endif
                        @elseif(str_contains($categoria, 'HORA_') || str_contains($categoria, 'DIAS_') || str_contains($categoria, 'HORAS_') || str_contains($categoria, 'JORNADA_'))
                            @if(!isset($horarioPrinted))
                                <h6 class="text-primary mt-3 mb-2">Horarios y Jornada</h6>
                                @php $horarioPrinted = true @endphp
                            @endif
                        @elseif(str_contains($categoria, 'SALARIO_') || str_contains($categoria, 'BONIFICACIONES') || str_contains($categoria, 'DESCUENTOS') || str_contains($categoria, 'MONEDA') || str_contains($categoria, 'TIPO_PAGO'))
                            @if(!isset($economiaPrinted))
                                <h6 class="text-primary mt-3 mb-2">Información Económica</h6>
                                @php $economiaPrinted = true @endphp
                            @endif
                        @elseif(!str_contains($categoria, '_TRABAJADOR') && !str_contains($categoria, 'FECHA_') && !str_contains($categoria, 'HORA_') && !str_contains($categoria, 'DIAS_') && !str_contains($categoria, 'HORAS_') && !str_contains($categoria, 'JORNADA_') && !str_contains($categoria, 'SALARIO_') && !str_contains($categoria, 'BONIFICACIONES') && !str_contains($categoria, 'DESCUENTOS') && !str_contains($categoria, 'MONEDA') && !str_contains($categoria, 'TIPO_PAGO'))
                            @if(!isset($generalPrinted))
                                <h6 class="text-primary mt-3 mb-2">Información General</h6>
                                @php $generalPrinted = true @endphp
                            @endif
                        @endif

                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary w-100 text-start marcador-btn"
                                    data-marcador="{{ $categoria }}" title="{{ $descripcion }}">
                                <code style="font-size: 0.7rem;">{{ $categoria }}</code>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('editMarcadoresBtn');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const marcadoresView = document.getElementById('marcadoresView');
    const marcadoresEdit = document.getElementById('marcadoresEdit');
    const updateForm = document.getElementById('updateMarcadoresForm');

    // Alternar entre vista y edición de marcadores
    editBtn.addEventListener('click', function() {
        marcadoresView.classList.add('d-none');
        marcadoresEdit.classList.remove('d-none');
    });

    cancelBtn.addEventListener('click', function() {
        marcadoresEdit.classList.add('d-none');
        marcadoresView.classList.remove('d-none');
    });

    // Actualizar marcadores
    updateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const textarea = document.getElementById('marcadoresTextarea');
        const marcadores = textarea.value.split('\n')
            .map(m => m.trim())
            .filter(m => m.length > 0 && m.startsWith('{{') && m.endsWith('}}'));

        // Enviar AJAX para actualizar marcadores
        fetch(`{{ route('contratos.templates.update', $template) }}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                marcadores: marcadores,
                update_marcadores_only: true
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la vista
                location.reload();
            } else {
                alert('Error al actualizar marcadores: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar marcadores');
        });
    });

    // Copiar marcadores al hacer clic - Con fallback mejorado
    document.querySelectorAll('.marcador-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const marcador = this.dataset.marcador;

            // Intentar usar la API moderna del portapapeles
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(marcador).then(() => {
                    showCopySuccess(this);
                }).catch(() => {
                    // Fallback si falla
                    fallbackCopyTextToClipboard(marcador, this);
                });
            } else {
                // Fallback para navegadores antiguos o contextos no seguros
                fallbackCopyTextToClipboard(marcador, this);
            }
        });
    });

    function fallbackCopyTextToClipboard(text, button) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showCopySuccess(button);
            } else {
                showCopyError(button, text);
            }
        } catch (err) {
            showCopyError(button, text);
        }

        document.body.removeChild(textArea);
    }

    function showCopySuccess(button) {
        const originalText = button.innerHTML;
        const originalClass = button.className;

        button.innerHTML = '<i class="fas fa-check text-success"></i> ¡Copiado!';
        button.className = 'btn btn-sm btn-success w-100 text-start marcador-btn';

        setTimeout(() => {
            button.innerHTML = originalText;
            button.className = originalClass;
        }, 1500);
    }

    function showCopyError(button, text) {
        const originalText = button.innerHTML;
        const originalClass = button.className;

        button.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error al copiar';
        button.className = 'btn btn-sm btn-warning w-100 text-start marcador-btn';

        setTimeout(() => {
            button.innerHTML = originalText;
            button.className = originalClass;
        }, 2000);

        // Mostrar el texto para que el usuario pueda copiarlo manualmente
        prompt('Copia manualmente este marcador:', text);
    }
});

// Estilos y funciones del editor WYSIWYG
document.addEventListener('DOMContentLoaded', function() {
    // Sincronizar contenido del editor con el textarea
    const editor = document.getElementById('editor');
    const textarea = document.getElementById('contenido_html');

    if (editor && textarea) {
        // Procesar marcadores existentes para agregarles la X de eliminación
        procesarMarcadoresExistentes();

        editor.addEventListener('input', function() {
            textarea.value = editor.innerHTML;
        });

        // Sincronizar al enviar el formulario
        const form = editor.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                textarea.value = editor.innerHTML;
            });
        }
    }
});

function formatText(command) {
    document.execCommand(command, false, null);
    const editor = document.getElementById('editor');
    if (editor) {
        editor.focus();
        // Actualizar textarea
        document.getElementById('contenido_html').value = editor.innerHTML;
    }
}

function procesarMarcadoresExistentes() {
    const editor = document.getElementById('editor');
    if (!editor) return;

    const contenido = editor.innerHTML;

    // Buscar marcadores con el patrón &#123;&#123;variable&#125;&#125;
    const patron = /\{\{([^}]+)\}\}/g;
    let nuevoContenido = contenido;

    // Reemplazar cada marcador encontrado con la versión que incluye X
    nuevoContenido = nuevoContenido.replace(patron, function(match) {
        return '<span class="marcador-tag" contenteditable="false">' + match + '<button class="marcador-delete" type="button" onclick="this.parentElement.remove(); document.getElementById(\'contenido_html\').value = document.getElementById(\'editor\').innerHTML;">×</button></span>';
    });

    editor.innerHTML = nuevoContenido;
}
</script>

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
@endsection
