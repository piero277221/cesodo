<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\CertificadoMedico;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificacionController extends Controller
{
    /**
     * Obtener todas las notificaciones activas
     */
    public function index()
    {
        $notificaciones = $this->obtenerNotificaciones();
        return view('notificaciones.index', compact('notificaciones'));
    }

    /**
     * Obtener notificaciones en formato JSON para AJAX
     */
    public function obtener()
    {
        $notificaciones = $this->obtenerNotificaciones();

        return response()->json([
            'success' => true,
            'notificaciones' => $notificaciones,
            'total' => count($notificaciones)
        ]);
    }

    /**
     * Obtener todas las notificaciones del sistema
     */
    public function obtenerNotificaciones()
    {
        $notificaciones = [];

        // 1. Certificados médicos próximos a vencer (30 días o menos)
        $certificadosProximos = CertificadoMedico::with('persona')
            ->whereDate('fecha_expiracion', '>=', Carbon::now())
            ->whereDate('fecha_expiracion', '<=', Carbon::now()->addDays(30))
            ->orderBy('fecha_expiracion', 'asc')
            ->get();

        foreach ($certificadosProximos as $certificado) {
            $diasRestantes = $certificado->diasRestantes();
            $tiempoTexto = $certificado->tiempoRestanteTexto();

            $notificaciones[] = [
                'tipo' => 'certificado_proximo',
                'prioridad' => $diasRestantes <= 7 ? 'alta' : 'media',
                'titulo' => 'Certificado Médico por vencer',
                'mensaje' => "{$certificado->persona->nombre_completo} - Vence en {$tiempoTexto}",
                'icono' => 'fa-file-medical',
                'color' => $diasRestantes <= 7 ? 'danger' : 'warning',
                'enlace' => route('certificados-medicos.show', $certificado->id),
                'fecha' => $certificado->fecha_expiracion,
                'datos' => [
                    'persona' => $certificado->persona->nombre_completo,
                    'dni' => $certificado->numero_documento,
                    'dias_restantes' => $diasRestantes,
                    'tiempo_texto' => $tiempoTexto
                ]
            ];
        }

        // 2. Certificados médicos vencidos
        $certificadosVencidos = CertificadoMedico::with('persona')
            ->whereDate('fecha_expiracion', '<', Carbon::now())
            ->orderBy('fecha_expiracion', 'desc')
            ->limit(10)
            ->get();

        foreach ($certificadosVencidos as $certificado) {
            $notificaciones[] = [
                'tipo' => 'certificado_vencido',
                'prioridad' => 'alta',
                'titulo' => 'Certificado Médico Vencido',
                'mensaje' => "{$certificado->persona->nombre_completo} - Vencido hace {$certificado->tiempoRestanteTexto()}",
                'icono' => 'fa-exclamation-triangle',
                'color' => 'danger',
                'enlace' => route('certificados-medicos.show', $certificado->id),
                'fecha' => $certificado->fecha_expiracion,
                'datos' => [
                    'persona' => $certificado->persona->nombre_completo,
                    'dni' => $certificado->numero_documento
                ]
            ];
        }

        // 3. Contratos próximos a vencer (30 días o menos)
        $contratosProximos = Contrato::with('persona')
            ->where('estado', 'activo')
            ->whereNotNull('fecha_fin')
            ->whereDate('fecha_fin', '>=', Carbon::now())
            ->whereDate('fecha_fin', '<=', Carbon::now()->addDays(30))
            ->orderBy('fecha_fin', 'asc')
            ->get();

        foreach ($contratosProximos as $contrato) {
            $diasRestantes = $contrato->diasRestantes();
            $tiempoTexto = $contrato->tiempoRestanteTexto();

            $notificaciones[] = [
                'tipo' => 'contrato_proximo',
                'prioridad' => $diasRestantes <= 7 ? 'alta' : 'media',
                'titulo' => 'Contrato por vencer',
                'mensaje' => "{$contrato->persona->nombre_completo} - Finaliza en {$tiempoTexto}",
                'icono' => 'fa-file-contract',
                'color' => $diasRestantes <= 7 ? 'danger' : 'warning',
                'enlace' => route('contratos.show', $contrato->id),
                'fecha' => $contrato->fecha_fin,
                'datos' => [
                    'persona' => $contrato->persona->nombre_completo,
                    'numero_contrato' => $contrato->numero_contrato,
                    'dias_restantes' => $diasRestantes,
                    'tiempo_texto' => $tiempoTexto
                ]
            ];
        }

        // Ordenar por prioridad y fecha
        usort($notificaciones, function($a, $b) {
            $prioridades = ['alta' => 3, 'media' => 2, 'baja' => 1];
            $prioridadA = $prioridades[$a['prioridad']] ?? 0;
            $prioridadB = $prioridades[$b['prioridad']] ?? 0;

            if ($prioridadA != $prioridadB) {
                return $prioridadB - $prioridadA; // Mayor prioridad primero
            }

            return $a['fecha'] <=> $b['fecha']; // Fecha más próxima primero
        });

        return $notificaciones;
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarLeida(Request $request)
    {
        // Aquí podrías guardar en sesión o base de datos
        // las notificaciones que el usuario ya vio

        return response()->json(['success' => true]);
    }
}

