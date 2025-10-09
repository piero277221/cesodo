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
        Schema::table('recetas', function (Blueprint $table) {
            // Modificar el enum tipo_plato para incluir todos los tipos necesarios
            $table->dropColumn('tipo_plato');
        });

        Schema::table('recetas', function (Blueprint $table) {
            $table->enum('tipo_plato', [
                'entrada', 'plato_principal', 'postre', 'bebida',
                'guarnicion', 'sopa', 'ensalada'
            ])->after('pasos_preparacion');
        });

        Schema::table('recetas', function (Blueprint $table) {
            // Modificar dificultad
            $table->dropColumn('dificultad');
        });

        Schema::table('recetas', function (Blueprint $table) {
            $table->enum('dificultad', ['facil', 'intermedio', 'dificil', 'muy_dificil'])->default('facil')->after('tiempo_preparacion');
        });

        Schema::table('recetas', function (Blueprint $table) {
            // Agregar columnas faltantes
            if (!Schema::hasColumn('recetas', 'estado')) {
                $table->enum('estado', ['activo', 'inactivo', 'revision', 'archivado'])->default('activo')->after('dificultad');
            }

            if (!Schema::hasColumn('recetas', 'costo_aproximado')) {
                $table->decimal('costo_aproximado', 8, 2)->nullable()->after('estado');
            }

            if (!Schema::hasColumn('recetas', 'ingredientes_especiales')) {
                $table->json('ingredientes_especiales')->nullable()->after('costo_aproximado');
            }

            if (!Schema::hasColumn('recetas', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->after('ingredientes_especiales');
            }

            // Eliminar columnas antiguas si existen
            if (Schema::hasColumn('recetas', 'activo')) {
                $table->dropColumn('activo');
            }

            if (Schema::hasColumn('recetas', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recetas', function (Blueprint $table) {
            $table->dropColumn(['estado', 'costo_aproximado', 'ingredientes_especiales', 'created_by']);
            $table->boolean('activo')->default(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }
};
