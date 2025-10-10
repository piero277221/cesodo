@extends('layouts.app')

@section('title', 'Constructor de Formularios')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-magic me-2 text-primary"></i>
                Constructor de Formularios Dinámicos
            </h1>
            <p class="text-muted mb-0">Arrastra y suelta elementos para crear formularios personalizados</p>
        </div>
        <div>
            <button class="btn btn-outline-secondary me-2" id="previewForm">
                <i class="fas fa-eye me-1"></i> Vista Previa
            </button>
            <button class="btn btn-success" id="saveForm">
                <i class="fas fa-save me-1"></i> Guardar Formulario
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Field Palette -->
        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-toolbox me-2"></i>
                        Paleta de Campos
                    </h6>
                </div>
                <div class="card-body p-2">
                    <!-- Form Configuration -->
                    <div class="mb-4">
                        <h6 class="text-primary border-bottom pb-1 mb-2">Configuración</h6>
                        
                        <div class="mb-2">
                            <label class="form-label small">Módulo:</label>
                            <select class="form-select form-select-sm" id="targetModule">
                                <option value="">Seleccionar módulo...</option>
                                <option value="trabajadores">Trabajadores</option>
                                <option value="clientes">Clientes</option>
                                <option value="contratos">Contratos</option>
                                <option value="inventario">Inventario</option>
                                <option value="compras">Compras</option>
                                <option value="pedidos">Pedidos</option>
                            </select>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label small">Grupo de Campos:</label>
                            <select class="form-select form-select-sm" id="fieldGroup">
                                <option value="">Sin grupo</option>
                                @foreach(\App\Models\DynamicFieldGroup::orderBy('name')->get() as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Basic Fields -->
                    <div class="field-category mb-3">
                        <h6 class="text-secondary border-bottom pb-1 mb-2">
                            <i class="fas fa-font me-1"></i>Campos Básicos
                        </h6>
                        <div class="field-palette">
                            <div class="field-item" data-type="text" title="Campo de Texto">
                                <i class="fas fa-font"></i>
                                <span>Texto</span>
                            </div>
                            <div class="field-item" data-type="textarea" title="Área de Texto">
                                <i class="fas fa-align-left"></i>
                                <span>Área Texto</span>
                            </div>
                            <div class="field-item" data-type="number" title="Número">
                                <i class="fas fa-hashtag"></i>
                                <span>Número</span>
                            </div>
                            <div class="field-item" data-type="email" title="Email">
                                <i class="fas fa-envelope"></i>
                                <span>Email</span>
                            </div>
                        </div>
                    </div>

                    <!-- Date & Time Fields -->
                    <div class="field-category mb-3">
                        <h6 class="text-secondary border-bottom pb-1 mb-2">
                            <i class="fas fa-calendar me-1"></i>Fecha y Hora
                        </h6>
                        <div class="field-palette">
                            <div class="field-item" data-type="date" title="Fecha">
                                <i class="fas fa-calendar-day"></i>
                                <span>Fecha</span>
                            </div>
                            <div class="field-item" data-type="datetime" title="Fecha y Hora">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Fecha/Hora</span>
                            </div>
                            <div class="field-item" data-type="time" title="Hora">
                                <i class="fas fa-clock"></i>
                                <span>Hora</span>
                            </div>
                        </div>
                    </div>

                    <!-- Selection Fields -->
                    <div class="field-category mb-3">
                        <h6 class="text-secondary border-bottom pb-1 mb-2">
                            <i class="fas fa-list me-1"></i>Selección
                        </h6>
                        <div class="field-palette">
                            <div class="field-item" data-type="select" title="Lista Desplegable">
                                <i class="fas fa-caret-down"></i>
                                <span>Desplegable</span>
                            </div>
                            <div class="field-item" data-type="radio" title="Botones de Radio">
                                <i class="fas fa-dot-circle"></i>
                                <span>Radio</span>
                            </div>
                            <div class="field-item" data-type="checkbox" title="Casilla de Verificación">
                                <i class="fas fa-check-square"></i>
                                <span>Checkbox</span>
                            </div>
                        </div>
                    </div>

                    <!-- File Fields -->
                    <div class="field-category mb-3">
                        <h6 class="text-secondary border-bottom pb-1 mb-2">
                            <i class="fas fa-file me-1"></i>Archivos
                        </h6>
                        <div class="field-palette">
                            <div class="field-item" data-type="file" title="Archivo">
                                <i class="fas fa-paperclip"></i>
                                <span>Archivo</span>
                            </div>
                            <div class="field-item" data-type="image" title="Imagen">
                                <i class="fas fa-image"></i>
                                <span>Imagen</span>
                            </div>
                        </div>
                    </div>

                    <!-- Special Fields -->
                    <div class="field-category">
                        <h6 class="text-secondary border-bottom pb-1 mb-2">
                            <i class="fas fa-star me-1"></i>Especiales
                        </h6>
                        <div class="field-palette">
                            <div class="field-item" data-type="url" title="URL">
                                <i class="fas fa-link"></i>
                                <span>URL</span>
                            </div>
                            <div class="field-item" data-type="tel" title="Teléfono">
                                <i class="fas fa-phone"></i>
                                <span>Teléfono</span>
                            </div>
                            <div class="field-item" data-type="password" title="Contraseña">
                                <i class="fas fa-lock"></i>
                                <span>Contraseña</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Builder Canvas -->
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-dark">
                            <i class="fas fa-edit me-2"></i>
                            Área de Construcción
                        </h6>
                        <div>
                            <button class="btn btn-outline-danger btn-sm" id="clearForm">
                                <i class="fas fa-trash me-1"></i> Limpiar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="min-height: 600px;">
                    <!-- Drop Zone -->
                    <div id="formCanvas" class="form-canvas">
                        <div class="drop-zone-placeholder text-center text-muted p-5">
                            <i class="fas fa-plus-circle fa-3x mb-3"></i>
                            <h5>Arrastra campos aquí para comenzar</h5>
                            <p>Selecciona un módulo y arrastra elementos desde la paleta de la izquierda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Field Properties Panel -->
        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Propiedades del Campo
                    </h6>
                </div>
                <div class="card-body">
                    <div id="fieldProperties">
                        <div class="text-center text-muted p-4">
                            <i class="fas fa-mouse-pointer fa-2x mb-2"></i>
                            <p class="mb-0">Selecciona un campo para ver sus propiedades</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="card shadow mt-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-tools me-2"></i>
                        Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm" id="addFieldGroup">
                            <i class="fas fa-layer-group me-1"></i> Nuevo Grupo
                        </button>
                        <button class="btn btn-outline-success btn-sm" id="importFields">
                            <i class="fas fa-upload me-1"></i> Importar Campos
                        </button>
                        <button class="btn btn-outline-warning btn-sm" id="exportFields">
                            <i class="fas fa-download me-1"></i> Exportar Formulario
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Field Properties Modal -->
<div class="modal fade" id="fieldPropertiesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cogs me-2"></i>
                    Configuración del Campo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalFieldProperties">
                <!-- Dynamic content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveFieldProperties">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>
                    Vista Previa del Formulario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="formPreview">
                    <!-- Form preview will be rendered here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css">
<style>
.field-palette {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-bottom: 10px;
}

.field-item {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    padding: 8px;
    text-align: center;
    cursor: grab;
    transition: all 0.2s ease;
    user-select: none;
}

.field-item:hover {
    border-color: #007bff;
    background: #e3f2fd;
    transform: translateY(-2px);
}

.field-item:active {
    cursor: grabbing;
}

.field-item i {
    display: block;
    font-size: 18px;
    margin-bottom: 4px;
    color: #6c757d;
}

.field-item span {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: #495057;
}

.form-canvas {
    min-height: 500px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    position: relative;
    padding: 20px;
}

.form-canvas.drag-over {
    border-color: #007bff;
    background-color: #f8f9ff;
}

.drop-zone-placeholder {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
}

.form-field {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
    position: relative;
    cursor: pointer;
    transition: all 0.2s ease;
}

.form-field:hover {
    border-color: #007bff;
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
}

.form-field.selected {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.field-controls {
    position: absolute;
    top: -10px;
    right: -10px;
    display: none;
    gap: 5px;
}

.form-field:hover .field-controls,
.form-field.selected .field-controls {
    display: flex;
}

.field-control-btn {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.field-control-btn.edit {
    background: #007bff;
    color: white;
}

.field-control-btn.delete {
    background: #dc3545;
    color: white;
}

.field-control-btn.duplicate {
    background: #28a745;
    color: white;
}

.field-control-btn:hover {
    transform: scale(1.1);
}

.sortable-ghost {
    opacity: 0.5;
}

.sortable-chosen {
    transform: scale(1.02);
}

.form-canvas.has-fields {
    border-style: solid;
    border-color: #dee2e6;
    background: #fff;
}

.form-canvas.has-fields .drop-zone-placeholder {
    display: none;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.form-field {
    animation: slideIn 0.3s ease;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
class FormBuilder {
    constructor() {
        this.canvas = document.getElementById('formCanvas');
        this.fieldCounter = 0;
        this.selectedField = null;
        this.fields = [];
        
        this.init();
    }
    
    init() {
        this.setupDragAndDrop();
        this.setupEventListeners();
        this.setupSortable();
    }
    
    setupDragAndDrop() {
        const fieldItems = document.querySelectorAll('.field-item');
        
        fieldItems.forEach(item => {
            item.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', item.dataset.type);
                item.style.opacity = '0.5';
            });
            
            item.addEventListener('dragend', (e) => {
                item.style.opacity = '1';
            });
            
            item.setAttribute('draggable', true);
        });
        
        // Canvas drop events
        this.canvas.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.canvas.classList.add('drag-over');
        });
        
        this.canvas.addEventListener('dragleave', (e) => {
            if (!this.canvas.contains(e.relatedTarget)) {
                this.canvas.classList.remove('drag-over');
            }
        });
        
        this.canvas.addEventListener('drop', (e) => {
            e.preventDefault();
            this.canvas.classList.remove('drag-over');
            
            const fieldType = e.dataTransfer.getData('text/plain');
            if (fieldType) {
                this.addField(fieldType);
            }
        });
    }
    
    setupSortable() {
        new Sortable(this.canvas, {
            group: 'formFields',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: () => {
                this.updateFieldOrder();
            }
        });
    }
    
    setupEventListeners() {
        // Clear form
        document.getElementById('clearForm').addEventListener('click', () => {
            if (confirm('¿Estás seguro de que deseas limpiar el formulario?')) {
                this.clearForm();
            }
        });
        
        // Preview form
        document.getElementById('previewForm').addEventListener('click', () => {
            this.previewForm();
        });
        
        // Save form
        document.getElementById('saveForm').addEventListener('click', () => {
            this.saveForm();
        });
        
        // Target module change
        document.getElementById('targetModule').addEventListener('change', () => {
            this.updateModuleFields();
        });
    }
    
    addField(type) {
        const targetModule = document.getElementById('targetModule').value;
        if (!targetModule) {
            alert('Por favor selecciona un módulo primero');
            return;
        }
        
        this.fieldCounter++;
        const fieldId = `field_${this.fieldCounter}`;
        
        const fieldData = {
            id: fieldId,
            type: type,
            name: `${type}_${this.fieldCounter}`,
            label: this.getDefaultLabel(type),
            module: targetModule,
            required: false,
            placeholder: '',
            default_value: '',
            options: type === 'select' || type === 'radio' ? ['Opción 1', 'Opción 2'] : null,
            validation_rules: {}
        };
        
        this.fields.push(fieldData);
        this.renderField(fieldData);
        this.updateCanvasState();
    }
    
    renderField(fieldData) {
        const fieldElement = document.createElement('div');
        fieldElement.className = 'form-field';
        fieldElement.dataset.fieldId = fieldData.id;
        
        fieldElement.innerHTML = `
            <div class="field-controls">
                <button class="field-control-btn edit" onclick="formBuilder.editField('${fieldData.id}')" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="field-control-btn duplicate" onclick="formBuilder.duplicateField('${fieldData.id}')" title="Duplicar">
                    <i class="fas fa-copy"></i>
                </button>
                <button class="field-control-btn delete" onclick="formBuilder.deleteField('${fieldData.id}')" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="field-content">
                <label class="form-label">
                    ${fieldData.label}
                    ${fieldData.required ? '<span class="text-danger">*</span>' : ''}
                </label>
                ${this.renderFieldInput(fieldData)}
            </div>
        `;
        
        fieldElement.addEventListener('click', () => {
            this.selectField(fieldData.id);
        });
        
        this.canvas.appendChild(fieldElement);
    }
    
    renderFieldInput(fieldData) {
        const commonAttrs = `class="form-control" placeholder="${fieldData.placeholder}" ${fieldData.required ? 'required' : ''}`;
        
        switch (fieldData.type) {
            case 'textarea':
                return `<textarea ${commonAttrs} rows="3" disabled></textarea>`;
            case 'select':
                let selectHTML = `<select class="form-select" disabled><option>Seleccionar...</option>`;
                if (fieldData.options) {
                    fieldData.options.forEach(option => {
                        selectHTML += `<option>${option}</option>`;
                    });
                }
                selectHTML += '</select>';
                return selectHTML;
            case 'radio':
                let radioHTML = '';
                if (fieldData.options) {
                    fieldData.options.forEach((option, index) => {
                        radioHTML += `
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled>
                                <label class="form-check-label">${option}</label>
                            </div>`;
                    });
                }
                return radioHTML;
            case 'checkbox':
                return `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" disabled>
                        <label class="form-check-label">${fieldData.label}</label>
                    </div>`;
            case 'file':
            case 'image':
                return `<input type="file" class="form-control" disabled>`;
            default:
                return `<input type="${fieldData.type}" ${commonAttrs} disabled>`;
        }
    }
    
    getDefaultLabel(type) {
        const labels = {
            'text': 'Campo de Texto',
            'textarea': 'Área de Texto',
            'number': 'Número',
            'email': 'Correo Electrónico',
            'password': 'Contraseña',
            'date': 'Fecha',
            'datetime': 'Fecha y Hora',
            'time': 'Hora',
            'select': 'Lista Desplegable',
            'radio': 'Opción Múltiple',
            'checkbox': 'Casilla de Verificación',
            'file': 'Archivo',
            'image': 'Imagen',
            'url': 'URL',
            'tel': 'Teléfono'
        };
        return labels[type] || 'Campo';
    }
    
    selectField(fieldId) {
        // Remove previous selection
        document.querySelectorAll('.form-field.selected').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Select new field
        const fieldElement = document.querySelector(`[data-field-id="${fieldId}"]`);
        fieldElement.classList.add('selected');
        
        this.selectedField = fieldId;
        this.showFieldProperties(fieldId);
    }
    
    showFieldProperties(fieldId) {
        const fieldData = this.fields.find(f => f.id === fieldId);
        if (!fieldData) return;
        
        const propertiesPanel = document.getElementById('fieldProperties');
        
        propertiesPanel.innerHTML = `
            <form id="fieldPropertiesForm">
                <div class="mb-3">
                    <label class="form-label small">Nombre del Campo</label>
                    <input type="text" class="form-control form-control-sm" name="name" value="${fieldData.name}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label small">Etiqueta</label>
                    <input type="text" class="form-control form-control-sm" name="label" value="${fieldData.label}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label small">Placeholder</label>
                    <input type="text" class="form-control form-control-sm" name="placeholder" value="${fieldData.placeholder}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label small">Valor por Defecto</label>
                    <input type="text" class="form-control form-control-sm" name="default_value" value="${fieldData.default_value}">
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="required" ${fieldData.required ? 'checked' : ''}>
                        <label class="form-check-label small">Campo Obligatorio</label>
                    </div>
                </div>
                
                ${this.renderFieldSpecificProperties(fieldData)}
                
                <div class="d-grid">
                    <button type="button" class="btn btn-primary btn-sm" onclick="formBuilder.updateFieldProperties('${fieldId}')">
                        Actualizar Campo
                    </button>
                </div>
            </form>
        `;
    }
    
    renderFieldSpecificProperties(fieldData) {
        if (fieldData.type === 'select' || fieldData.type === 'radio') {
            let optionsHTML = '<div class="mb-3"><label class="form-label small">Opciones</label>';
            
            if (fieldData.options) {
                fieldData.options.forEach((option, index) => {
                    optionsHTML += `
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control" name="options[]" value="${option}">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                });
            }
            
            optionsHTML += `
                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="formBuilder.addOption(this)">
                    <i class="fas fa-plus me-1"></i>Agregar Opción
                </button>
            </div>`;
            
            return optionsHTML;
        }
        
        return '';
    }
    
    updateFieldProperties(fieldId) {
        const form = document.getElementById('fieldPropertiesForm');
        const formData = new FormData(form);
        
        const fieldData = this.fields.find(f => f.id === fieldId);
        if (!fieldData) return;
        
        // Update field data
        fieldData.name = formData.get('name');
        fieldData.label = formData.get('label');
        fieldData.placeholder = formData.get('placeholder');
        fieldData.default_value = formData.get('default_value');
        fieldData.required = formData.has('required');
        
                // Update options if applicable
                if (fieldData.type === 'select' || fieldData.type === 'radio') {
                    const options = formData.getAll('options[]').filter(option => option && option.trim());
                    fieldData.options = options.length > 0 ? options : null;
                }        // Re-render the field
        const fieldElement = document.querySelector(`[data-field-id="${fieldId}"]`);
        const fieldContent = fieldElement.querySelector('.field-content');
        fieldContent.innerHTML = `
            <label class="form-label">
                ${fieldData.label}
                ${fieldData.required ? '<span class="text-danger">*</span>' : ''}
            </label>
            ${this.renderFieldInput(fieldData)}
        `;
    }
    
    addOption(button) {
        const optionHTML = `
            <div class="input-group input-group-sm mb-1">
                <input type="text" class="form-control" name="options[]" placeholder="Nueva opción">
                <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        button.insertAdjacentHTML('beforebegin', optionHTML);
    }
    
    editField(fieldId) {
        this.selectField(fieldId);
    }
    
    duplicateField(fieldId) {
        const originalField = this.fields.find(f => f.id === fieldId);
        if (!originalField) return;
        
        this.fieldCounter++;
        const newFieldId = `field_${this.fieldCounter}`;
        
        const newField = {
            ...originalField,
            id: newFieldId,
            name: `${originalField.name}_copy`,
            label: `${originalField.label} (Copia)`
        };
        
        this.fields.push(newField);
        this.renderField(newField);
    }
    
    deleteField(fieldId) {
        if (confirm('¿Estás seguro de que deseas eliminar este campo?')) {
            // Remove from fields array
            this.fields = this.fields.filter(f => f.id !== fieldId);
            
            // Remove from DOM
            const fieldElement = document.querySelector(`[data-field-id="${fieldId}"]`);
            fieldElement.remove();
            
            // Clear properties panel if this field was selected
            if (this.selectedField === fieldId) {
                document.getElementById('fieldProperties').innerHTML = `
                    <div class="text-center text-muted p-4">
                        <i class="fas fa-mouse-pointer fa-2x mb-2"></i>
                        <p class="mb-0">Selecciona un campo para ver sus propiedades</p>
                    </div>
                `;
                this.selectedField = null;
            }
            
            this.updateCanvasState();
        }
    }
    
    updateFieldOrder() {
        const fieldElements = this.canvas.querySelectorAll('.form-field');
        const orderedFields = [];
        
        fieldElements.forEach(element => {
            const fieldId = element.dataset.fieldId;
            const fieldData = this.fields.find(f => f.id === fieldId);
            if (fieldData) {
                orderedFields.push(fieldData);
            }
        });
        
        this.fields = orderedFields;
    }
    
    updateCanvasState() {
        if (this.fields.length > 0) {
            this.canvas.classList.add('has-fields');
        } else {
            this.canvas.classList.remove('has-fields');
        }
    }
    
    clearForm() {
        this.fields = [];
        this.canvas.innerHTML = `
            <div class="drop-zone-placeholder text-center text-muted p-5">
                <i class="fas fa-plus-circle fa-3x mb-3"></i>
                <h5>Arrastra campos aquí para comenzar</h5>
                <p>Selecciona un módulo y arrastra elementos desde la paleta de la izquierda</p>
            </div>
        `;
        this.updateCanvasState();
        
        document.getElementById('fieldProperties').innerHTML = `
            <div class="text-center text-muted p-4">
                <i class="fas fa-mouse-pointer fa-2x mb-2"></i>
                <p class="mb-0">Selecciona un campo para ver sus propiedades</p>
            </div>
        `;
        
        this.selectedField = null;
    }
    
    previewForm() {
        const targetModule = document.getElementById('targetModule').value;
        if (!targetModule) {
            alert('Por favor selecciona un módulo primero');
            return;
        }
        
        if (this.fields.length === 0) {
            alert('No hay campos en el formulario para mostrar');
            return;
        }
        
        let previewHTML = `<form class="row g-3">`;
        
        this.fields.forEach(field => {
            const colClass = field.type === 'textarea' ? 'col-12' : 'col-md-6';
            
            previewHTML += `<div class="${colClass}">`;
            previewHTML += `<label class="form-label">${field.label}${field.required ? ' <span class="text-danger">*</span>' : ''}</label>`;
            
            switch (field.type) {
                case 'textarea':
                    previewHTML += `<textarea class="form-control" placeholder="${field.placeholder}" ${field.required ? 'required' : ''}></textarea>`;
                    break;
                case 'select':
                    previewHTML += `<select class="form-select" ${field.required ? 'required' : ''}><option value="">Seleccionar...</option>`;
                    if (field.options) {
                        field.options.forEach(option => {
                            previewHTML += `<option value="${option}">${option}</option>`;
                        });
                    }
                    previewHTML += '</select>';
                    break;
                case 'radio':
                    if (field.options) {
                        field.options.forEach(option => {
                            previewHTML += `
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="${field.name}" value="${option}" ${field.required ? 'required' : ''}>
                                    <label class="form-check-label">${option}</label>
                                </div>
                            `;
                        });
                    }
                    break;
                case 'checkbox':
                    previewHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" ${field.required ? 'required' : ''}>
                            <label class="form-check-label">${field.label}</label>
                        </div>
                    `;
                    break;
                default:
                    previewHTML += `<input type="${field.type}" class="form-control" placeholder="${field.placeholder}" ${field.required ? 'required' : ''}>`;
            }
            
            previewHTML += '</div>';
        });
        
        previewHTML += `
            <div class="col-12">
                <hr>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="reset" class="btn btn-secondary ms-2">Limpiar</button>
            </div>
        </form>`;
        
        document.getElementById('formPreview').innerHTML = previewHTML;
        new bootstrap.Modal(document.getElementById('previewModal')).show();
    }
    
    async saveForm() {
        const targetModule = document.getElementById('targetModule').value;
        const fieldGroup = document.getElementById('fieldGroup').value;
        
        if (!targetModule) {
            alert('Por favor selecciona un módulo');
            return;
        }
        
        if (this.fields.length === 0) {
            alert('No hay campos para guardar');
            return;
        }
        
        // Prepare fields data for saving
        const fieldsToSave = this.fields.map((field, index) => ({
            name: field.name,
            label: field.label,
            type: field.type,
            module: targetModule,
            placeholder: field.placeholder,
            default_value: field.default_value,
            options: field.options,
            validation_rules: {
                required: field.required
            },
            group_id: fieldGroup || null,
            sort_order: index + 1,
            is_active: true
        }));
        
        try {
            const response = await fetch('/dynamic-fields/bulk-create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    fields: fieldsToSave
                })
            });
            
            const result = await response.json();
            
            if (response.ok) {
                alert(`¡Formulario guardado exitosamente! Se crearon ${result.created} campos.`);
                this.clearForm();
            } else {
                alert('Error al guardar el formulario: ' + (result.message || 'Error desconocido'));
            }
        } catch (error) {
            alert('Error de conexión al guardar el formulario');
            console.error(error);
        }
    }
}

// Initialize form builder
let formBuilder;

document.addEventListener('DOMContentLoaded', function() {
    formBuilder = new FormBuilder();
});
</script>
@endsection