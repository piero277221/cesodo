@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Reporte de Ventas</h1>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <!-- Filtros -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Filtros</h2>
            <form action="{{ route('reportes.ventas') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha_inicio">
                        Fecha Inicio
                    </label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio"
                           value="{{ request('fecha_inicio') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha_fin">
                        Fecha Fin
                    </label>
                    <input type="date" name="fecha_fin" id="fecha_fin"
                           value="{{ request('fecha_fin') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Resumen de Ventas -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Resumen de Ventas</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-100 p-4 rounded">
                    <p class="text-gray-600 text-sm">Total Ventas</p>
                    <p class="text-2xl font-bold">S/. {{ number_format($totalVentas ?? 0, 2) }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded">
                    <p class="text-gray-600 text-sm">Cantidad de Ventas</p>
                    <p class="text-2xl font-bold">{{ $cantidadVentas ?? 0 }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded">
                    <p class="text-gray-600 text-sm">Promedio por Venta</p>
                    <p class="text-2xl font-bold">S/. {{ number_format($promedioVentas ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Tabla de Ventas -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Detalle de Ventas</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventas as $venta)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                {{ $venta->fecha_venta }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                {{ $venta->cliente_nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                S/. {{ number_format($venta->total, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $venta->estado === 'completada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($venta->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                <a href="{{ route('ventas.show', $venta->id) }}"
                                   class="text-blue-600 hover:text-blue-900">Ver detalles</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 text-center">
                                No se encontraron ventas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($ventas) && method_exists($ventas, 'links'))
                <div class="mt-4">
                    {{ $ventas->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
