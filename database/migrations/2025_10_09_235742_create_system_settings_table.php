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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique(); // clave única de configuración
            $table->longText('value')->nullable(); // valor de la configuración (JSON o texto)
            $table->enum('type', ['string', 'number', 'boolean', 'json', 'text', 'date', 'email', 'url'])->default('string'); // tipo de dato
            $table->string('module', 50)->nullable(); // módulo al que pertenece (usuarios, productos, inventario, etc.)
            $table->string('category', 50)->default('general'); // categoría para agrupar configuraciones
            $table->text('description')->nullable(); // descripción de la configuración
            $table->boolean('editable')->default(true); // si puede ser editado por el usuario
            $table->boolean('is_system')->default(false); // si es configuración crítica del sistema
            $table->json('validation_rules')->nullable(); // reglas de validación en formato JSON
            $table->integer('sort_order')->default(0); // orden de visualización
            $table->timestamps();

            // Índices para mejor rendimiento
            $table->index(['module', 'category']);
            $table->index('editable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
