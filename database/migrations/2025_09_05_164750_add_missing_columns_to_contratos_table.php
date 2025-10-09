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
        Schema::table('contratos', function (Blueprint $table) {
            // Add missing columns from the form
            $table->decimal('descuentos', 10, 2)->default(0)->after('bonificaciones');
            $table->string('jornada_laboral')->nullable()->after('area_departamento');
            $table->string('departamento')->nullable()->after('jornada_laboral');
            $table->string('lugar_trabajo')->nullable()->after('departamento');
            $table->json('documentos_adjuntos')->nullable()->after('archivo_anexos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn([
                'descuentos',
                'jornada_laboral',
                'departamento',
                'lugar_trabajo',
                'documentos_adjuntos'
            ]);
        });
    }
};
