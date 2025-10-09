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
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->date('fecha_consumo');
            $table->time('hora_consumo');
            $table->enum('tipo_comida', ['desayuno', 'almuerzo', 'cena', 'refrigerio']);
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // quien registró
            $table->timestamps();

            // Un trabajador no puede tener el mismo tipo de comida el mismo día
            $table->unique(['trabajador_id', 'fecha_consumo', 'tipo_comida']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumos');
    }
};
