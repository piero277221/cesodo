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
        Schema::create('reniec_consultas', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 8); // DNI consultado
            $table->string('nombres')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->enum('tipo_consulta', ['gratuita', 'premium'])->default('gratuita');
            $table->enum('estado', ['exitosa', 'fallida', 'error'])->default('exitosa');
            $table->text('respuesta_api')->nullable(); // JSON de respuesta
            $table->string('ip_consulta')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();

            // Índices
            $table->index('dni');
            $table->index('tipo_consulta');
            $table->index('estado');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reniec_consultas');
    }
};
