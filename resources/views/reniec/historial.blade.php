@extends('adminlte::page')

@section('title', 'Historial de Consultas RENIEC')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0" style="color: #1a1a1a; font-weight: 700;">
            <i class="fas fa-id-card text-danger"></i> Historial de Consultas RENIEC
        </h1>
        <button class="btn btn-sm" style="background-color: #dc2626; color: white;" onclick="actualizarEstadisticas()">
            <i class="fas fa-sync-alt"></i> Actualizar
        </button>
    </div>
@stop

@section('content')
    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4" id="estadisticas-container">
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: white;">
                <div class="inner">
                    <h3 id="stat-hoy">-</h3>
                    <p>Consultas Hoy</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white;">
                <div class="inner">
                    <h3 id="stat-disponibles">-</h3>
                    <p>Consultas Disponibles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #4b5563 0%, #374151 100%); color: white;">
                <div class="inner">
                    <h3 id="stat-mes">-</h3>
                    <p>Consultas Este Mes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white;">
                <div class="inner">
                    <h3 id="stat-exitosas">-</h3>
                    <p>Consultas Exitosas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-thumbs-up"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Historial -->
    <div class="card">
        <div class="card-header" style="background-color: #1a1a1a; color: white;">
            <h3 class="card-title"><i class="fas fa-history"></i> Historial Completo de Consultas</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead style="background-color: #1a1a1a; color: white;">
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Nombre Completo</th>
                        <th>Estado</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>IP</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas as $consulta)
                        <tr>
                            <td><span class="badge badge-secondary">{{ $consulta->id }}</span></td>
                            <td><strong>{{ $consulta->dni }}</strong></td>
                            <td>{{ $consulta->nombre_completo ?? 'N/A' }}</td>
                            <td>
                                @if($consulta->estado === 'exitosa')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Exitosa
                                    </span>
                                @elseif($consulta->estado === 'fallida')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Fallida
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i> Error
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $consulta->tipo_consulta === 'gratuita' ? '#dc2626' : '#1a1a1a' }}; color: white;">
                                    {{ ucfirst($consulta->tipo_consulta) }}
                                </span>
                            </td>
                            <td>{{ $consulta->user->name ?? 'Sistema' }}</td>
                            <td><small class="text-muted">{{ $consulta->ip_consulta }}</small></td>
                            <td><small>{{ $consulta->created_at->format('d/m/Y H:i') }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>No hay consultas registradas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $consultas->links() }}
        </div>
    </div>
@stop

@section('css')
    <style>
        .small-box {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .small-box .icon {
            font-size: 70px;
            opacity: 0.3;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@stop

@section('js')
<script>
    // Cargar estadísticas al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        actualizarEstadisticas();
    });

    function actualizarEstadisticas() {
        fetch('{{ route('reniec.estadisticas') }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('stat-hoy').textContent = data.data.hoy;
                    document.getElementById('stat-disponibles').textContent = data.data.gratuitas_disponibles;
                    document.getElementById('stat-mes').textContent = data.data.mes;
                    document.getElementById('stat-exitosas').textContent = data.data.exitosas;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Actualizar cada 30 segundos
    setInterval(actualizarEstadisticas, 30000);
</script>
@stop
