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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('numero_compra')->unique();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->enum('tipo_compra', ['productos', 'insumos', 'equipos', 'servicios'])->default('productos');
            $table->date('fecha_compra');
            $table->date('fecha_entrega_esperada')->nullable();
            $table->date('fecha_entrega_real')->nullable();
            $table->enum('estado', ['borrador', 'enviado', 'confirmado', 'recibido', 'pagado', 'cancelado'])->default('borrador');
            $table->text('observaciones')->nullable();

            // Cálculos monetarios
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('impuestos', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Control de pagos
            $table->decimal('total_pagado', 12, 2)->default(0);
            $table->decimal('saldo_pendiente', 12, 2)->default(0);
            $table->enum('estado_pago', ['pendiente', 'parcial', 'pagado'])->default('pendiente');

            // Metadatos
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('metadata')->nullable(); // Para almacenar datos adicionales flexibles
            $table->timestamps();

            // Índices para optimización
            $table->index(['fecha_compra', 'estado']);
            $table->index(['proveedor_id', 'estado']);
            $table->index('numero_compra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
