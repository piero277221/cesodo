<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('estado')->default('borrador');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('costo_estimado', 10, 2)->default(0);
            $table->string('tipo_menu')->default('regular');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
