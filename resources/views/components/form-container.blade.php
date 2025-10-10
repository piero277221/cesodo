{{-- Componente de Formulario Mejorado --}}
@props([
    'action' => '#',
    'method' => 'POST',
    'title' => '',
    'subtitle' => '',
    'submitText' => 'Guardar',
    'submitClass' => 'btn-primary',
    'cancelRoute' => null,
    'multipart' => false
])

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card animate-fade-in">
                @if($title)
                <div class="card-header">
                    <h1 class="card-title">
                        <i class="bi bi-plus-circle-fill text-primary me-2"></i>
                        {{ $title }}
                    </h1>
                    @if($subtitle)
                        <p class="text-muted mb-0 mt-2">{{ $subtitle }}</p>
                    @endif
                </div>
                @endif

                <div class="card-body">
                    <form
                        action="{{ $action }}"
                        method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
                        @if($multipart) enctype="multipart/form-data" @endif
                        class="needs-validation"
                        novalidate
                    >
                        @if($method !== 'GET' && $method !== 'POST')
                            @method($method)
                        @endif

                        @if($method !== 'GET')
                            @csrf
                        @endif

                        <!-- Contenido del formulario -->
                        {{ $slot }}

                        <!-- Botones de acción -->
                        <div class="form-group mt-4 pt-3 border-top">
                            <div class="d-flex gap-3 justify-content-end">
                                @if($cancelRoute)
                                    <a href="{{ $cancelRoute }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>
                                        Cancelar
                                    </a>
                                @endif

                                <button type="submit" class="btn {{ $submitClass }}">
                                    <i class="bi bi-check-lg me-1"></i>
                                    {{ $submitText }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de formularios
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                // Mostrar primer error
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }

            form.classList.add('was-validated');
        });

        // Remover validación en tiempo real
        const inputs = form.querySelectorAll('.form-input, .form-select, .form-textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                if (input.checkValidity()) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            });
        });
    });
});
</script>
