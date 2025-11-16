@php
    echo "<h1 style='font-family: Arial;'>🔍 Diagnóstico del Sistema CESODO</h1>";
    echo "<hr>";
    
    // 1. Verificar URL base
    echo "<h2>1️⃣ Configuración de URL</h2>";
    echo "<p><strong>APP_URL:</strong> " . config('app.url') . "</p>";
    echo "<p><strong>URL Actual:</strong> " . url()->current() . "</p>";
    echo "<p><strong>Base Path:</strong> " . base_path() . "</p>";
    echo "<hr>";
    
    // 2. Verificar autenticación
    echo "<h2>2️⃣ Estado de Autenticación</h2>";
    if (Auth::check()) {
        $user = Auth::user();
        echo "<p style='color: green;'>✅ Usuario autenticado</p>";
        echo "<p><strong>ID:</strong> " . $user->id . "</p>";
        echo "<p><strong>Nombre:</strong> " . $user->name . "</p>";
        echo "<p><strong>Email:</strong> " . $user->email . "</p>";
        
        // Verificar roles
        if (method_exists($user, 'getRoleNames')) {
            $roles = $user->getRoleNames();
            echo "<p><strong>Roles:</strong> " . ($roles->count() > 0 ? $roles->implode(', ') : 'Sin roles') . "</p>";
        }
        
        // Verificar permisos
        if (method_exists($user, 'getAllPermissions')) {
            $permisos = $user->getAllPermissions();
            echo "<p><strong>Total de permisos:</strong> " . $permisos->count() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Usuario NO autenticado</p>";
        echo "<p><a href='" . route('login') . "'>Ir a Login</a></p>";
    }
    echo "<hr>";
    
    // 3. Verificar rutas
    echo "<h2>3️⃣ Rutas Disponibles (Contratos)</h2>";
    $routes = Route::getRoutes();
    $contratoRoutes = [];
    foreach ($routes as $route) {
        if (str_contains($route->uri(), 'contratos')) {
            $contratoRoutes[] = [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName()
            ];
        }
    }
    
    if (!empty($contratoRoutes)) {
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%; font-family: Arial; font-size: 12px;'>";
        echo "<tr style='background: #333; color: white;'><th>Método</th><th>URI</th><th>Nombre</th></tr>";
        foreach ($contratoRoutes as $r) {
            echo "<tr>";
            echo "<td>" . $r['method'] . "</td>";
            echo "<td><strong>" . $r['uri'] . "</strong></td>";
            echo "<td>" . ($r['name'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>❌ No se encontraron rutas de contratos</p>";
    }
    echo "<hr>";
    
    // 4. Verificar controlador
    echo "<h2>4️⃣ Verificar Controlador</h2>";
    if (class_exists('App\Http\Controllers\ContratoController')) {
        echo "<p style='color: green;'>✅ ContratoController existe</p>";
        
        $controller = new ReflectionClass('App\Http\Controllers\ContratoController');
        $methods = $controller->getMethods(ReflectionMethod::IS_PUBLIC);
        
        echo "<p><strong>Métodos públicos:</strong></p>";
        echo "<ul>";
        foreach ($methods as $method) {
            if ($method->class === 'App\Http\Controllers\ContratoController') {
                echo "<li>" . $method->name . "</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>❌ ContratoController NO existe</p>";
    }
    echo "<hr>";
    
    // 5. Verificar conexión a BD
    echo "<h2>5️⃣ Conexión a Base de Datos</h2>";
    try {
        DB::connection()->getPdo();
        echo "<p style='color: green;'>✅ Conexión exitosa</p>";
        echo "<p><strong>Driver:</strong> " . DB::connection()->getDriverName() . "</p>";
        echo "<p><strong>Database:</strong> " . DB::connection()->getDatabaseName() . "</p>";
        
        // Contar contratos
        $totalContratos = DB::table('contratos')->count();
        echo "<p><strong>Total de contratos en BD:</strong> " . $totalContratos . "</p>";
    } catch (\Exception $e) {
        echo "<p style='color: red;'>❌ Error de conexión: " . $e->getMessage() . "</p>";
    }
    echo "<hr>";
    
    // 6. Generar URLs de prueba
    echo "<h2>6️⃣ URLs de Prueba</h2>";
    try {
        echo "<p><strong>URL Dashboard:</strong> <a href='" . route('dashboard') . "'>" . route('dashboard') . "</a></p>";
        echo "<p><strong>URL Contratos:</strong> <a href='" . route('contratos.index') . "'>" . route('contratos.index') . "</a></p>";
        echo "<p><strong>URL Contratos (manual):</strong> <a href='" . url('contratos') . "'>" . url('contratos') . "</a></p>";
    } catch (\Exception $e) {
        echo "<p style='color: red;'>❌ Error generando URLs: " . $e->getMessage() . "</p>";
    }
    echo "<hr>";
    
    // 7. Verificar .htaccess
    echo "<h2>7️⃣ Configuración Apache</h2>";
    if (file_exists(public_path('.htaccess'))) {
        echo "<p style='color: green;'>✅ Archivo .htaccess existe</p>";
        $htaccess = file_get_contents(public_path('.htaccess'));
        if (str_contains($htaccess, 'mod_rewrite')) {
            echo "<p style='color: green;'>✅ mod_rewrite configurado</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Archivo .htaccess NO existe</p>";
    }
    
    echo "<hr>";
    echo "<p style='text-align: center; color: #666;'><em>Diagnóstico generado: " . now() . "</em></p>";
@endphp
