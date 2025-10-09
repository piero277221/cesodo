<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->boot();

use App\Models\Persona;

try {
    // Verificar si ya existe una persona con este DNI
    $existePersona = Persona::where('numero_documento', '12345678')->first();

    if ($existePersona) {
        echo "Ya existe una persona con DNI 12345678: " . $existePersona->nombres . " " . $existePersona->apellidos . "\n";
    } else {
        // Crear persona de prueba
        $persona = Persona::create([
            'nombres' => 'Juan Carlos',
            'apellidos' => 'Pérez García',
            'tipo_documento' => 'dni',
            'numero_documento' => '12345678',
            'fecha_nacimiento' => '1990-01-15',
            'sexo' => 'M',
            'direccion' => 'Av. Principal 123',
            'celular' => '987654321',
            'correo' => 'juan.perez@ejemplo.com',
            'nacionalidad' => 'Peruana',
            'estado_civil' => 'Soltero(a)'
        ]);

        echo "Persona creada exitosamente: " . $persona->nombres . " " . $persona->apellidos . " (DNI: " . $persona->numero_documento . ")\n";
    }

    // Crear otra persona de prueba
    $existePersona2 = Persona::where('numero_documento', '87654321')->first();

    if (!$existePersona2) {
        $persona2 = Persona::create([
            'nombres' => 'María Elena',
            'apellidos' => 'Rodríguez López',
            'tipo_documento' => 'dni',
            'numero_documento' => '87654321',
            'fecha_nacimiento' => '1985-08-20',
            'sexo' => 'F',
            'direccion' => 'Calle Secundaria 456',
            'celular' => '912345678',
            'correo' => 'maria.rodriguez@ejemplo.com',
            'nacionalidad' => 'Peruana',
            'estado_civil' => 'Casado(a)'
        ]);

        echo "Segunda persona creada: " . $persona2->nombres . " " . $persona2->apellidos . " (DNI: " . $persona2->numero_documento . ")\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
