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
        Schema::table('personas', function (Blueprint $table) {
            // Agregar índice único para celular (permitiendo NULL)
            $table->unique('celular', 'personas_celular_unique');
            
            // Agregar índice único para correo (permitiendo NULL)
            $table->unique('correo', 'personas_correo_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropUnique('personas_celular_unique');
            $table->dropUnique('personas_correo_unique');
        });
    }
};
