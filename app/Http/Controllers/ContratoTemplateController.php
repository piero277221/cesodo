<?php

namespace App\Http\Controllers;

use App\Models\ContratoTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

class ContratoTemplateController extends Controller
{
    public function index()
    {
        $templates = ContratoTemplate::with('creadoPor')
            ->orderBy('es_predeterminado', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('contratos.templates.index', compact('templates'));
    }

    public function create()
    {
        $marcadores = ContratoTemplate::getMarcadoresPredefinidos();
        return view('contratos.templates.create', compact('marcadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:html,word,pdf',
            'contenido_html' => 'required_if:tipo,html',
            'archivo' => 'required_unless:tipo,html|file|mimes:doc,docx,pdf,html|max:10240',
            'es_predeterminado' => 'boolean'
        ]);

        // Si es predeterminado, quitar el flag de otros templates
        if ($request->es_predeterminado) {
            ContratoTemplate::where('es_predeterminado', true)->update(['es_predeterminado' => false]);
        }

        $data = $request->only(['nombre', 'descripcion', 'tipo']);
        $data['creado_por'] = Auth::id();
        $data['es_predeterminado'] = $request->boolean('es_predeterminado');
        $data['activo'] = true;

        // Procesar según el tipo
        if ($request->tipo === 'html') {
            // HTML directo
            $data['contenido'] = $request->contenido_html;
            $contenidoParaMarcadores = $request->contenido_html;
        } else {
            // Archivo Word o PDF
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $extension = $archivo->getClientOriginalExtension();
                $nombreArchivo = Str::slug($request->nombre) . '_' . time() . '.' . $extension;
                $ruta = $archivo->storeAs('contratos/templates', $nombreArchivo, 'public');

                $data['archivo_path'] = $ruta;
                $data['archivo_original_name'] = $archivo->getClientOriginalName();

                // Extraer contenido para detectar marcadores
                $contenidoParaMarcadores = $this->extraerContenidoArchivo($archivo, $extension);
                $data['contenido'] = $contenidoParaMarcadores;
            }
        }

        // Detectar marcadores en el contenido
        $marcadoresDetectados = $this->detectarMarcadores($contenidoParaMarcadores ?? '');

        // Agregar marcadores seleccionados manualmente
        if ($request->has('marcadores_seleccionados') && !empty($request->marcadores_seleccionados)) {
            $marcadoresSeleccionados = json_decode($request->marcadores_seleccionados, true);
            if (is_array($marcadoresSeleccionados)) {
                $marcadoresDetectados = array_unique(array_merge($marcadoresDetectados, $marcadoresSeleccionados));
            }
        }

        $data['marcadores'] = $marcadoresDetectados;

        ContratoTemplate::create($data);

        return redirect()->route('contratos.templates.index')
            ->with('success', 'Template creado exitosamente. Se detectaron ' . count($marcadoresDetectados) . ' marcadores.');
    }

    /**
     * Extraer contenido de archivo para detectar marcadores
     */
    private function extraerContenidoArchivo($archivo, $extension)
    {
        try {
            if (in_array($extension, ['doc', 'docx'])) {
                // Archivo Word
                $phpWord = IOFactory::load($archivo->getRealPath());
                $contenido = '';

                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $contenido .= $element->getText() . ' ';
                        }
                    }
                }

