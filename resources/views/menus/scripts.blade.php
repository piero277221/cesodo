@section('scripts')
<script>
    function actualizarTablaMenu() {
        const diasSeleccionados = Array.from(document.querySelectorAll('input[name="dias_seleccionados[]"]:checked')).map(cb => cb.value);
        const tiposComidaSeleccionados = Array.from(document.querySelectorAll('input[name="tipos_comida[]"]:checked')).map(cb => cb.value);
        const tablaMenu = document.getElementById('tabla-menu');
        const tbody = tablaMenu.querySelector('tbody');
        tbody.innerHTML = '';

        diasSeleccionados.forEach(dia => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="fw-bold">${dia.charAt(0).toUpperCase() + dia.slice(1)}</td>
                ${tiposComidaSeleccionados.map(tipo => `
                    <td>
                        <select name="recetas[${dia}][${tipo}]" class="form-select">
                            <option value="">Seleccione una receta</option>
                            @foreach($recetas as $receta)
                                <option value="{{ $receta->id }}">{{ $receta->nombre }}</option>
                            @endforeach
                        </select>
                    </td>
                `).join('')}
                <td>
                    <button type="button" class="btn btn-info btn-sm verificar-ingredientes" data-dia="${dia}">
                        Verificar Ingredientes
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Actualizar encabezados
        const thead = tablaMenu.querySelector('thead tr');
        thead.innerHTML = `
            <th>DÍA</th>
            ${tiposComidaSeleccionados.map(tipo =>
                `<th>${tipo.charAt(0).toUpperCase() + tipo.slice(1)}</th>`
            ).join('')}
            <th>ACCIONES</th>
        `;
    }

    // Agregar event listeners
    document.querySelectorAll('input[name="dias_seleccionados[]"], input[name="tipos_comida[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', actualizarTablaMenu);
    });

    // Función para verificar ingredientes
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('verificar-ingredientes')) {
            const dia = e.target.dataset.dia;
            const recetas = {};
            document.querySelectorAll(`select[name^="recetas[${dia}]"]`).forEach(select => {
                const tipo = select.name.match(/\[(.*?)\]$/)[1];
                recetas[tipo] = select.value;
            });

            fetch('/menus/verificar-ingredientes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ recetas })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Todos los ingredientes están disponibles');
                } else {
                    alert('Faltan ingredientes: ' + data.faltantes.join(', '));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al verificar ingredientes');
            });
        }
    });

    // Inicializar tabla al cargar
    document.addEventListener('DOMContentLoaded', actualizarTablaMenu);
</script>
@endsection
