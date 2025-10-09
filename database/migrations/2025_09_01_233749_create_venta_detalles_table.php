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
        Schema::create('venta_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('restrict');
            $table->string('descripcion');
            $table->decimal('cantidad', 8, 2);
            $table->decimal('precio_unitario', 8, 2);
            $table->decimal('descuento_item', 8, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            // Índices
            $table->index(['venta_id', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
