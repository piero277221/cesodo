<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Agregar columnas faltantes si no existen
            if (!Schema::hasColumn('menus', 'numero_personas')) {
                $table->integer('numero_personas')->default(1)->after('tipo_menu');
            }
            if (!Schema::hasColumn('menus', 'platos_totales')) {
                $table->integer('platos_totales')->default(0)->after('numero_personas');
            }
            if (!Schema::hasColumn('menus', 'platos_disponibles')) {
                $table->integer('platos_disponibles')->default(0)->after('platos_totales');
            }
            if (!Schema::hasColumn('menus', 'auto_generado')) {
                $table->boolean('auto_generado')->default(false)->after('platos_disponibles');
            }
            if (!Schema::hasColumn('menus', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('descripcion');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn([
                'numero_personas',
                'platos_totales',
                'platos_disponibles',
                'auto_generado',
                'observaciones'
            ]);
        });
    }
};
