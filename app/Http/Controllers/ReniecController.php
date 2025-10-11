<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReniecService;
use App\Models\ReniecConsulta;

class ReniecController extends Controller
{
    protected $reniecService;

    public function __construct(ReniecService $reniecService)
    {
        $this->reniecService = $reniecService;
    }

    /**
     * Consultar DNI en RENIEC
     */
    public function consultarDni(Request $request)
    {
        $request->validate([
            'dni' => 'required|digits:8'
        ], [
            'dni.required' => 'El DNI es requerido',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos'
        ]);

        $resultado = $this->reniecService->consultarDni($request->dni);

        return response()->json($resultado);
    }

    /**
     * Obtener estadísticas de consultas
     */
    public function estadisticas()
    {
        $estadisticas = $this->reniecService->obtenerEstadisticas();

        return response()->json([
            'success' => true,
            'data' => $estadisticas
        ]);
    }

    /**
     * Obtener consultas disponibles
     */
    public function consultasDisponibles()
    {
        $disponibles = $this->reniecService->consultasDisponiblesHoy();

        return response()->json([
            'success' => true,
            'consultas_disponibles' => $disponibles,
            'limite_diario' => config('services.reniec.limite_gratuito', 100)
        ]);
    }

    /**
     * Ver historial de consultas
     */
    public function historial()
    {
        $consultas = ReniecConsulta::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('reniec.historial', compact('consultas'));
    }
}
