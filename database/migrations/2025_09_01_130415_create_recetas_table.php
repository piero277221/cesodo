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
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->text('pasos_preparacion');
            $table->enum('tipo_plato', ['desayuno', 'almuerzo', 'cena', 'refrigerio']);
            $table->integer('porciones')->default(1);
            $table->integer('tiempo_preparacion')->nullable(); // en minutos
            $table->enum('dificultad', ['facil', 'medio', 'dificil'])->default('medio');
            $table->boolean('es_especial')->default(false); // para menús especiales
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
