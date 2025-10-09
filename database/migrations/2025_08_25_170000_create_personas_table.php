<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->enum('tipo_documento', ['dni','ce','pasaporte','otros']);
            $table->string('numero_documento')->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['M','F','O'])->nullable();
            $table->string('direccion')->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('correo')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('estado_civil')->nullable();
            $table->timestamps();
            $table->index(['tipo_documento', 'numero_documento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
