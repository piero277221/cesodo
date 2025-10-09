<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContratoTemplate;

class ContratoTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContratoTemplate::create([
            'nombre' => 'Template Estándar de Contrato',
            'descripcion' => 'Template predeterminado basado en el formato actual del sistema',
            'tipo' => 'html',
            'contenido_html' => $this->getTemplateContent(),
            'activo' => true,
            'es_predeterminado' => true,
            'creado_por' => 1, // Usuario admin
        ]);
    }

    private function getTemplateContent(): string
    {
        return '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Trabajo #{NUMERO_CONTRATO}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .document-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
            text-transform: uppercase;
            color: #1e3a8a;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
            color: #1e3a8a;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .clause {
            margin-bottom: 15px;
            text-align: justify;
            line-height: 1.6;
        }

        .clause-number {
            font-weight: bold;
            color: #1e3a8a;
        }

        .signatures {
            margin-top: 50px;
            display: table;
            width: 100%;
        }

        .signature-row {
            display: table-row;
        }

        .signature-block {
            display: table-cell;
            width: 50%;
            padding: 20px;
            text-align: center;
            vertical-align: top;
        }

        .signature-line {
            border-top: 1px solid #333;
            padding-top: 10px;
            margin-top: 50px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">NOMBRE DE LA EMPRESA</div>
            <div class="header-info">
                RIF: J-12345678-9<br>
                Dirección: [DIRECCIÓN DE LA EMPRESA]<br>
                Teléfono: [TELÉFONO] | Email: [EMAIL]
            </div>
        </div>

        <!-- Document Title -->
        <div class="document-title">
            Contrato de Trabajo por Tiempo {TIPO_CONTRATO}
        </div>

        <!-- Contract Information -->
        <div class="section">
            <div class="section-title">Información del Contrato</div>

            <div class="clause">
                <strong>Número de Contrato:</strong> {NUMERO_CONTRATO}
            </div>

            <div class="clause">
                <strong>Fecha de Creación:</strong> {FECHA_ACTUAL}
            </div>
        </div>

        <!-- Parties -->
        <div class="section">
            <div class="section-title">Partes Contratantes</div>

            <div class="clause">
                <span class="clause-number">EMPLEADOR:</span>
                [NOMBRE DE LA EMPRESA], sociedad mercantil constituida y domiciliada
                con RIF J-12345678-9, domiciliada en [DIRECCIÓN DE LA EMPRESA],
                representada en este acto por [NOMBRE DEL REPRESENTANTE LEGAL],
                venezolano(a), mayor de edad, titular de la cédula de identidad No. [CÉDULA REPRESENTANTE],
                en su carácter de [CARGO], quien en adelante se denominará "EL EMPLEADOR".
            </div>

            <div class="clause">
                <span class="clause-number">TRABAJADOR:</span>
                {NOMBRE_TRABAJADOR}, venezolano(a), mayor de edad,
                titular de la cédula de identidad No. {CEDULA_TRABAJADOR},
                teléfono {TELEFONO_TRABAJADOR}, correo electrónico {EMAIL_TRABAJADOR},
                domiciliado(a) en {DIRECCION_TRABAJADOR},
                quien en adelante se denominará "EL TRABAJADOR".
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="section">
            <div class="section-title">Términos y Condiciones</div>

            <div class="clause">
                <span class="clause-number">PRIMERA (OBJETO):</span>
                EL EMPLEADOR contrata los servicios profesionales de EL TRABAJADOR para desempeñar
                el cargo de <strong>{CARGO}</strong> en el departamento de <strong>{DEPARTAMENTO}</strong>,
                bajo la modalidad de <strong>{MODALIDAD}</strong>.
            </div>

            <div class="clause">
                <span class="clause-number">SEGUNDA (DURACIÓN):</span>
                El presente contrato es por tiempo <strong>{TIPO_CONTRATO}</strong>,
                iniciando sus efectos el día {FECHA_INICIO} y culminando el {FECHA_FIN}.
            </div>

            <div class="clause">
                <span class="clause-number">TERCERA (JORNADA LABORAL):</span>
                EL TRABAJADOR prestará sus servicios de {HORA_INICIO} a {HORA_FIN},
                {DIAS_LABORALES}, para un total de {HORAS_SEMANALES} horas semanales.
                La jornada será: {JORNADA_LABORAL}.
            </div>

            <div class="clause">
                <span class="clase-number">CUARTA (REMUNERACIÓN):</span>
                EL EMPLEADOR pagará a EL TRABAJADOR un salario base de
                <strong>{SALARIO_BASE} {MONEDA}</strong> de forma {TIPO_PAGO},
                más bonificaciones por {BONIFICACIONES} {MONEDA}.
                El salario neto será de <strong>{SALARIO_NETO} {MONEDA}</strong>.
            </div>

            <div class="clause">
                <span class="clause-number">QUINTA (BENEFICIOS):</span>
                EL TRABAJADOR tendrá derecho a los siguientes beneficios: {BENEFICIOS}.
            </div>

            <div class="clause">
                <span class="clause-number">SEXTA (OBLIGACIONES):</span>
                EL TRABAJADOR se compromete a cumplir con las políticas y procedimientos
                de la empresa, mantener confidencialidad sobre la información empresarial
                y desempeñar sus funciones con la mayor diligencia y profesionalismo.
            </div>

            <div class="clause">
                <span class="clause-number">SÉPTIMA (CLÁUSULAS ESPECIALES):</span>
                {CLAUSULAS_ESPECIALES}
            </div>

            <div class="clause">
                <span class="clause-number">OBSERVACIONES:</span>
                {OBSERVACIONES}
            </div>
        </div>

        <!-- Final Clause -->
        <div class="section">
            <div class="clause">
                En constancia de conformidad, las partes firman el presente contrato en dos (2) ejemplares
                de igual tenor y validez, en la ciudad de [CIUDAD], a los {FECHA_ACTUAL_LETRAS}.
            </div>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-row">
                <div class="signature-block">
                    <div class="signature-line">
                        <strong>EL EMPLEADOR</strong><br>
                        [NOMBRE DEL REPRESENTANTE LEGAL]<br>
                        C.I: [CÉDULA REPRESENTANTE]<br>
                        [CARGO]
                    </div>
                </div>
                <div class="signature-block">
                    <div class="signature-line">
                        <strong>EL TRABAJADOR</strong><br>
                        {NOMBRE_TRABAJADOR}<br>
                        C.I: {CEDULA_TRABAJADOR}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Documento generado el {FECHA_ACTUAL} | Sistema de Gestión de Contratos
        </div>
    </div>
</body>
</html>';
    }
}
