
<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ContratoTemplateController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ConfigurationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta AJAX para analizar ingredientes de receta
Route::post('/recetas/analizar-ingredientes', [RecetaController::class, 'analizarIngredientes'])->name('recetas.analizarIngredientes');

Route::get('/', function () {
    // Verificación de depuración
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('modules.index');
});

Route::get('/modules', function () {
    return view('modules.index');
})->middleware(['auth'])->name('modules.index');

// Ruta de prueba para verificar que funciona
Route::get('/test', function () {
    return 'Laravel está funcionando correctamente';
});

// Ruta de debug para módulos
Route::get('/debug-modules', function () {
    return view('debug_modules');
})->middleware(['auth'])->name('debug.modules');

// Ruta temporal de debug para trabajadores
Route::get('/debug-trabajadores', function () {
    return view('debug_trabajadores');
});

// Rutas para Menus
Route::middleware(['auth'])->group(function () {
    Route::resource('menus', MenuController::class);
    Route::get('/menus/{menu}/consumir', [MenuController::class, 'consumir'])->name('menus.consumir');
    Route::post('/menus/{menu}/registrar-consumo', [MenuController::class, 'registrarConsumo'])->name('menus.registrar-consumo');
    Route::get('/menus/{menu}/disponibilidad', [MenuController::class, 'checkDisponibilidad'])->name('menus.disponibilidad');
})->middleware(['auth'])->name('debug.trabajadores');

// Ruta para verificar ingredientes de menús
Route::post('/menus/verificar-ingredientes', [MenuController::class, 'verificarIngredientes'])
    ->name('menus.verificar-ingredientes');

// Ruta para verificar permisos del usuario
Route::get('/test-permissions', function () {
    $user = Auth::user();

    if (!$user) {
        return "No hay usuario autenticado";
    }

    $info = "Usuario: " . $user->name . " (ID: " . $user->id . ")<br>";
    $info .= "Email: " . $user->email . "<br>";

    // Verificar si el usuario tiene permisos
    $info .= "Permiso 'ver-productos': " . ($user->can('ver-productos') ? 'SÍ' : 'NO') . "<br>";

    // Verificar todos los permisos del usuario
    if (method_exists($user, 'getAllPermissions')) {
        $permisos = $user->getAllPermissions();
        $info .= "Permisos del usuario:<br>";
        foreach ($permisos as $permiso) {
            $info .= "- " . $permiso->name . "<br>";
        }
    }

    // Verificar roles
    if (method_exists($user, 'getRoleNames')) {
        $roles = $user->getRoleNames();
        $info .= "Roles del usuario:<br>";
        foreach ($roles as $rol) {
            $info .= "- " . $rol . "<br>";
        }
    }

    return $info;
})->middleware('auth');

