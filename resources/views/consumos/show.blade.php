@extends('layouts.app')

@section('title', 'Detalles del Consumo')

@section('content')
<div class="container-fluid">
    <!-- Header del módulo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-eye text-info me-2"></i>
                        Detalles del Consumo
                    </h1>
                    <p class="text-muted mt-1">Información completa del registro de consumo</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('consumos.edit', $consumo) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>
                        Editar
                    </a>
                    <a href="{{ route('consumos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información principal -->
        <div class="col-12 col-lg-8">
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-utensils me-2"></i>
                        Información del Consumo
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Fecha y Hora -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle p-3 me-3">
                                    <i class="fas fa-calendar text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Fecha del Consumo</h6>
                                    <h5 class="mb-0">{{ $consumo->fecha_consumo?->format('d/m/Y') ?? 'No especificada' }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning rounded-circle p-3 me-3">
                                    <i class="fas fa-clock text-white"></i>
                        </div>

                        <div class="col-12">
                            <small class="text-muted">Fecha de registro:</small>
                            <div class="fw-bold">
                                <i class="fas fa-calendar-plus me-1"></i>
                                {{ $consumo->created_at?->format('d/m/Y H:i') ?? 'No disponible' }}
                            </div>
                        </div>

                        @if($consumo->updated_at && $consumo->updated_at != $consumo->created_at)
                            <div class="col-12">
                                <small class="text-muted">Última actualización:</small>
                                <div class="fw-bold">
                                    <i class="fas fa-edit me-1"></i>
                                    {{ $consumo->updated_at?->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones adicionales -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Acciones disponibles</h6>
                            <small class="text-muted">Operaciones que puedes realizar con este consumo</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('consumos.edit', $consumo) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>
                                Editar consumo
                            </a>
                            <form method="POST"
                                  action="{{ route('consumos.destroy', $consumo) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este consumo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash me-1"></i>
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('consumos.create') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i>
                                Nuevo consumo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-2px);
}
</style>
@endpush
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function eliminarConsumo() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará permanentemente este registro de consumo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            // Crear y enviar formulario
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("consumos.destroy", $consumo) }}';
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
