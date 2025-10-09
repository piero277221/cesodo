<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Gestión de Personas</h2>
    </x-slot>

    <div class="p-4 space-y-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <form method="GET" class="flex-1 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por nombre, apellido o documento..."
                           class="form-control flex-1" />
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('personas.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i> Limpiar
                        </a>
                    @endif
                </form>
                <a href="{{ route('personas.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Nueva Persona
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left">
                            <th class="p-3">Documento</th>
                            <th class="p-3">Nombres</th>
                            <th class="p-3">Apellidos</th>
                            <th class="p-3">Celular</th>
                            <th class="p-3">Correo</th>
                            <th class="p-3">Trabajador</th>
                            <th class="p-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personas as $p)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">
                                    <div>
                                        <span class="badge bg-secondary">{{ strtoupper($p->tipo_documento) }}</span>
                                        <br><span class="font-mono">{{ $p->numero_documento }}</span>
                                    </div>
                                </td>
                                <td class="p-3 font-medium">{{ $p->nombres }}</td>
                                <td class="p-3 font-medium">{{ $p->apellidos }}</td>
                                <td class="p-3">{{ $p->celular ?: '-' }}</td>
                                <td class="p-3">{{ $p->correo ?: '-' }}</td>
                                <td class="p-3">
                                    @if($p->trabajador)
                                        <span class="badge bg-success">Sí</span>
                                        <br><small class="text-gray-600">{{ $p->trabajador->cargo }}</small>
                                    @else
                                        <span class="badge bg-warning">No vinculado</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <div class="flex gap-1">
                                        <a href="{{ route('personas.edit', $p) }}"
                                           class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('personas.destroy', $p) }}" method="POST"
                                              class="inline" onsubmit="return confirm('¿Eliminar persona {{ $p->nombres }} {{ $p->apellidos }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500">
                                    @if(request('search'))
                                        No se encontraron personas con el término "{{ request('search') }}"
                                    @else
                                        No hay personas registradas
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Mostrando {{ $personas->firstItem() ?: 0 }} - {{ $personas->lastItem() ?: 0 }}
                de {{ $personas->total() }} personas
            </div>
            {{ $personas->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
