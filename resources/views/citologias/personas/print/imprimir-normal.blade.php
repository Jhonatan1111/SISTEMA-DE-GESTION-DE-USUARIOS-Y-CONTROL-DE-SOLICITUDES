<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Citología Normal {{ $citologia->ncitologia }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            font-size: 11pt;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-title {
            color: #4A90E2;
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header-subtitle {
            color: #4A90E2;
            font-size: 10pt;
            margin-bottom: 3px;
        }

        /* Línea azul separadora */
        .blue-line {
            border-bottom: 3px solid #4A90E2;
            margin: 15px 0;
        }

        /* Información básica */
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 10pt;
        }

        .info-label {
            color: #4A90E2;
            font-weight: bold;
            display: inline-block;
            min-width: 120px;
        }

        .info-value {
            color: #000;
            flex: 1;
        }

        /* Secciones de contenido */
        .section {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .section-label {
            color: #4A90E2;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 5px;
        }

        .section-content {
            color: #000;
            font-size: 10pt;
            line-height: 1.4;
            text-align: justify;
            padding-left: 10px;
        }

        /* Diagnóstico final */
        .diagnostico-final {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .diagnostico-text {
            color: #000;
            font-weight: bold;
            font-size: 11pt;
        }

        /* Firma */
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 45%;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-bottom: 5px;
            padding-top: 50px;
        }

        .signature-label {
            font-size: 9pt;
            color: #000;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            border: 2px solid #4A90E2;
            padding: 10px;
        }

        .footer-text {
            color: #4A90E2;
            font-size: 9pt;
            font-weight: bold;
        }

        .footer-id {
            color: #000;
            font-size: 8pt;
        }

        /* Botón de imprimir */
        .btn-print {
            background: #4A90E2;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 12pt;
        }

        .btn-print:hover {
            background: #357ABD;
        }

        @media print {

            .btn-print,
            .no-print {
                display: none;
            }

            body {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <button class="btn-print no-print" onclick="window.print()">🖨️ Imprimir</button>

    <!-- Header -->
    <div class="header">
        <div class="header-title">Dra. Marilú Evelyn Echeverría Martínez</div>
        <div class="header-subtitle">DOCTORA EN MEDICINA</div>
        <div class="header-subtitle" style="font-size: 8pt;">
            POST GRADO UPEDI DE PATOLOGIA CLINICA, ANÁTOMICA Y FORENSE<br>
            MEDICO ESPECIALISTA EN URGENCIAS Y CLINICAS PATOLOGIA, BANCO DE SANGRE
        </div>
    </div>

    <div class="blue-line"></div>

    <!-- Información básica -->
    <div class="info-row">
        <div>
            <span class="info-label">CITOLOGÍA N°:</span>
            <span class="info-value">{{ $citologia->ncitologia }}</span>
        </div>
    </div>

    <div class="info-row">
        <div style="flex: 1;">
            <span class="info-label">PACIENTE:</span>
            <span class="info-value">{{ strtoupper($citologia->paciente->nombre . ' ' . $citologia->paciente->apellido) }}</span>
        </div>
        <div style="flex: 0 0 auto; margin-left: 20px;">
            <span class="info-label">EDAD:</span>
            <span class="info-value">{{ $citologia->paciente->edad }} AÑOS</span>
        </div>
        <div style="flex: 0 0 auto; margin-left: 20px;">
            <span class="info-label">SEXO:</span>
            <span class="info-value">{{ strtoupper($citologia->paciente->sexo) }}</span>
        </div>
    </div>

    <div class="info-row">
        <div>
            <span class="info-label">REMITENTE:</span>
            <span class="info-value">
                @if($citologia->remitente_especial)
                {{ strtoupper($citologia->remitente_especial) }}
                @else
                {{ strtoupper('DR. ' . $citologia->doctor->nombre . ' ' . $citologia->doctor->apellido) }}
                @endif
            </span>
        </div>
        <div style="flex: 0 0 auto; margin-left: 20px;">
            <span class="info-label">REGISTRO:</span>
            <span class="info-value">{{ $citologia->paciente->id }}</span>
        </div>
    </div>

    <div class="info-row">
        <div>
            <span class="info-label">DIAGNOSTICO CLINICO:</span>
            <span class="info-value">{{ strtoupper($citologia->diagnostico_clinico) }}</span>
        </div>
    </div>

    <div class="info-row">
        <div>
            <span class="info-label">FECHA DE RECIBIDA:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($citologia->fecha_recibida)->format('d/m/Y') }}</span>
        </div>
    </div>

    <div class="blue-line"></div>

    <!-- Macroscópico -->
    @if($citologia->macroscopico)
    <div class="section">
        <div class="section-label">MACROSCÓPICO</div>
        <div class="section-content">
            {{ $citologia->macroscopico }}
        </div>
    </div>
    @endif

    <!-- Microscópico -->
    @if($citologia->microscopico)
    <div class="section">
        <div class="section-label">MICROSCÓPICO</div>
        <div class="section-content">
            {{ $citologia->microscopico }}
        </div>
    </div>
    @endif

    <!-- Diagnóstico -->
    @if($citologia->diagnostico)
    <div class="diagnostico-final">
        <div class="section-label">DIAGNÓSTICO</div>
        <div class="diagnostico-text">
            {{ strtoupper($citologia->diagnostico) }}
        </div>
    </div>
    @endif

    <!-- Firmas -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">FECHA DE REPORTE: {{ \Carbon\Carbon::parse($citologia->created_at)->format('d/m/Y') }}</div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">Dra. Marilú Evelyn Echeverría Martínez<br>DOCTORA EN MEDICINA</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-text">Dra. Marilú Evelyn Echeverría Martínez</div>
        <div class="footer-id">NIF-210R PATOLOGIA 2-6853</div>
        <div class="footer-text">J.V.P.M. No. 4448</div>
    </div>

    <div style="margin-top: 20px; font-size: 8pt; color: #666; text-align: center;" class="no-print">
        <p>Fecha de impresión: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>