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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('persona_id')->nullable()->after('estado');
            $table->unsignedBigInteger('trabajador_id')->nullable()->after('persona_id');
            $table->string('codigo_empleado', 20)->nullable()->after('trabajador_id');
            $table->timestamp('ultimo_acceso')->nullable()->after('codigo_empleado');
            $table->boolean('cambiar_password')->default(false)->after('ultimo_acceso');
            $table->text('observaciones')->nullable()->after('cambiar_password');

            // Agregar índices
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('trabajador_id')->references('id')->on('trabajadores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['persona_id']);
            $table->dropForeign(['trabajador_id']);
            $table->dropColumn([
                'persona_id',
                'trabajador_id',
                'codigo_empleado',
                'ultimo_acceso',
                'cambiar_password',
                'observaciones'
            ]);
        });
    }
};