// Ruta de prueba para verificar el módulo de categorías
Route::get('/test-categorias', function () {
    return view('modules.test-categorias');
})->middleware('auth');

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // API Routes - Rutas independientes para evitar conflictos con route model binding
    Route::get('/api/personas/buscar-por-dni/{dni}', [TrabajadorController::class, 'buscarPersonaPorDni'])->name('trabajadores.buscar-persona');

    // Rutas específicas de trabajadores - DEBEN IR ANTES del resource route
    Route::prefix('trabajadores')->name('trabajadores.')->group(function () {
        Route::get('buscar-persona-documento', [TrabajadorController::class, 'buscarPersonaPorDocumento'])->name('buscar-persona-documento');
        Route::get('{trabajador}/contratos', [TrabajadorController::class, 'obtenerContratos'])->name('contratos');
        Route::post('{trabajador}/actualizar-estado', [TrabajadorController::class, 'actualizarEstado'])->name('actualizar-estado');
    });

    // Trabajadores - Resource routes (van después de las rutas específicas)
    Route::resource('trabajadores', TrabajadorController::class)->parameters([
        'trabajadores' => 'trabajador'
    ]);

    // Usuarios - Sistema de Gestión de Usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Ruta de debug para usuarios
    Route::get('usuarios/{id}/debug-delete', function($id) {
        $usuario = \App\Models\User::find($id);
        if (!$usuario) {
            return "Usuario con ID $id no encontrado";
        }
        return "Usuario encontrado: {$usuario->name} (ID: {$usuario->id})";
    })->name('usuarios.debug-delete');

    // Rutas adicionales para usuarios
    Route::prefix('usuarios')->group(function () {
        Route::get('persona-data', [UsuarioController::class, 'getPersonaData'])->name('usuarios.persona-data');
        Route::get('trabajador-data', [UsuarioController::class, 'getTrabajadorData'])->name('usuarios.trabajador-data');
        Route::post('{usuario}/reset-password', [UsuarioController::class, 'resetPassword'])->name('usuarios.reset-password');
        Route::post('{usuario}/enviar-credenciales', [UsuarioController::class, 'enviarCredenciales'])->name('usuarios.enviar-credenciales');
        Route::post('{usuario}/toggle', [UsuarioController::class, 'toggle'])->name('usuarios.toggle');
    });

    // Configuraciones del Sistema - Módulo de Administración de Configuraciones
    Route::middleware(['permission:ver-configuraciones'])->group(function () {
        Route::resource('configurations', ConfigurationController::class);

        // Rutas adicionales para configuraciones
        Route::prefix('configurations')->group(function () {
            Route::post('bulk-update', [ConfigurationController::class, 'bulkUpdate'])->name('configurations.bulk-update');
            Route::get('export', [ConfigurationController::class, 'export'])->name('configurations.export');
        });
    });

    // Gestión de Roles Avanzada - Módulo de Administración de Roles y Permisos
    Route::middleware(['permission:ver-configuraciones'])->group(function () {
        Route::resource('role-management', \App\Http\Controllers\RoleManagementController::class);

        // Rutas adicionales para gestión de roles
        Route::prefix('role-management')->group(function () {
            Route::get('matrix', [\App\Http\Controllers\RoleManagementController::class, 'matrix'])->name('role-management.matrix');
            Route::post('update-matrix', [\App\Http\Controllers\RoleManagementController::class, 'updateMatrix'])->name('role-management.update-matrix');
            Route::post('{role_management}/clone', [\App\Http\Controllers\RoleManagementController::class, 'clone'])->name('role-management.clone');
            Route::get('stats', [\App\Http\Controllers\RoleManagementController::class, 'stats'])->name('role-management.stats');
        });
    });

    // Campos Dinámicos - Sistema de Extensibilidad de Módulos
    Route::middleware(['permission:ver-configuraciones'])->group(function () {
        Route::resource('dynamic-fields', \App\Http\Controllers\DynamicFieldController::class);

        // Rutas adicionales para campos dinámicos
        Route::prefix('dynamic-fields')->group(function () {
            Route::get('form-builder', [\App\Http\Controllers\DynamicFieldController::class, 'formBuilder'])->name('dynamic-fields.form-builder');
            Route::post('bulk-create', [\App\Http\Controllers\DynamicFieldController::class, 'bulkCreate'])->name('dynamic-fields.bulk-create');
            Route::post('reorder', [\App\Http\Controllers\DynamicFieldController::class, 'reorder'])->name('dynamic-fields.reorder');
            Route::post('{dynamicField}/duplicate', [\App\Http\Controllers\DynamicFieldController::class, 'duplicate'])->name('dynamic-fields.duplicate');
        });
    });

    // Contratos - Sistema de Gestión de Contratos
    Route::resource('contratos', ContratoController::class);

    // Rutas adicionales para contratos
    Route::prefix('contratos')->group(function () {
        Route::get('por-vencer', [ContratoController::class, 'porVencer'])->name('contratos.por-vencer');
        Route::get('{contrato}/seleccionar-template', [ContratoController::class, 'seleccionarTemplate'])->name('contratos.seleccionar-template');
        Route::get('{contrato}/generar-pdf', [ContratoController::class, 'generarPdf'])->name('contratos.generar-pdf');
        Route::get('{contrato}/pdf', [ContratoController::class, 'generarPdf'])->name('contratos.pdf');
        Route::post('{contrato}/generar-pdf', [ContratoController::class, 'generarPdf'])->name('contratos.generar-pdf.post');
        Route::post('{contrato}/subir-firmado', [ContratoController::class, 'subirFirmado'])->name('contratos.subir-firmado');
        Route::post('{contrato}/activar', [ContratoController::class, 'activar'])->name('contratos.activar');
        Route::post('{contrato}/finalizar', [ContratoController::class, 'finalizar'])->name('contratos.finalizar');
        Route::get('persona-data', [ContratoController::class, 'getPersonaData'])->name('contratos.persona-data');
    });

    // Templates de Contratos (rutas independientes)
    Route::prefix('contratos-templates')->name('contratos.templates.')->group(function () {
        Route::get('/', [ContratoTemplateController::class, 'index'])->name('index');
        Route::get('create', [ContratoTemplateController::class, 'create'])->name('create');
        Route::post('/', [ContratoTemplateController::class, 'store'])->name('store');
        Route::get('{template}', [ContratoTemplateController::class, 'show'])->name('show');
        Route::get('{template}/edit', [ContratoTemplateController::class, 'edit'])->name('edit');
        Route::put('{template}', [ContratoTemplateController::class, 'update'])->name('update');
        Route::delete('{template}', [ContratoTemplateController::class, 'destroy'])->name('destroy');
        Route::get('{template}/preview', [ContratoTemplateController::class, 'preview'])->name('preview');
        Route::post('{template}/set-default', [ContratoTemplateController::class, 'setDefault'])->name('set-default');
    });

    // Generador de Plantillas
    Route::prefix('plantillas')->name('plantillas.')->group(function () {
        Route::get('generador', [App\Http\Controllers\PlantillaGeneradorController::class, 'index'])->name('generador');
        Route::post('generar', [App\Http\Controllers\PlantillaGeneradorController::class, 'generar'])->name('generar');
        Route::post('guardar', [App\Http\Controllers\PlantillaGeneradorController::class, 'guardar'])->name('guardar');
        Route::get('base', [App\Http\Controllers\PlantillaGeneradorController::class, 'plantillaBase'])->name('base');
    });    // Ruta de prueba para debug
    Route::get('/api/test-persona/{dni}', function($dni) {
        try {
            $persona = \App\Models\Persona::where('numero_documento', $dni)
                ->whereIn('tipo_documento', ['DNI', 'dni'])
                ->first();

            return response()->json([
                'success' => true,
                'found' => $persona ? true : false,
                'persona' => $persona ? $persona->toArray() : null,
                'debug' => [
                    'dni_buscado' => $dni,
                    'total_personas' => \App\Models\Persona::count(),
                    'personas_con_dni' => \App\Models\Persona::where('numero_documento', $dni)->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    });

    // Proveedores
    Route::resource('proveedores', ProveedorController::class)->middleware('permission:ver-proveedores');

    // Categorías
    Route::resource('categorias', CategoriaController::class);

    // Productos
    Route::resource('productos', ProductoController::class);

    // Inventarios
    Route::resource('inventarios', InventarioController::class)->middleware('permission:ver-inventario');
    Route::get('/inventarios/{id}/movimientos', [InventarioController::class, 'movimientos'])->name('inventarios.movimientos');
    Route::post('/inventarios/{id}/entrada', [InventarioController::class, 'entrada'])->name('inventarios.entrada');
    Route::post('/inventarios/{id}/salida', [InventarioController::class, 'salida'])->name('inventarios.salida');

    // Consumos
    Route::resource('consumos', ConsumoController::class);
    Route::get('/consumos-buscar-trabajador', [ConsumoController::class, 'buscarTrabajador'])->name('consumos.buscar-trabajador');
    Route::get('/consumos/registro-rapido', [ConsumoController::class, 'registroRapido'])->name('consumos.registro-rapido');

    // Pedidos
    Route::resource('pedidos', PedidoController::class);
    Route::patch('/pedidos/{pedido}/confirmar', [PedidoController::class, 'confirmar'])->name('pedidos.confirmar');
    Route::patch('/pedidos/{pedido}/entregar', [PedidoController::class, 'entregar'])->name('pedidos.entregar');

    // Kardex
    Route::prefix('kardex')->group(function () {
        Route::get('/', [KardexController::class, 'index'])->name('kardex.index');
        Route::get('/create', [KardexController::class, 'create'])->name('kardex.create');
        Route::post('/', [KardexController::class, 'store'])->name('kardex.store');
        Route::get('/producto/{producto}', [KardexController::class, 'porProducto'])->name('kardex.producto');
        Route::get('/reporte', [KardexController::class, 'reporte'])->name('kardex.reporte');
        Route::get('/producto/{producto}/export', [KardexController::class, 'exportarProducto'])->name('kardex.producto.export');
        Route::post('/transferir-consumos', [KardexController::class, 'transferirAConsumos'])->name('kardex.transferir-consumos');
    });

    // Personas
    Route::resource('personas', PersonaController::class);

    // Menús - Sistema de Gestión de Menús
    Route::resource('menus', MenuController::class);

    // Rutas adicionales para el sistema de gestión de menús
    Route::prefix('menus')->group(function () {
        Route::post('{menu}/generar-automatico', [MenuController::class, 'generarAutomatico'])->name('menus.generar-automatico');
        Route::get('{menu}/verificar-disponibilidad', [MenuController::class, 'verificarDisponibilidad'])->name('menus.verificar-disponibilidad');
        Route::post('{menu}/clonar', [MenuController::class, 'clonar'])->name('menus.clonar');
        Route::get('{menu}/exportar-pdf', [MenuController::class, 'exportarPDF'])->name('menus.exportar-pdf');
        Route::patch('{menu}/activar', [MenuController::class, 'activar'])->name('menus.activar');
        Route::patch('{menu}/completar', [MenuController::class, 'completar'])->name('menus.completar');
        Route::patch('{menu}/publicar', [MenuController::class, 'publicar'])->name('menus.publicar');
    });

    // Recetas - Sistema de Gestión de Recetas
    Route::resource('recetas', RecetaController::class);

    // Rutas adicionales para recetas
    Route::prefix('recetas')->group(function () {
        Route::post('{receta}/clonar', [RecetaController::class, 'clonar'])->name('recetas.clonar');
        Route::post('{receta}/calcular-costo', [RecetaController::class, 'calcularCosto'])->name('recetas.calcular-costo');
        Route::get('{receta}/verificar-disponibilidad', [RecetaController::class, 'verificarDisponibilidad'])->name('recetas.verificar-disponibilidad');
    });

    // Condiciones de Salud
    Route::resource('condiciones-salud', \App\Http\Controllers\CondicionSaludController::class)->middleware('permission:ver-inventario');

    // Reportes
    Route::prefix('reportes')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/consumos', [ReporteController::class, 'consumos'])->name('reportes.consumos');
        Route::get('/inventario', [ReporteController::class, 'inventario'])->name('reportes.inventario');
        Route::get('/proveedores', [ReporteController::class, 'proveedores'])->name('reportes.proveedores');
        Route::get('/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');

        // Exportaciones
        Route::get('/consumos/excel', [ReporteController::class, 'exportarConsumosExcel'])->name('reportes.consumos.excel');
        Route::get('/consumos/pdf', [ReporteController::class, 'exportarConsumosPdf'])->name('reportes.consumos.pdf');
        Route::get('/inventario/excel', [ReporteController::class, 'exportarInventarioExcel'])->name('reportes.inventario.excel');
        Route::get('/inventario/pdf', [ReporteController::class, 'exportarInventarioPdf'])->name('reportes.inventario.pdf');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta temporal para reparar base de datos
    Route::get('/fix-database', function() {
        try {
            require_once base_path('fix_database.php');
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    });

    // Ruta directa para reparar base de datos (método directo)
    Route::get('/repair-db', function() {
        $output = '';
        try {
            ob_start();
            require_once base_path('repair_db_direct.php');
            $output = ob_get_clean();
            return '<pre>' . $output . '</pre>';
        } catch (Exception $e) {
            return '<pre>Error: ' . $e->getMessage() . '</pre>';
        }
    });

    // Ruta simple para reparar base de datos
    Route::get('/simple-repair', function() {
        $output = '';
        try {
            ob_start();
            require_once base_path('simple_repair.php');
            $output = ob_get_clean();
            return '<pre>' . $output . '</pre>';
        } catch (Exception $e) {
            return '<pre>Error: ' . $e->getMessage() . '</pre>';
        }
    });

    // Ruta de debug para pedidos
    Route::get('/debug-pedidos', function() {
        return view('debug_pedidos');
    })->name('debug.pedidos');

    // Clientes - Módulo de Gestión de Clientes
    Route::resource('clientes', ClienteController::class);
    Route::get('/clientes/{cliente}/estado-cuenta', [ClienteController::class, 'estadoCuenta'])->name('clientes.estado-cuenta');

    // Ventas - Módulo de Gestión de Ventas
    Route::resource('ventas', VentaController::class);
    Route::post('/ventas/{venta}/confirmar', [VentaController::class, 'confirmar'])->name('ventas.confirmar');

    // Compras - Módulo de Gestión de Compras
    Route::resource('compras', CompraController::class);
    Route::post('/compras/{compra}/enviar', [CompraController::class, 'enviar'])->name('compras.enviar');
    Route::post('/compras/{compra}/recibir', [CompraController::class, 'recibir'])->name('compras.recibir');
});

require __DIR__.'/auth.php';
