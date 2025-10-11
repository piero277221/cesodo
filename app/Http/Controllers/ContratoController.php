<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\ContratoTemplate;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contrato::with(['persona', 'creadoPor', 'aprobadoPor']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_contrato')) {
            $query->where('tipo_contrato', $request->tipo_contrato);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('numero_contrato', 'like', "%{$buscar}%")
                  ->orWhere('cargo', 'like', "%{$buscar}%")
                  ->orWhereHas('persona', function ($query) use ($buscar) {
                      $query->where('nombres', 'like', "%{$buscar}%")
                            ->orWhere('apellidos', 'like', "%{$buscar}%")
                            ->orWhere('numero_documento', 'like', "%{$buscar}%");
                  });
            });
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_fin', '<=', $request->fecha_fin);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $contratos = $query->paginate(15)->withQueryString();

        // Estadísticas para el dashboard
        $estadisticas = [
            'total' => Contrato::count(),
            'activos' => Contrato::where('estado', 'activo')->count(),
            'pendientes_firma' => Contrato::where('estado', 'pendiente_firma')->count(),
            'por_vencer' => Contrato::where('estado', 'activo')
                                    ->whereNotNull('fecha_fin')
                                    ->whereBetween('fecha_fin', [now(), now()->addDays(30)])
                                    ->count(),
            'borradores' => Contrato::where('estado', 'borrador')->count()
        ];

        return view('contratos.index', compact('contratos', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $personas = Persona::orderBy('nombres')->orderBy('apellidos')->get();
        $tipos_contrato = [
            'indefinido' => 'Contrato Indefinido',
            'plazo_fijo' => 'Contrato a Plazo Fijo',
            'proyecto' => 'Contrato por Proyecto',
            'practicas' => 'Contrato de Prácticas',
            'temporal' => 'Contrato Temporal',
            'consultoria' => 'Contrato de Consultoría'
        ];
        $modalidades = [
            'presencial' => 'Presencial',
            'remoto' => 'Remoto',
            'hibrido' => 'Híbrido'
        ];
        $tipos_pago = [
            'mensual' => 'Mensual',
            'quincenal' => 'Quincenal',
            'semanal' => 'Semanal'
        ];

        // Agregar listas de cargos y áreas desde trabajadores
        $cargos = [
            'Gerente',
            'Jefe de Área',
            'Supervisor',
            'Analista',
            'Asistente',
            'Operario',
            'Técnico',
            'Especialista',
            'Coordinador',
            'Auxiliar'
        ];

        $areas = [
            'Administración',
            'Recursos Humanos',
            'Finanzas',
            'Operaciones',
            'Ventas',
            'Marketing',
            'Tecnología',
            'Logística',
            'Calidad',
            'Seguridad'
        ];

        return view('contratos.create', compact('personas', 'tipos_contrato', 'modalidades', 'tipos_pago', 'cargos', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'tipo_contrato' => 'required|string|in:temporal,obra_labor,aprendizaje,prestacion_servicios',
            'numero_contrato' => 'nullable|string|unique:contratos,numero_contrato',
            'cargo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'salario' => 'required|numeric|min:0',
            'jornada_laboral' => 'required|string',
            'departamento' => 'nullable|string|max:255',
            'lugar_trabajo' => 'nullable|string|max:500',
            'clausulas_especiales' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'archivo_contrato' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB
            'documentos_adjuntos.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
        ]);

        DB::beginTransaction();

        try {
            // Prepare data for the contract
            $contratoData = $request->all();

            // Map form fields to database fields
            if (isset($contratoData['salario'])) {
                $contratoData['salario_base'] = $contratoData['salario'];
                unset($contratoData['salario']);
            }

            // Map department field
            if (isset($contratoData['departamento'])) {
                $contratoData['area_departamento'] = $contratoData['departamento'];
            }

            // Set default values for fields not in the form
            $contratoData['modalidad'] = $contratoData['modalidad'] ?? 'presencial';
            $contratoData['moneda'] = $contratoData['moneda'] ?? 'PEN';
            $contratoData['tipo_pago'] = $contratoData['tipo_pago'] ?? 'mensual';

            // SIEMPRE generar número de contrato automáticamente (ignorar cualquier valor enviado)
            $contratoData['numero_contrato'] = $this->generarNumeroContratoUnico();

            $contrato = new Contrato($contratoData);
            $contrato->creado_por = Auth::id();

            // Subir archivos si existen
            if ($request->hasFile('archivo_contrato')) {
                $contrato->archivo_contrato = $request->file('archivo_contrato')
                    ->store('contratos/originales', 'public');
            }

            if ($request->hasFile('documentos_adjuntos')) {
                $documentos = [];
                foreach ($request->file('documentos_adjuntos') as $archivo) {
                    $documentos[] = $archivo->store('contratos/anexos', 'public');
                }
                $contrato->documentos_adjuntos = $documentos;
            }

            $contrato->save();

            DB::commit();

            return redirect()->route('contratos.show', $contrato)
                           ->with('success', 'Contrato creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()
                        ->with('error', 'Error al crear el contrato: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contrato $contrato)
    {
        $contrato->load(['persona', 'creadoPor', 'aprobadoPor']);

        return view('contratos.show', compact('contrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contrato $contrato)
    {
        if (!$contrato->puedeEditarse()) {
            return redirect()->route('contratos.show', $contrato)
                           ->with('error', 'No se puede editar un contrato en estado: ' . $contrato->estado_texto);
        }

        $personas = Persona::orderBy('nombres')->orderBy('apellidos')->get();
        $tipos_contrato = [
            'indefinido' => 'Contrato Indefinido',
            'plazo_fijo' => 'Contrato a Plazo Fijo',
            'proyecto' => 'Contrato por Proyecto',
            'practicas' => 'Contrato de Prácticas',
            'temporal' => 'Contrato Temporal',
            'consultoria' => 'Contrato de Consultoría'
        ];
        $modalidades = [
            'presencial' => 'Presencial',
            'remoto' => 'Remoto',
            'hibrido' => 'Híbrido'
        ];
        $tipos_pago = [
            'mensual' => 'Mensual',
            'quincenal' => 'Quincenal',
            'semanal' => 'Semanal'
        ];

        // Agregar listas de cargos y áreas desde trabajadores
        $cargos = [
            'Gerente',
            'Jefe de Área',
            'Supervisor',
            'Analista',
            'Asistente',
            'Operario',
            'Técnico',
            'Especialista',
            'Coordinador',
            'Auxiliar'
        ];

        $areas = [
            'Administración',
            'Recursos Humanos',
            'Finanzas',
            'Operaciones',
            'Ventas',
            'Marketing',
            'Tecnología',
            'Logística',
            'Calidad',
            'Seguridad'
        ];

        return view('contratos.edit', compact('contrato', 'personas', 'tipos_contrato', 'modalidades', 'tipos_pago', 'cargos', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contrato $contrato)
    {
        if (!$contrato->puedeEditarse()) {
            return redirect()->route('contratos.show', $contrato)
                           ->with('error', 'No se puede editar un contrato en estado: ' . $contrato->estado_texto);
        }

        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'tipo_contrato' => 'required|string',
            'cargo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'salario' => 'required|numeric|min:0',
            'bonificaciones' => 'nullable|numeric|min:0',
            'descuentos' => 'nullable|numeric|min:0',
            'jornada_laboral' => 'required|string',
            'departamento' => 'nullable|string|max:255',
            'lugar_trabajo' => 'nullable|string|max:255',
            'clausulas_especiales' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'archivo_contrato' => 'nullable|file|mimes:pdf|max:10240',
            'archivo_anexos' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        DB::beginTransaction();

        try {
            // Prepare data for the contract update
            $contratoData = $request->all();

            // Map form fields to database fields
            if (isset($contratoData['salario'])) {
                $contratoData['salario_base'] = $contratoData['salario'];
                unset($contratoData['salario']); // Remove the form field to avoid SQL errors
            }

            // Map department field
            if (isset($contratoData['departamento'])) {
                $contratoData['area_departamento'] = $contratoData['departamento'];
            }

            // Set default values for fields not in the form (maintain existing values if not provided)
            $contratoData['modalidad'] = $contratoData['modalidad'] ?? $contrato->modalidad ?? 'presencial';
            $contratoData['moneda'] = $contratoData['moneda'] ?? $contrato->moneda ?? 'PEN';
            $contratoData['tipo_pago'] = $contratoData['tipo_pago'] ?? $contrato->tipo_pago ?? 'mensual';

            $contrato->fill($contratoData);            // Manejar archivos
            if ($request->hasFile('archivo_contrato')) {
                // Eliminar archivo anterior si existe
                if ($contrato->archivo_contrato && Storage::disk('public')->exists($contrato->archivo_contrato)) {
                    Storage::disk('public')->delete($contrato->archivo_contrato);
                }

                $contrato->archivo_contrato = $request->file('archivo_contrato')
                    ->store('contratos/originales', 'public');
            }

            if ($request->hasFile('archivo_anexos')) {
                // Eliminar archivo anterior si existe
                if ($contrato->archivo_anexos && Storage::disk('public')->exists($contrato->archivo_anexos)) {
                    Storage::disk('public')->delete($contrato->archivo_anexos);
                }

                $contrato->archivo_anexos = $request->file('archivo_anexos')
                    ->store('contratos/anexos', 'public');
            }

            $contrato->save();

            DB::commit();

            return redirect()->route('contratos.show', $contrato)
                           ->with('success', 'Contrato actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()
                        ->with('error', 'Error al actualizar el contrato: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contrato $contrato)
    {
        if ($contrato->estado === 'activo') {
            return back()->with('error', 'No se puede eliminar un contrato activo.');
        }

        try {
            $contrato->delete();

            return redirect()->route('contratos.index')
                           ->with('success', 'Contrato eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el contrato: ' . $e->getMessage());
        }
    }

    /**
     * Generar PDF del contrato usando template personalizado
     */
    public function generarPdf(Contrato $contrato, Request $request)
    {
        try {
            $contrato->load('persona');

            // Configurar Carbon para español
            \Carbon\Carbon::setLocale('es');

            // Obtener template a usar
            $templateId = $request->get('template_id');

            if ($templateId) {
                $template = ContratoTemplate::findOrFail($templateId);
            } else {
                // Usar template predeterminado
                $template = ContratoTemplate::where('es_predeterminado', true)->first();
            }

            if ($template) {
                // Usar template personalizado
                $contenidoHtml = $template->reemplazarMarcadores($contrato);
                $pdf = Pdf::loadHTML($contenidoHtml);
            } else {
                // Fallback al template original
                $pdf = Pdf::loadView('contratos.pdf', compact('contrato'));
            }

            return $pdf->download("contrato-{$contrato->numero_contrato}.pdf");
        } catch (\Exception $e) {
            Log::error('Error generando PDF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar opciones de templates para generar PDF
     */
    public function seleccionarTemplate(Contrato $contrato)
    {
        $templates = ContratoTemplate::where('activo', true)->get();
        return view('contratos.seleccionar-template', compact('contrato', 'templates'));
    }

    /**
     * Subir archivo firmado
     */
    public function subirFirmado(Request $request, Contrato $contrato)
    {
        $request->validate([
            'archivo_firmado' => 'required|file|mimes:pdf|max:10240'
        ]);

        try {
            // Eliminar archivo firmado anterior si existe
            if ($contrato->archivo_firmado && Storage::disk('public')->exists($contrato->archivo_firmado)) {
                Storage::disk('public')->delete($contrato->archivo_firmado);
            }

            $path = $request->file('archivo_firmado')
                          ->store('contratos/firmados', 'public');

            $contrato->update([
                'archivo_firmado' => $path,
                'estado' => 'firmado',
                'fecha_firma' => Carbon::now()
            ]);

            return back()->with('success', 'Archivo firmado subido exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al subir el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Activar contrato
     */
    public function activar(Contrato $contrato)
    {
        if (!$contrato->puedeActivarse()) {
            return back()->with('error', 'El contrato no puede ser activado. Debe estar firmado y tener el archivo firmado subido.');
        }

        $contrato->update([
            'estado' => 'activo',
            'fecha_activacion' => Carbon::now(),
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => Carbon::now()
        ]);

        return back()->with('success', 'Contrato activado exitosamente.');
    }

    /**
     * Finalizar contrato
     */
    public function finalizar(Request $request, Contrato $contrato)
    {
        if (!$contrato->puedeFinalizarse()) {
            return back()->with('error', 'El contrato no puede ser finalizado.');
        }

        $request->validate([
            'motivo_finalizacion' => 'required|string|max:500'
        ]);

        $contrato->update([
            'estado' => 'finalizado',
            'fecha_finalizacion' => Carbon::now(),
            'motivo_finalizacion' => $request->motivo_finalizacion
        ]);

        return back()->with('success', 'Contrato finalizado exitosamente.');
    }

    /**
     * Obtener datos de persona para formulario
     */
    public function getPersonaData(Request $request)
    {
        $persona = Persona::with('trabajador')->find($request->persona_id);

        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }

        return response()->json([
            'persona' => [
                'nombres' => $persona->nombres,
                'apellidos' => $persona->apellidos,
                'numero_documento' => $persona->numero_documento,
                'celular' => $persona->celular,
                'correo' => $persona->correo,
                'direccion' => $persona->direccion
            ],
            'trabajador' => $persona->trabajador ? [
                'cargo' => $persona->trabajador->cargo,
                'area' => $persona->trabajador->area ?? null
            ] : null
        ]);
    }

    /**
     * Dashboard de contratos por vencer
     */
    public function porVencer()
    {
        $contratos = Contrato::porVencer(30)
                           ->with(['persona'])
                           ->orderBy('fecha_fin')
                           ->get();

        return view('contratos.por-vencer', compact('contratos'));
    }

    /**
     * Genera un número de contrato único
     * Utiliza bloqueo de tabla para evitar duplicados en operaciones concurrentes
     */
    private function generarNumeroContratoUnico()
    {
        $año = date('Y');
        $intentos = 0;
        $maxIntentos = 10;

        do {
            $intentos++;

            // Buscar el último número de contrato del año actual con bloqueo
            $ultimoContrato = Contrato::where('numero_contrato', 'like', "CON-{$año}-%")
                ->lockForUpdate()
                ->orderBy('numero_contrato', 'desc')
                ->first();

            $contador = 1;
            if ($ultimoContrato) {
                // Extraer el número del último contrato
                $partes = explode('-', $ultimoContrato->numero_contrato);
                if (count($partes) >= 3) {
                    $ultimoNumero = intval(end($partes));
                    $contador = $ultimoNumero + 1;
                }
            }

            // Generar número con formato: CON-YYYY-00001
            $numeroContrato = 'CON-' . $año . '-' . str_pad($contador, 5, '0', STR_PAD_LEFT);

            // Verificar que no exista (doble validación)
            $existe = Contrato::where('numero_contrato', $numeroContrato)->exists();

            if (!$existe) {
                return $numeroContrato;
            }

            // Si existe, incrementar y reintentar
            $contador++;

        } while ($intentos < $maxIntentos);

        // Si después de 10 intentos no se pudo generar, lanzar excepción
        throw new \Exception('No se pudo generar un número de contrato único después de ' . $maxIntentos . ' intentos.');
    }
}
