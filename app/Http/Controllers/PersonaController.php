<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        $query = Persona::with('trabajador');

        // Filtro de búsqueda
        if ($request->search) {
            $s = "%{$request->search}%";
            $query->where(function($q) use ($s) {
                $q->where('nombres', 'like', $s)
                  ->orWhere('apellidos', 'like', $s)
                  ->orWhere('numero_documento', 'like', $s);
            });
        }

        // Filtro de tipo de documento
        if ($request->tipo_documento) {
            $query->where('tipo_documento', $request->tipo_documento);
        }

        $personas = $query->orderBy('apellidos', 'asc')
            ->orderBy('nombres', 'asc')
            ->paginate(15)
            ->withQueryString();

        // Estadísticas
        $stats = [
            'con_trabajador' => Persona::whereHas('trabajador')->count(),
            'sin_trabajador' => Persona::whereDoesntHave('trabajador')->count(),
            'nuevas_mes' => Persona::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count()
        ];

        return view('personas.index', compact('personas', 'stats'));
    }

    public function create()
    {
        return view('personas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'tipo_documento' => 'required|in:dni,ce,pasaporte,otros,ruc',
            'numero_documento' => 'required|string|max:15|unique:personas,numero_documento',
            'fecha_nacimiento' => 'nullable|date|before:today|before_or_equal:' . date('Y-m-d', strtotime('-18 years')),
            'sexo' => 'nullable|in:M,F,O',
            'direccion' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:15|unique:personas,celular',
            'correo' => 'nullable|email|max:100|unique:personas,correo',
            'pais' => 'nullable|string|max:50',
            'estado_civil' => 'nullable|string|max:20',
        ]);

        $persona = Persona::create($data);

        // Si existe trabajador por DNI, enlazarlo
        if ($data['tipo_documento'] === 'dni') {
            $trab = Trabajador::where('dni', $persona->numero_documento)->first();
            if ($trab && !$trab->persona_id) {
                $trab->update(['persona_id' => $persona->id]);
            }
        }

        return redirect()->route('personas.index')->with('success', 'Persona creada exitosamente');
    }

    public function show(Persona $persona)
    {
        $persona->load('trabajador');
        return view('personas.show', compact('persona'));
    }

    public function edit(Persona $persona)
    {
        return view('personas.edit', compact('persona'));
    }

    public function update(Request $request, Persona $persona)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'tipo_documento' => 'required|in:dni,ce,pasaporte,otros,ruc',
            'numero_documento' => 'required|string|max:15|unique:personas,numero_documento,' . $persona->id,
            'fecha_nacimiento' => 'nullable|date|before:today|before_or_equal:' . date('Y-m-d', strtotime('-18 years')),
            'sexo' => 'nullable|in:M,F,O',
            'direccion' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:15|unique:personas,celular,' . $persona->id,
            'correo' => 'nullable|email|max:100|unique:personas,correo,' . $persona->id,
            'pais' => 'nullable|string|max:50',
            'estado_civil' => 'nullable|string|max:20',
        ]);

        $persona->update($data);

        // Si cambió el tipo o número de documento, verificar enlace con trabajador
        if ($data['tipo_documento'] === 'dni') {
            $trab = Trabajador::where('dni', $persona->numero_documento)->first();
            if ($trab && !$trab->persona_id) {
                $trab->update(['persona_id' => $persona->id]);
            }
        }

        return redirect()->route('personas.index')->with('success', 'Persona actualizada exitosamente');
    }

    public function destroy(Persona $persona)
    {
        // Verificar si tiene trabajador vinculado
        if ($persona->trabajador) {
            return redirect()->route('personas.index')
                ->with('error', 'No se puede eliminar la persona porque tiene un trabajador vinculado. Primero elimine o desvincule el trabajador.');
        }

        $nombreCompleto = $persona->nombres . ' ' . $persona->apellidos;
        $persona->delete();

        return redirect()->route('personas.index')
            ->with('success', "Persona {$nombreCompleto} eliminada exitosamente");
    }
}
