@extends('layouts.app')

@section('styles')
<style>
.disponibilidad-card {
    background: linear-gradient(to right, #f0fdf4, #dcfce7);
    border-left: 4px solid #16a34a;
}
.disponibilidad-card.agotado {
    background: linear-gradient(to right, #fef2f2, #fee2e2);
    border-left: 4px solid #dc2626;
}
.platos-counter {
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    padding: 1rem;
    border-radius: 0.5rem;
}
.tipo-comida-btn.selected {
    background-color: #e0e7ff;
    border-color: #6366f1;
    color: #4f46e5;
}
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Encabezado -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('menus.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold">Registrar Nuevo Consumo</h1>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Contador destacado de platos disponibles -->
            <div class="mb-6">
                <div class="flex items-center justify-center">
                    <div class="bg-green-100 border border-green-400 rounded-lg px-6 py-4 shadow text-center">
                        <span class="block text-lg font-semibold text-green-800">Platos disponibles</span>
                        <span class="block text-4xl font-bold text-green-700 platos-counter" id="contadorPlatos">
                            {{ $menu->platos_disponibles }}
                        </span>
                        <span class="block text-sm text-gray-600">de {{ $menu->platos_totales }} totales</span>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $menu->nombre }}</h2>
                <p class="text-sm text-gray-600 mb-4">{{ $menu->descripcion }}</p>

                @if($menu->estaDisponible())
                <!-- Formulario de registro de consumo -->
                <form action="{{ route('consumos.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                    <!-- Selección de trabajador -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Trabajador *
                        </label>
                        <div class="relative">
                            <select name="trabajador_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un trabajador</option>
                                @foreach($trabajadores ?? [] as $trabajador)
                                    <option value="{{ $trabajador->id }}">
                                        {{ $trabajador->nombre_completo ?? $trabajador->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tipo de comida -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Comida *
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="tipo_comida" value="desayuno" class="sr-only" required>
                                <div class="p-3 border rounded-lg text-center hover:bg-gray-50 tipo-comida-option">
                                    <i class="fas fa-coffee text-xl mb-1"></i>
                                    <span class="block text-sm">Desayuno</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="tipo_comida" value="almuerzo" class="sr-only" required>
                                <div class="p-3 border rounded-lg text-center hover:bg-gray-50 tipo-comida-option">
                                    <i class="fas fa-utensils text-xl mb-1"></i>
                                    <span class="block text-sm">Almuerzo</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="tipo_comida" value="cena" class="sr-only" required>
                                <div class="p-3 border rounded-lg text-center hover:bg-gray-50 tipo-comida-option">
                                    <i class="fas fa-moon text-xl mb-1"></i>
                                    <span class="block text-sm">Cena</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Campos de fecha y hora -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Consumo *
                            </label>
                            <input type="date" name="fecha_consumo" required
                                   value="{{ now()->format('Y-m-d') }}"
                                   max="{{ now()->format('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Hora de Consumo *
                            </label>
                            <input type="time" name="hora_consumo" required
                                   value="{{ now()->format('H:i') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Observaciones
                        </label>
                        <textarea name="observaciones" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                  placeholder="Ingrese cualquier observación adicional..."></textarea>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">

                        <button type="button" onclick="window.history.back()"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Registrar Consumo
                        </button>
                    </div>
                </form>

                @else
                <!-- Mensaje de menú no disponible -->
                <div class="text-center py-6">
                    <div class="mb-4">
                        <svg class="mx-auto h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-red-800">No se pueden registrar más consumos</h3>
                    <p class="mt-2 text-sm text-red-600">
                        Este menú se encuentra agotado o no está disponible para consumos.
                    </p>
                    <a href="{{ route('menus.index') }}"
                       class="mt-4 inline-block px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Volver al listado de menús
                    </a>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
