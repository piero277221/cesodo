@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-bell text-danger me-2"></i>
            Centro de Notificaciones
        </h2>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Volver al Dashboard
        </a>
    </div>

    @if(count($notificaciones) > 0)
        <!-- Resumen -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-circle text-danger fa-2x mb-2"></i>
                        <h3 class="mb-0">{{ collect($notificaciones)->where('prioridad', 'alta')->count() }}</h3>
                        <p class="text-muted mb-0">Prioridad Alta</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                        <h3 class="mb-0">{{ collect($notificaciones)->where('prioridad', 'media')->count() }}</h3>
                        <p class="text-muted mb-0">Prioridad Media</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                        <h3 class="mb-0">{{ count($notificaciones) }}</h3>
                        <p class="text-muted mb-0">Total Notificaciones</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Notificaciones -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Todas las Notificaciones
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($notificaciones as $notificacion)
                        <a href="{{ $notificacion['enlace'] }}"
                           class="list-group-item list-group-item-action border-start border-{{ $notificacion['color'] }} border-3">
                            <div class="d-flex w-100 align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-{{ $notificacion['color'] }}-subtle"
                                          style="width: 50px; height: 50px;">
                                        <i class="fas {{ $notificacion['icono'] }} text-{{ $notificacion['color'] }} fa-lg"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <h6 class="mb-1 fw-bold">{{ $notificacion['titulo'] }}</h6>
                                        @if($notificacion['prioridad'] === 'alta')
                                            <span class="badge bg-danger ms-2">Urgente</span>
                                        @elseif($notificacion['prioridad'] === 'media')
                                            <span class="badge bg-warning text-dark ms-2">Media</span>
                                        @endif
                                    </div>
                                    <p class="mb-1 text-muted">{{ $notificacion['mensaje'] }}</p>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        @php
                                            $fecha = \Carbon\Carbon::parse($notificacion['fecha']);
                                            $diff = now()->diffInDays($fecha, false);
                                        @endphp
                                        @if($diff < 0)
                                            <span class="text-danger fw-bold">Vencido</span>
                                        @elseif($diff == 0)
                                            <span class="text-warning fw-bold">Hoy</span>
                                        @elseif($diff == 1)
                                            Mañana
                                        @else
                                            {{ $fecha->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </div>
                                <div class="flex-shrink-0 ms-3">
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    @else
        <!-- Sin notificaciones -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                <h3 class="mt-4 mb-3">¡Todo está al día!</h3>
                <p class="text-muted">No hay notificaciones pendientes en este momento.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-home me-2"></i>Ir al Dashboard
                </a>
            </div>
        </div>
    @endif
</div>

<style>
.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1);
}

.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1);
}

.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1);
}

.list-group-item:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.border-3 {
    border-width: 3px !important;
}
</style>
@endsection
