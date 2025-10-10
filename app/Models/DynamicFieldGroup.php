<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class DynamicFieldGroup extends Model
{
    protected $fillable = [
        'name',
        'label',
        'module',
        'description',
        'sort_order',
        'is_active',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Relación con campos dinámicos
     */
    public function fields(): HasMany
    {
        return $this->hasMany(DynamicField::class, 'group', 'name')
            ->where('module', $this->module);
    }

    /**
     * Scope para grupos activos
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para grupos de un módulo específico
     */
    public function scopeForModule(Builder $query, string $module): Builder
    {
        return $query->where('module', $module);
    }

    /**
     * Scope para grupos ordenados
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
