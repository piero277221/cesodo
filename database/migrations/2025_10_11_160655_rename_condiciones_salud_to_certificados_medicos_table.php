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
        // Renombrar la tabla
        Schema::rename('condiciones_salud', 'certificados_medicos');

        // Modificar la estructura de la tabla
        Schema::table('certificados_medicos', function (Blueprint $table) {
            // Eliminar columnas antiguas
            $table->dropColumn(['restricciones_alimentarias', 'activo']);

            // Renombrar columnas
            $table->renameColumn('nombre', 'numero_documento');
            $table->renameColumn('descripcion', 'observaciones');

            // Agregar nuevas columnas
            $table->foreignId('persona_id')->nullable()->after('id')->constrained('personas')->onDelete('cascade');
            $table->string('archivo_certificado')->nullable()->after('observaciones');
            $table->date('fecha_emision')->nullable()->after('archivo_certificado');
            $table->date('fecha_expiracion')->nullable()->after('fecha_emision');
            $table->boolean('notificacion_enviada')->default(false)->after('fecha_expiracion');
        });

        // Modificar la columna numero_documento para que sea VARCHAR
        Schema::table('certificados_medicos', function (Blueprint $table) {
            $table->string('numero_documento', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir cambios de columnas
        Schema::table('certificados_medicos', function (Blueprint $table) {
            $table->dropForeign(['persona_id']);
            $table->dropColumn(['persona_id', 'archivo_certificado', 'fecha_emision', 'fecha_expiracion', 'notificacion_enviada']);

            $table->renameColumn('numero_documento', 'nombre');
            $table->renameColumn('observaciones', 'descripcion');

            $table->json('restricciones_alimentarias')->nullable();
            $table->boolean('activo')->default(true);
        });

        // Renombrar la tabla de vuelta
        Schema::rename('certificados_medicos', 'condiciones_salud');
    }
};
