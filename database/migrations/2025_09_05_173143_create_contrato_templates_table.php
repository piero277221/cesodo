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
        Schema::create('contrato_templates', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['html', 'word', 'pdf'])->default('html');
            $table->text('contenido_html')->nullable(); // Para templates HTML
            $table->string('archivo_original')->nullable(); // Ruta del archivo subido
            $table->json('marcadores')->nullable(); // Lista de marcadores disponibles
            $table->boolean('activo')->default(true);
            $table->boolean('es_predeterminado')->default(false);
            $table->unsignedBigInteger('creado_por')->nullable();
            $table->timestamps();

            $table->foreign('creado_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrato_templates');
    }
};
