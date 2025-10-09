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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();

            // Relación con persona
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');

            // Información básica del contrato
            $table->string('numero_contrato')->unique();
            $table->string('tipo_contrato'); // Indefinido, Plazo Fijo, Proyecto, Prácticas, etc.
            $table->string('modalidad'); // Presencial, Remoto, Híbrido
            $table->string('cargo');
            $table->string('area_departamento')->nullable();

            // Fechas
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->date('fecha_firma')->nullable();

            // Información salarial
            $table->decimal('salario_base', 10, 2);
            $table->string('moneda', 3)->default('PEN'); // PEN, USD, EUR
            $table->string('tipo_pago'); // Mensual, Quincenal, Semanal
            $table->decimal('bonificaciones', 10, 2)->default(0);
            $table->text('beneficios')->nullable();

            // Horario de trabajo
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('dias_laborales')->nullable(); // L-V, L-S, etc.
            $table->integer('horas_semanales')->nullable();

            // Estado del contrato
            $table->enum('estado', ['borrador', 'pendiente_firma', 'firmado', 'activo', 'finalizado', 'rescindido'])->default('borrador');
            $table->date('fecha_activacion')->nullable();
            $table->date('fecha_finalizacion')->nullable();
            $table->text('motivo_finalizacion')->nullable();

            // Archivos
            $table->string('archivo_contrato')->nullable(); // PDF del contrato
            $table->string('archivo_firmado')->nullable(); // PDF firmado por empleado
            $table->string('archivo_anexos')->nullable(); // Documentos adicionales

            // Información adicional
            $table->text('clausulas_especiales')->nullable();
            $table->text('observaciones')->nullable();
            $table->json('metadata')->nullable(); // Para información adicional flexible

            // Auditoría
            $table->foreignId('creado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_aprobacion')->nullable();

            $table->timestamps();

            // Índices
            $table->index(['persona_id', 'estado']);
            $table->index(['fecha_inicio', 'fecha_fin']);
            $table->index('numero_contrato');
            $table->index('tipo_contrato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
