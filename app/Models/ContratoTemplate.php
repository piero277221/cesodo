<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ContratoTemplate extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'contenido',
        'tipo',
        'archivo_path',
        'archivo_original_name',
        'marcadores',
        'activo',
        'es_predeterminado',
        'creado_por'
    ];

    protected $casts = [
        'marcadores' => 'array',
        'activo' => 'boolean',
        'es_predeterminado' => 'boolean'
    ];

    // Relationships
    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Marcadores predefinidos del sistema
    public static function getMarcadoresPredefinidos(): array
    {
        return [
            // Datos del trabajador
            '{NOMBRE_TRABAJADOR}' => 'Nombre completo del trabajador',
            '{NOMBRES_TRABAJADOR}' => 'Nombres del trabajador',
            '{APELLIDOS_TRABAJADOR}' => 'Apellidos del trabajador',
            '{CEDULA_TRABAJADOR}' => 'Cédula de identidad del trabajador',
            '{TELEFONO_TRABAJADOR}' => 'Teléfono del trabajador',
            '{EMAIL_TRABAJADOR}' => 'Correo electrónico del trabajador',
            '{DIRECCION_TRABAJADOR}' => 'Dirección del trabajador',

            // Datos del contrato
            '{NUMERO_CONTRATO}' => 'Número del contrato',
            '{TIPO_CONTRATO}' => 'Tipo de contrato (indefinido, temporal)',
            '{CARGO}' => 'Cargo del trabajador',
            '{DEPARTAMENTO}' => 'Departamento de trabajo',
            '{LUGAR_TRABAJO}' => 'Lugar de trabajo',
            '{SALARIO_BASE}' => 'Salario base',
            '{BONIFICACIONES}' => 'Bonificaciones',
            '{DESCUENTOS}' => 'Descuentos',
            '{SALARIO_NETO}' => 'Salario neto (base + bonificaciones - descuentos)',
            '{MODALIDAD}' => 'Modalidad de trabajo',
            '{MONEDA}' => 'Moneda del salario',
            '{TIPO_PAGO}' => 'Tipo de pago',

            // Fechas
            '{FECHA_INICIO}' => 'Fecha de inicio del contrato',
            '{FECHA_FIN}' => 'Fecha de fin del contrato',
            '{FECHA_FIRMA}' => 'Fecha de firma del contrato',
            '{FECHA_ACTUAL}' => 'Fecha actual',
            '{FECHA_ACTUAL_LETRAS}' => 'Fecha actual en letras',

            // Horarios
            '{HORA_INICIO}' => 'Hora de inicio de jornada',
            '{HORA_FIN}' => 'Hora de fin de jornada',
            '{DIAS_LABORALES}' => 'Días laborales',
            '{HORAS_SEMANALES}' => 'Horas semanales',
            '{JORNADA_LABORAL}' => 'Descripción de jornada laboral',

            // Otros
            '{BENEFICIOS}' => 'Beneficios adicionales',
            '{CLAUSULAS_ESPECIALES}' => 'Cláusulas especiales',
            '{OBSERVACIONES}' => 'Observaciones'
        ];
    }

    // Reemplazar marcadores en el contenido
    public function reemplazarMarcadores(Contrato $contrato): string
    {
        if ($this->tipo === 'word' && $this->archivo_path) {
            return $this->procesarDocumentoWord($contrato);
        } elseif ($this->tipo === 'pdf' && $this->archivo_path) {
            return $this->procesarDocumentoPdf($contrato);
        } else {
            // HTML tradicional
            $contenido = $this->contenido ?? '';

            // Primero reemplazar marcadores predefinidos del sistema
            $marcadores = self::getMarcadoresPredefinidos();
            foreach ($marcadores as $marcador => $descripcion) {
                $valor = $this->obtenerValorMarcador($marcador, $contrato);
                $contenido = str_replace($marcador, $valor, $contenido);
            }

            // Luego reemplazar marcadores del generador de plantillas (formato {{marcador}})
            $marcadoresGenerador = $this->getMarcadoresGenerador();
            foreach ($marcadoresGenerador as $marcador => $valor) {
                $valorReal = $this->obtenerValorMarcadorGenerador($marcador, $contrato);
                $contenido = str_replace($marcador, $valorReal, $contenido);
            }

            return $contenido;
        }
    }

    /**
     * Obtener marcadores del generador (formato {{marcador}})
     */
    private function getMarcadoresGenerador(): array
    {
        return [
            '{{nombre}}' => 'Nombre completo',
            '{{cedula}}' => 'Número de cédula',
            '{{cargo}}' => 'Cargo del trabajador',
            '{{salario}}' => 'Salario base',
            '{{fecha_inicio}}' => 'Fecha de inicio',
            '{{empresa}}' => 'Nombre de la empresa'
        ];
    }

    /**
     * Obtener valor específico para marcadores del generador
     */
    private function obtenerValorMarcadorGenerador(string $marcador, Contrato $contrato): string
    {
        return match($marcador) {
            '{{nombre}}' => ($contrato->persona->nombres ?? '') . ' ' . ($contrato->persona->apellidos ?? ''),
            '{{cedula}}' => $contrato->persona->numero_documento ?? '',
            '{{cargo}}' => $contrato->cargo ?? '',
            '{{salario}}' => number_format($contrato->salario_base ?? 0, 2),
            '{{fecha_inicio}}' => $contrato->fecha_inicio ? \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') : '',
            '{{empresa}}' => 'Tu Empresa', // Aquí puedes poner el nombre real de la empresa
            default => $marcador
        };
    }

    /**
     * Procesar documento Word reemplazando marcadores
     */
    public function procesarDocumentoWord(Contrato $contrato): string
    {
        try {
            $rutaCompleta = storage_path('app/public/' . $this->archivo_path);

            if (!file_exists($rutaCompleta)) {
                throw new \Exception('Archivo template no encontrado');
            }

            // Crear procesador de template
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($rutaCompleta);

            // Obtener marcadores y reemplazar
            $marcadores = self::getMarcadoresPredefinidos();

            foreach ($marcadores as $marcador => $descripcion) {
                $clave = str_replace(['{', '}'], '', $marcador); // Quitar llaves para PhpWord
                $valor = $this->obtenerValorMarcador($marcador, $contrato);

                // PhpWord usa marcadores sin llaves
                $templateProcessor->setValue($clave, $valor);
            }

            // Guardar archivo temporal
            $archivoTemporal = storage_path('app/public/contratos/temp/contrato_' . $contrato->id . '_' . time() . '.docx');
            $directorioTemp = dirname($archivoTemporal);

            if (!is_dir($directorioTemp)) {
                mkdir($directorioTemp, 0755, true);
            }

            $templateProcessor->saveAs($archivoTemporal);

            // Convertir a HTML para PDF
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($archivoTemporal);
            $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');

            ob_start();
            $htmlWriter->save('php://output');
            $htmlContent = ob_get_clean();

            // Limpiar archivo temporal
            if (file_exists($archivoTemporal)) {
                unlink($archivoTemporal);
            }

            return $htmlContent;

        } catch (\Exception $e) {
            Log::error('Error procesando documento Word: ' . $e->getMessage());
            return $this->contenido ?? 'Error procesando template Word: ' . $e->getMessage();
        }
    }

    /**
     * Procesar documento PDF (más básico)
     */
    public function procesarDocumentoPdf(Contrato $contrato): string
    {
        // Para PDF es más complejo, por ahora retornamos el contenido HTML básico
        // con los datos del contrato
        $html = '
        <div style="font-family: Arial, sans-serif; padding: 20px;">
            <h2 style="text-align: center;">CONTRATO DE TRABAJO</h2>
            <p><strong>Documento basado en template PDF:</strong> ' . $this->archivo_original_name . '</p>

            <div style="margin: 20px 0;">
                <h3>Datos del Trabajador:</h3>
                <p><strong>Nombre:</strong> ' . ($contrato->persona->nombres ?? '') . ' ' . ($contrato->persona->apellidos ?? '') . '</p>
                <p><strong>DNI:</strong> ' . ($contrato->persona->numero_documento ?? '') . '</p>
                <p><strong>Dirección:</strong> ' . ($contrato->persona->direccion ?? '') . '</p>
            </div>

            <div style="margin: 20px 0;">
                <h3>Datos del Contrato:</h3>
                <p><strong>Número:</strong> ' . $contrato->numero_contrato . '</p>
                <p><strong>Cargo:</strong> ' . $contrato->cargo . '</p>
                <p><strong>Salario:</strong> S/. ' . number_format((float)$contrato->salario_base, 2) . '</p>
                <p><strong>Fecha de Inicio:</strong> ' . \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') . '</p>
            </div>

            <p style="margin-top: 40px; font-style: italic; color: #666;">
                Nota: Este contrato está basado en el template PDF subido. Para un procesamiento completo del PDF,
                se recomienda usar formatos Word que permiten mejor manipulación de contenido.
            </p>
        </div>';

        return $html;
    }

    // Obtener valor específico para cada marcador
    private function obtenerValorMarcador(string $marcador, Contrato $contrato): string
    {
        return match($marcador) {
            '{NOMBRE_TRABAJADOR}' => $contrato->persona->nombres . ' ' . $contrato->persona->apellidos,
            '{NOMBRES_TRABAJADOR}' => $contrato->persona->nombres ?? '',
            '{APELLIDOS_TRABAJADOR}' => $contrato->persona->apellidos ?? '',
            '{CEDULA_TRABAJADOR}' => $contrato->persona->numero_documento ?? '',
            '{TELEFONO_TRABAJADOR}' => $contrato->persona->celular ?? '',
            '{EMAIL_TRABAJADOR}' => $contrato->persona->correo ?? '',
            '{DIRECCION_TRABAJADOR}' => $contrato->persona->direccion ?? '',

            '{NUMERO_CONTRATO}' => $contrato->numero_contrato ?? '',
            '{TIPO_CONTRATO}' => $contrato->tipo_contrato ?? '',
            '{CARGO}' => $contrato->cargo ?? '',
            '{DEPARTAMENTO}' => $contrato->departamento ?? '',
            '{LUGAR_TRABAJO}' => $contrato->lugar_trabajo ?? '',
            '{SALARIO_BASE}' => number_format($contrato->salario_base ?? 0, 2),
            '{BONIFICACIONES}' => number_format($contrato->bonificaciones ?? 0, 2),
            '{DESCUENTOS}' => number_format($contrato->descuentos ?? 0, 2),
            '{SALARIO_NETO}' => number_format(($contrato->salario_base ?? 0) + ($contrato->bonificaciones ?? 0) - ($contrato->descuentos ?? 0), 2),
            '{MODALIDAD}' => $contrato->modalidad ?? '',
            '{MONEDA}' => $contrato->moneda ?? '',
            '{TIPO_PAGO}' => $contrato->tipo_pago ?? '',

            '{FECHA_INICIO}' => $contrato->fecha_inicio ? Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') : '',
            '{FECHA_FIN}' => $contrato->fecha_fin ? Carbon::parse($contrato->fecha_fin)->format('d/m/Y') : '',
            '{FECHA_FIRMA}' => $contrato->fecha_firma ? Carbon::parse($contrato->fecha_firma)->format('d/m/Y') : '',
            '{FECHA_ACTUAL}' => now()->format('d/m/Y'),
            '{FECHA_ACTUAL_LETRAS}' => $this->fechaEnLetras(now()),

            '{HORA_INICIO}' => $contrato->hora_inicio ? Carbon::parse($contrato->hora_inicio)->format('H:i') : '',
            '{HORA_FIN}' => $contrato->hora_fin ? Carbon::parse($contrato->hora_fin)->format('H:i') : '',
            '{DIAS_LABORALES}' => $contrato->dias_laborales ?? '',
            '{HORAS_SEMANALES}' => $contrato->horas_semanales ?? '',
            '{JORNADA_LABORAL}' => $contrato->jornada_laboral ?? '',

            '{BENEFICIOS}' => $contrato->beneficios ?? '',
            '{CLAUSULAS_ESPECIALES}' => $contrato->clausulas_especiales ?? '',
            '{OBSERVACIONES}' => $contrato->observaciones ?? '',

            default => $marcador
        };
    }

    // Convertir fecha a letras en español
    private function fechaEnLetras($fecha): string
    {
        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];

        $dia = $fecha->format('d');
        $mes = $meses[(int)$fecha->format('n')];
        $año = $fecha->format('Y');

        return "{$dia} días del mes de {$mes} del año {$año}";
    }
}
