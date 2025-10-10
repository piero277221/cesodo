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
        // Tabla para tipos de widgets disponibles
        Schema::create('widget_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // stats, chart, table, quick_actions, etc.
            $table->string('title'); // Título mostrado al usuario
            $table->string('icon'); // Icono FontAwesome
            $table->text('description')->nullable();
            $table->json('default_config')->nullable(); // Configuración por defecto
            $table->json('config_schema')->nullable(); // Schema para validar configuración
            $table->string('component_view'); // Vista blade del widget
            $table->boolean('requires_data')->default(false); // Si necesita datos del backend
            $table->string('data_source')->nullable(); // Método para obtener datos
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tabla para configuraciones de widgets por usuario
        Schema::create('user_dashboard_widgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('widget_type_id')->constrained()->onDelete('cascade');
            $table->string('widget_id')->unique(); // UUID único del widget en el dashboard
            $table->string('title')->nullable(); // Título personalizado
            $table->json('config')->nullable(); // Configuración específica del widget
            $table->json('position'); // {x, y, width, height, col, row}
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_collapsed')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Índices para mejorar performance
            $table->index(['user_id', 'is_visible']);
            $table->index('sort_order');
        });

        // Tabla para layouts de dashboard predefinidos
        Schema::create('dashboard_layouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('layout_config'); // Configuración completa del layout
            $table->boolean('is_public')->default(false); // Si otros usuarios pueden usarlo
            $table->boolean('is_default')->default(false); // Layout por defecto para nuevos usuarios
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Tabla para compartir layouts entre usuarios
        Schema::create('dashboard_layout_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layout_id')->constrained('dashboard_layouts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('can_edit')->default(false);
            $table->timestamps();

            // Prevenir duplicados
            $table->unique(['layout_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_layout_shares');
        Schema::dropIfExists('dashboard_layouts');
        Schema::dropIfExists('user_dashboard_widgets');
        Schema::dropIfExists('widget_types');
    }
};
