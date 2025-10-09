<?php
require dirname(__DIR__) . '/vendor/autoload.php';
$path = dirname(__DIR__) . '/app/Models/Consumo.php';
echo "File exists: ", file_exists($path) ? "yes" : "no", PHP_EOL;
$code = file_get_contents($path);
echo "Bytes[0..60]: ", substr($code, 0, 60), PHP_EOL;
include $path;
$matches = [];
foreach (get_declared_classes() as $c) {
    if (strpos($c, 'App\\Models\\') === 0) { $matches[] = $c; }
}
echo "Declared App\\Models classes: ", implode(', ', $matches), PHP_EOL;
echo "class_exists(App\\Models\\Consumo): ", class_exists('App\\Models\\Consumo') ? 'yes' : 'no', PHP_EOL;
