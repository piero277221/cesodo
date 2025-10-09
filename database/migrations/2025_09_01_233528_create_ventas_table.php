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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_venta', 20)->unique();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('restrict');
            $table->date('fecha_venta');
            $table->enum('tipo_comprobante', ['boleta', 'factura', 'nota_credito', 'nota_debito']);
            $table->string('numero_comprobante', 20)->nullable();

            // Montos
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('igv', 10, 2);
            $table->decimal('total', 10, 2);

            // Estados
            $table->enum('estado', ['pendiente', 'procesando', 'completado', 'cancelado', 'anulado'])->default('pendiente');
            $table->enum('estado_pago', ['pendiente', 'parcial', 'pagado', 'vencido'])->default('pendiente');
            $table->decimal('saldo_pendiente', 10, 2);
            $table->date('fecha_vencimiento')->nullable();

            // Información adicional
            $table->text('observaciones')->nullable();
            $table->foreignId('vendedor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('metodo_pago', 50)->nullable();
            $table->string('referencia_pago')->nullable();

            $table->timestamps();

            // Índices
            $table->index(['fecha_venta', 'estado']);
            $table->index(['cliente_id', 'estado_pago']);
            $table->index('numero_comprobante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
