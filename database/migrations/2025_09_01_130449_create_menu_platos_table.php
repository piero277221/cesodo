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
        Schema::create('menu_platos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('receta_id')->constrained()->onDelete('cascade');
            $table->enum('dia_semana', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
            $table->enum('tipo_comida', ['desayuno', 'almuerzo', 'cena', 'refrigerio']);
            $table->date('fecha_programada');
            $table->integer('porciones_planificadas')->default(1);
            $table->decimal('costo_estimado', 8, 2)->nullable();
            $table->enum('estado', ['planificado', 'preparado', 'servido', 'cancelado'])->default('planificado');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_platos');
    }
};
