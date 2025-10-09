/**
 * JavaScript para el módulo de trabajadores
 * SCM CESODO
 */

// Validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {

    // Validación de DNI
    const dniInput = document.getElementById('dni');
    if (dniInput) {
        dniInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) {
                value = value.substring(0, 8);
            }
            e.target.value = value;

            // Validar longitud
            if (value.length === 8) {
                e.target.classList.remove('is-invalid');
                e.target.classList.add('is-valid');
            } else if (value.length > 0) {
                e.target.classList.remove('is-valid');
                e.target.classList.add('is-invalid');
            } else {
                e.target.classList.remove('is-valid', 'is-invalid');
            }
        });
    }

    // Formatear código a mayúsculas
    const codigoInput = document.getElementById('codigo');
    if (codigoInput) {
        codigoInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    }

    // Capitalizar nombres y apellidos
    const nameFields = ['nombres', 'apellidos', 'cargo'];
    nameFields.forEach(function(fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('blur', function(e) {
                e.target.value = capitalizeWords(e.target.value);
            });
        }
    });

    // Auto-submit en filtros
    const filterSelects = document.querySelectorAll('select[name="area"], select[name="estado"], select[name="sort_by"], select[name="sort_dir"]');
    filterSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            const form = document.getElementById('searchForm');
            if (form) {
                form.submit();
            }
        });
    });

    // Búsqueda con debounce
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const form = document.getElementById('searchForm');
                if (form) {
                    form.submit();
                }
            }, 500);
        });
    }
});

// Funciones auxiliares
function capitalizeWords(str) {
    return str.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
}

function formatDNI(dni) {
    return dni.replace(/\D/g, '').substring(0, 8);
}

// Confirmación de eliminación con SweetAlert
function confirmarEliminacion(id, nombre) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar al trabajador "${nombre}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    } else {
        // Fallback si SweetAlert no está disponible
        if (confirm(`¿Estás seguro de que deseas eliminar al trabajador "${nombre}"?`)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
}

// Validación del formulario antes de enviar
function validarFormulario(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    const dni = form.querySelector('#dni');
    const codigo = form.querySelector('#codigo');
    const nombres = form.querySelector('#nombres');
    const apellidos = form.querySelector('#apellidos');

    // Validar DNI
    if (dni && (dni.value.length !== 8 || !/^\d+$/.test(dni.value))) {
        alert('El DNI debe tener exactamente 8 dígitos numéricos.');
        dni.focus();
        return false;
    }

    // Validar código
    if (codigo && codigo.value.trim().length === 0) {
        alert('El código es obligatorio.');
        codigo.focus();
        return false;
    }

    // Validar nombres
    if (nombres && nombres.value.trim().length === 0) {
        alert('Los nombres son obligatorios.');
        nombres.focus();
        return false;
    }

    // Validar apellidos
    if (apellidos && apellidos.value.trim().length === 0) {
        alert('Los apellidos son obligatorios.');
        apellidos.focus();
        return false;
    }

    return true;
}

// Mostrar notificaciones
function mostrarNotificacion(tipo, mensaje) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: tipo,
            title: tipo === 'success' ? '¡Éxito!' : 'Información',
            text: mensaje,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    } else {
        alert(mensaje);
    }
}
