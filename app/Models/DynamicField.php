<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class DynamicField extends Model
{
    protected $fillable = [
        'name',
        'label',
        'module',
        'model_class',
        'type',
        'options',
        'validation_rules',
        'attributes',
        'placeholder',
        'help_text',
        'default_value',
        'is_required',
        'is_active',
        'sort_order',
        'group',
        'conditional_logic'
    ];

    protected $casts = [
        'options' => 'array',
        'validation_rules' => 'array',
        'attributes' => 'array',
        'conditional_logic' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Relación con valores de campos dinámicos
     */
    public function values(): HasMany
    {
        return $this->hasMany(DynamicFieldValue::class, 'field_id');
    }

    /**
     * Relación con grupo de campos
     */
    public function fieldGroup(): BelongsTo
    {
        return $this->belongsTo(DynamicFieldGroup::class, 'group', 'name')
            ->where('module', $this->module);
    }

    /**
     * Scope para campos activos
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para campos de un módulo específico
     */
    public function scopeForModule(Builder $query, string $module): Builder
    {
        return $query->where('module', $module);
    }

    /**
     * Scope para campos ordenados
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Obtener campos de un módulo con cache
     */
    public static function getFieldsForModule(string $module): \Illuminate\Support\Collection
    {
        $cacheKey = "dynamic_fields.{$module}";

        return Cache::remember($cacheKey, 3600, function () use ($module) {
            return self::active()
                ->forModule($module)
                ->ordered()
                ->get();
        });
    }

    /**
     * Limpiar cache de campos de un módulo
     */
    public static function clearModuleCache(string $module): void
    {
        Cache::forget("dynamic_fields.{$module}");
    }

    /**
     * Obtener reglas de validación formateadas para Laravel
     */
    public function getValidationRulesFormatted(): array
    {
        $rules = $this->validation_rules ?? [];

        // Agregar regla required si el campo es obligatorio
        if ($this->is_required) {
            array_unshift($rules, 'required');
        }

        return $rules;
    }

    /**
     * Obtener atributos HTML formateados
     */
    public function getHtmlAttributes(): array
    {
        $attributes = $this->attributes ?? [];

        // Agregar atributos por defecto según el tipo
        if ($this->placeholder) {
            $attributes['placeholder'] = $this->placeholder;
        }

        if ($this->is_required) {
            $attributes['required'] = true;
        }

        return $attributes;
    }

    /**
     * Verificar si el campo tiene opciones (select, radio, checkbox)
     */
    public function hasOptions(): bool
    {
        return in_array($this->type, ['select', 'radio', 'checkbox']) && !empty($this->options);
    }

    /**
     * Obtener opciones formateadas
     */
    public function getFormattedOptions(): array
    {
        if (!$this->hasOptions()) {
            return [];
        }

        return $this->options ?? [];
    }

    /**
     * Renderizar campo como HTML
     */
    public function renderField($value = null): string
    {
        $attributes = $this->getHtmlAttributes();
        $attributesString = '';

        foreach ($attributes as $key => $val) {
            if (is_bool($val)) {
                if ($val) $attributesString .= " {$key}";
            } else {
                $attributesString .= " {$key}=\"" . htmlspecialchars($val) . "\"";
            }
        }

        $fieldName = "dynamic_fields[{$this->name}]";
        $fieldId = "dynamic_field_{$this->name}";
        $currentValue = $value ?? $this->default_value;

        switch ($this->type) {
            case 'textarea':
                return "<textarea name=\"{$fieldName}\" id=\"{$fieldId}\" class=\"form-control\"{$attributesString}>" .
                       htmlspecialchars($currentValue ?? '') . "</textarea>";

            case 'select':
                $html = "<select name=\"{$fieldName}\" id=\"{$fieldId}\" class=\"form-control\"{$attributesString}>";
                if (!$this->is_required) {
                    $html .= "<option value=\"\">-- Seleccionar --</option>";
                }
                foreach ($this->getFormattedOptions() as $optionValue => $optionLabel) {
                    $selected = ($currentValue == $optionValue) ? ' selected' : '';
                    $html .= "<option value=\"" . htmlspecialchars($optionValue) . "\"{$selected}>" .
                            htmlspecialchars($optionLabel) . "</option>";
                }
                $html .= "</select>";
                return $html;

            case 'checkbox':
                $checked = $currentValue ? ' checked' : '';
                return "<input type=\"hidden\" name=\"{$fieldName}\" value=\"0\">" .
                       "<input type=\"checkbox\" name=\"{$fieldName}\" id=\"{$fieldId}\" class=\"form-check-input\" value=\"1\"{$checked}{$attributesString}>";

            case 'radio':
                $html = '';
                foreach ($this->getFormattedOptions() as $optionValue => $optionLabel) {
                    $checked = ($currentValue == $optionValue) ? ' checked' : '';
                    $html .= "<div class=\"form-check\">";
                    $html .= "<input type=\"radio\" name=\"{$fieldName}\" id=\"{$fieldId}_{$optionValue}\" class=\"form-check-input\" value=\"" .
                            htmlspecialchars($optionValue) . "\"{$checked}{$attributesString}>";
                    $html .= "<label class=\"form-check-label\" for=\"{$fieldId}_{$optionValue}\">" .
                            htmlspecialchars($optionLabel) . "</label>";
                    $html .= "</div>";
                }
                return $html;

            default:
                return "<input type=\"{$this->type}\" name=\"{$fieldName}\" id=\"{$fieldId}\" class=\"form-control\" value=\"" .
                       htmlspecialchars($currentValue ?? '') . "\"{$attributesString}>";
        }
    }

    /**
     * Event handlers
     */
    protected static function boot()
    {
        parent::boot();

        // Limpiar cache al guardar o eliminar
        static::saved(function ($field) {
            self::clearModuleCache($field->module);
        });

        static::deleted(function ($field) {
            self::clearModuleCache($field->module);
        });
    }
}
