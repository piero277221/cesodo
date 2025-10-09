<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add the 'tipo_menu' column if it doesn't exist yet.
        if (!Schema::hasColumn('menus', 'tipo_menu')) {
            Schema::table('menus', function (Blueprint $table) {
                // If a 'nombre' column exists, place after it to keep ordering, otherwise just add it.
                if (Schema::hasColumn('menus', 'nombre')) {
                    $table->string('tipo_menu')->default('semanal')->after('nombre');
                } else {
                    $table->string('tipo_menu')->default('semanal');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('menus', 'tipo_menu')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->dropColumn('tipo_menu');
            });
        }
    }
};
