<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\Kardex;

class ProductoApiController extends Controller
{
    /**
     * Obtener información básica de un producto para el formulario de kardex
     */
    public function info($id)
    {
        try {
            $producto = Producto::with('categoria')->findOrFail($id);

            // Obtener stock actual del inventario
            $inventario = Inventario::where('producto_id', $id)->first();
            $stockInventario = $inventario ? $inventario->stock_actual : 0;

            // Obtener último saldo del kardex de inventario
            $ultimoKardex = Kardex::where('producto_id', $id)
                                 ->where('modulo', 'inventario')
                                 ->orderBy('fecha', 'desc')
                                 ->orderBy('id', 'desc')
                                 ->first();

            $stockKardex = $ultimoKardex ? $ultimoKardex->saldo_cantidad : 0;

            // Usar el stock del kardex como prioritario
            $stock = $stockKardex > 0 ? $stockKardex : $stockInventario;

            return response()->json([
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'categoria' => $producto->categoria ? $producto->categoria->nombre : null,
                'precio' => $producto->precio,
                'stock' => $stock,
                'unidad' => $producto->unidad ?? 'Unidad',
                'descripcion' => $producto->descripcion,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Producto no encontrado'
            ], 404);
        }
    }
}
