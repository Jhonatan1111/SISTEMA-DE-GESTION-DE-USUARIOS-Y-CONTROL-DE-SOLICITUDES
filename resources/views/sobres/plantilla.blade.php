<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - {{ $doctor->nombre }}@if($paciente) - {{ $paciente->nombre }}@endif</title>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Tamaño real del sobre COM10 (24.1 x 10.5 cm) */
        @page {
            size: 241mm 105mm;
            margin: 0;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            width: 241mm;
            height: 105mm;
            position: relative;
            background: white;
        }

        .sobre-container {
            width: 100%;
            height: 100%;
            position: relative;
        }

        /* Texto centrado en medio de la página */
        .bloque-inferior-izquierdo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
            text-transform: uppercase;
        }

        .nombre-doctor {
            font-weight: bold;
            font-size: 16px;
        }

        .nombre-paciente {
            font-size: 15px;
            color: #555;
            margin-top: 3mm;
        }
    </style>
</head>
<body>
    <div class="sobre-container">
        <div class="bloque-inferior-izquierdo">
            <div class="nombre-doctor">Dr/a: {{ $doctor->nombre }} {{ $doctor->apellido }}</div>
            @if($paciente)
                <div class="nombre-paciente">PTE: {{ $paciente->nombre }} {{ $paciente->apellido }}</div>
            @endif
        </div>
    </div>
</body>
</html>