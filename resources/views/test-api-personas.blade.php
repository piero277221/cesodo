@extends('layouts.app')

@section('title', 'Test API Personas')

@section('content')
<div class="container">
    <h1>Test de Búsqueda de Persona</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="text" class="form-control" id="dni" value="71981207">
            </div>
            <button class="btn btn-primary" onclick="buscarPersona()">Buscar</button>
        </div>
        <div class="col-md-6">
            <h5>Resultado:</h5>
            <div id="resultado" style="border: 1px solid #ccc; padding: 10px; min-height: 200px;"></div>
        </div>
    </div>
</div>

<script>
async function buscarPersona() {
    const dni = document.getElementById('dni').value;
    const resultado = document.getElementById('resultado');

    try {
        console.log('Buscando DNI:', dni);

        const response = await fetch(`{{ url('/api/personas/buscar-por-dni') }}/${dni}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });

        console.log('Status:', response.status);
        console.log('Headers:', [...response.headers.entries()]);

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`HTTP error! status: ${response.status}, response: ${errorText}`);
        }

        const data = await response.json();
        console.log('Data:', data);

        resultado.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';

    } catch (error) {
        console.error('Error:', error);
        resultado.innerHTML = '<p style="color: red;">Error: ' + error.message + '</p>';
    }
}
</script>
@endsection
