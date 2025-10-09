<?php

// Script to convert all views from @extends('layouts.app') to <x-app-layout>

$viewsDir = __DIR__ . '/resources/views';
$excludeFiles = ['personas/index.blade.php', 'personas/create.blade.php', 'personas/edit.blade.php', 'menus/index.blade.php', 'menus/create.blade.php'];

function processDirectory($dir, $excludeFiles = []) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $relativePath = str_replace(__DIR__ . '/resources/views/', '', $file->getPathname());
            $relativePath = str_replace('\\', '/', $relativePath);

            if (in_array($relativePath, $excludeFiles)) {
                continue;
            }

            $content = file_get_contents($file->getPathname());

            // Skip if already using component syntax
            if (strpos($content, '<x-app-layout>') !== false) {
                continue;
            }

            // Skip if not using @extends('layouts.app')
            if (strpos($content, "@extends('layouts.app')") === false) {
                continue;
            }

            echo "Processing: " . $relativePath . "\n";

            // Replace @extends and @section with component syntax
            $content = preg_replace("/^@extends\('layouts\.app'\)\s*\n/m", "", $content);
            $content = preg_replace("/^@section\('title',\s*'([^']+)'\)\s*\n/m", "", $content);
            $content = preg_replace("/^@section\('content'\)\s*\n/m", "", $content);
            $content = preg_replace("/\n@endsection\s*$/", "", $content);

            // Add component wrapper
            $header = '<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ' . ucfirst(basename(dirname($file->getPathname()))) . '
        </h2>
    </x-slot>

';
            $footer = '
</x-app-layout>';

            $content = $header . $content . $footer;

            file_put_contents($file->getPathname(), $content);
        }
    }
}

processDirectory($viewsDir, $excludeFiles);
echo "Views conversion completed!\n";
