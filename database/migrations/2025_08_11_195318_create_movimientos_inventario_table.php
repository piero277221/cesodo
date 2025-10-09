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
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->enum('tipo_movimiento', ['entrada', 'salida']);
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->decimal('precio_total', 10, 2)->nullable();
            $table->string('motivo'); // compra, venta, consumo, ajuste, vencimiento, etc.
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('documento_referencia')->nullable(); // número de factura, boleta, etc.
            $table->date('fecha_movimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
