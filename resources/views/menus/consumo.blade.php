@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $menu->nombre }}
                        @if($menu->estado === 'cerrado')
                            <span class="badge bg-danger">Cerrado</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Contador de platos disponibles -->
                    <div class="alert {{ $menu->platos_disponibles > 0 ? 'alert-success' : 'alert-danger' }}">
                        <h4 class="alert-heading">
                            <i class="fas fa-utensils me-2"></i>
                            Platos disponibles: {{ $menu->platos_disponibles }}
                        </h4>
                        <p class="mb-0">
                            Total inicial: {{ $menu->platos_totales }}
                            <br>
                            Consumidos: {{ $menu->platos_totales - $menu->platos_disponibles }}
                        </p>
                    </div>

                    @if($menu->estado !== 'cerrado' && $menu->platos_disponibles > 0)
                        <!-- Formulario de registro de consumo -->
                        <form id="consumoForm" class="mt-4">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cantidad a consumir</label>
                                        <input type="number" name="cantidad" class="form-control"
                                               min="1" max="{{ $menu->platos_disponibles }}" value="1">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label>Observaciones</label>
                                        <textarea name="observaciones" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar Consumo
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('consumoForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    try {
        const response = await fetch(`/menus/{{ $menu->id }}/consumos`, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const result = await response.json();

        if (result.success) {
            // Actualizar la vista
            location.reload();
        } else {
            alert(result.message);
        }
    } catch (error) {
        alert('Error al registrar el consumo');
    }
});
</script>
@endpush
@endsection
