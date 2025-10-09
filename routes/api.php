<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConsumoApiController;
use App\Http\Controllers\Api\InventarioApiController;
use App\Http\Controllers\Api\TrabajadorApiController;
use App\Http\Controllers\Api\ProductoApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas API para exportación de datos
Route::middleware('auth:sanctum')->group(function () {

    // API de Productos (para kardex)
    Route::prefix('productos')->group(function () {
        Route::get('/{id}/info', [ProductoApiController::class, 'info']);
    });

    // API de Consumos
    Route::prefix('consumos')->group(function () {
        Route::get('/', [ConsumoApiController::class, 'index']);
        Route::get('/{id}', [ConsumoApiController::class, 'show']);
        Route::get('/trabajador/{trabajadorId}', [ConsumoApiController::class, 'porTrabajador']);
        Route::get('/fecha/{fecha}', [ConsumoApiController::class, 'porFecha']);
        Route::get('/rango/{fechaInicio}/{fechaFin}', [ConsumoApiController::class, 'porRango']);
    });

    // API de Inventario
    Route::prefix('inventario')->group(function () {
        Route::get('/', [InventarioApiController::class, 'index']);
        Route::get('/stock-bajo', [InventarioApiController::class, 'stockBajo']);
        Route::get('/proximos-vencer', [InventarioApiController::class, 'proximosVencer']);
        Route::get('/movimientos/{productoId}', [InventarioApiController::class, 'movimientos']);
    });

    // API de Trabajadores
    Route::prefix('trabajadores')->group(function () {
        Route::get('/', [TrabajadorApiController::class, 'index']);
        Route::get('/buscar/{codigo}', [TrabajadorApiController::class, 'buscarPorCodigo']);
        Route::get('/{id}/consumos', [TrabajadorApiController::class, 'consumos']);
    });

    // Estadísticas para Dashboard
    Route::prefix('estadisticas')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json([
                'consumos_hoy' => \App\Models\Consumo::whereDate('fecha_consumo', today())->count(),
                'trabajadores_activos' => \App\Models\Trabajador::where('estado', 'activo')->count(),
                'productos_stock_bajo' => \App\Models\Producto::stockBajo()->count(),
                'pedidos_pendientes' => \App\Models\Pedido::where('estado', 'pendiente')->count(),
            ]);
        });
    });
});
