<?php

namespace App\Traits;

use App\Models\Kardex;
use Illuminate\Support\Facades\DB;

trait KardexTrait
{
    protected function registrarKardex($datos)
    {
        // Obtener el último registro de kardex para este producto
        $ultimoKardex = Kardex::where('producto_id', $datos['producto_id'])
            ->orderBy('id', 'desc')
            ->first();

        // Calcular saldo inicial
        $saldoInicial = $ultimoKardex ? $ultimoKardex->saldo_cantidad : 0;

        // Calcular el nuevo saldo
        $cantidadEntrada = $datos['cantidad_entrada'] ?? 0;
        $cantidadSalida = $datos['cantidad_salida'] ?? 0;
        $nuevoSaldo = $saldoInicial + $cantidadEntrada - $cantidadSalida;

        // Verificar stock suficiente para salidas
        if ($cantidadSalida > 0 && $nuevoSaldo < 0) {
            throw new \Exception("Stock insuficiente. Saldo actual: {$saldoInicial}, Cantidad a retirar: {$cantidadSalida}");
        }

        // Asegurar que el precio unitario no sea null
        $precioUnitario = $datos['precio_unitario'] ?? 0;

        // Calcular el nuevo saldo en valor monetario
        $saldoValor = $nuevoSaldo * $precioUnitario;

        // Crear el registro de kardex con los saldos calculados
        return Kardex::create(array_merge($datos, [
            'saldo_cantidad' => $nuevoSaldo,
            'saldo_valor' => $saldoValor,
            'precio_unitario' => $precioUnitario
        ]));
    }
}
