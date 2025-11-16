<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Agregar macros globales para compatibilidad con fechas
        Builder::macro('compatibleWhereYear', function ($column, $year) {
            return $this->whereYear($column, $year);
        });

        Builder::macro('compatibleWhereMonth', function ($column, $month) {
            return $this->whereMonth($column, $month);
        });
    }
}
