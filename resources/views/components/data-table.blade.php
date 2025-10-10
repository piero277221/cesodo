{{-- Componente de Tabla Mejorada --}}
@props([
    'title' => '',
    'subtitle' => '',
    'createRoute' => null,
    'createText' => 'Nuevo',
    'searchable' => true,
    'exportable' => false,
    'columns' => [],
    'actions' => true
])

<div class="container-fluid py-4">
    <!-- Header de la tabla -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            @if($title)
                <h1 class="h2 mb-1 text-cesodo-black">
                    <i class="bi bi-table me-2 text-cesodo-red"></i>
                    {{ $title }}
                </h1>
            @endif
            @if($subtitle)
                <p class="text-muted mb-0">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="d-flex gap-2">
            @if($exportable)
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-download me-1"></i>
                        Exportar
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="exportTable('excel')">
                            <i class="bi bi-file-earmark-excel me-1"></i> Excel
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="exportTable('pdf')">
                            <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="exportTable('csv')">
                            <i class="bi bi-file-earmark-text me-1"></i> CSV
                        </a></li>
                    </ul>
                </div>
            @endif

            @if($createRoute)
                <a href="{{ $createRoute }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    {{ $createText }}
                </a>
            @endif
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    @if($searchable)
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="text"
                            class="form-input"
                            placeholder="Buscar en la tabla..."
                            id="tableSearch"
                        >
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="entriesPerPage">
                        <option value="10">10 por página</option>
                        <option value="25" selected>25 por página</option>
                        <option value="50">50 por página</option>
                        <option value="100">100 por página</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-secondary w-100" onclick="clearFilters()">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Limpiar filtros
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Tabla -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        @foreach($columns as $column)
                            <th
                                class="{{ $column['sortable'] ?? true ? 'sortable' : '' }}"
                                data-column="{{ $column['key'] ?? '' }}"
                                @if(isset($column['width']) && $column['width']) style="width: {{ $column['width'] }}" @endif
                            >
                                {{ $column['label'] ?? $column }}
                                @if($column['sortable'] ?? true)
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                @endif
                            </th>
                        @endforeach

                        @if($actions)
                            <th style="width: 120px;" class="text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>

        <!-- Información de paginación -->
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Mostrando <span id="showingFrom">1</span> a <span id="showingTo">25</span>
                de <span id="totalRecords">0</span> registros
            </div>

            <!-- Paginación -->
            <nav aria-label="Paginación de tabla">
                <ul class="pagination pagination-sm mb-0" id="tablePagination">
                    <!-- Se genera dinámicamente con JavaScript -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para tablas */
.sortable {
    cursor: pointer;
    user-select: none;
    transition: all var(--cesodo-transition-fast);
}

.sortable:hover {
    background-color: var(--cesodo-red-dark) !important;
}

.sort-icon {
    opacity: 0.5;
    transition: all var(--cesodo-transition-fast);
}

.sortable:hover .sort-icon {
    opacity: 1;
}

.sortable.asc .sort-icon::before {
    content: "\F145";
}

.sortable.desc .sort-icon::before {
    content: "\F149";
}

.table-actions {
    display: flex;
    gap: var(--cesodo-spacing-xs);
    justify-content: center;
}

.table-actions .btn {
    padding: var(--cesodo-spacing-xs) var(--cesodo-spacing-sm);
    font-size: var(--cesodo-font-size-xs);
}

.pagination .page-link {
    color: var(--cesodo-gray-600);
    border-color: var(--cesodo-gray-300);
}

.pagination .page-item.active .page-link {
    background-color: var(--cesodo-red);
    border-color: var(--cesodo-red);
    color: var(--cesodo-white);
}

