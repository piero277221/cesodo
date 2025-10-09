<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumoSimple extends Model
{
    use HasFactory;

    protected $table = 'consumos';

    protected $fillable = [
        'trabajador_id',
        'fecha_consumo',
        'hora_consumo',
        'tipo_comida',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'fecha_consumo' => 'datetime:Y-m-d',
        'hora_consumo' => 'datetime:H:i',
    ];

    // Relaciones
    public function trabajador(): BelongsTo
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
