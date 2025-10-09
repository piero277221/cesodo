<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('menus', 'fecha_inicio') || !Schema::hasColumn('menus', 'fecha_fin')) {
            Schema::table('menus', function (Blueprint $table) {
                if (!Schema::hasColumn('menus', 'fecha_inicio')) {
                    // place after tipo_menu if present
                    if (Schema::hasColumn('menus', 'tipo_menu')) {
                        $table->date('fecha_inicio')->nullable()->after('tipo_menu');
                    } else {
                        $table->date('fecha_inicio')->nullable();
                    }
                }

                if (!Schema::hasColumn('menus', 'fecha_fin')) {
                    if (Schema::hasColumn('menus', 'fecha_inicio')) {
                        $table->date('fecha_fin')->nullable()->after('fecha_inicio');
                    } else {
                        $table->date('fecha_fin')->nullable();
                    }
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            if (Schema::hasColumn('menus', 'fecha_fin')) {
                $table->dropColumn('fecha_fin');
            }
            if (Schema::hasColumn('menus', 'fecha_inicio')) {
                $table->dropColumn('fecha_inicio');
            }
        });
    }
};
