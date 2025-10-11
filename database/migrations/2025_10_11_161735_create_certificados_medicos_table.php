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
        Schema::create('certificados_medicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->string('numero_documento', 20);
            $table->text('observaciones')->nullable();
            $table->string('archivo_certificado')->nullable();
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_expiracion')->nullable();
            $table->boolean('notificacion_enviada')->default(false);
            $table->timestamps();

            // Índices
            $table->index('numero_documento');
            $table->index('fecha_expiracion');
            $table->index(['persona_id', 'fecha_expiracion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados_medicos');
    }
};
