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
        Schema::table('contratos', function (Blueprint $table) {
            // Make modalidad nullable and add defaults for required fields
            $table->string('modalidad')->nullable()->default('presencial')->change();
            $table->string('moneda', 3)->default('PEN')->change();
            $table->string('tipo_pago')->nullable()->default('mensual')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->string('modalidad')->nullable(false)->change();
            $table->string('tipo_pago')->nullable(false)->change();
        });
    }
};
