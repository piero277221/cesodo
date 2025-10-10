<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'module',
        'category',
        'description',
        'editable',
        'is_system',
        'validation_rules',
        'sort_order'
    ];

    protected $casts = [
        'editable' => 'boolean',
        'is_system' => 'boolean',
        'validation_rules' => 'array',
        'sort_order' => 'integer'
    ];

    /**
     * Obtener valor de configuración por clave
     */
    public static function getValue($key, $default = null)
    {
        $cacheKey = "system_setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            return self::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Establecer valor de configuración
     */
    public static function setValue($key, $value, $type = 'string')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) || is_object($value) ? json_encode($value) : $value,
                'type' => $type
            ]
        );

        // Limpiar caché
        Cache::forget("system_setting_{$key}");
        
        return $setting;
    }

    /**
     * Convertir valor según tipo
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'number':
                return is_numeric($value) ? (float) $value : 0;
            case 'json':
                return json_decode($value, true) ?: [];
            case 'date':
                return $value ? \Carbon\Carbon::parse($value) : null;
            default:
                return $value;
        }
    }

    /**
     * Obtener configuraciones por módulo
     */
    public static function getByModule($module)
    {
        return self::where('module', $module)
                  ->orderBy('category')
                  ->orderBy('sort_order')
                  ->orderBy('key')
                  ->get();
    }

    /**
     * Obtener configuraciones por categoría
     */
    public static function getByCategory($category, $module = null)
    {
        $query = self::where('category', $category);
        
        if ($module) {
            $query->where('module', $module);
        }
        
        return $query->orderBy('sort_order')->orderBy('key')->get();
    }

    /**
     * Obtener todas las configuraciones editables
     */
    public static function getEditable()
    {
        return self::where('editable', true)
                  ->orderBy('module')
                  ->orderBy('category')
                  ->orderBy('sort_order')
                  ->get();
    }

    /**
     * Limpiar toda la caché de configuraciones
     */
    public static function clearCache()
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget("system_setting_{$setting->key}");
        }
    }

    /**
     * Scopes
     */
    public function scopeEditable($query)
    {
        return $query->where('editable', true);
    }

    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
