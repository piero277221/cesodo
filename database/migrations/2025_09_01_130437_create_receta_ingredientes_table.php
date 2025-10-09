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
        Schema::create('receta_ingredientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receta_id')->constrained()->onDelete('cascade');
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->decimal('cantidad', 8, 2);
            $table->string('unidad_medida');
            $table->boolean('es_principal')->default(false); // ingrediente principal del plato
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['receta_id', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_ingredientes');
    }
};
