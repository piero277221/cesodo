<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserDashboardWidget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'widget_type_id',
        'widget_id',
        'title',
        'config',
        'position',
        'is_visible',
        'is_collapsed',
        'sort_order'
    ];

    protected $casts = [
        'config' => 'array',
        'position' => 'array',
        'is_visible' => 'boolean',
        'is_collapsed' => 'boolean'
    ];

    /**
     * Generar widget_id único al crear
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($widget) {
            if (empty($widget->widget_id)) {
                $widget->widget_id = 'widget_' . Str::random(10);
            }
        });
    }

    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el tipo de widget
     */
    public function widgetType(): BelongsTo
    {
        return $this->belongsTo(WidgetType::class);
    }

    /**
     * Scope para widgets visibles
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope para widgets ordenados
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Obtener el título del widget (personalizado o por defecto)
     */
    public function getDisplayTitleAttribute(): string
    {
        return $this->title ?: $this->widgetType->title;
    }

    /**
     * Obtener la configuración completa (por defecto + personalizada)
     */
    public function getFullConfigAttribute(): array
    {
        $defaultConfig = $this->widgetType->default_config ?? [];
        $userConfig = $this->config ?? [];

        return array_merge($defaultConfig, $userConfig);
    }

    /**
     * Obtener los datos del widget
     */
    public function getData()
    {
        return $this->widgetType->getData($this->full_config, $this->user_id);
    }

    /**
     * Renderizar el widget
     */
    public function render()
    {
        $data = $this->getData();

        return view($this->widgetType->component_view, [
            'widget' => $this,
            'config' => $this->full_config,
            'data' => $data
        ])->render();
    }

    /**
     * Actualizar posición del widget
     */
    public function updatePosition(array $position): bool
    {
        $this->position = $position;
        return $this->save();
    }

    /**
     * Actualizar configuración del widget
     */
    public function updateConfig(array $config): bool
    {
        $this->config = array_merge($this->config ?? [], $config);
        return $this->save();
    }

    /**
     * Alternar visibilidad del widget
     */
    public function toggleVisibility(): bool
    {
        $this->is_visible = !$this->is_visible;
        return $this->save();
    }

    /**
     * Alternar estado colapsado del widget
     */
    public function toggleCollapsed(): bool
    {
        $this->is_collapsed = !$this->is_collapsed;
        return $this->save();
    }
}
