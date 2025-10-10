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
        // Tabla para definir campos dinámicos
        Schema::create('dynamic_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del campo (input_name)
            $table->string('label'); // Etiqueta visible para el usuario
            $table->string('module'); // Módulo al que pertenece (trabajadores, usuarios, etc.)
            $table->string('model_class'); // Clase del modelo (App\Models\Trabajador)
            $table->enum('type', [
                'text', 'textarea', 'number', 'email', 'password', 'date', 'datetime',
                'time', 'select', 'checkbox', 'radio', 'file', 'image', 'url', 'tel'
            ]);
            $table->json('options')->nullable(); // Opciones para select, radio, etc.
            $table->json('validation_rules')->nullable(); // Reglas de validación
            $table->json('attributes')->nullable(); // Atributos HTML adicionales
            $table->string('placeholder')->nullable(); // Placeholder del campo
            $table->text('help_text')->nullable(); // Texto de ayuda
            $table->string('default_value')->nullable(); // Valor por defecto
            $table->boolean('is_required')->default(false); // Campo obligatorio
            $table->boolean('is_active')->default(true); // Campo activo
            $table->integer('sort_order')->default(0); // Orden de visualización
            $table->string('group')->nullable(); // Grupo de campos (básico, adicional, etc.)
            $table->json('conditional_logic')->nullable(); // Lógica condicional
            $table->timestamps();

            $table->index(['module', 'is_active']);
            $table->index(['model_class', 'is_active']);
            $table->unique(['module', 'name']); // Un campo por módulo debe ser único
        });

        // Tabla para almacenar valores de campos dinámicos
        Schema::create('dynamic_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('dynamic_fields')->onDelete('cascade');
            $table->morphs('model'); // Polimórfico: model_type, model_id
            $table->longText('value')->nullable(); // Valor del campo
            $table->timestamps();

            $table->index(['field_id', 'model_type', 'model_id']);
        });

        // Tabla para grupos de campos dinámicos
        Schema::create('dynamic_field_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del grupo
            $table->string('label'); // Etiqueta del grupo
            $table->string('module'); // Módulo al que pertenece
            $table->text('description')->nullable(); // Descripción del grupo
            $table->integer('sort_order')->default(0); // Orden de visualización
            $table->boolean('is_active')->default(true); // Grupo activo
            $table->json('settings')->nullable(); // Configuraciones adicionales
            $table->timestamps();

            $table->index(['module', 'is_active']);
            $table->unique(['module', 'name']); // Un grupo por módulo debe ser único
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_field_values');
        Schema::dropIfExists('dynamic_fields');
        Schema::dropIfExists('dynamic_field_groups');
    }
};
