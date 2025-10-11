<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class CertificadoMedico extends Model
{
    use HasFactory;

    protected $table = 'certificados_medicos';

    protected $fillable = [
        'persona_id',
        'numero_documento',
        'observaciones',
        'archivo_certificado',
        'fecha_emision',
        'fecha_expiracion',
        'notificacion_enviada',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_expiracion' => 'date',
        'notificacion_enviada' => 'boolean',
    ];

    /**
     * Relación con Persona
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    /**
     * Verificar si el certificado está próximo a vencer (30 días o menos)
     */
    public function estaProximoAVencer()
    {
        if (!$this->fecha_expiracion) {
            return false;
        }

        $diasRestantes = Carbon::now()->diffInDays($this->fecha_expiracion, false);
        return $diasRestantes <= 30 && $diasRestantes >= 0;
    }

    /**
     * Verificar si el certificado está vencido
     */
    public function estaVencido()
    {
        if (!$this->fecha_expiracion) {
            return false;
        }

        return Carbon::now()->greaterThan($this->fecha_expiracion);
    }

    /**
     * Obtener días restantes hasta la expiración
     */
    public function diasRestantes()
    {
        if (!$this->fecha_expiracion) {
            return null;
        }

        $dias = Carbon::now()->diffInDays($this->fecha_expiracion, false);
        return (int) floor($dias);
    }

    /**
     * Obtener horas restantes hasta la expiración
     */
    public function horasRestantes()
    {
        if (!$this->fecha_expiracion) {
            return null;
        }

        $horas = Carbon::now()->diffInHours($this->fecha_expiracion, false);
        return (int) floor($horas);
    }

    /**
     * Obtener texto formateado de tiempo restante
     */
    public function tiempoRestanteTexto()
    {
        if (!$this->fecha_expiracion) {
            return 'Sin fecha de expiración';
        }

        $dias = $this->diasRestantes();
        
        if ($dias < 0) {
            $diasVencido = abs($dias);
            if ($diasVencido == 0) {
                $horasVencido = abs($this->horasRestantes());
                return $horasVencido . ' ' . ($horasVencido == 1 ? 'hora' : 'horas');
            }
            return $diasVencido . ' ' . ($diasVencido == 1 ? 'día' : 'días');
        }
        
        if ($dias == 0) {
            $horas = $this->horasRestantes();
            if ($horas <= 0) {
                return 'Menos de 1 hora';
            }
            return $horas . ' ' . ($horas == 1 ? 'hora' : 'horas');
        }
        
        return $dias . ' ' . ($dias == 1 ? 'día' : 'días');
    }

    /**
     * Obtener certificados próximos a vencer
     */
    public static function proximosAVencer()
    {
        $fechaLimite = Carbon::now()->addDays(30);

        return self::whereDate('fecha_expiracion', '<=', $fechaLimite)
            ->whereDate('fecha_expiracion', '>=', Carbon::now())
            ->where('notificacion_enviada', false)
            ->with('persona')
            ->get();
    }

    /**
     * Obtener certificados vencidos
     */
    public static function vencidos()
    {
        return self::whereDate('fecha_expiracion', '<', Carbon::now())
            ->with('persona')
            ->get();
    }
}
