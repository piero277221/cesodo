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
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->date('fecha');
            $table->string('tipo_movimiento'); // entrada, salida, ajuste, devolucion
            $table->string('concepto'); // compra, venta, ajuste_inventario, devolucion_proveedor, etc.
            $table->string('numero_documento')->nullable(); // numero de factura, pedido, etc.
            $table->integer('cantidad_entrada')->default(0);
            $table->integer('cantidad_salida')->default(0);
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->integer('saldo_cantidad');
            $table->decimal('saldo_valor', 12, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('referencia_tipo')->nullable(); // tipo de documento de referencia
            $table->unsignedBigInteger('referencia_id')->nullable(); // id del documento de referencia
            $table->timestamps();

            // Índices para mejorar rendimiento
            $table->index(['producto_id', 'fecha']);
            $table->index(['tipo_movimiento']);
            $table->index(['fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardex');
    }
};
