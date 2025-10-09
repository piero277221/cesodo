<?php

namespace App\Observers;

use App\Models\Menu;

class MenuObserver
{
    public function creating(Menu $menu)
    {
        // Copiar fecha_inicio a semana_inicio y fecha_fin a semana_fin
        if ($menu->fecha_inicio) {
            $menu->semana_inicio = $menu->fecha_inicio;
        }
        if ($menu->fecha_fin) {
            $menu->semana_fin = $menu->fecha_fin;
        }
    }

    public function updating(Menu $menu)
    {
        // Copiar fecha_inicio a semana_inicio y fecha_fin a semana_fin
        if ($menu->isDirty('fecha_inicio')) {
            $menu->semana_inicio = $menu->fecha_inicio;
        }
        if ($menu->isDirty('fecha_fin')) {
            $menu->semana_fin = $menu->fecha_fin;
        }
    }
}
