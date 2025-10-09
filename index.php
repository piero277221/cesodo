<?php
// Front Controller para manejar todas las rutas de Laravel
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Remover el prefijo /scm-cesodo si existe
$path = str_replace('/scm-cesodo', '', $path);

// Si es la raíz, redirigir al public
if ($path === '/' || $path === '') {
    header('Location: /scm-cesodo/public/');
    exit();
}

// Si es una ruta de Laravel (como /pedidos), redirigir al public con index.php
if (in_array($path, ['/pedidos', '/trabajadores', '/proveedores', '/productos', '/inventarios', '/consumos', '/dashboard', '/login', '/register', '/auto-login'])) {
    header('Location: /scm-cesodo/public/index.php' . $path);
    exit();
}

// Para cualquier otra ruta, intentar servir desde public
header('Location: /scm-cesodo/public' . $path);
exit();
?>
