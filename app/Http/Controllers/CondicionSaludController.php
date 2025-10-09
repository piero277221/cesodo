<?php

namespace App\Http\Controllers;

use App\Models\CondicionSalud;
use App\Models\Producto;
use Illuminate\Http\Request;

class CondicionSaludController extends Controller
{
    public function index()
    {
        $condiciones = CondicionSalud::with('productosRestringidos')->paginate(15);
        return view('condiciones-salud.index', compact('condiciones'));
    }

    public function create()
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('condiciones-salud.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:condiciones_salud',
            'descripcion' => 'nullable|string',
            'restricciones_alimentarias' => 'nullable|array',
            'restricciones_alimentarias.*' => 'exists:productos,id',
            'activo' => 'boolean',
        ]);

        CondicionSalud::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'restricciones_alimentarias' => $request->restricciones_alimentarias ?? [],
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('condiciones-salud.index')
            ->with('success', 'Condición de salud creada exitosamente');
    }

    public function show(CondicionSalud $condicionesSalud)
    {
        $condicionesSalud->load('productosRestringidos');
        return view('condiciones-salud.show', compact('condicionesSalud'));
    }

    public function edit(CondicionSalud $condicionesSalud)
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('condiciones-salud.edit', compact('condicionesSalud', 'productos'));
    }

    public function update(Request $request, CondicionSalud $condicionesSalud)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:condiciones_salud,nombre,' . $condicionesSalud->id,
            'descripcion' => 'nullable|string',
            'restricciones_alimentarias' => 'nullable|array',
            'restricciones_alimentarias.*' => 'exists:productos,id',
            'activo' => 'boolean',
        ]);

        $condicionesSalud->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'restricciones_alimentarias' => $request->restricciones_alimentarias ?? [],
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('condiciones-salud.index')
            ->with('success', 'Condición de salud actualizada exitosamente');
    }

    public function destroy(CondicionSalud $condicionesSalud)
    {
        $condicionesSalud->delete();
        return redirect()->route('condiciones-salud.index')
            ->with('success', 'Condición de salud eliminada exitosamente');
    }
}
