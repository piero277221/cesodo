@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Debug - Módulos</h1>

    <div class="alert alert-info">
        <h3>Información del Usuario Actual:</h3>
        @auth
            <p><strong>Usuario:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>ID:</strong> {{ auth()->user()->id }}</p>

            <h4>Roles:</h4>
            @if(method_exists(auth()->user(), 'getRoleNames'))
                @foreach(auth()->user()->getRoleNames() as $role)
                    <span class="badge badge-primary">{{ $role }}</span>
                @endforeach
            @else
                <p>No se pueden obtener roles</p>
            @endif

            <h4>Permisos Específicos:</h4>
            @php
                $permissions = ['ver-productos', 'ver-trabajadores', 'ver-inventario', 'ver-proveedores'];
            @endphp

            @foreach($permissions as $permission)
                <p>
                    <strong>{{ $permission }}:</strong>
                    @can($permission)
                        <span class="text-success">✓ SÍ</span>
                    @else
                        <span class="text-danger">✗ NO</span>
                    @endcan
                </p>
            @endforeach
        @else
            <p class="text-danger">Usuario NO autenticado</p>
        @endauth
    </div>

    <div class="alert alert-warning">
        <h3>Test de Módulo Categorías:</h3>
        @can('ver-productos')
            <div class="alert alert-success">
                <h4>✓ DEBERÍA VER EL MÓDULO DE CATEGORÍAS</h4>
                <p>El usuario tiene permiso 'ver-productos'</p>
                <a href="{{ route('categorias.index') }}" class="btn btn-primary">Ir a Categorías</a>
            </div>
        @else
            <div class="alert alert-danger">
                <h4>✗ NO DEBERÍA VER EL MÓDULO DE CATEGORÍAS</h4>
                <p>El usuario NO tiene permiso 'ver-productos'</p>
            </div>
        @endcan
    </div>

    <div class="mt-4">
        <a href="{{ route('modules.index') }}" class="btn btn-secondary">Volver a Módulos</a>
    </div>
</div>
@endsection
