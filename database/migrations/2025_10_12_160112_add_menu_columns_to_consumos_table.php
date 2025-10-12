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
        Schema::table('consumos', function (Blueprint $table) {
            // Hacer trabajador_id nullable para permitir consumos sin trabajador específico
            if (Schema::hasColumn('consumos', 'trabajador_id')) {
                $table->foreignId('trabajador_id')->nullable()->change();
            }

            // Agregar columna menu_id si no existe
            if (!Schema::hasColumn('consumos', 'menu_id')) {
                $table->foreignId('menu_id')->nullable()->after('trabajador_id')->constrained('menus')->onDelete('cascade');
            }

            // Agregar columna cantidad si no existe
            if (!Schema::hasColumn('consumos', 'cantidad')) {
                $table->integer('cantidad')->default(1)->after('tipo_comida');
            }

            // Hacer campos opcionales si no lo son
            if (Schema::hasColumn('consumos', 'hora_consumo')) {
                $table->time('hora_consumo')->nullable()->change();
            }
            if (Schema::hasColumn('consumos', 'tipo_comida')) {
                $table->string('tipo_comida')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consumos', function (Blueprint $table) {
            // Revertir trabajador_id a NOT NULL
            $table->foreignId('trabajador_id')->nullable(false)->change();

            // Eliminar columnas agregadas
            if (Schema::hasColumn('consumos', 'menu_id')) {
                $table->dropForeign(['menu_id']);
                $table->dropColumn('menu_id');
            }
            if (Schema::hasColumn('consumos', 'cantidad')) {
                $table->dropColumn('cantidad');
            }
        });
    }
};
