<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class DashboardLayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'layout_config',
        'is_public',
        'is_default',
        'created_by'
    ];

    protected $casts = [
        'layout_config' => 'array',
        'is_public' => 'boolean',
        'is_default' => 'boolean'
    ];

    /**
     * Generar slug automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layout) {
            if (empty($layout->slug)) {
                $layout->slug = Str::slug($layout->name);

                // Asegurar unicidad del slug
                $counter = 1;
                $originalSlug = $layout->slug;

                while (self::where('slug', $layout->slug)->exists()) {
                    $layout->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });
    }

    /**
     * Relación con el creador del layout
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con usuarios que tienen acceso al layout
     */
    public function sharedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'dashboard_layout_shares')
            ->withPivot('can_edit')
            ->withTimestamps();
    }

    /**
     * Scope para layouts públicos
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope para layouts por defecto
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope para layouts accesibles por un usuario
     */
    public function scopeAccessibleBy($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('is_public', true)
              ->orWhere('created_by', $userId)
              ->orWhereHas('sharedUsers', function ($subQ) use ($userId) {
                  $subQ->where('user_id', $userId);
              });
        });
    }

    /**
     * Verificar si un usuario puede editar el layout
     */
    public function canEdit(User $user): bool
    {
        // El creador siempre puede editar
        if ($this->created_by === $user->id) {
            return true;
        }

        // Verificar si tiene permisos de edición compartidos
        $share = $this->sharedUsers()->where('user_id', $user->id)->first();
        return $share && $share->pivot->can_edit;
    }

    /**
     * Compartir layout con un usuario
     */
    public function shareWith(User $user, bool $canEdit = false): bool
    {
        $this->sharedUsers()->syncWithoutDetaching([
            $user->id => ['can_edit' => $canEdit]
        ]);

        return true;
    }

    /**
     * Revocar acceso de un usuario
     */
    public function revokeAccess(User $user): bool
    {
        return $this->sharedUsers()->detach($user->id) > 0;
    }

    /**
     * Aplicar layout a un usuario
     */
    public function applyToUser(User $user): bool
    {
        // Eliminar widgets existentes del usuario
        UserDashboardWidget::where('user_id', $user->id)->delete();

        // Crear widgets según la configuración del layout
        $widgets = $this->layout_config['widgets'] ?? [];

        foreach ($widgets as $widgetConfig) {
            $widgetType = WidgetType::where('name', $widgetConfig['type'])->first();

            if ($widgetType) {
                UserDashboardWidget::create([
                    'user_id' => $user->id,
                    'widget_type_id' => $widgetType->id,
                    'title' => $widgetConfig['title'] ?? null,
                    'config' => $widgetConfig['config'] ?? [],
                    'position' => $widgetConfig['position'] ?? [],
                    'is_visible' => $widgetConfig['is_visible'] ?? true,
                    'sort_order' => $widgetConfig['sort_order'] ?? 0
                ]);
            }
        }

        return true;
    }

    /**
     * Crear layout desde configuración de usuario
     */
    public static function createFromUser(User $user, string $name, string $description = null): self
    {
        $widgets = $user->dashboardWidgets()->with('widgetType')->get();

        $widgetConfigs = $widgets->map(function ($widget) {
            return [
                'type' => $widget->widgetType->name,
                'title' => $widget->title,
                'config' => $widget->config,
                'position' => $widget->position,
                'is_visible' => $widget->is_visible,
                'sort_order' => $widget->sort_order
            ];
        })->toArray();

        return self::create([
            'name' => $name,
            'description' => $description,
            'layout_config' => [
                'widgets' => $widgetConfigs,
                'grid_config' => [
                    'columns' => 12,
                    'row_height' => 150,
                    'margin' => 10
                ]
            ],
            'created_by' => $user->id
        ]);
    }
}
