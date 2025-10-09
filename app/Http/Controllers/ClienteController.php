<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cliente::query();

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%")
                  ->orWhere('rut', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->get('tipo'));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->get('estado'));
        }

        $clientes = $query->with(['ventas' => function ($q) {
            $q->selectRaw('cliente_id, COUNT(*) as total_ventas, SUM(total) as total_comprado')
              ->groupBy('cliente_id');
        }])
        ->orderBy('nombre')
        ->paginate(15);

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:natural,juridica',
            'nombre' => 'required|string|max:255',
            'rut' => 'nullable|string|max:12|unique:clientes,rut',
            'email' => 'nullable|email|max:255|unique:clientes,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'ciudad' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:10',
            'giro' => 'nullable|string|max:255',
            'limite_credito' => 'nullable|numeric|min:0',
            'dias_credito' => 'nullable|integer|min:0|max:365',
            'observaciones' => 'nullable|string|max:1000',
            'estado' => 'required|in:activo,inactivo,suspendido'
        ]);

        $cliente = Cliente::create($validated);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load([
            'ventas' => function ($query) {
                $query->with('detalles.producto')
                      ->orderBy('fecha_venta', 'desc')
                      ->limit(10);
            }
        ]);

        // Estadísticas del cliente
        $estadisticas = [
            'total_ventas' => $cliente->ventas()->count(),
            'total_gastado' => $cliente->ventas()->sum('total'),
            'promedio_compra' => $cliente->ventas()->avg('total') ?? 0,
            'ultima_compra' => $cliente->ventas()->latest('fecha_venta')->value('fecha_venta'),
            'saldo_pendiente' => $cliente->ventas()
                ->where('estado_pago', '!=', 'pagado')
                ->sum('saldo_pendiente')
        ];

        return view('clientes.show', compact('cliente', 'estadisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:natural,juridica',
            'nombre' => 'required|string|max:255',
            'rut' => [
                'nullable',
                'string',
                'max:12',
                Rule::unique('clientes')->ignore($cliente->id)
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('clientes')->ignore($cliente->id)
            ],
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'ciudad' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:10',
            'giro' => 'nullable|string|max:255',
            'limite_credito' => 'nullable|numeric|min:0',
            'dias_credito' => 'nullable|integer|min:0|max:365',
            'observaciones' => 'nullable|string|max:1000',
            'estado' => 'required|in:activo,inactivo,suspendido'
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar si tiene ventas asociadas
        if ($cliente->ventas()->count() > 0) {
            return redirect()->route('clientes.index')
                ->with('error', 'No se puede eliminar el cliente porque tiene ventas asociadas.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Obtener estado de cuenta del cliente
     */
    public function estadoCuenta(Cliente $cliente)
    {
        $ventas = $cliente->ventas()
            ->with(['detalles.producto', 'pagos'])
            ->orderBy('fecha_venta', 'desc')
            ->paginate(20);

        $resumen = [
            'total_ventas' => $cliente->ventas()->sum('total'),
            'total_pagado' => $cliente->ventas()->sum('total_pagado'),
            'saldo_pendiente' => $cliente->ventas()->sum('saldo_pendiente'),
            'ventas_pendientes' => $cliente->ventas()->where('estado_pago', '!=', 'pagado')->count()
        ];

        return view('clientes.estado-cuenta', compact('cliente', 'ventas', 'resumen'));
    }
}
