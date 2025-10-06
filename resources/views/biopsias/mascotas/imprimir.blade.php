<!DOCTYPE html>
<html>

<head>
    <title>Biopsia {{ $biopsia->nbiopsia }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }

        .btn-print {
            background: #3b82f6;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin: 20px 0;
        }

        @media print {

            .btn-print,
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button class="btn-print no-print" onclick="window.print()">🖨️ Imprimir</button>

    <div class="header">
        <h1>Informe de Biopsia</h1>
        <p>N° {{ $biopsia->nbiopsia }}</p>
    </div>

    <div class="section">
        <span class="label">Fecha Recibida:</span> {{ $biopsia->fecha_recibida->format('d/m/Y') }}
    </div>

    <div class="section">
        <span class="label">Mascota:</span> {{ $biopsia->mascota->nombre }}
    </div>

    <div class="section">
        <span class="label">Propietario:</span> {{ $biopsia->mascota->propietario ?? 'N/A' }}
    </div>

    <div class="section">
        <span class="label">Raza:</span> {{ $biopsia->mascota->raza ?? 'N/A' }}
    </div>

    <div class="section">
        <span class="label">Edad:</span> {{ $biopsia->mascota->edad }} años
    </div>

    <div class="section">
        <span class="label">Sexo:</span> {{ $biopsia->mascota->sexo === 'M' ? 'Masculino' : 'Femenino' }}
    </div>

    <div class="section">
        <span class="label">Doctor:</span> Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}
    </div>

    <div class="section">
        <span class="label">Diagnóstico Clínico:</span><br>
        <p style="margin-left: 150px; margin-top: 5px;">{{ $biopsia->diagnostico_clinico }}</p>
    </div>

    @if($biopsia->diagnostico)
    <div class="section">
        <span class="label">Diagnóstico Final:</span><br>
        <p style="margin-left: 150px; margin-top: 5px;">{{ $biopsia->diagnostico }}</p>
    </div>
    @endif

    @if($biopsia->descripcion)
    <div class="section">
        <span class="label">Descripción:</span><br>
        <p style="margin-left: 150px; margin-top: 5px;">{{ $biopsia->descripcion }}</p>
    </div>
    @endif

    @if($biopsia->macroscopico)
    <div class="section">
        <span class="label">Macroscópico:</span><br>
        <p style="margin-left: 150px; margin-top: 5px;">{{ $biopsia->macroscopico }}</p>
    </div>
    @endif

    @if($biopsia->microscopico)
    <div class="section">
        <span class="label">Microscópico:</span><br>
        <p style="margin-left: 150px; margin-top: 5px;">{{ $biopsia->microscopico }}</p>
    </div>
    @endif

    <div class="section">
        <span class="label">Estado:</span> {{ $biopsia->estado ? 'Activa' : 'Inactiva' }}
    </div>

    <div class="section" style="margin-top: 50px; font-size: 12px; color: #666;">
        <p>Fecha de impresión: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>