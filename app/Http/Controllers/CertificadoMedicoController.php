<?php

namespace App\Http\Controllers;

use App\Models\CertificadoMedico;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificadoMedicoController extends Controller
{
    public function index(Request $request)
    {
        $query = CertificadoMedico::with('persona');

        // Filtrar por estado
        if ($request->filled('estado')) {
            switch ($request->estado) {
                case 'vigente':
                    $query->whereDate('fecha_expiracion', '>=', now());
                    break;
                case 'proximo_vencer':
                    $query->whereDate('fecha_expiracion', '>=', now())
                          ->whereDate('fecha_expiracion', '<=', now()->addDays(30));
                    break;
                case 'vencido':
                    $query->whereDate('fecha_expiracion', '<', now());
                    break;
            }
        }

        // Búsqueda por DNI o nombre
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_documento', 'like', "%{$search}%")
                  ->orWhereHas('persona', function($q) use ($search) {
                      $q->where('nombres', 'like', "%{$search}%")
                        ->orWhere('apellidos', 'like', "%{$search}%");
                  });
            });
        }

        $certificados = $query->latest()->paginate(15);

        return view('certificados-medicos.index', compact('certificados'));
    }

    public function create()
    {
        return view('certificados-medicos.create');
    }

    /**
     * Buscar persona por DNI
     */
    public function buscarPersona(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|size:8'
        ]);

        $persona = Persona::where('numero_documento', $request->dni)
            ->orWhere('numero_documento', 'LIKE', $request->dni)
            ->first();

        if (!$persona) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ninguna persona con ese DNI'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'persona' => [
                'id' => $persona->id,
                'nombre_completo' => $persona->nombre_completo,
                'nombres' => $persona->nombres,
                'apellidos' => $persona->apellidos,
                'numero_documento' => $persona->numero_documento,
                'celular' => $persona->celular,
                'correo' => $persona->correo,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_documento' => 'required|string|size:8',
            'persona_id' => 'required|exists:personas,id',
            'archivo_certificado' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fecha_emision' => 'required|date',
            'fecha_expiracion' => 'required|date|after:fecha_emision',
            'observaciones' => 'nullable|string|max:1000',
        ], [
            'numero_documento.required' => 'El DNI es obligatorio',
            'numero_documento.size' => 'El DNI debe tener 8 dígitos',
            'persona_id.required' => 'Debe buscar y seleccionar una persona',
            'persona_id.exists' => 'La persona seleccionada no existe',
            'archivo_certificado.required' => 'Debe adjuntar el certificado médico',
            'archivo_certificado.mimes' => 'El archivo debe ser PDF, JPG, JPEG o PNG',
            'archivo_certificado.max' => 'El archivo no debe superar los 5MB',
            'fecha_emision.required' => 'La fecha de emisión es obligatoria',
            'fecha_expiracion.required' => 'La fecha de expiración es obligatoria',
            'fecha_expiracion.after' => 'La fecha de expiración debe ser posterior a la fecha de emisión',
        ]);

        // Guardar el archivo
        $archivo = $request->file('archivo_certificado');
        $nombreArchivo = 'cert_' . $request->numero_documento . '_' . time() . '.' . $archivo->getClientOriginalExtension();
        $rutaArchivo = $archivo->storeAs('certificados_medicos', $nombreArchivo, 'public');

        CertificadoMedico::create([
            'persona_id' => $request->persona_id,
            'numero_documento' => $request->numero_documento,
            'archivo_certificado' => $rutaArchivo,
            'fecha_emision' => $request->fecha_emision,
            'fecha_expiracion' => $request->fecha_expiracion,
            'observaciones' => $request->observaciones,
            'notificacion_enviada' => false,
        ]);

        return redirect()->route('certificados-medicos.index')
            ->with('success', 'Certificado médico registrado exitosamente');
    }

    public function show(CertificadoMedico $certificadosMedico)
    {
        $certificadosMedico->load('persona');
        return view('certificados-medicos.show', compact('certificadosMedico'));
    }

    public function edit(CertificadoMedico $certificadosMedico)
    {
        $certificadosMedico->load('persona');
        return view('certificados-medicos.edit', compact('certificadosMedico'));
    }

    public function update(Request $request, CertificadoMedico $certificadosMedico)
    {
        $request->validate([
            'archivo_certificado' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fecha_emision' => 'required|date',
            'fecha_expiracion' => 'required|date|after:fecha_emision',
            'observaciones' => 'nullable|string|max:1000',
        ], [
            'archivo_certificado.mimes' => 'El archivo debe ser PDF, JPG, JPEG o PNG',
            'archivo_certificado.max' => 'El archivo no debe superar los 5MB',
            'fecha_emision.required' => 'La fecha de emisión es obligatoria',
            'fecha_expiracion.required' => 'La fecha de expiración es obligatoria',
            'fecha_expiracion.after' => 'La fecha de expiración debe ser posterior a la fecha de emisión',
        ]);

        $datos = [
            'fecha_emision' => $request->fecha_emision,
            'fecha_expiracion' => $request->fecha_expiracion,
            'observaciones' => $request->observaciones,
        ];

        // Si se sube un nuevo archivo
        if ($request->hasFile('archivo_certificado')) {
            // Eliminar archivo anterior
            if ($certificadosMedico->archivo_certificado) {
                Storage::disk('public')->delete($certificadosMedico->archivo_certificado);
            }

            // Guardar nuevo archivo
            $archivo = $request->file('archivo_certificado');
            $nombreArchivo = 'cert_' . $certificadosMedico->numero_documento . '_' . time() . '.' . $archivo->getClientOriginalExtension();
            $rutaArchivo = $archivo->storeAs('certificados_medicos', $nombreArchivo, 'public');
            $datos['archivo_certificado'] = $rutaArchivo;
        }

        // Resetear notificación si se actualiza la fecha
        if ($request->fecha_expiracion != $certificadosMedico->fecha_expiracion) {
            $datos['notificacion_enviada'] = false;
        }

        $certificadosMedico->update($datos);

        return redirect()->route('certificados-medicos.index')
            ->with('success', 'Certificado médico actualizado exitosamente');
    }

    public function destroy(CertificadoMedico $certificadosMedico)
    {
        // Eliminar archivo
        if ($certificadosMedico->archivo_certificado) {
            Storage::disk('public')->delete($certificadosMedico->archivo_certificado);
        }

        $certificadosMedico->delete();

        return redirect()->route('certificados-medicos.index')
            ->with('success', 'Certificado médico eliminado exitosamente');
    }

    /**
     * Descargar archivo del certificado
     */
    public function descargar(CertificadoMedico $certificadosMedico)
    {
        if (!$certificadosMedico->archivo_certificado || !Storage::disk('public')->exists($certificadosMedico->archivo_certificado)) {
            return redirect()->back()->with('error', 'El archivo no existe');
        }

        $rutaCompleta = Storage::disk('public')->path($certificadosMedico->archivo_certificado);
        $nombreDescarga = 'certificado_' . $certificadosMedico->numero_documento . '.' . pathinfo($certificadosMedico->archivo_certificado, PATHINFO_EXTENSION);

        return response()->download($rutaCompleta, $nombreDescarga);
    }
}
