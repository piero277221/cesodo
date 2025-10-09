<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Persona;
use Carbon\Carbon;

class Contrato extends Model
{
    protected $fillable = [
        'persona_id',
        'numero_contrato',
        'tipo_contrato',
        'modalidad',
        'cargo',
        'area_departamento',
        'fecha_inicio',
        'fecha_fin',
        'fecha_firma',
        'salario_base',
        'moneda',
        'tipo_pago',
        'bonificaciones',
        'beneficios',
        'hora_inicio',
        'hora_fin',
        'dias_laborales',
        'horas_semanales',
        'estado',
        'fecha_activacion',
        'fecha_finalizacion',
        'motivo_finalizacion',
        'archivo_contrato',
        'archivo_firmado',
        'archivo_anexos',
        'documentos_adjuntos',
        'clausulas_especiales',
        'observaciones',
        'metadata',
        'creado_por',
        'aprobado_por',
        'fecha_aprobacion',
        'jornada_laboral',
        'departamento',
        'lugar_trabajo',
        'descuentos'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_firma' => 'date',
        'fecha_activacion' => 'date',
        'fecha_finalizacion' => 'date',
        'fecha_aprobacion' => 'datetime',
        'salario_base' => 'decimal:2',
        'bonificaciones' => 'decimal:2',
        'descuentos' => 'decimal:2',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'metadata' => 'array',
        'documentos_adjuntos' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        // Configurar Carbon con locale español
        Carbon::setLocale('es');
    }

    // Relationships
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function aprobadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    // Business Logic Methods
    public function puedeEditarse(): bool
    {
        // Un contrato puede editarse si está en estado borrador o enviado
        return in_array($this->estado, ['borrador', 'enviado']);
    }

    public function puedeActivarse(): bool
    {
        // Un contrato puede activarse si está en estado borrador o enviado
        return in_array($this->estado, ['borrador', 'enviado']);
    }

    public function puedeFinalizarse(): bool
    {
        // Un contrato puede finalizarse si está activo
        return $this->estado === 'activo';
    }

    public function estaVigente(): bool
    {
        // Un contrato está vigente si está activo y no ha vencido
        if ($this->estado !== 'activo') {
            return false;
        }

        if ($this->fecha_fin) {
            return Carbon::parse($this->fecha_fin)->gt(now());
        }

        return true; // Contratos indefinidos siempre están vigentes si están activos
    }

    public function diasRestantes(): ?int
    {
        if (!$this->fecha_fin) {
            return null; // Contrato indefinido
        }

        $dias = now()->diffInDays(Carbon::parse($this->fecha_fin), false);
        return $dias > 0 ? $dias : 0;
    }

    public function estaProximoAVencer(): bool
    {
        $diasRestantes = $this->diasRestantes();
        return $diasRestantes !== null && $diasRestantes <= 30;
    }

    public function estaVencido(): bool
    {
        if (!$this->fecha_fin) {
            return false;
        }

        return Carbon::parse($this->fecha_fin)->lt(now());
    }

    public function getSalarioNetoAttribute(): float
    {
        return $this->salario_base + $this->bonificaciones - $this->descuentos;
    }

    public function getSalarioAttribute()
    {
        return $this->salario_base;
    }

    public function getEstadoBadgeClassAttribute(): string
    {
        return match($this->estado) {
            'activo' => 'bg-success',
            'borrador' => 'bg-warning',
            'enviado' => 'bg-info',
            'finalizado' => 'bg-secondary',
            'rescindido' => 'bg-danger',
            default => 'bg-dark'
        };
    }
}
