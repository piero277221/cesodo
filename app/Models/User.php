<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'telefono',
        'estado',
        'persona_id',
        'trabajador_id',
        'codigo_empleado',
        'ultimo_acceso',
        'cambiar_password',
        'observaciones',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'ultimo_acceso' => 'datetime',
            'cambiar_password' => 'boolean',
        ];
    }

    /**
     * Relaciones
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function consumos()
    {
        return $this->hasMany(Consumo::class);
    }

    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'usuario_id');
    }

    /**
     * Métodos auxiliares
     */
    public function getNombreCompletoAttribute()
    {
        if ($this->persona) {
            return $this->persona->nombre_completo;
        }
        return $this->name;
    }

    public function getCodigoEmpleadoGeneradoAttribute()
    {
        if ($this->trabajador) {
            return $this->trabajador->codigo;
        }
        return $this->codigo_empleado;
    }

    public function isPasswordTemporary()
    {
        return $this->cambiar_password;
    }

    /**
     * Relación con widgets del dashboard
     */
    public function dashboardWidgets()
    {
        return $this->hasMany(UserDashboardWidget::class);
    }

    /**
     * Relación con layouts creados por el usuario
     */
    public function createdLayouts()
    {
        return $this->hasMany(DashboardLayout::class, 'created_by');
    }

    /**
     * Relación con layouts compartidos con el usuario
     */
    public function sharedLayouts()
    {
        return $this->belongsToMany(DashboardLayout::class, 'dashboard_layout_shares')
            ->withPivot('can_edit')
            ->withTimestamps();
    }
}