                return $contenido;
            } elseif ($extension === 'pdf') {
                // Para PDF, retornamos un contenido básico ya que es más complejo extraer texto
                return 'Archivo PDF - se procesará con marcadores estándar';
            } elseif ($extension === 'html') {
                return file_get_contents($archivo->getRealPath());
            }
        } catch (\Exception $e) {
            // Si hay error, retornar contenido básico
            return 'Contenido del template - se procesará con marcadores estándar';
        }

        return '';
    }

    /**
     * Detectar marcadores en el contenido
     */
    private function detectarMarcadores($contenido)
    {
        $marcadoresDetectados = [];
        $marcadoresPredefinidos = ContratoTemplate::getMarcadoresPredefinidos();

        foreach (array_keys($marcadoresPredefinidos) as $marcador) {
            if (strpos($contenido, $marcador) !== false) {
                $marcadoresDetectados[] = $marcador;
            }
        }

        // También buscar marcadores con patrón {TEXTO}
        preg_match_all('/\{([^}]+)\}/', $contenido, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $marcador) {
                if (!in_array($marcador, $marcadoresDetectados)) {
                    $marcadoresDetectados[] = $marcador;
                }
            }
        }

        return $marcadoresDetectados;
    }

    public function show(ContratoTemplate $template)
    {
        return view('contratos.templates.show', compact('template'));
    }

    public function edit(ContratoTemplate $template)
    {
        $marcadores = ContratoTemplate::getMarcadoresPredefinidos();
        return view('contratos.templates.edit', compact('template', 'marcadores'));
    }

    public function update(Request $request, ContratoTemplate $template)
    {
        // Si es una actualización solo de marcadores
        if ($request->update_marcadores_only) {
            $request->validate([
                'marcadores' => 'required|array',
                'marcadores.*' => 'string'
            ]);

            $template->update([
                'marcadores' => $request->marcadores
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Marcadores actualizados exitosamente',
                'marcadores' => $request->marcadores
            ]);
        }

        // Validación normal para actualización completa
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido_html' => 'required',
            'es_predeterminado' => 'boolean'
        ]);

        // Si es predeterminado, quitar el flag de otros templates
        if ($request->es_predeterminado && !$template->es_predeterminado) {
            ContratoTemplate::where('es_predeterminado', true)->update(['es_predeterminado' => false]);
        }

        $data = $request->only(['nombre', 'descripcion']);
        $data['contenido'] = $request->contenido_html; // Mapear contenido_html a contenido
        $data['es_predeterminado'] = $request->boolean('es_predeterminado');

        // Detectar marcadores en el contenido
        $contenido = $data['contenido'];
        $marcadoresDetectados = [];
        $marcadoresPredefinidos = ContratoTemplate::getMarcadoresPredefinidos();

        foreach (array_keys($marcadoresPredefinidos) as $marcador) {
            if (strpos($contenido, $marcador) !== false) {
                $marcadoresDetectados[] = $marcador;
            }
        }

        // También buscar marcadores con patrón {{texto}}
        preg_match_all('/\{\{([^}]+)\}\}/', $contenido, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $marcador) {
                if (!in_array($marcador, $marcadoresDetectados)) {
                    $marcadoresDetectados[] = $marcador;
                }
            }
        }

        $data['marcadores'] = $marcadoresDetectados;

        $template->update($data);

        return redirect()->route('contratos.templates.index')
            ->with('success', 'Template actualizado exitosamente.');
    }

    public function destroy(ContratoTemplate $template)
    {
        // No permitir eliminar el template predeterminado si es el único
        if ($template->es_predeterminado && ContratoTemplate::where('activo', true)->count() === 1) {
            return redirect()->back()->with('error', 'No se puede eliminar el único template activo.');
        }

        // Eliminar archivo si existe
        if ($template->archivo_original && Storage::disk('public')->exists($template->archivo_original)) {
            Storage::disk('public')->delete($template->archivo_original);
        }

        $template->delete();

        return redirect()->route('contratos.templates.index')
            ->with('success', 'Template eliminado exitosamente.');
    }

    public function preview(ContratoTemplate $template)
    {
        // Crear datos de ejemplo para la vista previa
        $contratoEjemplo = (object) [
            'persona' => (object) [
                'nombres' => 'Juan Carlos',
                'apellidos' => 'Pérez García',
                'numero_documento' => '12.345.678',
                'celular' => '+58 414-123-4567',
                'correo' => 'juan.perez@email.com',
                'direccion' => 'Av. Principal, Casa #123, Caracas'
            ],
            'numero_contrato' => 'CONT-2025-001',
            'tipo_contrato' => 'Indefinido',
            'cargo' => 'Desarrollador Senior',
            'departamento' => 'Tecnología',
            'lugar_trabajo' => 'Oficina Central',
            'salario_base' => 2500.00,
            'bonificaciones' => 300.00,
            'descuentos' => 100.00,
            'modalidad' => 'Presencial',
            'moneda' => 'USD',
            'tipo_pago' => 'Mensual',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addYear(),
            'fecha_firma' => now(),
            'hora_inicio' => '08:00',
            'hora_fin' => '17:00',
            'dias_laborales' => 'Lunes a Viernes',
            'horas_semanales' => '40',
            'jornada_laboral' => 'Tiempo completo',
            'beneficios' => 'Seguro médico, bono de alimentación',
            'clausulas_especiales' => 'Confidencialidad y no competencia',
            'observaciones' => 'Periodo de prueba de 3 meses'
        ];

        $contenidoProcesado = $template->reemplazarMarcadores($contratoEjemplo);

        return view('contratos.templates.preview', compact('template', 'contenidoProcesado'));
    }

    public function setDefault(ContratoTemplate $template)
    {
        // Quitar el flag de predeterminado de todos los templates
        ContratoTemplate::where('es_predeterminado', true)->update(['es_predeterminado' => false]);

        // Establecer este como predeterminado
        $template->update(['es_predeterminado' => true]);

        return redirect()->back()->with('success', 'Template establecido como predeterminado.');
    }
}
