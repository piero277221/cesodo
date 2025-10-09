<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Menús Semanales</h2></x-slot>
    <div class="p-4 space-y-4">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium">Lista de Menús</h3>
            <a href="{{ route('menus.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Nuevo Menú
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="table-auto w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="p-3">Semana</th>
                        <th class="p-3">Descripción</th>
                        <th class="p-3">Items</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($menus as $m)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $m->semana_inicio->format('d/m/Y') }} - {{ $m->semana_fin->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $m->descripcion }}</td>
                        <td class="p-3">
                            <span class="badge bg-info">{{ $m->items->count() }} items</span>
                        </td>
                        <td class="p-3">
                            @if($m->estado === 'publicado')
                                <span class="badge bg-success">Publicado</span>
                            @else
                                <span class="badge bg-warning">Borrador</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('menus.show', $m) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                @if($m->estado !== 'publicado')
                                    <a href="{{ route('menus.edit', $m) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('menus.publicar', $m) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success" onclick="return confirm('¿Publicar menú? Esto descontará el stock.')">Publicar</button>
                                    </form>
                                @endif
                                <form action="{{ route('menus.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar menú?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-4 text-center text-gray-500">No hay menús registrados</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $menus->links() }}
    </div>
</x-app-layout>
