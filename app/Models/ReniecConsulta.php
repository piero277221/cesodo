<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReniecConsulta extends Model
{
    protected $fillable = [
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'nombre_completo',
        'tipo_consulta',
        'estado',
        'respuesta_api',
        'ip_consulta',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que hizo la consulta
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el número de consultas gratuitas disponibles hoy
     */
    public static function consultasGratuitasHoy(): int
    {
        $limite = config('services.reniec.limite_gratuito', 100);
        $usadas = self::where('tipo_consulta', 'gratuita')
            ->whereDate('created_at', today())
            ->count();
        
        return max(0, $limite - $usadas);
    }

    /**
     * Obtener el total de consultas de hoy
     */
    public static function totalConsultasHoy(): int
    {
        return self::whereDate('created_at', today())->count();
    }

    /**
     * Obtener estadísticas de consultas
     */
    public static function estadisticas(): array
    {
        return [
            'hoy' => self::whereDate('created_at', today())->count(),
            'mes' => self::whereMonth('created_at', now()->month)->count(),
            'total' => self::count(),
            'exitosas' => self::where('estado', 'exitosa')->count(),
            'fallidas' => self::where('estado', 'fallida')->count(),
            'gratuitas_disponibles' => self::consultasGratuitasHoy(),
        ];
    }
}
