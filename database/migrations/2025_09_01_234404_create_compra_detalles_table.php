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
        Schema::create('compra_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->decimal('cantidad', 10, 3);
            $table->string('unidad_medida', 50);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('descuento_unitario', 10, 2)->default(0);
            $table->decimal('precio_final', 10, 2); // precio después del descuento
            $table->decimal('subtotal', 12, 2); // cantidad * precio_final

            // Control de recepción
            $table->decimal('cantidad_recibida', 10, 3)->default(0);
            $table->decimal('cantidad_pendiente', 10, 3)->default(0);
            $table->date('fecha_vencimiento')->nullable();
            $table->string('lote')->nullable();
            $table->text('observaciones')->nullable();

            // Estado del detalle
            $table->enum('estado', ['pendiente', 'parcial', 'recibido', 'cancelado'])->default('pendiente');

            $table->timestamps();

            // Índices
            $table->index(['compra_id', 'producto_id']);
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra_detalles');
    }
};
