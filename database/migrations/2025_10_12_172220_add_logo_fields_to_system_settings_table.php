<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->text('logo_path')->nullable()->after('value');
            $table->text('icon_path')->nullable()->after('logo_path');
        });

        // Insertar configuraciones iniciales de empresa
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'Mi Empresa',
                'type' => 'string',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Nombre de la empresa',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_logo',
                'value' => null,
                'logo_path' => null,
                'type' => 'string',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Logo de la empresa (aparece en sistema y reportes)',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_icon',
                'value' => null,
                'icon_path' => null,
                'type' => 'string',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Icono de la empresa (aparece en la barra lateral)',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_address',
                'value' => '',
                'type' => 'text',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Dirección de la empresa',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_phone',
                'value' => '',
                'type' => 'string',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Teléfono de contacto',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_email',
                'value' => '',
                'type' => 'email',
                'module' => 'general',
                'category' => 'empresa',
                'description' => 'Email de contacto',
                'editable' => true,
                'is_system' => false,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($settings as $setting) {
            // Solo insertar si no existe
            if (!DB::table('system_settings')->where('key', $setting['key'])->exists()) {
                DB::table('system_settings')->insert($setting);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropColumn(['logo_path', 'icon_path']);
        });

        // Eliminar configuraciones de empresa
        DB::table('system_settings')->whereIn('key', [
            'company_name',
            'company_logo',
            'company_icon',
            'company_address',
            'company_phone',
            'company_email'
        ])->delete();
    }
};
