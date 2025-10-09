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
        Schema::table('kardex', function (Blueprint $table) {
            $table->string('modulo')->default('inventario')->after('tipo_movimiento'); // inventario, consumos
            $table->index(['modulo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kardex', function (Blueprint $table) {
            $table->dropIndex(['modulo']);
            $table->dropColumn('modulo');
        });
    }
};
