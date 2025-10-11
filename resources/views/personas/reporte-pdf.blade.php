<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Personas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        /* Portada Profesional */
        .portada {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-after: always;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #dc2626 100%);
            color: white;
            padding: 60px 40px;
            text-align: center;
        }

        .portada-logo {
            text-align: center;
            margin-bottom: 80px;
        }

        .portada-logo-box {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .portada-logo-text {
            font-size: 36px;
            font-weight: bold;
            color: #dc2626;
            letter-spacing: 2px;
        }

        .portada-contenido {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .portada-institucion {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 60px;
            color: white;
        }

        .portada-titulo {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 20px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-top: 3px solid white;
            border-bottom: 3px solid white;
            padding: 30px 0;
        }

        .portada-subtitulo {
            font-size: 18px;
            margin-bottom: 80px;
            opacity: 0.9;
            font-style: italic;
        }

        .portada-info {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .portada-info-item {
            margin: 15px 0;
            font-size: 14px;
        }

        .portada-info-label {
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 5px;
        }

        .portada-info-value {
            font-size: 16px;
            color: white;
        }

        .portada-footer {
            text-align: center;
            padding-top: 40px;
            border-top: 2px solid rgba(255, 255, 255, 0.3);
        }

        .portada-fecha {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header p {
            font-size: 11px;
            opacity: 0.9;
        }

        .info-section {
            background-color: #f8f9fa;
            padding: 12px;
            margin-bottom: 15px;
            border-left: 4px solid #dc2626;
        }

        .info-section h3 {
            font-size: 12px;
            color: #dc2626;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            color: #1a1a1a;
        }

        .info-value {
            display: table-cell;
            color: #4a4a4a;
        }

        .tabla-personas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .tabla-personas thead {
            background-color: #1a1a1a;
            color: white;
        }

        .tabla-personas th {
            padding: 10px 6px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tabla-personas tbody tr {
            border-bottom: 1px solid #e0e0e0;
        }

        .tabla-personas tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .tabla-personas tbody tr:hover {
            background-color: #f1f1f1;
        }

        .tabla-personas td {
            padding: 8px 6px;
            font-size: 9px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-trabajador {
            background-color: #10b981;
            color: white;
        }

        .badge-no-trabajador {
            background-color: #6b7280;
            color: white;
        }

        .badge-masculino {
            background-color: #3b82f6;
            color: white;
        }

        .badge-femenino {
            background-color: #ec4899;
            color: white;
        }

        .badge-otro {
            background-color: #8b5cf6;
            color: white;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
            padding: 10px 0;
            border-top: 1px solid #e0e0e0;
        }

        .page-break {
            page-break-after: always;
        }

        .resumen {
            background-color: #fff;
            border: 2px solid #dc2626;
            padding: 12px;
            margin-bottom: 15px;
            text-align: center;
        }

        .resumen h2 {
            font-size: 14px;
            color: #dc2626;
            margin-bottom: 8px;
        }

        .resumen p {
            font-size: 12px;
            color: #1a1a1a;
            margin: 3px 0;
        }

        .foto-persona {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dc2626;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }

        .no-data i {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- ============================================ -->
    <!-- PORTADA PROFESIONAL -->
    <!-- ============================================ -->
    <div class="portada">
        <!-- Logo -->
        <div class="portada-logo">
            <div class="portada-logo-box">
                <span class="portada-logo-text">C</span>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="portada-contenido">
            <!-- Institución -->
            <div class="portada-institucion">
                CESODO - Centro de Estudios y Servicios
            </div>

            <!-- Título del Reporte -->
            <div class="portada-titulo">
                Reporte de Personas
            </div>

            <div class="portada-subtitulo">
                Sistema Integral de Gestión de Información
            </div>

            <!-- Información del Reporte -->
            <div class="portada-info">
                <div class="portada-info-item">
                    <span class="portada-info-label">Elaborado por:</span>
                    <span class="portada-info-value">{{ Auth::user()->name ?? 'Sistema CESODO' }}</span>
                </div>
                <div class="portada-info-item">
                    <span class="portada-info-label">Área:</span>
                    <span class="portada-info-value">Departamento de Recursos Humanos</span>
                </div>
                <div class="portada-info-item">
                    <span class="portada-info-label">Cargo:</span>
                    <span class="portada-info-value">{{ Auth::user()->rol ?? 'Administrador del Sistema' }}</span>
                </div>
                <div class="portada-info-item">
                    <span class="portada-info-label">Total de Registros:</span>
                    <span class="portada-info-value">{{ $total_personas }} persona(s)</span>
                </div>
            </div>
        </div>

        <!-- Footer con Fecha -->
        <div class="portada-footer">
            <div class="portada-fecha">
                {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- CONTENIDO DEL REPORTE -->
    <!-- ============================================ -->

    <!-- Header -->
    <div class="header">
        <h1>📋 REPORTE DE PERSONAS</h1>
        <p>Sistema de Gestión CESODO</p>
        <p>Generado el: {{ $fecha_generacion }}</p>
    </div>

    <!-- Resumen -->
    <div class="resumen">
        <h2>Total de Personas en el Reporte</h2>
        <p><strong>{{ $total_personas }}</strong> persona(s) registrada(s)</p>
    </div>

    <!-- Filtros Aplicados -->
    @if(array_filter($filtros))
    <div class="info-section">
        <h3>🔍 Filtros Aplicados</h3>
        @if($filtros['search'])
            <div class="info-row">
                <span class="info-label">Búsqueda:</span>
                <span class="info-value">{{ $filtros['search'] }}</span>
            </div>
        @endif
        @if($filtros['tipo_documento'])
            <div class="info-row">
                <span class="info-label">Tipo de Documento:</span>
                <span class="info-value">{{ strtoupper($filtros['tipo_documento']) }}</span>
            </div>
        @endif
        @if($filtros['genero'])
            <div class="info-row">
                <span class="info-label">Género:</span>
                <span class="info-value">
                    @if($filtros['genero'] == 'M') Masculino
                    @elseif($filtros['genero'] == 'F') Femenino
                    @else Otro
                    @endif
                </span>
            </div>
        @endif
        @if($filtros['estado_civil'])
            <div class="info-row">
                <span class="info-label">Estado Civil:</span>
                <span class="info-value">{{ ucfirst($filtros['estado_civil']) }}</span>
            </div>
        @endif
        @if($filtros['con_trabajador'])
            <div class="info-row">
                <span class="info-label">Relación Laboral:</span>
                <span class="info-value">{{ $filtros['con_trabajador'] == 'si' ? 'Con relación laboral' : 'Sin relación laboral' }}</span>
            </div>
        @endif
        @if($filtros['fecha_inicio'] || $filtros['fecha_fin'])
            <div class="info-row">
                <span class="info-label">Rango de Fechas:</span>
                <span class="info-value">
                    @if($filtros['fecha_inicio']) Desde: {{ \Carbon\Carbon::parse($filtros['fecha_inicio'])->format('d/m/Y') }} @endif
                    @if($filtros['fecha_fin']) Hasta: {{ \Carbon\Carbon::parse($filtros['fecha_fin'])->format('d/m/Y') }} @endif
                </span>
            </div>
        @endif
    </div>
    @endif

    <!-- Tabla de Personas -->
    @if($personas->count() > 0)
    <table class="tabla-personas">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                @if($opciones['incluir_foto'])
                <th style="width: 8%;">Foto</th>
                @endif
                <th style="width: 25%;">Nombre Completo</th>
                <th style="width: 12%;">Documento</th>
                <th style="width: 8%;">Género</th>
                @if($opciones['incluir_contacto'])
                <th style="width: 15%;">Contacto</th>
                @endif
                @if($opciones['incluir_direccion'])
                <th style="width: 17%;">Dirección</th>
                @endif
                <th style="width: 10%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personas as $index => $persona)
            <tr>
                <td>{{ $index + 1 }}</td>
                @if($opciones['incluir_foto'])
                <td style="text-align: center;">
                    @if($persona->foto)
                        <img src="{{ public_path('storage/' . $persona->foto) }}" class="foto-persona" alt="Foto">
                    @else
                        <div style="width: 35px; height: 35px; border-radius: 50%; background: #dc2626; color: white; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px;">
                            {{ strtoupper(substr($persona->nombres, 0, 1) . substr($persona->apellidos, 0, 1)) }}
                        </div>
                    @endif
                </td>
                @endif
                <td>
                    <strong>{{ $persona->apellidos }}, {{ $persona->nombres }}</strong>
                    @if($persona->fecha_nacimiento)
                        <br><small style="color: #6b7280;">{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años</small>
                    @endif
                </td>
                <td>
                    <strong>{{ strtoupper($persona->tipo_documento) }}</strong>
                    <br>{{ $persona->numero_documento }}
                </td>
                <td>
                    @if($persona->sexo == 'M')
                        <span class="badge badge-masculino">Masculino</span>
                    @elseif($persona->sexo == 'F')
                        <span class="badge badge-femenino">Femenino</span>
                    @else
                        <span class="badge badge-otro">Otro</span>
                    @endif
                </td>
                @if($opciones['incluir_contacto'])
                <td>
                    @if($persona->celular)
                        📱 {{ $persona->celular }}<br>
                    @endif
                    @if($persona->correo)
                        ✉️ <small>{{ $persona->correo }}</small>
                    @endif
                    @if(!$persona->celular && !$persona->correo)
                        <small style="color: #6b7280;">Sin contacto</small>
                    @endif
                </td>
                @endif
                @if($opciones['incluir_direccion'])
                <td>
                    @if($persona->direccion)
                        {{ $persona->direccion }}
                        @if($persona->pais)
                            <br><small style="color: #6b7280;">{{ $persona->pais }}</small>
                        @endif
                    @else
                        <small style="color: #6b7280;">Sin dirección</small>
                    @endif
                </td>
                @endif
                <td>
                    @if($persona->trabajador)
                        <span class="badge badge-trabajador">Trabajador</span>
                    @else
                        <span class="badge badge-no-trabajador">Sin relación</span>
                    @endif
                    @if($persona->estado_civil)
                        <br><small>{{ ucfirst($persona->estado_civil) }}</small>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p style="font-size: 14px; color: #1a1a1a; font-weight: bold;">No se encontraron personas con los filtros aplicados</p>
        <p style="font-size: 11px; color: #6b7280;">Intente modificar los criterios de búsqueda</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Sistema CESODO - Reporte generado automáticamente | Página <span class="pagenum"></span></p>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("Arial");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 30;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>
