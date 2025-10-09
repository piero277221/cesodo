<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc_dni',
        'tipo_documento',
        'razon_social',
        'nombre_comercial',
        'telefono',
        'email',
        'direccion',
        'distrito',
        'provincia',
        'departamento',
        'contacto_principal',
        'telefono_contacto',
        'email_contacto',
        'tipo_cliente',
        'activo',
        'descuento_habitual',
        'limite_credito',
        'dias_credito',
        'observaciones'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'descuento_habitual' => 'decimal:2',
        'limite_credito' => 'decimal:2'
    ];

    // Relaciones
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->nombre_comercial ?: $this->razon_social;
    }

    public function getTipoDocumentoTextoAttribute()
    {
        $tipos = [
            'ruc' => 'RUC',
            'dni' => 'DNI',
            'ce' => 'Carnet de Extranjería',
            'pasaporte' => 'Pasaporte'
        ];

        return $tipos[$this->tipo_documento] ?? 'No especificado';
    }

    public function getTipoClienteTextoAttribute()
    {
        $tipos = [
            'empresa' => 'Empresa',
            'persona' => 'Persona Natural',
            'gobierno' => 'Entidad Gubernamental',
            'ong' => 'ONG'
        ];

        return $tipos[$this->tipo_cliente] ?? 'No especificado';
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeEmpresas($query)
    {
        return $query->where('tipo_cliente', 'empresa');
    }

    public function scopePersonas($query)
    {
        return $query->where('tipo_cliente', 'persona');
    }

    // Métodos
    public function ventasDelMes($mes = null, $año = null)
    {
        $mes = $mes ?: date('m');
        $año = $año ?: date('Y');

        return $this->ventas()
                   ->whereMonth('fecha_venta', $mes)
                   ->whereYear('fecha_venta', $año)
                   ->sum('total');
    }

    public function saldoPendiente()
    {
        return $this->ventas()
                   ->where('estado_pago', '!=', 'pagado')
                   ->sum('saldo_pendiente');
    }
}
