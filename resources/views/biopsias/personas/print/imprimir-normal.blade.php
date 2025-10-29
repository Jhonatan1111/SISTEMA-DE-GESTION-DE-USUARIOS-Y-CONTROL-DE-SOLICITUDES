<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Biopsia - Reporte</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 40px 50px;
            font-size: 11pt;
            line-height: 1.4;
        }

        /* Header con logo y título */
        .header-container {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .header-text {
            flex: 1;
            text-align: center;
        }

        .header-title {
            color: #3FA9F5;
            font-size: 22pt;
            font-family: 'Brush Script MT', cursive, Arial;
            font-style: italic;
            margin-bottom: 3px;
        }

        .header-subtitle {
            color: #3FA9F5;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .header-info {
            color: #3FA9F5;
            font-size: 8pt;
            line-height: 1.3;
            font-weight: normal;
        }

        /* Línea azul separadora gruesa */
        .blue-line {
            border-bottom: 3px solid #3FA9F5;
            margin: 15px 0;
        }

        /* Información con líneas debajo */
        .info-line {
            margin-bottom: 12px;
            font-size: 11pt;
            border-bottom: 1px solid #3FA9F5;
            padding-bottom: 2px;
        }

        .info-label {
            color: #3FA9F5;
            font-weight: bold;
            display: inline;
        }

        .info-value {
            color: #000;
            display: inline;
        }

        /* Contenido descriptivo */
        .content-section {
            margin-top: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
        }

        .section-title {
            color: #000;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
            width: 150px;
            flex-shrink: 0;
            margin-right: 10px;
        }

        .content-text {
            color: #000;
            font-size: 11pt;
            line-height: 1.3;
            text-align: justify;
            margin-bottom: 8px;
            flex: 1;
        }

        /* Diagnóstico */
        .dx-section {
            margin-top: 25px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
        }

        .dx-label {
            color: #000;
            font-weight: bold;
            font-size: 11pt;
            width: 150px;
            flex-shrink: 0;
            margin-right: 10px;
        }

        .dx-item {
            color: #000;
            font-size: 11pt;
            line-height: 1.3;
            flex: 1;
        }

        /* Firma y fecha */
        .signature-container {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            page-break-inside: avoid;
            break-inside: avoid;
            min-height: 80px; /* Altura mínima para mantener consistencia */
            position: relative;
        }

        .fecha-reporte {
            flex: 0 0 auto;
            position: absolute;
            left: 0;
            bottom: 0;
        }

        .fecha-label {
            color: #3FA9F5;
            font-size: 10pt;
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
        }

        .fecha-value {
            color: #000;
            font-size: 11pt;
            border-bottom: 1px solid #3FA9F5;
            display: inline-block;
            min-width: 150px;
            padding-bottom: 2px;
        }

        .signature-area {
            flex: 0 0 auto;
            text-align: center;
            position: absolute;
            right: 0;
            bottom: 0;
        }

        .firma-manuscrita {
            font-family: 'Brush Script MT', cursive, Arial;
            font-size: 32pt;
            color: #000;
            margin-bottom: -5px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 280px;
            margin: 0 auto 5px auto;
        }

        .firma-nombre {
            color: #3FA9F5;
            font-size: 9pt;
            font-weight: normal;
            font-family: 'Brush Script MT', cursive, Arial;
            font-style: italic;
        }

        .firma-subtitle {
            color: #3FA9F5;
            font-size: 8pt;
            font-weight: normal;
        }

        /* Línea final azul */
        .final-line {
            border-bottom: 2px solid #3FA9F5;
            margin-top: 20px;
            margin-bottom: 15px;
            page-break-after: avoid;
        }

        /* Sello footer */
        .footer-seal {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            page-break-inside: avoid;
            break-inside: avoid;
            position: relative;
        }

        .seal-box {
            /* border: 2px solid #3FA9F5; */
            padding: 10px 30px;
            margin-top: -10px;
            text-align: center;
            display: inline-block;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .seal-name {
            color: #3FA9F5;
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .seal-info {
            color: #000;
            font-size: 8pt;
            margin: 1px 0;
        }

        .seal-id {
            color: #3FA9F5;
            font-size: 9pt;
            font-weight: bold;
            margin-top: 3px;
        }

        /* Botón de imprimir */
        .btn-print {
            background: #3FA9F5;
            color: white;
            padding: 12px 25px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 12pt;
            font-weight: bold;
        }

        .btn-print:hover {
            background: #2E8FD5;
        }

        @media print {

            .btn-print,
            .no-print {
                display: none;
            }

            body {
                padding: 20px;
            }

            /* Ocultar encabezados y pies de página del navegador */
            @page {
                margin: 0;
                size: auto;
            }

            html {
                margin: 0;
            }

            body {
                margin: 1cm;
            }
        }
    </style>
</head>

<body>
    <button class="btn-print no-print" onclick="window.print()">🖨️ Imprimir</button>

    <!-- Header con logo -->
    <div class="header-container">
        <svg class="logo" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <!-- Microscopio en azul -->
            <g fill="#3FA9F5">
                <ellipse cx="50" cy="25" rx="12" ry="15" />
                <rect x="45" y="35" width="10" height="30" />
                <polygon points="35,65 65,65 60,75 40,75" />
                <rect x="38" y="77" width="24" height="6" rx="2" />
                <ellipse cx="50" cy="88" rx="20" ry="5" />
            </g>
        </svg>
        <div class="header-text">
            <div class="header-title">Dra. Marta Evelyn Echeverría Martínez</div>
            <div class="header-subtitle">DOCTORA EN MEDICINA</div>
            <div class="header-info">
                POST GRADO: DEPTO. DE PATOLOGIA HOSPITAL NACIONAL ROSALES<br>
                ISTITUTO NAZIONALE PER LO STUDIO E LA CURA DEI TUMORI, MILAN, ITALIA
            </div>
        </div>
    </div>

    <div class="blue-line"></div>

    <!-- Información de la biopsia -->
    <div class="info-line">
        <span class="info-label">BIOPSIA N°:</span>
        <span class="info-value">{{ $biopsia->nbiopsia }}</span>
    </div>

    <div class="info-line">
        <span class="info-label">PACIENTE:</span>
        <span class="info-value">{{ strtoupper($biopsia->paciente->nombre . ' ' . $biopsia->paciente->apellido) }}</span>
        <span style="margin-left: 60px;"></span>
        <span class="info-label">EDAD:</span>
        <span class="info-value">{{ $biopsia->paciente->edad }} AÑOS</span>
        <span style="margin-left: 60px;"></span>
        <span class="info-label">SEXO:</span>
        <span class="info-value">{{ strtoupper($biopsia->paciente->sexo) }}</span>
    </div>

    <div class="info-line">
        <span class="info-label">REMITENTE:</span>
        <span class="info-value">
            @if($biopsia->remitente_especial)
            {{ strtoupper($biopsia->remitente_especial) }}
            @else
            {{ strtoupper('DR. ' . $biopsia->doctor->nombre . ' ' . $biopsia->doctor->apellido) }}
            @endif
        </span>
        <span style="margin-left: 60px;"></span>
        <span class="info-label">REGISTRO:</span>
        <span class="info-value">{{ $biopsia->doctor->jvpm ?? 'S/R' }}</span>
    </div>

    <div class="info-line">
        <span class="info-label">DIAGNOSTICO CLINICO:</span>
        <span class="info-value">{{ strtoupper($biopsia->diagnostico_clinico) }}</span>
    </div>

    <div class="info-line">
        <span class="info-label">FECHA DE RECIBIDA:</span>
        <span class="info-value">{{ \Carbon\Carbon::parse($biopsia->fecha_recibida)->format('d/m/Y') }}</span>
    </div>

    <!-- Contenido principal -->
    @if($biopsia->descripcion)
    <div class="content-section">
        <div class="content-text">
            {{ $biopsia->descripcion }}
        </div>
    </div>
    @endif

    <!-- Macroscópico -->
    @if($biopsia->macroscopico)
    <div class="content-section">
        <div class="section-title">Macroscópico</div>
        <div class="content-text">
            {{ $biopsia->macroscopico }}
        </div>
    </div>
    @endif

    <!-- Microscópico -->
    @if($biopsia->microscopico)
    <div class="content-section">
        <div class="section-title">Microscópico</div>
        <div class="content-text">
            {{ $biopsia->microscopico }}
        </div>
    </div>
    @endif

    <!-- Diagnóstico -->
    @if($biopsia->diagnostico)
    <div class="dx-section">
        <div class="dx-label">DIAGNÓSTICO</div>
        <div class="dx-item">{{ $biopsia->diagnostico }}</div>
    </div>
    @endif

    <!-- Firma y fecha -->
    <div class="signature-container">
        <div class="fecha-reporte">
            <span class="fecha-label">FECHA DE REPORTE:</span>
            <span class="fecha-value">{{ \Carbon\Carbon::parse($biopsia->created_at)->format('d/m/Y') }}</span>
        </div>
        <div class="signature-area">
            <img src="{{ asset('image/firma-doctora.png') }}" alt="Firma de la doctora" style="height: 60px; width: auto; margin-bottom: 5px;">
            <div class="signature-line"></div>
            <div class="firma-nombre">Dra. Marta Evelyn Echeverría Martínez</div>
            <div class="firma-subtitle">DOCTORA EN MEDICINA</div>
        </div>
    </div>

    <div class="final-line"></div>

    <!-- Sello de la doctora -->
    <div class="footer-seal">
        <div class="seal-box">
            <img src="{{ asset('image/sello-doctora.png') }}" alt="Sello Dra. Marta Evelyn Echeverría Martínez" style="max-width: 200px; height: 100px; width: auto;">
        </div>
    </div>

    <div style="margin-top: 20px; font-size: 8pt; color: #999; text-align: center;" class="no-print">
        <p>Impreso el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>