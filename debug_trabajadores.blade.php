<!DOCTYPE html>
<html>
<head>
    <title>Debug Trabajadores</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Debug: Búsqueda de Personas</h2>

        <div class="mb-3">
            <label>DNI a buscar:</label>
            <input type="text" id="dni-test" value="12345678" class="form-control" style="width: 200px; display: inline-block;">
            <button onclick="buscarPersonaTest()" class="btn btn-primary">Buscar</button>
        </div>

        <div id="resultado-test"></div>

        <h3>Personas en Base de Datos:</h3>
        <div>
            @foreach(\App\Models\Persona::all() as $persona)
                <p>ID: {{ $persona->id }}, DNI: {{ $persona->numero_documento }}, Nombre: {{ $persona->nombres }} {{ $persona->apellidos }}</p>
            @endforeach
        </div>
    </div>

    <script>
    async function buscarPersonaTest() {
        const dni = document.getElementById('dni-test').value;
        const resultado = document.getElementById('resultado-test');

        console.log('=== INICIO TEST BÚSQUEDA ===');
        console.log('DNI:', dni);

        try {
            const url = `{{ route('trabajadores.buscar-persona-documento') }}?documento=${dni}`;
            console.log('URL:', url);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            const text = await response.text();
            console.log('Response text:', text);

            try {
                const data = JSON.parse(text);
                console.log('Response JSON:', data);
                resultado.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            } catch (jsonError) {
                console.error('Error parsing JSON:', jsonError);
                resultado.innerHTML = '<div class="alert alert-danger">Error parsing JSON: ' + text + '</div>';
            }

        } catch (error) {
            console.error('Error:', error);
            resultado.innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
        }
    }
    </script>
</body>
</html>
