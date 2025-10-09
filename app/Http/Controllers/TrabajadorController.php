<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use App\Models\Persona;
use App\Models\Consumo;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Trabajador::query();

            // Búsqueda por texto
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('nombres', 'LIKE', "%{$search}%")
                      ->orWhere('apellidos', 'LIKE', "%{$search}%")
                      ->orWhere('dni', 'LIKE', "%{$search}%")
                      ->orWhere('area', 'LIKE', "%{$search}%")
                      ->orWhere('cargo', 'LIKE', "%{$search}%");
                });
            }

            // Filtro por área
            if ($request->filled('area')) {
                $query->where('area', $request->area);
            }

            // Filtro por estado
            if ($request->filled('estado')) {
                $query->where('estado', $request->estado);
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'created_at');
            $sortDir = $request->get('sort_dir', 'desc');
            $query->orderBy($sortBy, $sortDir);

            $trabajadores = $query->paginate(10)->withQueryString();

            // Obtener áreas únicas para el filtro
            $areas = Trabajador::distinct()->pluck('area')->filter()->sort();

            return view('trabajadores.index', compact('trabajadores', 'areas'));

        } catch (\Exception $e) {
            return response('<h1>Error: ' . $e->getMessage() . '</h1>');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener personas para el select
        $personas = \App\Models\Persona::all();

        return view('trabajadores.create', compact('personas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'codigo' => 'required|string|max:20|unique:trabajadores',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'dni' => 'required|string|size:8|unique:trabajadores',
            'area' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'estado' => 'required|in:Activo,Inactivo,Suspendido,Vacaciones',
            'persona_id' => 'nullable|exists:personas,id',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:Masculino,Femenino',
            'fecha_ingreso' => 'required|date',
            'salario' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Crear el trabajador
            $trabajador = Trabajador::create($data);

            // Si hay persona_id, actualizar el estado del contrato asociado
            if ($trabajador->persona_id) {
                $this->actualizarEstadoEnSistema($trabajador->persona_id, $trabajador->estado);
            }

            return redirect()->route('trabajadores.index')
                ->with('success', 'Trabajador creado exitosamente y estado actualizado en todo el sistema.');
        } catch (\Exception $e) {
            Log::error('Error al crear trabajador: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Error al crear el trabajador: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Trabajador $trabajador)
    {
        // Cargar relaciones si existen
        $trabajador->load('persona');

        return view('trabajadores.show', compact('trabajador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trabajador $trabajador)
    {
        // Obtener personas para el select
        $personas = \App\Models\Persona::all();

        return view('trabajadores.edit', compact('trabajador', 'personas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trabajador $trabajador)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|max:20|unique:trabajadores,codigo,' . $trabajador->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'dni' => 'required|string|size:8|unique:trabajadores,dni,' . $trabajador->id,
            'area' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'estado' => 'required|in:activo,inactivo',
            'persona_id' => 'nullable|exists:personas,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $trabajador->update($request->all());

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado exitosamente.');
    }

    /**
     * Buscar persona por DNI para autocompletar datos
     */
    public function buscarPersonaPorDni($dni)
    {
        try {
            $persona = \App\Models\Persona::where('numero_documento', $dni)
                ->whereIn('tipo_documento', ['DNI', 'dni'])
                ->first();

            if ($persona) {
                return response()->json([
                    'success' => true,
                    'persona' => [
                        'id' => $persona->id,
                        'nombres' => $persona->nombres,
                        'apellidos' => $persona->apellidos,
                        'fecha_nacimiento' => $persona->fecha_nacimiento,
                        'sexo' => $persona->sexo,
                        'direccion' => $persona->direccion,
                        'celular' => $persona->celular,
                        'correo' => $persona->correo,
                        'nacionalidad' => $persona->nacionalidad,
                        'estado_civil' => $persona->estado_civil,
                        'numero_documento' => $persona->numero_documento,
                        'nombre_completo' => $persona->nombre_completo
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró una persona con ese DNI'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar la persona: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trabajador $trabajador)
    {
        try {
            // Verificar si el trabajador tiene consumos asociados
            $consumosCount = $trabajador->consumos()->count();

            if ($consumosCount > 0) {
                return redirect()->route('trabajadores.index')
                    ->with('error', "No se puede eliminar el trabajador porque tiene {$consumosCount} consumos registrados. Primero elimine los consumos asociados.");
            }

            // Obtener el nombre antes de eliminar
            $nombreCompleto = $trabajador->nombres . ' ' . $trabajador->apellidos;

            // Intentar eliminar
            $deleted = $trabajador->delete();

            if ($deleted) {
                return redirect()->route('trabajadores.index')
                    ->with('success', "Trabajador {$nombreCompleto} eliminado exitosamente.");
            } else {
                return redirect()->route('trabajadores.index')
                    ->with('error', 'Error al eliminar el trabajador. Inténtelo nuevamente.');
            }

        } catch (\Exception $e) {
            Log::error('Error al eliminar trabajador: ' . $e->getMessage());

            return redirect()->route('trabajadores.index')
                ->with('error', 'Error al eliminar el trabajador: ' . $e->getMessage());
        }
    }

    /**
     * Buscar persona por número de documento
     */
    public function buscarPersonaPorDocumento(Request $request)
    {
        try {
            $numeroDocumento = $request->get('documento');

            Log::info('=== BÚSQUEDA PERSONA POR DOCUMENTO ===');
            Log::info('Request completo: ' . json_encode($request->all()));
            Log::info('Documento recibido: ' . $numeroDocumento);
            Log::info('Request headers: ' . json_encode($request->headers->all()));

            if (!$numeroDocumento) {
                Log::warning('Documento vacío o no proporcionado');
                return response()->json([
                    'success' => false,
                    'message' => 'Número de documento requerido'
                ], 400);
            }

            // Crear persona de prueba si es 12345678 y no existe
            if ($numeroDocumento === '12345678') {
                $personaExiste = Persona::where('numero_documento', '12345678')->first();
                if (!$personaExiste) {
                    Log::info('Creando persona de prueba...');
                    Persona::create([
                        'numero_documento' => '12345678',
                        'tipo_documento' => 'DNI',
                        'nombres' => 'Juan Carlos',
                        'apellidos' => 'Pérez López',
                        'fecha_nacimiento' => '1990-05-15',
                        'sexo' => 'M',
                        'direccion' => 'Av. Prueba 123',
                        'celular' => '987654321',
                        'correo' => 'juan.perez@ejemplo.com',
                        'nacionalidad' => 'Peruana',
                        'estado_civil' => 'Soltero'
                    ]);
                    Log::info('Persona de prueba creada exitosamente');
                }
            }

            // Buscar persona por número de documento
            $persona = Persona::where('numero_documento', $numeroDocumento)->first();

            Log::info('Persona encontrada: ' . ($persona ? 'SÍ (ID: ' . $persona->id . ')' : 'NO'));

            if (!$persona) {
                Log::info('Persona no encontrada con documento: ' . $numeroDocumento);
                return response()->json([
                    'success' => false,
                    'message' => 'Persona no encontrada con el documento: ' . $numeroDocumento
                ]);
            }

            // Verificar si ya tiene trabajador asociado
            $tieneTrabajador = Trabajador::where('persona_id', $persona->id)->exists();

            if ($tieneTrabajador) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta persona ya tiene un trabajador asociado',
                    'persona' => $persona
                ]);
            }

            // Buscar contrato activo si existe
            $contratoActivo = Contrato::where('persona_id', $persona->id)
                                   ->where('estado', 'activo')
                                   ->first();

            // Contar total de contratos
            $totalContratos = Contrato::where('persona_id', $persona->id)->count();

            return response()->json([
                'success' => true,
                'persona' => [
                    'id' => $persona->id,
                    'nombres' => $persona->nombres,
                    'apellidos' => $persona->apellidos,
                    'numero_documento' => $persona->numero_documento,
                    'tipo_documento' => $persona->tipo_documento,
                    'fecha_nacimiento' => $persona->fecha_nacimiento,
                    'sexo' => $persona->sexo,
                    'direccion' => $persona->direccion,
                    'celular' => $persona->celular,
                    'correo' => $persona->correo,
                    'nacionalidad' => $persona->nacionalidad,
                    'estado_civil' => $persona->estado_civil
                ],
                'contrato_activo' => $contratoActivo ? [
                    'id' => $contratoActivo->id,
                    'numero_contrato' => $contratoActivo->numero_contrato,
                    'cargo' => $contratoActivo->cargo,
                    'area_departamento' => $contratoActivo->area_departamento,
                    'salario_base' => $contratoActivo->salario_base,
                    'fecha_inicio' => $contratoActivo->fecha_inicio,
                    'fecha_fin' => $contratoActivo->fecha_fin,
                    'estado' => $contratoActivo->estado,
                    'modalidad' => $contratoActivo->modalidad,
                    'jornada_laboral' => $contratoActivo->jornada_laboral,
                    'departamento' => $contratoActivo->departamento
                ] : null,
                'tiene_contratos' => $totalContratos > 0,
                'total_contratos' => $totalContratos
            ]);

            Log::info('=== RESPUESTA EXITOSA ENVIADA ===');

        } catch (\Exception $e) {
            Log::error('=== ERROR EN BÚSQUEDA ===');
            Log::error('Error completo: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener contratos de un trabajador
     */
    public function obtenerContratos($trabajadorId)
    {
        try {
            $trabajador = Trabajador::with('persona.contratos')->findOrFail($trabajadorId);

            if (!$trabajador->persona) {
                return response()->json([
                    'success' => false,
                    'message' => 'El trabajador no tiene persona asociada'
                ], 404);
            }

            $contratos = $trabajador->persona->contratos->map(function($contrato) {
                return [
                    'id' => $contrato->id,
                    'numero_contrato' => $contrato->numero_contrato,
                    'tipo_contrato' => $contrato->tipo_contrato,
                    'cargo' => $contrato->cargo,
                    'area_departamento' => $contrato->area_departamento,
                    'salario_base' => $contrato->salario_base,
                    'fecha_inicio' => $contrato->fecha_inicio,
                    'fecha_fin' => $contrato->fecha_fin,
                    'estado' => $contrato->estado,
                    'modalidad' => $contrato->modalidad,
                    'fecha_inicio_formatted' => $contrato->fecha_inicio ? $contrato->fecha_inicio->format('d/m/Y') : null,
                    'fecha_fin_formatted' => $contrato->fecha_fin ? $contrato->fecha_fin->format('d/m/Y') : null,
                    'estado_badge' => $this->getEstadoBadge($contrato->estado),
                    'puede_descargar' => in_array($contrato->estado, ['activo', 'finalizado'])
                ];
            });

            return response()->json([
                'success' => true,
                'trabajador' => [
                    'id' => $trabajador->id,
                    'nombre_completo' => $trabajador->nombres . ' ' . $trabajador->apellidos,
                    'codigo' => $trabajador->codigo,
                    'cargo' => $trabajador->cargo,
                    'area' => $trabajador->area
                ],
                'persona' => [
                    'id' => $trabajador->persona->id,
                    'nombre_completo' => $trabajador->persona->nombres . ' ' . $trabajador->persona->apellidos,
                    'numero_documento' => $trabajador->persona->numero_documento
                ],
                'contratos' => $contratos,
                'total_contratos' => $contratos->count(),
                'contrato_activo' => $contratos->where('estado', 'activo')->first()
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener contratos: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los contratos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar solo el estado del trabajador y propagarlo al sistema
     */
    public function actualizarEstado(Request $request, Trabajador $trabajador)
    {
        $validator = Validator::make($request->all(), [
            'estado' => 'required|in:Activo,Inactivo,Suspendido,Vacaciones'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Estado inválido',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $estadoAnterior = $trabajador->estado;
            $nuevoEstado = $request->estado;

            // Actualizar el estado del trabajador
            $trabajador->update(['estado' => $nuevoEstado]);

            // Actualizar estado en todo el sistema si hay persona asociada
            $resultados = [];
            if ($trabajador->persona_id) {
                $resultados = $this->actualizarEstadoEnSistema($trabajador->persona_id, $nuevoEstado);
            }

            Log::info("Estado actualizado - Trabajador ID: {$trabajador->id}, Estado anterior: $estadoAnterior, Nuevo estado: $nuevoEstado");

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente en todo el sistema',
                'data' => [
                    'trabajador_id' => $trabajador->id,
                    'estado_anterior' => $estadoAnterior,
                    'estado_nuevo' => $nuevoEstado,
                    'contratos_actualizados' => $resultados['contratos_actualizados'] ?? 0,
                    'trabajadores_actualizados' => $resultados['trabajadores_actualizados'] ?? 0
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al actualizar estado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar estado en todo el sistema
     */
    private function actualizarEstadoEnSistema($personaId, $nuevoEstado)
    {
        try {
            Log::info("Actualizando estado en sistema - Persona ID: $personaId, Nuevo estado: $nuevoEstado");

            // Mapear estados de trabajador a estados de contrato
            $estadosContrato = [
                'Activo' => 'activo',
                'Inactivo' => 'finalizado',
                'Suspendido' => 'suspendido',
                'Vacaciones' => 'activo' // Mantener contrato activo durante vacaciones
            ];

            $estadoContrato = $estadosContrato[$nuevoEstado] ?? 'activo';

            // Actualizar contratos activos de la persona
            $contratosActualizados = Contrato::where('persona_id', $personaId)
                ->where('estado', 'activo')
                ->update(['estado' => $estadoContrato]);

            Log::info("Contratos actualizados: $contratosActualizados");

            // Si hay trabajadores existentes con la misma persona, actualizarlos también
            $trabajadoresActualizados = Trabajador::where('persona_id', $personaId)
                ->where('estado', '!=', $nuevoEstado)
                ->update(['estado' => $nuevoEstado]);

            Log::info("Trabajadores actualizados: $trabajadoresActualizados");

            return [
                'contratos_actualizados' => $contratosActualizados,
                'trabajadores_actualizados' => $trabajadoresActualizados
            ];

        } catch (\Exception $e) {
            Log::error('Error actualizando estado en sistema: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener badge HTML para el estado del contrato
     */
    private function getEstadoBadge($estado)
    {
        $badges = [
            'borrador' => '<span class="badge bg-secondary">Borrador</span>',
            'enviado' => '<span class="badge bg-warning">Enviado</span>',
            'activo' => '<span class="badge bg-success">Activo</span>',
            'finalizado' => '<span class="badge bg-danger">Finalizado</span>',
            'cancelado' => '<span class="badge bg-dark">Cancelado</span>'
        ];

        return $badges[$estado] ?? '<span class="badge bg-light text-dark">' . ucfirst($estado) . '</span>';
    }
}
