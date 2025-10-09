@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Consumir Menú: {{ $menu->nombre }}</h1>

        <div class="mb-6">
            <div class="flex items-center space-x-2">
                <span class="text-lg">Estado:</span>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $menu->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($menu->estado) }}
                </span>

            </div>

            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <p class="text-lg">
                    Platos disponibles:
                    <span class="font-bold text-2xl {{ $menu->platos_disponibles == 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $menu->platos_disponibles }}
                    </span>
                    <span class="text-gray-500">/ {{ $menu->platos_totales }} totales</span>
                </p>
            </div>
        </div>

        <form action="{{ route('menus.registrar-consumo', $menu->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad a consumir</label>
                <input type="number" name="cantidad" id="cantidad" min="1" max="{{ $menu->platos_disponibles }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       required>
            </div>

            <div>
                <label for="notas" class="block text-sm font-medium text-gray-700">Notas (opcional)</label>
                <textarea name="notas" id="notas" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('menus.index') }}"
                   class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Registrar Consumo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
