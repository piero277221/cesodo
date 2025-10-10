<?php

namespace App\Traits;

use App\Models\DynamicField;
use App\Models\DynamicFieldValue;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasDynamicFields
{
    /**
     * Relación polimórfica con valores de campos dinámicos
     */
    public function dynamicFieldValues(): MorphMany
    {
        return $this->morphMany(DynamicFieldValue::class, 'model');
    }

    /**
     * Obtener campos dinámicos disponibles para este modelo
     */
    public function getDynamicFields(): Collection
    {
        $moduleName = $this->getDynamicFieldsModule();
        return DynamicField::getFieldsForModule($moduleName);
    }

    /**
     * Obtener el nombre del módulo para campos dinámicos
     * Debe ser implementado por cada modelo que use este trait
     */
    abstract protected function getDynamicFieldsModule(): string;

    /**
     * Obtener valor de un campo dinámico específico
     */
    public function getDynamicFieldValue(string $fieldName)
    {
        $field = $this->getDynamicFields()->firstWhere('name', $fieldName);

        if (!$field) {
            return null;
        }

        $value = $this->dynamicFieldValues()
            ->whereHas('field', function ($query) use ($fieldName) {
                $query->where('name', $fieldName);
            })
            ->first();

        return $value ? $value->getCastedValue() : $field->default_value;
    }

    /**
     * Establecer valor de un campo dinámico
     */
    public function setDynamicFieldValue(string $fieldName, $value): void
    {
        $field = $this->getDynamicFields()->firstWhere('name', $fieldName);

        if (!$field) {
            throw new \InvalidArgumentException("Campo dinámico '{$fieldName}' no encontrado");
        }

        $fieldValue = $this->dynamicFieldValues()
            ->whereHas('field', function ($query) use ($fieldName) {
                $query->where('name', $fieldName);
            })
            ->first();

        if (!$fieldValue) {
            $fieldValue = new DynamicFieldValue([
                'field_id' => $field->id,
                'model_type' => get_class($this),
                'model_id' => $this->id
            ]);
        }

        $fieldValue->setCastedValue($value);
        $fieldValue->save();
    }

    /**
     * Obtener todos los valores de campos dinámicos como array asociativo
     */
    public function getDynamicFieldsValues(): array
    {
        $values = [];

        foreach ($this->getDynamicFields() as $field) {
            $values[$field->name] = $this->getDynamicFieldValue($field->name);
        }

        return $values;
    }

    /**
     * Establecer múltiples valores de campos dinámicos
     */
    public function setDynamicFieldsValues(array $values): void
    {
        foreach ($values as $fieldName => $value) {
            try {
                $this->setDynamicFieldValue($fieldName, $value);
            } catch (\InvalidArgumentException $e) {
                // Ignorar campos que no existen
                continue;
            }
        }
    }

    /**
     * Validar campos dinámicos según sus reglas
     */
    public function validateDynamicFields(array $data): array
    {
        $rules = [];
        $messages = [];
        $attributes = [];

        foreach ($this->getDynamicFields() as $field) {
            $fieldKey = "dynamic_fields.{$field->name}";

            if (!empty($field->validation_rules)) {
                $rules[$fieldKey] = $field->getValidationRulesFormatted();
            }

            $attributes[$fieldKey] = $field->label;
        }

        if (empty($rules)) {
            return [];
        }

        $validator = \Validator::make($data, $rules, $messages, $attributes);

        return $validator->errors()->toArray();
    }

    /**
     * Renderizar formulario de campos dinámicos
     */
    public function renderDynamicFieldsForm(array $values = []): string
    {
        $html = '';
        $fields = $this->getDynamicFields();

        if ($fields->isEmpty()) {
            return $html;
        }

        // Agrupar campos por grupo
        $groupedFields = $fields->groupBy('group');

        foreach ($groupedFields as $groupName => $groupFields) {
            if ($groupName) {
                $html .= "<div class=\"card mb-3\">";
                $html .= "<div class=\"card-header\"><h6 class=\"mb-0\">{$groupName}</h6></div>";
                $html .= "<div class=\"card-body\">";
            }

            foreach ($groupFields as $field) {
                $currentValue = $values[$field->name] ?? $this->getDynamicFieldValue($field->name);

                $html .= "<div class=\"mb-3\">";
                $html .= "<label for=\"dynamic_field_{$field->name}\" class=\"form-label\">";
                $html .= htmlspecialchars($field->label);
                if ($field->is_required) {
                    $html .= " <span class=\"text-danger\">*</span>";
                }
                $html .= "</label>";

                $html .= $field->renderField($currentValue);

                if ($field->help_text) {
                    $html .= "<div class=\"form-text\">" . htmlspecialchars($field->help_text) . "</div>";
                }

                $html .= "</div>";
            }

            if ($groupName) {
                $html .= "</div></div>";
            }
        }

        return $html;
    }

    /**
     * Event handler para limpiar valores al eliminar modelo
     */
    public static function bootHasDynamicFields()
    {
        static::deleting(function ($model) {
            $model->dynamicFieldValues()->delete();
        });
    }
}
