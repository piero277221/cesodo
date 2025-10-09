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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('ruc_dni', 20)->unique();
            $table->enum('tipo_documento', ['ruc', 'dni', 'ce', 'pasaporte']);
            $table->string('razon_social');
            $table->string('nombre_comercial')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('direccion')->nullable();
            $table->string('distrito', 100)->nullable();
            $table->string('provincia', 100)->nullable();
            $table->string('departamento', 100)->nullable();

            // Contacto principal
            $table->string('contacto_principal')->nullable();
            $table->string('telefono_contacto', 20)->nullable();
            $table->string('email_contacto')->nullable();

            // Información comercial
            $table->enum('tipo_cliente', ['empresa', 'persona', 'gobierno', 'ong'])->default('persona');
            $table->boolean('activo')->default(true);
            $table->decimal('descuento_habitual', 5, 2)->default(0);
            $table->decimal('limite_credito', 10, 2)->default(0);
            $table->integer('dias_credito')->default(0);
            $table->text('observaciones')->nullable();

            $table->timestamps();

            // Índices
            $table->index(['tipo_cliente', 'activo']);
            $table->index('razon_social');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
