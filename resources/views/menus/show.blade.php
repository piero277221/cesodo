<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Ver Menú Semanal</h2>
    </x-slot>

    <div class="p-4 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-xl font-bold">{{ $menu->descripcion ?: 'Menú Semanal' }}</h3>
                    <p class="text-gray-600">Del {{ $menu->semana_inicio->format('d/m/Y') }} al {{ $menu->semana_fin->format('d/m/Y') }}</p>
                    <span class="badge {{ $menu->estado === 'publicado' ? 'bg-success' : 'bg-warning' }} mt-2">
                        {{ ucfirst($menu->estado) }}
                    </span>
                </div>
                <div class="flex gap-2">
                    @if($menu->estado !== 'publicado')
                        <a href="{{ route('menus.edit', $menu) }}" class="btn btn-outline-primary">Editar</a>
                        <form action="{{ route('menus.publicar', $menu) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-success" onclick="return confirm('¿Publicar menú? Esto descontará el stock.')">Publicar</button>
                        </form>
                    @endif
                    <a href="{{ route('menus.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>

            @if($menu->menuPlatos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($menu->menuPlatos->groupBy('dia_semana') as $dia => $platos)
                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold text-lg mb-3 text-center bg-gray-100 py-2 rounded">
                                {{ ucfirst($dia) }}
                            </h4>
                            @foreach($platos as $plato)
                                <div class="mb-4 last:mb-0">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="font-medium">{{ ucfirst($plato->tipo_comida) }}</h5>
                                    </div>
                                    @if($plato->receta)
                                        <p class="font-medium text-blue-600">{{ $plato->receta->nombre }}</p>
                                    @endif
                                    @if($plato->observaciones)
                                        <p class="text-sm text-gray-600 mb-2">{{ $plato->observaciones }}</p>
                                    @endif
                                    @if($plato->receta && $plato->receta->ingredientes->count() > 0)
                                        <div class="text-sm">
                                            <strong>Ingredientes:</strong>
                                            <ul class="list-disc list-inside mt-1">
                                                @foreach($plato->receta->ingredientes as $ingrediente)
                                                    <li>
                                                        {{ $ingrediente->producto->nombre }}
                                                        <span class="text-gray-500">
                                                            ({{ $ingrediente->cantidad }} {{ $ingrediente->unidad ?? 'unid' }})
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>Este menú no tiene items configurados.</p>
                    @if($menu->estado !== 'publicado')
                        <a href="{{ route('menus.edit', $menu) }}" class="btn btn-primary mt-3">Agregar Items</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
