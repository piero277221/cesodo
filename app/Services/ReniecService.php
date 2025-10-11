<?php

namespace App\Services;

use App\Models\ReniecConsulta;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReniecService
{
    /**
     * API gratuita de RENIEC Perú
     * Usaremos APIs Peru API (gratuita con límite de 100 consultas/día)
     */
    private $apiUrl;
    private $apiToken;
    private $limiteGratuito = 100;

    public function __construct()
    {
        // API gratuita de RENIEC
        // Opción 1: apis.net.pe (gratuita)
        $this->apiUrl = config('services.reniec.api_url', 'https://api.apis.net.pe/v2/reniec/dni');
        $this->apiToken = config('services.reniec.api_token', 'apis-token-10359.Iw6wGcFLmn3FRpPz1mmT1Qwr3T4hh4IH');
        $this->limiteGratuito = config('services.reniec.limite_gratuito', 100);
    }

    /**
     * Consultar DNI en RENIEC
     */
    public function consultarDni(string $dni): array
    {
        try {
            // Validar formato DNI
            if (!$this->validarDni($dni)) {
                return [
                    'success' => false,
                    'message' => 'DNI inválido. Debe tener 8 dígitos.',
                    'data' => null
                ];
            }

            // Verificar límite de consultas gratuitas
            $consultasDisponibles = ReniecConsulta::consultasGratuitasHoy();
            if ($consultasDisponibles <= 0) {
                return [
                    'success' => false,
                    'message' => 'Límite de consultas gratuitas alcanzado por hoy.',
                    'data' => null,
                    'consultas_disponibles' => 0
                ];
            }

            // Hacer la consulta a la API
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiToken,
                    'Accept' => 'application/json',
                ])
                ->get($this->apiUrl, [
                    'numero' => $dni
                ]);

            // Procesar respuesta
            if ($response->successful()) {
                $data = $response->json();
                
                // Registrar consulta exitosa
                $this->registrarConsulta($dni, $data, 'exitosa', $response->body());

                return [
                    'success' => true,
                    'message' => 'Consulta exitosa',
                    'data' => [
                        'dni' => $dni,
                        'nombres' => $data['nombres'] ?? '',
                        'apellido_paterno' => $data['apellidoPaterno'] ?? '',
                        'apellido_materno' => $data['apellidoMaterno'] ?? '',
                        'nombre_completo' => trim(
                            ($data['nombres'] ?? '') . ' ' . 
                            ($data['apellidoPaterno'] ?? '') . ' ' . 
                            ($data['apellidoMaterno'] ?? '')
                        ),
                    ],
                    'consultas_disponibles' => $consultasDisponibles - 1
                ];
            } else {
                // Registrar consulta fallida
                $this->registrarConsulta($dni, null, 'fallida', $response->body());

                return [
                    'success' => false,
                    'message' => 'No se encontró información para el DNI proporcionado.',
                    'data' => null,
                    'consultas_disponibles' => $consultasDisponibles - 1
                ];
            }

        } catch (\Exception $e) {
            Log::error('Error en consulta RENIEC: ' . $e->getMessage());
            
            // Registrar error
            $this->registrarConsulta($dni, null, 'error', $e->getMessage());

            return [
                'success' => false,
                'message' => 'Error al consultar RENIEC: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Validar formato de DNI peruano
     */
    private function validarDni(string $dni): bool
    {
        return preg_match('/^[0-9]{8}$/', $dni);
    }

    /**
     * Registrar consulta en la base de datos
     */
    private function registrarConsulta(string $dni, ?array $data, string $estado, ?string $respuestaApi): void
    {
        ReniecConsulta::create([
            'dni' => $dni,
            'nombres' => $data['nombres'] ?? null,
            'apellido_paterno' => $data['apellidoPaterno'] ?? null,
            'apellido_materno' => $data['apellidoMaterno'] ?? null,
            'nombre_completo' => isset($data['nombres']) 
                ? trim(($data['nombres'] ?? '') . ' ' . ($data['apellidoPaterno'] ?? '') . ' ' . ($data['apellidoMaterno'] ?? ''))
                : null,
            'tipo_consulta' => 'gratuita',
            'estado' => $estado,
            'respuesta_api' => $respuestaApi,
            'ip_consulta' => request()->ip(),
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Obtener estadísticas de uso
     */
    public function obtenerEstadisticas(): array
    {
        return ReniecConsulta::estadisticas();
    }

    /**
     * Obtener consultas disponibles hoy
     */
    public function consultasDisponiblesHoy(): int
    {
        return ReniecConsulta::consultasGratuitasHoy();
    }
}
