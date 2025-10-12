<?php

/**
 * Script de prueba para verificar detección de ingredientes
 * Ejecutar con: php test-regex-ingredientes.php
 */

// Texto de prueba con diferentes formatos
$textos = [
    "4 Piernas de Pollo\n2 Tazas de Arroz Blanco\n3 Tazas de Agua",
    "500 g tomate\n1 kg cebolla\n2 litros agua",
    "4 piernas pollo\n2 kg arroz\n1/2 taza arvejas",
    "½ Taza de Arvejas\n1 Cucharadita de Ajo Molido\n4 Cucharadas de Aceite",
];

// Dos regex: uno con "de" y otro sin "de"
$regex1 = '/(\d+[\.,]?\d*|½|⅓|¼|⅔|¾|1\/2|1\/3|1\/4|2\/3|3\/4)\s+([\wáéíóúñ\- ]+?)\s+de\s+([\wáéíóúñ\- ]+)/iu';
$regex2 = '/(\d+[\.,]?\d*|½|⅓|¼|⅔|¾|1\/2|1\/3|1\/4|2\/3|3\/4)\s+(kg|kilogramo|gramos?|g|litros?|l|ml|mililitros?|lb|oz)\s+([\wáéíóúñ\- ]+)/iu';

echo "=== PRUEBA DE DETECCIÓN DE INGREDIENTES ===\n\n";

foreach ($textos as $i => $texto) {
    echo "--- Prueba " . ($i + 1) . " ---\n";
    echo "Texto:\n$texto\n\n";

    // Probar regex 1 (con "de")
    preg_match_all($regex1, $texto, $matches1, PREG_SET_ORDER);
    echo "Patrón 1 (con 'de'): " . count($matches1) . " ingredientes\n";
    foreach ($matches1 as $j => $m) {
        echo "  " . ($j + 1) . ". Cantidad: {$m[1]}, Unidad: {$m[2]}, Nombre: " . trim($m[3]) . "\n";
    }

    // Probar regex 2 (sin "de")
    preg_match_all($regex2, $texto, $matches2, PREG_SET_ORDER);
    echo "\nPatrón 2 (sin 'de'): " . count($matches2) . " ingredientes\n";
    foreach ($matches2 as $j => $m) {
        echo "  " . ($j + 1) . ". Cantidad: {$m[1]}, Unidad: {$m[2]}, Nombre: " . trim($m[3]) . "\n";
    }

    echo "\n" . str_repeat("-", 50) . "\n\n";
}

echo "\n=== PRUEBA COMPLETADA ===\n";
