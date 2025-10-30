<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Biopsia N° {{ $biopsia->nbiopsia }}</title>
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

        .header-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-cell {
            width: 100px;
            vertical-align: top;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .header-text {
            text-align: center;
            vertical-align: top;
        }

        .header-title {
            color: #3FA9F5;
            font-size: 22pt;
            font-weight: bold;
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
        }

        .blue-line {
            border-bottom: 3px solid #3FA9F5;
            margin: 15px 0;
        }

        .info-line {
            margin-bottom: 12px;
            font-size: 11pt;
            border-bottom: 1px solid #3FA9F5;
            padding-bottom: 2px;
        }

        .info-label {
            color: #3FA9F5;
            font-weight: bold;
        }

        .info-value {
            color: #000;
        }

        .content-table {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .section-title {
            width: 150px;
            color: #000;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
            vertical-align: top;
            padding-right: 20px;
            padding-bottom: 10px;
        }

        .content-text {
            color: #000;
            font-size: 11pt;
            line-height: 1.5;
            text-align: justify;
            vertical-align: top;
            padding-bottom: 10px;
        }

        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }

        .fecha-cell {
            width: 35%;
            vertical-align: bottom;
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

        .firma-cell {
            width: 65%;
            text-align: center;
            vertical-align: bottom;
        }

        .firma-img {
            height: 50px;
            width: auto;
            display: block;
            margin: 0 auto 5px auto;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 280px;
            margin: 10px auto 5px auto;
        }

        .firma-nombre {
            color: #3FA9F5;
            font-size: 10pt;
            font-weight: bold;
            font-style: italic;
        }

        .firma-subtitle {
            color: #3FA9F5;
            font-size: 9pt;
        }

        .final-line {
            border-bottom: 2px solid #3FA9F5;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        .footer-section {
            text-align: right;
            margin-top: 10px;
        }

        .sello-img {
            max-width: 200px;
            height: 100px;
            width: auto;
        }

        /* Estilos específicos para PDF */
        @page {
            margin: 1cm;
            size: A4;
        }

        /* Ocultar elementos no necesarios en PDF */
        .no-print {
            display: none;
        }

        @page {
            margin: 1.5cm;
            size: A4 portrait;
        }
    </style>
</head>

<body>
    <!-- Header con logo -->
    <div class="header-container">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    @if(file_exists(public_path('image/logo.png')))
                    <img src="{{ public_path('image/logo.png') }}" class="logo" alt="Logo">
                    @endif
                </td>
                <td class="header-text">
                    <div class="header-title">Dra. Marta Evelyn Echeverría Martínez</div>
                    <div class="header-subtitle">DOCTORA EN MEDICINA</div>
                    <div class="header-info">
                        POST GRADO: DEPTO. DE PATOLOGIA HOSPITAL NACIONAL ROSALES<br>
                        ISTITUTO NAZIONALE PER LO STUDIO E LA CURA DEI TUMORI, MILAN, ITALIA
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="blue-line"></div>

    <!-- Información de la biopsia -->
    <div class="info-line">
        <span class="info-label">BIOPSIA N°:</span>
        <span class="info-value">{{ $biopsia->nbiopsia }}</span>
    </div>

    <div class="info-line">
        <span class="info-label">MASCOTA:</span>
        <span class="info-value">{{ strtoupper($biopsia->mascota->nombre) }}</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="info-label">ESPECIE:</span>
        <span class="info-value">{{ strtoupper($biopsia->mascota->especie) }}</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="info-label">RAZA:</span>
        <span class="info-value">{{ strtoupper($biopsia->mascota->raza) }}</span>
    </div>

    <div class="info-line">
        <span class="info-label">DUEÑO:</span>
        <span class="info-value">{{ strtoupper($biopsia->mascota->propietario) }}</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="info-label">SEXO:</span>
        <span class="info-value">{{ strtoupper($biopsia->mascota->sexo) }}</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="info-label">EDAD:</span>
        <span class="info-value">{{ $biopsia->mascota->edad }} AÑOS</span>
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
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
    <table class="content-table">
        <tr>
            <td colspan="2" class="content-text">{{ $biopsia->descripcion }}</td>
        </tr>
    </table>
    @endif

    @if($biopsia->macroscopico)
    <table class="content-table">
        <tr>
            <td class="section-title">MACROSCÓPICO</td>
            <td class="content-text">{{ $biopsia->macroscopico }}</td>
        </tr>
    </table>
    @endif

    @if($biopsia->microscopico)
    <table class="content-table">
        <tr>
            <td class="section-title">MICROSCÓPICO</td>
            <td class="content-text">{{ $biopsia->microscopico }}</td>
        </tr>
    </table>
    @endif

    @if($biopsia->diagnostico)
    <table class="content-table">
        <tr>
            <td class="section-title">DIAGNÓSTICO</td>
            <td class="content-text">{{ $biopsia->diagnostico }}</td>
        </tr>
    </table>
    @endif

    <!-- Firma y fecha -->
    <table class="signature-table">
        <tr>
            <td class="fecha-cell">
                <span class="fecha-label">FECHA DE REPORTE:</span><br>
                <span class="fecha-value">{{ \Carbon\Carbon::parse($biopsia->created_at)->format('d/m/Y') }}</span>
            </td>
            <td class="firma-cell">
                @if(file_exists(public_path('image/firma-doctora.png')))
                <img src="{{ public_path('image/firma-doctora.png') }}" class="firma-img" alt="Firma">
                @endif
                <div class="signature-line"></div>
                <div class="firma-nombre">Dra. Marta Evelyn Echeverría Martínez</div>
                <div class="firma-subtitle">DOCTORA EN MEDICINA</div>
            </td>
        </tr>
    </table>

    <div class="final-line"></div>

    <!-- Sello -->
    <div class="footer-section">
        @if(file_exists(public_path('image/sello-doctora.png')))
        <img src="{{ public_path('image/sello-doctora.png') }}" class="sello-img" alt="Sello">
        @endif
    </div>
</body>

</html>