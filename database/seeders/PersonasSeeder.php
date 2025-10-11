<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonasSeeder extends Seeder
{
    public function run(): void
    {
        $personas = [
            ['nombres' => 'Juan Carlos', 'apellidos' => 'Rodríguez García', 'tipo_documento' => 'dni', 'numero_documento' => '45678901', 'fecha_nacimiento' => '1985-03-15', 'sexo' => 'M', 'direccion' => 'Av. Los Sauces 123, Lima', 'celular' => '987654321', 'correo' => 'juan.rodriguez@email.com'],
            ['nombres' => 'María Elena', 'apellidos' => 'Torres Vega', 'tipo_documento' => 'dni', 'numero_documento' => '45678902', 'fecha_nacimiento' => '1990-07-22', 'sexo' => 'F', 'direccion' => 'Jr. Las Flores 456, Miraflores', 'celular' => '987654322', 'correo' => 'maria.torres@email.com'],
            ['nombres' => 'Carlos Alberto', 'apellidos' => 'Mendoza Silva', 'tipo_documento' => 'dni', 'numero_documento' => '45678903', 'fecha_nacimiento' => '1982-11-30', 'sexo' => 'M', 'direccion' => 'Av. La Marina 789, San Miguel', 'celular' => '987654323', 'correo' => 'carlos.mendoza@email.com'],
            ['nombres' => 'Ana Patricia', 'apellidos' => 'Gutiérrez López', 'tipo_documento' => 'dni', 'numero_documento' => '45678904', 'fecha_nacimiento' => '1995-05-18', 'sexo' => 'F', 'direccion' => 'Av. Universitaria 234, Los Olivos', 'celular' => '987654324', 'correo' => 'ana.gutierrez@email.com'],
            ['nombres' => 'Luis Fernando', 'apellidos' => 'Castro Pérez', 'tipo_documento' => 'dni', 'numero_documento' => '45678905', 'fecha_nacimiento' => '1978-09-10', 'sexo' => 'M', 'direccion' => 'Jr. Los Olivos 567, SJL', 'celular' => '987654325', 'correo' => 'luis.castro@email.com'],
            ['nombres' => 'Rosa María', 'apellidos' => 'Flores Quispe', 'tipo_documento' => 'dni', 'numero_documento' => '45678906', 'fecha_nacimiento' => '1988-12-25', 'sexo' => 'F', 'direccion' => 'Av. Aviación 890, San Borja', 'celular' => '987654326', 'correo' => 'rosa.flores@email.com'],
            ['nombres' => 'Pedro José', 'apellidos' => 'Vargas Huamán', 'tipo_documento' => 'dni', 'numero_documento' => '45678907', 'fecha_nacimiento' => '1992-04-08', 'sexo' => 'M', 'direccion' => 'Av. La Paz 345, Miraflores', 'celular' => '987654327', 'correo' => 'pedro.vargas@email.com'],
            ['nombres' => 'Carmen Rosa', 'apellidos' => 'Sánchez García', 'tipo_documento' => 'dni', 'numero_documento' => '45678908', 'fecha_nacimiento' => '1987-08-14', 'sexo' => 'F', 'direccion' => 'Jr. Libertad 678, Surco', 'celular' => '987654328', 'correo' => 'carmen.sanchez@email.com'],
            ['nombres' => 'José Luis', 'apellidos' => 'Ramírez Torres', 'tipo_documento' => 'dni', 'numero_documento' => '45678909', 'fecha_nacimiento' => '1984-02-20', 'sexo' => 'M', 'direccion' => 'Av. Colonial 901, Callao', 'celular' => '987654329', 'correo' => 'jose.ramirez@email.com'],
            ['nombres' => 'Lucía Isabel', 'apellidos' => 'Martínez Díaz', 'tipo_documento' => 'dni', 'numero_documento' => '45678910', 'fecha_nacimiento' => '1993-06-12', 'sexo' => 'F', 'direccion' => 'Av. Javier Prado 234, San Isidro', 'celular' => '987654330', 'correo' => 'lucia.martinez@email.com'],
            ['nombres' => 'Roberto Carlos', 'apellidos' => 'Chávez Rojas', 'tipo_documento' => 'dni', 'numero_documento' => '45678911', 'fecha_nacimiento' => '1980-10-05', 'sexo' => 'M', 'direccion' => 'Av. Brasil 456, Breña', 'celular' => '987654331', 'correo' => 'roberto.chavez@email.com'],
            ['nombres' => 'Diana Carolina', 'apellidos' => 'Reyes Paredes', 'tipo_documento' => 'dni', 'numero_documento' => '45678912', 'fecha_nacimiento' => '1991-01-28', 'sexo' => 'F', 'direccion' => 'Jr. Huancayo 789, Lima', 'celular' => '987654332', 'correo' => 'diana.reyes@email.com'],
            ['nombres' => 'Miguel Ángel', 'apellidos' => 'Fernández Cruz', 'tipo_documento' => 'dni', 'numero_documento' => '45678913', 'fecha_nacimiento' => '1986-07-19', 'sexo' => 'M', 'direccion' => 'Av. Venezuela 123, Cercado de Lima', 'celular' => '987654333', 'correo' => 'miguel.fernandez@email.com'],
            ['nombres' => 'Patricia Sofía', 'apellidos' => 'Herrera Morales', 'tipo_documento' => 'dni', 'numero_documento' => '45678914', 'fecha_nacimiento' => '1994-11-03', 'sexo' => 'F', 'direccion' => 'Av. Arequipa 456, Lince', 'celular' => '987654334', 'correo' => 'patricia.herrera@email.com'],
            ['nombres' => 'Jorge Luis', 'apellidos' => 'Palacios Ríos', 'tipo_documento' => 'dni', 'numero_documento' => '45678915', 'fecha_nacimiento' => '1983-03-27', 'sexo' => 'M', 'direccion' => 'Jr. Washington 789, Centro de Lima', 'celular' => '987654335', 'correo' => 'jorge.palacios@email.com'],
        ];

        foreach ($personas as $persona) {
            DB::table('personas')->insert(array_merge($persona, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
