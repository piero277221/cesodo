<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'celular',
        'correo',
        'nacionalidad',
        'estado_civil',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function trabajador()
    {
        return $this->hasOne(Trabajador::class);
    }

    public function usuario()
    {
        return $this->hasOne(User::class);
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    public function contratoActivo()
    {
        return $this->hasOne(Contrato::class)->where('estado', 'activo');
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim(($this->nombres ?? '') . ' ' . ($this->apellidos ?? ''));
    }

    public function getEmailSugeridoAttribute(): string
    {
        $nombres = strtolower($this->nombres ?? '');
        $apellidos = strtolower($this->apellidos ?? '');

        // Tomar primer nombre y primer apellido
        $primerNombre = explode(' ', $nombres)[0];
        $primerApellido = explode(' ', $apellidos)[0];

        // Remover acentos y caracteres especiales
        $email = $this->removeAccents($primerNombre . '.' . $primerApellido);

        return $email . '@cesodo.com';
    }

    private function removeAccents($string)
    {
        $string = str_replace(
            ['á','à','ä','â','ª','Á','À','Â','Ä'],
            ['a','a','a','a','a','A','A','A','A'],
            $string
        );
        $string = str_replace(
            ['é','è','ë','ê','É','È','Ê','Ë'],
            ['e','e','e','e','E','E','E','E'],
            $string
        );
        $string = str_replace(
            ['í','ì','ï','î','Í','Ì','Ï','Î'],
            ['i','i','i','i','I','I','I','I'],
            $string
        );
        $string = str_replace(
            ['ó','ò','ö','ô','Ó','Ò','Ö','Ô'],
            ['o','o','o','o','O','O','O','O'],
            $string
        );
        $string = str_replace(
            ['ú','ù','ü','û','Ú','Ù','Ü','Û'],
            ['u','u','u','u','U','U','U','U'],
            $string
        );
        $string = str_replace(['ñ','Ñ','ç','Ç'], ['n','N','c','C'], $string);

        return preg_replace('/[^a-zA-Z0-9.]/', '', $string);
    }
}
