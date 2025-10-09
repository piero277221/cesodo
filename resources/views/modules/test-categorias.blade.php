@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Prueba del Módulo de Categorías</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Módulo de Categorías (Sin permisos)</h5>
                </div>
                <div class="card-body">
                    <div class="module-card group">
                        <a href="{{ route('categorias.index') }}" class="block h-full">
                            <div class="module-icon" style="background: #f59e0b;">
                                <i class="bi bi-tags"></i>
                            </div>
                            <div class="module-content">
                                <h3 class="module-title">Categorías</h3>
                                <p class="module-description">Gestión de categorías de productos</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Módulo de Categorías (Con permisos)</h5>
                </div>
                <div class="card-body">
                    @can('ver-productos')
                    <div class="module-card group">
                        <a href="{{ route('categorias.index') }}" class="block h-full">
                            <div class="module-icon" style="background: #f59e0b;">
                                <i class="bi bi-tags"></i>
                            </div>
                            <div class="module-content">
                                <h3 class="module-title">Categorías</h3>
                                <p class="module-description">Gestión de categorías de productos</p>
                            </div>
                        </a>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        No tienes permisos para ver este módulo
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Información de Permisos</h5>
                </div>
                <div class="card-body">
                    <p><strong>Usuario:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Permiso 'ver-productos':</strong> {{ Auth::user()->can('ver-productos') ? 'SÍ' : 'NO' }}</p>

                    @if(method_exists(Auth::user(), 'getRoleNames'))
                        <p><strong>Roles:</strong> {{ implode(', ', Auth::user()->getRoleNames()->toArray()) }}</p>
                    @endif

                    @if(method_exists(Auth::user(), 'getAllPermissions'))
                        <p><strong>Permisos:</strong></p>
                        <ul>
                            @foreach(Auth::user()->getAllPermissions() as $permiso)
                                <li>{{ $permiso->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.module-card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    overflow: hidden;
    border: 1px solid #f3f4f6;
}

.module-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.module-icon {
    height: 5rem;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

.module-content {
    padding: 1rem;
    text-align: center;
}

.module-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.module-description {
    color: #6b7280;
    font-size: 0.875rem;
}
</style>
@endsection
