<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('menus', 'observaciones')) {
            Schema::table('menus', function (Blueprint $table) {
                // Add as nullable text after descripcion if present
                if (Schema::hasColumn('menus', 'descripcion')) {
                    $table->text('observaciones')->nullable()->after('descripcion');
                } else {
                    $table->text('observaciones')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('menus', 'observaciones')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->dropColumn('observaciones');
            });
        }
    }
};
