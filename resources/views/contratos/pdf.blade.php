<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Trabajo #{{ $contrato->numero_contrato ?? 'SIN NÚMERO' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
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

        /* Header */
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

        .header-info {
            font-size: 10px;
            color: #666;
        }

        /* Title */
        .document-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 30px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Contract info */
        .contract-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .contract-info h3 {
            color: #1e3a8a;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #374151;
            padding: 3px 10px 3px 0;
            width: 30%;
            vertical-align: top;
        }

        .info-value {
            display: table-cell;
            padding: 3px 0;
            vertical-align: top;
        }

        /* Content sections */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #1e3a8a;
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .clause {
            text-align: justify;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .clause-number {
            font-weight: bold;
            color: #1e3a8a;
        }

        /* Economic info */
        .economic-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .economic-table th,
        .economic-table td {
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            text-align: left;
        }

        .economic-table th {
            background: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }

        .amount {
            text-align: right;
            font-weight: bold;
        }

        .total-row {
            background: #fef3c7;
            font-weight: bold;
        }

        /* Signatures */
        .signatures {
            margin-top: 50px;
            page-break-inside: avoid;
        }

        .signature-row {
            display: table;
            width: 100%;
            margin-top: 40px;
        }

        .signature-block {
            display: table-cell;
            width: 48%;
            text-align: center;
            vertical-align: top;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 8px;
            font-size: 11px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            font-size: 9px;
            color: #6b7280;
            text-align: center;
        }

        /* Page break utilities */
        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        /* Status badge */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-activo { background: #dcfce7; color: #166534; }
        .status-borrador { background: #fef3c7; color: #92400e; }
        .status-enviado { background: #dbeafe; color: #1e40af; }
        .status-finalizado { background: #f3f4f6; color: #374151; }

        /* Print styles */
        @media print {
            body { margin: 0; }
            .container { padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">CESODO</div>
            <div class="header-info">
                Centro de Servicios Odontológicos<br>
                RIF: J-12345678-9 | Tel: (000) 123-4567<br>
                direccion@cesodo.com | www.cesodo.com
            </div>
        </div>

        <!-- Document Title -->
        <div class="document-title">
            Contrato de Trabajo
            @if($contrato->numero_contrato)
                <br><small style="font-size: 14px;">No. {{ $contrato->numero_contrato }}</small>
            @endif
        </div>

        <!-- Contract Basic Info -->
        <div class="contract-info">
            <h3>Información del Contrato</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Tipo de Contrato:</div>
                    <div class="info-value">{{ ucwords(str_replace('_', ' ', $contrato->tipo_contrato)) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Estado:</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $contrato->estado }}">
                            {{ ucfirst($contrato->estado) }}
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fecha de Emisión:</div>
                    <div class="info-value">{{ $contrato->created_at->format('d/m/Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Vigencia:</div>
                    <div class="info-value">
                        Desde {{ $contrato->fecha_inicio->format('d/m/Y') }}
                        @if($contrato->fecha_fin)
                            hasta {{ $contrato->fecha_fin->format('d/m/Y') }}
                        @else
                            (Indefinido)
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Parties Section -->
        <div class="section">
            <div class="section-title">PARTES CONTRATANTES</div>

            <div class="clause">
                <span class="clause-number">EMPLEADOR:</span>
                CENTRO DE SERVICIOS ODONTOLÓGICOS (CESODO), empresa legalmente constituida,
                con RIF J-12345678-9, domiciliada en [DIRECCIÓN DE LA EMPRESA],
                representada en este acto por [NOMBRE DEL REPRESENTANTE LEGAL],
                venezolano(a), mayor de edad, titular de la cédula de identidad No. [CÉDULA REPRESENTANTE],
                en su carácter de [CARGO], quien en adelante se denominará "EL EMPLEADOR".
            </div>

            <div class="clause">
                <span class="clause-number">TRABAJADOR:</span>
                {{ strtoupper($contrato->persona->nombres . ' ' . $contrato->persona->apellidos) }},
                venezolano(a), mayor de edad, titular de la cédula de identidad No. {{ $contrato->persona->numero_documento }},
                @if($contrato->persona->celular)
                    teléfono {{ $contrato->persona->celular }},
                @endif
                @if($contrato->persona->correo)
                    correo electrónico {{ $contrato->persona->correo }},
                @endif
                domiciliado(a) en {{ $contrato->persona->direccion ?? '[DIRECCIÓN DEL TRABAJADOR]' }},
                quien en adelante se denominará "EL TRABAJADOR".
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="section">
            <div class="section-title">TÉRMINOS Y CONDICIONES</div>

            <div class="clause">
                <span class="clause-number">PRIMERA (OBJETO):</span>
                EL EMPLEADOR contrata los servicios profesionales de EL TRABAJADOR para desempeñar
                el cargo de <strong>{{ $contrato->cargo }}</strong>
                @if($contrato->departamento)
                    en el departamento de <strong>{{ $contrato->departamento }}</strong>
                @endif
                , con las responsabilidades, funciones y actividades inherentes al cargo,
                así como aquellas que le sean asignadas por sus superiores jerárquicos.
            </div>

            <div class="clause">
                <span class="clause-number">SEGUNDA (DURACIÓN):</span>
                @if($contrato->tipo_contrato === 'indefinido')
                    El presente contrato es por tiempo INDEFINIDO, iniciando sus efectos
                    el día {{ $contrato->fecha_inicio->format('d/m/Y') }}.
                @else
                    @php
                        $fechaInicio = \Carbon\Carbon::parse($contrato->fecha_inicio);
                        $fechaFin = \Carbon\Carbon::parse($contrato->fecha_fin);
                        $dias = (int) floor($fechaInicio->diffInDays($fechaFin, false));
                    @endphp
                    El presente contrato tendrá una duración de
                    {{ $dias }} días,
                    iniciando el {{ $contrato->fecha_inicio->format('d/m/Y') }}
                    y culminando el {{ $contrato->fecha_fin->format('d/m/Y') }}.
                @endif
            </div>

            <div class="clause">
                <span class="clause-number">TERCERA (JORNADA LABORAL):</span>
                EL TRABAJADOR prestará sus servicios en jornada de
                <strong>{{ ucwords(str_replace('_', ' ', $contrato->jornada_laboral)) }}</strong>
                , cumpliendo con los horarios establecidos por EL EMPLEADOR
                y las disposiciones legales vigentes.
            </div>
        </div>

        <!-- Economic Information -->
        <div class="section">
            <div class="section-title">CONDICIONES ECONÓMICAS</div>

            <div class="clause">
                <span class="clause-number">CUARTA (SALARIO):</span>
                EL EMPLEADOR pagará a EL TRABAJADOR por sus servicios la cantidad de:
            </div>

            <table class="economic-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Salario Base</td>
                        <td class="amount">${{ number_format($contrato->salario, 2) }}</td>
                    </tr>
                    @if($contrato->bonificaciones > 0)
                    <tr>
                        <td>Bonificaciones</td>
                        <td class="amount">${{ number_format($contrato->bonificaciones, 2) }}</td>
                    </tr>
                    @endif
                    @if($contrato->descuentos > 0)
                    <tr>
                        <td>Descuentos</td>
                        <td class="amount">-${{ number_format($contrato->descuentos, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="total-row">
                        <td><strong>SALARIO NETO MENSUAL</strong></td>
                        <td class="amount">
                            <strong>${{ number_format($contrato->salario + $contrato->bonificaciones - $contrato->descuentos, 2) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="clause">
                El salario será pagado mensualmente, los días 30 de cada mes o el día hábil anterior
                si coincide con día no laborable, mediante transferencia bancaria a la cuenta
                que indique EL TRABAJADOR.
            </div>
        </div>

        <!-- Additional Clauses -->
        <div class="section">
            <div class="section-title">CLÁUSULAS ADICIONALES</div>

            <div class="clause">
                <span class="clause-number">QUINTA (OBLIGACIONES DEL TRABAJADOR):</span>
                EL TRABAJADOR se compromete a: a) Cumplir con las funciones asignadas con diligencia y profesionalismo;
                b) Respetar los horarios establecidos; c) Mantener confidencialidad sobre la información de la empresa;
                d) Cumplir con las normas internas y reglamentos de la empresa; e) Cuidar los bienes y recursos asignados.
            </div>

            <div class="clause">
                <span class="clause-number">SEXTA (OBLIGACIONES DEL EMPLEADOR):</span>
                EL EMPLEADOR se compromete a: a) Pagar puntualmente el salario acordado;
                b) Proporcionar las herramientas y recursos necesarios para el trabajo;
                c) Respetar los derechos laborales; d) Mantener un ambiente de trabajo seguro;
                e) Cumplir con las prestaciones sociales establecidas por ley.
            </div>

            @if($contrato->clausulas_especiales)
            <div class="clause">
                <span class="clause-number">SÉPTIMA (CLÁUSULAS ESPECIALES):</span>
                {{ $contrato->clausulas_especiales }}
            </div>
            @endif

            <div class="clause">
                <span class="clause-number">OCTAVA (TERMINACIÓN):</span>
                El presente contrato podrá terminarse por las causales establecidas en la
                Ley Orgánica del Trabajo, los Trabajadores y las Trabajadoras, así como
                por mutuo acuerdo entre las partes.
            </div>

            <div class="clause">
                <span class="clause-number">NOVENA (LEY APLICABLE):</span>
                Este contrato se rige por las disposiciones de la Ley Orgánica del Trabajo,
                los Trabajadores y las Trabajadoras, su Reglamento y demás normas laborales vigentes.
            </div>

            @if($contrato->observaciones)
            <div class="clause">
                <span class="clause-number">OBSERVACIONES:</span>
                {{ $contrato->observaciones }}
            </div>
            @endif
        </div>

        <!-- Final Clause -->
        <div class="section no-break">
            <div class="clause">
                En constancia de conformidad, las partes firman el presente contrato en dos (2) ejemplares
                de igual tenor y validez, en la ciudad de [CIUDAD], a los
                {{ $contrato->created_at->format('d') }} días del mes de
                @php
                    $meses = [
                        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
                        5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
                        9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
                    ];
                    echo $meses[$contrato->created_at->format('n')];
                @endphp del año
                {{ $contrato->created_at->format('Y') }}.
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
                        {{ strtoupper($contrato->persona->nombres . ' ' . $contrato->persona->apellidos) }}<br>
                        C.I: {{ $contrato->persona->numero_documento }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                Documento generado el {{ now()->format('d/m/Y H:i:s') }} |
                Contrato #{{ $contrato->numero_contrato ?? 'SIN NÚMERO' }} |
                Estado: {{ ucfirst($contrato->estado) }}
            </div>
        </div>
    </div>
</body>
</html>
