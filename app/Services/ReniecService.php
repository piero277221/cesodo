<?php

namespace App\Services;

use App\Models\ReniecConsulta;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReniecService
{
    /**
     * API de RENIEC Perú - apiperu.dev
     * Token registrado y funcional
     */
    private $apiUrl;
    private $apiToken;
    private $limiteGratuito = 100;

    public function __construct()
    {
        // API de RENIEC - apiperu.dev con token registrado
        $this->apiUrl = config('services.reniec.api_url', 'https://apiperu.dev/api/dni');
        $this->apiToken = config('services.reniec.api_token', '17a346deb75dfbbd59a76f2fd87ab0d8aee01859f4b5fb3080aa6412b60f2ff9');
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

            // Hacer la consulta a la API REAL
            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiToken,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->get($this->apiUrl . '/' . $dni);

            // Log para debug
            Log::info('RENIEC API Response Status: ' . $response->status());
            Log::info('RENIEC API Response Body: ' . $response->body());

            // Procesar respuesta
            if ($response->successful()) {
                $responseData = $response->json();
                
                // Verificar si la respuesta tiene los datos
                if (isset($responseData['success']) && $responseData['success'] === true && isset($responseData['data'])) {
                    $data = $responseData['data'];
                    
                    // Registrar consulta exitosa
                    $this->registrarConsulta($dni, $data, 'exitosa', $response->body());

                    return [
                        'success' => true,
                        'message' => 'Consulta exitosa en RENIEC',
                        'data' => [
                            'dni' => $dni,
                            'nombres' => $data['nombres'] ?? $data['nombre'] ?? '',
                            'apellido_paterno' => $data['apellido_paterno'] ?? $data['apellidoPaterno'] ?? '',
                            'apellido_materno' => $data['apellido_materno'] ?? $data['apellidoMaterno'] ?? '',
                            'nombre_completo' => trim(
                                ($data['nombres'] ?? $data['nombre'] ?? '') . ' ' .
                                ($data['apellido_paterno'] ?? $data['apellidoPaterno'] ?? '') . ' ' .
                                ($data['apellido_materno'] ?? $data['apellidoMaterno'] ?? '')
                            ),
                            // Campos adicionales si están disponibles
                            'sexo' => $data['sexo'] ?? null,
                            'fecha_nacimiento' => $data['fecha_nacimiento'] ?? $data['fechaNacimiento'] ?? null,
                            'direccion' => $data['direccion'] ?? $data['direccion_completa'] ?? '',
                            'ubigeo' => $data['ubigeo_reniec'] ?? $data['ubigeo_sunat'] ?? '',
                        ],
                        'consultas_disponibles' => $consultasDisponibles - 1
                    ];
                } else {
                    // Si la API devuelve success=false o no tiene datos
                    $this->registrarConsulta($dni, null, 'fallida', $response->body());
                    
                    return [
                        'success' => false,
                        'message' => $responseData['message'] ?? 'No se encontró información para el DNI proporcionado.',
                        'data' => null,
                        'consultas_disponibles' => $consultasDisponibles - 1
                    ];
                }
            } else {
                // Error de respuesta HTTP
                $this->registrarConsulta($dni, null, 'fallida', $response->body());

                return [
                    'success' => false,
                    'message' => 'Error al consultar RENIEC. Código: ' . $response->status(),
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
     * Obtener datos de prueba para demostración
     */
    private function obtenerDatosPrueba(string $dni): ?array
    {
        // Base de datos de DNIs de prueba para demostración
        $dnisPrueba = [
            '71981207' => [
                'nombres' => 'JUAN CARLOS',
                'apellido_paterno' => 'RODRIGUEZ',
                'apellido_materno' => 'GARCIA'
            ],
            '41821256' => [
                'nombres' => 'MARIA ELENA',
                'apellido_paterno' => 'LOPEZ',
                'apellido_materno' => 'FERNANDEZ'
            ],
            '12345678' => [
                'nombres' => 'PEDRO LUIS',
                'apellido_paterno' => 'MARTINEZ',
                'apellido_materno' => 'SANCHEZ'
            ],
            '87654321' => [
                'nombres' => 'ANA SOFIA',
                'apellido_paterno' => 'TORRES',
                'apellido_materno' => 'RAMIREZ'
            ],
            '45678901' => [
                'nombres' => 'CARLOS ALBERTO',
                'apellido_paterno' => 'GONZALEZ',
                'apellido_materno' => 'DIAZ'
            ],
        ];

        return $dnisPrueba[$dni] ?? null;
    }

    /**
     * Método alternativo: Consultar API real (desactivado por ahora)
     */
    private function consultarApiReal(string $dni): array
    {
        try {
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

            // Hacer la consulta a la API (sin autenticación)
            $response = Http::timeout(15)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->get($this->apiUrl . '/' . $dni);

            // Log para debug
            Log::info('RENIEC Response Status: ' . $response->status());
            Log::info('RENIEC Response Body: ' . $response->body());

            // Procesar respuesta
            if ($response->successful()) {
                $responseData = $response->json();
                
                // La API apiperu.dev devuelve los datos en formato diferente
                // Verificar si hay datos válidos
                if (isset($responseData['data'])) {
                    $data = $responseData['data'];
                    
                    // Registrar consulta exitosa
                    $this->registrarConsulta($dni, $data, 'exitosa', $response->body());

                    return [
                        'success' => true,
                        'message' => 'Consulta exitosa',
                        'data' => [
                            'dni' => $dni,
                            'nombres' => $data['nombres'] ?? ($data['nombre'] ?? ''),
                            'apellido_paterno' => $data['apellido_paterno'] ?? ($data['apellidoPaterno'] ?? ''),
                            'apellido_materno' => $data['apellido_materno'] ?? ($data['apellidoMaterno'] ?? ''),
                            'nombre_completo' => trim(
                                ($data['nombres'] ?? ($data['nombre'] ?? '')) . ' ' .
                                ($data['apellido_paterno'] ?? ($data['apellidoPaterno'] ?? '')) . ' ' .
                                ($data['apellido_materno'] ?? ($data['apellidoMaterno'] ?? ''))
                            ),
                        ],
                        'consultas_disponibles' => $consultasDisponibles - 1
                    ];
                } else {
                    // Si no hay campo 'data', intentar leer directamente
                    $data = $responseData;
                    
                    if (isset($data['nombres']) || isset($data['nombre'])) {
                        // Registrar consulta exitosa
                        $this->registrarConsulta($dni, $data, 'exitosa', $response->body());

                        return [
                            'success' => true,
                            'message' => 'Consulta exitosa',
                            'data' => [
                                'dni' => $dni,
                                'nombres' => $data['nombres'] ?? ($data['nombre'] ?? ''),
                                'apellido_paterno' => $data['apellido_paterno'] ?? ($data['apellidoPaterno'] ?? ''),
                                'apellido_materno' => $data['apellido_materno'] ?? ($data['apellidoMaterno'] ?? ''),
                                'nombre_completo' => trim(
                                    ($data['nombres'] ?? ($data['nombre'] ?? '')) . ' ' .
                                    ($data['apellido_paterno'] ?? ($data['apellidoPaterno'] ?? '')) . ' ' .
                                    ($data['apellido_materno'] ?? ($data['apellidoMaterno'] ?? ''))
                                ),
                            ],
                            'consultas_disponibles' => $consultasDisponibles - 1
                        ];
                    }
                }
                
                // Si llegamos aquí, no se encontraron datos válidos
                $this->registrarConsulta($dni, null, 'fallida', $response->body());
                return [
                    'success' => false,
                    'message' => 'No se encontró información para el DNI proporcionado.',
                    'data' => null,
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
