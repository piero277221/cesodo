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
        // Verificar si la tabla condiciones_salud existe antes de renombrarla
        if (Schema::hasTable('condiciones_salud')) {
            // Renombrar la tabla
            Schema::rename('condiciones_salud', 'certificados_medicos');

            // Modificar la estructura de la tabla
            Schema::table('certificados_medicos', function (Blueprint $table) {
                // Eliminar columnas antiguas si existen
                if (Schema::hasColumn('certificados_medicos', 'restricciones_alimentarias')) {
                    $table->dropColumn('restricciones_alimentarias');
                }
                if (Schema::hasColumn('certificados_medicos', 'activo')) {
                    $table->dropColumn('activo');
                }

                // Renombrar columnas si existen
                if (Schema::hasColumn('certificados_medicos', 'nombre') && !Schema::hasColumn('certificados_medicos', 'numero_documento')) {
                    $table->renameColumn('nombre', 'numero_documento');
                }
                if (Schema::hasColumn('certificados_medicos', 'descripcion') && !Schema::hasColumn('certificados_medicos', 'observaciones')) {
                    $table->renameColumn('descripcion', 'observaciones');
                }

                // Agregar nuevas columnas solo si no existen
                if (!Schema::hasColumn('certificados_medicos', 'persona_id')) {
                    $table->foreignId('persona_id')->nullable()->after('id')->constrained('personas')->onDelete('cascade');
                }
                if (!Schema::hasColumn('certificados_medicos', 'archivo_certificado')) {
                    $table->string('archivo_certificado')->nullable()->after('observaciones');
                }
                if (!Schema::hasColumn('certificados_medicos', 'fecha_emision')) {
                    $table->date('fecha_emision')->nullable()->after('archivo_certificado');
                }
                if (!Schema::hasColumn('certificados_medicos', 'fecha_expiracion')) {
                    $table->date('fecha_expiracion')->nullable()->after('fecha_emision');
                }
                if (!Schema::hasColumn('certificados_medicos', 'notificacion_enviada')) {
                    $table->boolean('notificacion_enviada')->default(false)->after('fecha_expiracion');
                }
            });

            // Modificar la columna numero_documento para que sea VARCHAR
            Schema::table('certificados_medicos', function (Blueprint $table) {
                $table->string('numero_documento', 20)->change();
            });
        }
        // Si la tabla no existe, no hacer nada (ya fue creada con la otra migración)
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
