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
        Schema::create('ordenes_compra', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden', 20)->unique();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('restrict');
            $table->date('fecha_orden');
            $table->date('fecha_entrega_esperada')->nullable();
            $table->enum('estado', ['pendiente', 'aprobada', 'enviada', 'recibida', 'completada', 'cancelada'])->default('pendiente');
            $table->decimal('total_estimado', 10, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->foreignId('solicitante_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('aprobador_id')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('fecha_aprobacion')->nullable();
            $table->timestamps();

            // Índices
            $table->index(['fecha_orden', 'estado']);
            $table->index(['proveedor_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_compra');
    }
};
