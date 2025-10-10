<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DynamicField;
use App\Models\DynamicFieldGroup;

class DynamicFieldsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Crear grupos de campos dinámicos
        $groups = [
            [
                'name' => 'informacion_personal',
                'label' => 'Información Personal Adicional',
                'module' => 'trabajadores',
                'description' => 'Campos adicionales para información personal del trabajador',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'informacion_contacto',
                'label' => 'Información de Contacto',
                'module' => 'trabajadores',
                'description' => 'Campos para información de contacto del trabajador',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'informacion_laboral',
                'label' => 'Información Laboral',
                'module' => 'trabajadores',
                'description' => 'Campos específicos del trabajo y contrato',
                'sort_order' => 3,
                'is_active' => true
            ]
        ];

        foreach ($groups as $group) {
            DynamicFieldGroup::updateOrCreate(
                ['module' => $group['module'], 'name' => $group['name']],
                $group
            );
        }

        // Crear campos dinámicos para el módulo de trabajadores
        $fields = [
            [
                'name' => 'telefono_personal',
                'label' => 'Teléfono Personal',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'tel',
                'placeholder' => 'Ej: +51 987 654 321',
                'help_text' => 'Número de teléfono personal del trabajador',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 1,
                'group' => 'informacion_contacto',
                'validation_rules' => ['string', 'max:20']
            ],
            [
                'name' => 'telefono_emergencia',
                'label' => 'Teléfono de Emergencia',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'tel',
                'placeholder' => 'Contacto en caso de emergencia',
                'help_text' => 'Número de contacto en caso de emergencia',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 2,
                'group' => 'informacion_contacto',
                'validation_rules' => ['string', 'max:20']
            ],
            [
                'name' => 'email_personal',
                'label' => 'Email Personal',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'email',
                'placeholder' => 'email@ejemplo.com',
                'help_text' => 'Correo electrónico personal del trabajador',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 3,
                'group' => 'informacion_contacto',
                'validation_rules' => ['email', 'max:255']
            ],
            [
                'name' => 'direccion_completa',
                'label' => 'Dirección Completa',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'textarea',
                'placeholder' => 'Dirección completa del trabajador',
                'help_text' => 'Dirección completa incluyendo distrito, provincia',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 4,
                'group' => 'informacion_personal',
                'validation_rules' => ['string', 'max:500']
            ],
            [
                'name' => 'fecha_nacimiento',
                'label' => 'Fecha de Nacimiento',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'date',
                'help_text' => 'Fecha de nacimiento del trabajador',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 1,
                'group' => 'informacion_personal',
                'validation_rules' => ['date', 'before:today']
            ],
            [
                'name' => 'estado_civil',
                'label' => 'Estado Civil',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'select',
                'options' => [
                    'soltero' => 'Soltero(a)',
                    'casado' => 'Casado(a)',
                    'divorciado' => 'Divorciado(a)',
                    'viudo' => 'Viudo(a)',
                    'conviviente' => 'Conviviente'
                ],
                'help_text' => 'Estado civil actual del trabajador',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 2,
                'group' => 'informacion_personal',
                'validation_rules' => ['string', 'in:soltero,casado,divorciado,viudo,conviviente']
            ],
            [
                'name' => 'numero_hijos',
                'label' => 'Número de Hijos',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'number',
                'default_value' => '0',
                'help_text' => 'Número de hijos del trabajador',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 3,
                'group' => 'informacion_personal',
                'validation_rules' => ['integer', 'min:0', 'max:20']
            ],
            [
                'name' => 'tipo_contrato',
                'label' => 'Tipo de Contrato',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'select',
                'options' => [
                    'indefinido' => 'Plazo Indefinido',
                    'temporal' => 'Temporal',
                    'practicas' => 'Prácticas',
                    'locacion' => 'Locación de Servicios'
                ],
                'help_text' => 'Tipo de contrato laboral del trabajador',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 1,
                'group' => 'informacion_laboral',
                'validation_rules' => ['string', 'in:indefinido,temporal,practicas,locacion']
            ],
            [
                'name' => 'salario_base',
                'label' => 'Salario Base',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'number',
                'placeholder' => '0.00',
                'help_text' => 'Salario base mensual del trabajador',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 2,
                'group' => 'informacion_laboral',
                'validation_rules' => ['numeric', 'min:0']
            ],
            [
                'name' => 'fecha_ingreso',
                'label' => 'Fecha de Ingreso',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'date',
                'help_text' => 'Fecha de ingreso a la empresa',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 3,
                'group' => 'informacion_laboral',
                'validation_rules' => ['date', 'before_or_equal:today']
            ],
            [
                'name' => 'es_supervisor',
                'label' => 'Es Supervisor',
                'module' => 'trabajadores',
                'model_class' => 'App\\Models\\Trabajador',
                'type' => 'checkbox',
                'help_text' => 'Marcar si el trabajador tiene funciones de supervisión',
                'default_value' => '0',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 4,
                'group' => 'informacion_laboral',
                'validation_rules' => ['boolean']
            ]
        ];

        foreach ($fields as $field) {
            DynamicField::updateOrCreate(
                ['module' => $field['module'], 'name' => $field['name']],
                $field
            );
        }

        // Crear algunos campos para otros módulos
        $otherFields = [
            [
                'name' => 'ruc_proveedor',
                'label' => 'RUC del Proveedor',
                'module' => 'proveedores',
                'model_class' => 'App\\Models\\Proveedor',
                'type' => 'text',
                'placeholder' => '20XXXXXXXXX1',
                'help_text' => 'Número de RUC del proveedor',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 1,
                'validation_rules' => ['string', 'max:11']
            ],
            [
                'name' => 'categoria_producto',
                'label' => 'Categoría Específica',
                'module' => 'productos',
                'model_class' => 'App\\Models\\Producto',
                'type' => 'select',
                'options' => [
                    'perecedero' => 'Perecedero',
                    'no_perecedero' => 'No Perecedero',
                    'congelado' => 'Congelado',
                    'bebidas' => 'Bebidas'
                ],
                'help_text' => 'Categoría específica del producto',
                'is_required' => false,
                'is_active' => true,
                'sort_order' => 1,
                'validation_rules' => ['string']
            ]
        ];

        foreach ($otherFields as $field) {
            DynamicField::updateOrCreate(
                ['module' => $field['module'], 'name' => $field['name']],
                $field
            );
        }

        echo "✅ Campos dinámicos creados exitosamente:\n";
        echo "- " . count($fields) . " campos para módulo 'trabajadores'\n";
        echo "- " . count($otherFields) . " campos para otros módulos\n";
        echo "- " . count($groups) . " grupos de campos creados\n";
    }
}
