<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - {{ $institucion->nombre }}</title>
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

        .bloque-centro {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            text-transform: uppercase;
        }

        .nombre-institucion {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="sobre-container">
        <div class="bloque-centro">
            <div class="nombre-institucion">{{ $institucion->nombre }}</div>
        </div>
    </div>
</body>
</html>