.pagination .page-link:hover {
    color: var(--cesodo-red);
    border-color: var(--cesodo-red);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('dataTable');
    if (!table) return;

    const tbody = table.querySelector('tbody');
    const searchInput = document.getElementById('tableSearch');
    const entriesSelect = document.getElementById('entriesPerPage');
    let currentPage = 1;
    let sortColumn = '';
    let sortDirection = '';

    // Búsqueda en tiempo real
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterTable();
        });
    }

    // Cambio de entradas por página
    if (entriesSelect) {
        entriesSelect.addEventListener('change', function() {
            currentPage = 1;
            filterTable();
        });
    }

    // Ordenamiento de columnas
    table.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const column = this.dataset.column;

            if (sortColumn === column) {
                sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                sortColumn = column;
                sortDirection = 'asc';
            }

            // Actualizar clases visuales
            table.querySelectorAll('.sortable').forEach(h => {
                h.classList.remove('asc', 'desc');
            });
            this.classList.add(sortDirection);

            sortTable();
        });
    });

    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const entriesPerPage = entriesSelect ? parseInt(entriesSelect.value) : 25;
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // Filtrar filas
        const filteredRows = rows.filter(row => {
            const text = row.textContent.toLowerCase();
            return text.includes(searchTerm);
        });

        // Ocultar todas las filas
        rows.forEach(row => row.style.display = 'none');

        // Mostrar filas de la página actual
        const startIndex = (currentPage - 1) * entriesPerPage;
        const endIndex = startIndex + entriesPerPage;

        filteredRows.slice(startIndex, endIndex).forEach(row => {
            row.style.display = '';
        });

        // Actualizar información de paginación
        updatePaginationInfo(filteredRows.length, entriesPerPage);
        generatePagination(filteredRows.length, entriesPerPage);
    }

    function sortTable() {
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const columnIndex = Array.from(table.querySelectorAll('th')).findIndex(th =>
            th.dataset.column === sortColumn
        );

        if (columnIndex === -1) return;

        rows.sort((a, b) => {
            const aVal = a.children[columnIndex].textContent.trim();
            const bVal = b.children[columnIndex].textContent.trim();

            const aNum = parseFloat(aVal);
            const bNum = parseFloat(bVal);

            let comparison;
            if (!isNaN(aNum) && !isNaN(bNum)) {
                comparison = aNum - bNum;
            } else {
                comparison = aVal.localeCompare(bVal);
            }

            return sortDirection === 'asc' ? comparison : -comparison;
        });

        // Reordenar las filas en el DOM
        rows.forEach(row => tbody.appendChild(row));

        // Aplicar filtros después del ordenamiento
        filterTable();
    }

    function updatePaginationInfo(totalRecords, entriesPerPage) {
        const showingFrom = document.getElementById('showingFrom');
        const showingTo = document.getElementById('showingTo');
        const totalRecordsSpan = document.getElementById('totalRecords');

        if (showingFrom && showingTo && totalRecordsSpan) {
            const startIndex = (currentPage - 1) * entriesPerPage + 1;
            const endIndex = Math.min(currentPage * entriesPerPage, totalRecords);

            showingFrom.textContent = totalRecords > 0 ? startIndex : 0;
            showingTo.textContent = endIndex;
            totalRecordsSpan.textContent = totalRecords;
        }
    }

    function generatePagination(totalRecords, entriesPerPage) {
        const pagination = document.getElementById('tablePagination');
        if (!pagination) return;

        const totalPages = Math.ceil(totalRecords / entriesPerPage);
        pagination.innerHTML = '';

        if (totalPages <= 1) return;

        // Botón anterior
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">‹</a>`;
        pagination.appendChild(prevLi);

        // Números de página
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
                pagination.appendChild(li);
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                const li = document.createElement('li');
                li.className = 'page-item disabled';
                li.innerHTML = '<span class="page-link">...</span>';
                pagination.appendChild(li);
            }
        }

        // Botón siguiente
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">›</a>`;
        pagination.appendChild(nextLi);

        // Event listeners para paginación
        pagination.querySelectorAll('a[data-page]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.dataset.page);
                if (page >= 1 && page <= totalPages && page !== currentPage) {
                    currentPage = page;
                    filterTable();
                }
            });
        });
    }

    // Inicializar tabla
    filterTable();
});

// Función para limpiar filtros
function clearFilters() {
    const searchInput = document.getElementById('tableSearch');
    const entriesSelect = document.getElementById('entriesPerPage');

    if (searchInput) searchInput.value = '';
    if (entriesSelect) entriesSelect.value = '25';

    currentPage = 1;

    // Remover ordenamiento
    document.querySelectorAll('.sortable').forEach(h => {
        h.classList.remove('asc', 'desc');
    });

    // Recargar tabla
    location.reload();
}

// Funciones de exportación
function exportTable(format) {
    const table = document.getElementById('dataTable');
    const title = document.querySelector('h1')?.textContent || 'Datos';

    if (format === 'excel') {
        exportToExcel(table, title);
    } else if (format === 'pdf') {
        exportToPDF(table, title);
    } else if (format === 'csv') {
        exportToCSV(table, title);
    }
}

function exportToExcel(table, filename) {
    // Implementar exportación a Excel
    console.log('Exportando a Excel...', filename);
}

function exportToPDF(table, filename) {
    // Implementar exportación a PDF
    console.log('Exportando a PDF...', filename);
}

function exportToCSV(table, filename) {
    // Implementar exportación a CSV
    console.log('Exportando a CSV...', filename);
}
</script>
