<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('menus', 'created_by')) {
            Schema::table('menus', function (Blueprint $table) {
                // Add nullable foreign key to users
                $table->foreignId('created_by')->nullable()->constrained('users')->after('estado');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('menus', 'created_by')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->dropConstrainedForeignId('created_by');
            });
        }
    }
};
