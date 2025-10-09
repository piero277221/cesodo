<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            if (!Schema::hasColumn('menus', 'platos_disponibles')) {
                $table->integer('platos_disponibles')->default(0);
            }
            if (!Schema::hasColumn('menus', 'platos_totales')) {
                $table->integer('platos_totales')->default(0);
            }
            if (!Schema::hasColumn('menus', 'estado')) {
                $table->enum('estado', ['borrador', 'activo', 'terminado', 'cancelado'])->default('borrador');
            }
        });
    }

    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['platos_disponibles', 'platos_totales']);
            // No eliminamos el campo estado porque podría estar en uso por otras funcionalidades
        });
    }
};
