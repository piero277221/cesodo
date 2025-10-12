<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria_id',
        'unidad_medida',
        'precio_unitario',
        'stock_minimo',
        'estado',
        'fecha_vencimiento',
        'dias_alerta_vencimiento',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'stock_minimo' => 'integer',
        'estado' => 'string',
        'fecha_vencimiento' => 'date',
        'dias_alerta_vencimiento' => 'integer',
    ];

    /**
     * Relaciones
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class);
    }

    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function recetaIngredientes()
    {
        return $this->hasMany(RecetaIngrediente::class);
    }

    /**
     * Scopes
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeStockBajo($query)
    {
        return $query->whereHas('inventario', function ($q) {
            $q->whereRaw('stock_disponible <= productos.stock_minimo');
        });
    }

    public function scopeProximosAVencer($query, $dias = null)
    {
        $query->whereNotNull('fecha_vencimiento')
              ->whereDate('fecha_vencimiento', '>=', Carbon::now());
        
        if ($dias) {
            $query->whereDate('fecha_vencimiento', '<=', Carbon::now()->addDays($dias));
        } else {
            // Usar el campo dias_alerta_vencimiento de cada producto
            $query->whereRaw('fecha_vencimiento <= DATE_ADD(NOW(), INTERVAL dias_alerta_vencimiento DAY)');
        }
        
        return $query->orderBy('fecha_vencimiento', 'asc');
    }

    public function scopeVencidos($query)
    {
        return $query->whereNotNull('fecha_vencimiento')
                     ->whereDate('fecha_vencimiento', '<', Carbon::now())
                     ->orderBy('fecha_vencimiento', 'desc');
    }

    /**
     * Accessors
     */
    public function getStockActualAttribute()
    {
        return $this->inventario ? $this->inventario->stock_actual : 0;
    }

    public function getStockDisponibleAttribute()
    {
        return $this->inventario ? $this->inventario->stock_disponible : 0;
    }

    /**
     * Métodos de vencimiento
     */
    public function diasRestantesVencimiento()
    {
        if (!$this->fecha_vencimiento) {
            return null;
        }
        
        return Carbon::now()->diffInDays($this->fecha_vencimiento, false);
    }

    public function estaVencido()
    {
        if (!$this->fecha_vencimiento) {
            return false;
        }
        
        return Carbon::now()->isAfter($this->fecha_vencimiento);
    }

    public function estaProximoAVencer()
    {
        if (!$this->fecha_vencimiento) {
            return false;
        }
        
        $diasRestantes = $this->diasRestantesVencimiento();
        
        return $diasRestantes !== null && 
               $diasRestantes >= 0 && 
               $diasRestantes <= $this->dias_alerta_vencimiento;
    }

    public function tiempoVencimientoTexto()
    {
        if (!$this->fecha_vencimiento) {
            return 'Sin fecha de vencimiento';
        }
        
        $dias = $this->diasRestantesVencimiento();
        
        if ($dias < 0) {
            $diasVencido = abs($dias);
            if ($diasVencido == 1) {
                return 'Vencido hace 1 día';
            }
            return "Vencido hace {$diasVencido} días";
        }
        
        if ($dias == 0) {
            return 'Vence hoy';
        }
        
        if ($dias == 1) {
            return 'Vence mañana';
        }
        
        if ($dias <= 7) {
            return "Vence en {$dias} días";
        }
        
        $semanas = floor($dias / 7);
        if ($semanas == 1) {
            return 'Vence en 1 semana';
        }
        
        if ($dias <= 30) {
            return "Vence en {$semanas} semanas";
        }
        
        $meses = floor($dias / 30);
        if ($meses == 1) {
            return 'Vence en 1 mes';
        }
        
        return "Vence en {$meses} meses";
    }
}
