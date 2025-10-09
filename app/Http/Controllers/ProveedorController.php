<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Proveedor::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ruc', 'LIKE', "%{$search}%")
                  ->orWhere('razon_social', 'LIKE', "%{$search}%")
                  ->orWhere('nombre_comercial', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $proveedores = $query->orderBy('razon_social')->paginate(15);

        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruc' => 'required|string|max:11|unique:proveedores,ruc',
            'razon_social' => 'required|string|max:255',
            'nombre_comercial' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'contacto' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Proveedor::create($validated);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        $proveedor->load(['pedidos' => function($query) {
            $query->latest()->limit(10);
        }]);

        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'ruc' => 'required|string|max:11|unique:proveedores,ruc,' . $proveedor->id,
            'razon_social' => 'required|string|max:255',
            'nombre_comercial' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'contacto' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $proveedor->update($validated);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        try {
            // Verificar si tiene pedidos asociados
            if ($proveedor->pedidos()->count() > 0) {
                return redirect()->route('proveedores.index')
                    ->with('error', 'No se puede eliminar el proveedor porque tiene pedidos asociados.');
            }

            $proveedor->delete();

            return redirect()->route('proveedores.index')
                ->with('success', 'Proveedor eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('proveedores.index')
                ->with('error', 'Error al eliminar el proveedor: ' . $e->getMessage());
        }
    }
}
