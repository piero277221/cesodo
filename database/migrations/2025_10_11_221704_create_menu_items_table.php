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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->string('dia')->nullable(); // lunes, martes, miercoles, etc.
            $table->string('tiempo')->nullable(); // desayuno, almuerzo, cena, merienda
            $table->string('titulo')->nullable(); // nombre del plato
            $table->text('descripcion')->nullable();
            $table->timestamps();
            
            // Índices para mejorar búsquedas
            $table->index(['menu_id', 'dia', 'tiempo']);
        });

        // Tabla pivot para menu_items y productos
        Schema::create('menu_item_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained('menu_items')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->decimal('cantidad', 10, 2)->default(1);
            $table->string('unidad')->default('unidad');
            $table->timestamps();
            
            // Evitar duplicados
            $table->unique(['menu_item_id', 'producto_id']);
        });

        // Tabla para productos alternativos por condiciones de salud
        Schema::create('menu_item_producto_alternativos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained('menu_items')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('certificado_medico_id')->nullable()->constrained('certificados_medicos')->onDelete('cascade');
            $table->decimal('cantidad', 10, 2)->default(1);
            $table->string('unidad')->default('unidad');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->index(['menu_item_id', 'certificado_medico_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_producto_alternativos');
        Schema::dropIfExists('menu_item_producto');
        Schema::dropIfExists('menu_items');
    }
};
