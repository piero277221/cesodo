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
        Schema::table('menus', function (Blueprint $table) {
            // Solo agregar la columna costo_total si no existe
            if (!Schema::hasColumn('menus', 'costo_total')) {
                $table->decimal('costo_total', 10, 2)->default(0)->after('estado');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            if (Schema::hasColumn('menus', 'costo_total')) {
                $table->dropColumn('costo_total');
            }
        });
    }
};
