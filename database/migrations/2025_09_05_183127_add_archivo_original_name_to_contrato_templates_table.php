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
        Schema::table('contrato_templates', function (Blueprint $table) {
            $table->string('archivo_original_name')->nullable()->after('archivo_original');
            // También vamos a renombrar archivo_original a archivo_path para consistencia
            $table->renameColumn('archivo_original', 'archivo_path');
            // Y cambiar contenido_html por contenido
            $table->renameColumn('contenido_html', 'contenido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contrato_templates', function (Blueprint $table) {
            $table->dropColumn('archivo_original_name');
            $table->renameColumn('archivo_path', 'archivo_original');
            $table->renameColumn('contenido', 'contenido_html');
        });
    }
};
