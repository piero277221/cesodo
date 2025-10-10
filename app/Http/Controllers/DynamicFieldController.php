<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicField;
use App\Models\DynamicFieldGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class DynamicFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $module = $request->get('module');
        
        $query = DynamicField::with('fieldGroup');
        
        if ($module) {
            $query->where('module', $module);
        }
        
        $fields = $query->orderBy('module')
                       ->orderBy('sort_order')
                       ->orderBy('id')
                       ->paginate(20);

        // Obtener módulos disponibles
        $availableModules = $this->getAvailableModules();
        
        // Obtener grupos por módulo
        $groups = DynamicFieldGroup::when($module, function ($q) use ($module) {
            return $q->where('module', $module);
        })->orderBy('module')->orderBy('sort_order')->get();

        return view('dynamic-fields.index', compact('fields', 'availableModules', 'groups', 'module'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $module = $request->get('module');
        $availableModules = $this->getAvailableModules();
        $fieldTypes = $this->getFieldTypes();
        
        $groups = collect();
        if ($module) {
            $groups = DynamicFieldGroup::where('module', $module)->ordered()->get();
        }

        return view('dynamic-fields.create', compact('availableModules', 'fieldTypes', 'groups', 'module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9_]+$/',
            'label' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,number,email,password,date,datetime,time,select,checkbox,radio,file,image,url,tel',
            'options' => 'nullable|array',
            'options.*' => 'required|string',
            'validation_rules' => 'nullable|array',
            'attributes' => 'nullable|array',
            'placeholder' => 'nullable|string|max:255',
            'help_text' => 'nullable|string',
            'default_value' => 'nullable|string',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'group' => 'nullable|string|max:255',
        ]);

        // Validación personalizada para unicidad de nombre en módulo
        $validator->after(function ($validator) use ($request) {
            $exists = DynamicField::where('module', $request->module)
                                  ->where('name', $request->name)
                                  ->exists();
            
            if ($exists) {
                $validator->errors()->add('name', 'Ya existe un campo con este nombre en el módulo seleccionado.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            
            // Obtener model_class basado en el módulo
            $data['model_class'] = $this->getModelClassForModule($request->module);
            
            // Procesar opciones para select, radio, checkbox
            if (in_array($request->type, ['select', 'radio', 'checkbox']) && $request->options) {
                $options = [];
                foreach ($request->options as $key => $value) {
                    if (!empty($value)) {
                        $options[$key] = $value;
                    }
                }
                $data['options'] = $options;
            }

            // Procesar reglas de validación
            if ($request->validation_rules) {
                $data['validation_rules'] = array_filter($request->validation_rules);
            }

            // Procesar atributos HTML
            if ($request->attributes) {
                $data['attributes'] = array_filter($request->attributes);
            }

            $field = DynamicField::create($data);

            DB::commit();

            return redirect()->route('dynamic-fields.index', ['module' => $request->module])
                ->with('success', 'Campo dinámico creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear el campo: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DynamicField $dynamicField)
    {
        return view('dynamic-fields.show', compact('dynamicField'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DynamicField $dynamicField)
    {
        $availableModules = $this->getAvailableModules();
        $fieldTypes = $this->getFieldTypes();
        
        $groups = DynamicFieldGroup::where('module', $dynamicField->module)->ordered()->get();

        return view('dynamic-fields.edit', compact('dynamicField', 'availableModules', 'fieldTypes', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DynamicField $dynamicField)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9_]+$/',
            'label' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,number,email,password,date,datetime,time,select,checkbox,radio,file,image,url,tel',
            'options' => 'nullable|array',
            'options.*' => 'required|string',
            'validation_rules' => 'nullable|array',
            'attributes' => 'nullable|array',
            'placeholder' => 'nullable|string|max:255',
            'help_text' => 'nullable|string',
            'default_value' => 'nullable|string',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'group' => 'nullable|string|max:255',
        ]);

        // Validación personalizada para unicidad de nombre en módulo
        $validator->after(function ($validator) use ($request, $dynamicField) {
            $exists = DynamicField::where('module', $request->module)
                                  ->where('name', $request->name)
                                  ->where('id', '!=', $dynamicField->id)
                                  ->exists();
            
            if ($exists) {
                $validator->errors()->add('name', 'Ya existe un campo con este nombre en el módulo seleccionado.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            
            // Obtener model_class basado en el módulo
            $data['model_class'] = $this->getModelClassForModule($request->module);
            
            // Procesar opciones para select, radio, checkbox
            if (in_array($request->type, ['select', 'radio', 'checkbox']) && $request->options) {
                $options = [];
                foreach ($request->options as $key => $value) {
                    if (!empty($value)) {
                        $options[$key] = $value;
                    }
                }
                $data['options'] = $options;
            } else {
                $data['options'] = null;
            }

            // Procesar reglas de validación
            if ($request->validation_rules) {
                $data['validation_rules'] = array_filter($request->validation_rules);
            }

            // Procesar atributos HTML
            if ($request->attributes) {
                $data['attributes'] = array_filter($request->attributes);
            }

            $dynamicField->update($data);

            DB::commit();

            return redirect()->route('dynamic-fields.index', ['module' => $request->module])
                ->with('success', 'Campo dinámico actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar el campo: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DynamicField $dynamicField)
    {
        try {
            $module = $dynamicField->module;
            
            // Verificar si el campo tiene valores asociados
            $hasValues = $dynamicField->values()->exists();
            
            if ($hasValues) {
                return back()->withErrors(['error' => 'No se puede eliminar un campo que tiene valores asociados.']);
            }

            $dynamicField->delete();

            return redirect()->route('dynamic-fields.index', ['module' => $module])
                ->with('success', 'Campo dinámico eliminado exitosamente');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar el campo: ' . $e->getMessage()]);
        }
    }

    /**
     * Reordenar campos
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'fields' => 'required|array',
            'fields.*.id' => 'required|integer|exists:dynamic_fields,id',
            'fields.*.sort_order' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->fields as $fieldData) {
                DynamicField::where('id', $fieldData['id'])
                           ->update(['sort_order' => $fieldData['sort_order']]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Orden actualizado exitosamente']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al actualizar el orden']);
        }
    }

    /**
     * Duplicar campo
     */
    public function duplicate(DynamicField $dynamicField)
    {
        try {
            DB::beginTransaction();

            $newField = $dynamicField->replicate();
            $newField->name = $dynamicField->name . '_copy_' . time();
            $newField->label = $dynamicField->label . ' (Copia)';
            $newField->save();

            DB::commit();

            return redirect()->route('dynamic-fields.edit', $newField)
                ->with('success', 'Campo duplicado exitosamente. Puedes editarlo ahora.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al duplicar el campo: ' . $e->getMessage()]);
        }
    }

    /**
     * Obtener módulos disponibles del sistema
     */
    private function getAvailableModules(): array
    {
        return [
            'trabajadores' => 'Trabajadores',
            'usuarios' => 'Usuarios',
            'contratos' => 'Contratos',
            'productos' => 'Productos',
            'proveedores' => 'Proveedores',
            'inventarios' => 'Inventarios',
            'consumos' => 'Consumos',
            'pedidos' => 'Pedidos',
            'personas' => 'Personas',
            'menus' => 'Menús',
            'recetas' => 'Recetas',
            'clientes' => 'Clientes',
            'ventas' => 'Ventas',
            'compras' => 'Compras'
        ];
    }

    /**
     * Obtener tipos de campo disponibles
     */
    private function getFieldTypes(): array
    {
        return [
            'text' => 'Texto',
            'textarea' => 'Área de Texto',
            'number' => 'Número',
            'email' => 'Email',
            'password' => 'Contraseña',
            'date' => 'Fecha',
            'datetime' => 'Fecha y Hora',
            'time' => 'Hora',
            'select' => 'Lista Desplegable',
            'checkbox' => 'Casilla de Verificación',
            'radio' => 'Botones de Radio',
            'file' => 'Archivo',
            'image' => 'Imagen',
            'url' => 'URL',
            'tel' => 'Teléfono'
        ];
    }

    /**
     * Obtener la clase del modelo basado en el módulo
     */
    private function getModelClassForModule(string $module): string
    {
        $modelMapping = [
            'trabajadores' => 'App\\Models\\Trabajador',
            'usuarios' => 'App\\Models\\User',
            'contratos' => 'App\\Models\\Contrato',
            'productos' => 'App\\Models\\Producto',
            'proveedores' => 'App\\Models\\Proveedor',
            'inventarios' => 'App\\Models\\Inventario',
            'consumos' => 'App\\Models\\Consumo',
            'pedidos' => 'App\\Models\\Pedido',
            'personas' => 'App\\Models\\Persona',
            'menus' => 'App\\Models\\Menu',
            'recetas' => 'App\\Models\\Receta',
            'clientes' => 'App\\Models\\Cliente',
            'ventas' => 'App\\Models\\Venta',
            'compras' => 'App\\Models\\Compra'
        ];

        return $modelMapping[$module] ?? 'App\\Models\\' . ucfirst($module);
    }

    /**
     * Show the form builder interface
     */
    public function formBuilder()
    {
        return view('dynamic-fields.form-builder');
    }

    /**
     * Create multiple fields from form builder
     */
    public function bulkCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fields' => 'required|array|min:1',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.type' => 'required|string|in:text,textarea,number,email,password,date,datetime,time,select,checkbox,radio,file,image,url,tel',
            'fields.*.module' => 'required|string|max:255',
            'fields.*.placeholder' => 'nullable|string|max:255',
            'fields.*.default_value' => 'nullable|string',
            'fields.*.options' => 'nullable|array',
            'fields.*.options.*' => 'string|max:255',
            'fields.*.validation_rules' => 'nullable|array',
            'fields.*.group_id' => 'nullable|exists:dynamic_field_groups,id',
            'fields.*.sort_order' => 'nullable|integer|min:0',
            'fields.*.is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos de validación incorrectos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $createdFields = [];
            $fieldsData = $request->input('fields');

            foreach ($fieldsData as $fieldData) {
                // Verificar unicidad del nombre en el módulo
                $exists = DynamicField::where('module', $fieldData['module'])
                                      ->where('name', $fieldData['name'])
                                      ->exists();

                if ($exists) {
                    // Si ya existe, generar un nombre único
                    $counter = 1;
                    $originalName = $fieldData['name'];
                    
                    do {
                        $fieldData['name'] = $originalName . '_' . $counter;
                        $counter++;
                        
                        $exists = DynamicField::where('module', $fieldData['module'])
                                              ->where('name', $fieldData['name'])
                                              ->exists();
                    } while ($exists);
                }

                // Procesar opciones para select/radio
                if (in_array($fieldData['type'], ['select', 'radio']) && isset($fieldData['options'])) {
                    $fieldData['options'] = array_filter($fieldData['options'], function($option) {
                        return !empty(trim($option));
                    });
                    
                    if (empty($fieldData['options'])) {
                        $fieldData['options'] = ['Opción 1', 'Opción 2'];
                    }
                } else {
                    $fieldData['options'] = null;
                }

                // Procesar reglas de validación
                $validationRules = $fieldData['validation_rules'] ?? [];
                
                // Asegurar que la estructura sea correcta
                if (!is_array($validationRules)) {
                    $validationRules = [];
                }

                $fieldData['validation_rules'] = $validationRules;

                // Obtener el próximo sort_order si no se especifica
                if (!isset($fieldData['sort_order']) || $fieldData['sort_order'] === null) {
                    $maxOrder = DynamicField::where('module', $fieldData['module'])->max('sort_order') ?? 0;
                    $fieldData['sort_order'] = $maxOrder + 1;
                }

                // Crear el campo
                $field = DynamicField::create($fieldData);
                $createdFields[] = $field;

                // Invalidar caché para el módulo
                Cache::forget("dynamic_fields_{$fieldData['module']}");
                Cache::forget("dynamic_fields_all");
            }

            DB::commit();

            return response()->json([
                'message' => 'Campos creados exitosamente',
                'created' => count($createdFields),
                'fields' => collect($createdFields)->map(function($field) {
                    return [
                        'id' => $field->id,
                        'name' => $field->name,
                        'label' => $field->label,
                        'type' => $field->type,
                        'module' => $field->module
                    ];
                })->toArray()
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Error al crear los campos: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
