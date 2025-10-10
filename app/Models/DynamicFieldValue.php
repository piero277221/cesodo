<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DynamicFieldValue extends Model
{
    protected $fillable = [
        'field_id',
        'model_type',
        'model_id',
        'value'
    ];

    /**
     * Relación polimórfica con el modelo que tiene el valor
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relación con el campo dinámico
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(DynamicField::class);
    }

    /**
     * Obtener valor castado según el tipo de campo
     */
    public function getCastedValue()
    {
        if (!$this->field) {
            return $this->value;
        }

        switch ($this->field->type) {
            case 'number':
                return is_numeric($this->value) ? (float) $this->value : null;

            case 'checkbox':
                return (bool) $this->value;

            case 'date':
                return $this->value ? \Carbon\Carbon::parse($this->value)->format('Y-m-d') : null;

            case 'datetime':
                return $this->value ? \Carbon\Carbon::parse($this->value) : null;

            case 'time':
                return $this->value ? \Carbon\Carbon::parse($this->value)->format('H:i') : null;

            default:
                return $this->value;
        }
    }

    /**
     * Establecer valor según el tipo de campo
     */
    public function setCastedValue($value): void
    {
        if (!$this->field) {
            $this->value = $value;
            return;
        }

        switch ($this->field->type) {
            case 'checkbox':
                $this->value = $value ? '1' : '0';
                break;

            case 'date':
            case 'datetime':
            case 'time':
                $this->value = $value ? \Carbon\Carbon::parse($value)->toDateTimeString() : null;
                break;

            default:
                $this->value = $value;
        }
    }
}
