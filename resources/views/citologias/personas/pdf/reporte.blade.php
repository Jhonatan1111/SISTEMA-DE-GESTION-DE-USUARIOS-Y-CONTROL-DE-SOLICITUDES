<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Biopsias - Personas</title>
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

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #10b981; /* Verde, igual que Mascotas */
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            color: #047857; /* Verde oscuro, igual que Mascotas */
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        .info {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-item {
            display: table-cell;
            width: 33.33%;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #10b981; /* Verde, igual que Mascotas */
            color: white;
            padding: 8px 4px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
        }

        td {
            padding: 6px 4px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-normal {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-liquida {
            background-color: #e9d5ff;
            color: #6b21a8;
        }

        .badge-activa {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-inactiva {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-style: italic;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Laboratorio de Anatomía Patológico Echeverría</h1>
        <p>Reporte de Biopsias - Personas</p>
    </div>

    <!-- Info -->
    <div class="info">
        <div class="info-item">
            <span class="info-label">Fecha de generación:</span> {{ $fecha }}
        </div>
        <div class="info-item" style="text-align: center;">
            <span class="info-label">Tipo:</span> {{ $tipo }}
        </div>
        <div class="info-item" style="text-align: right;">
            <span class="info-label">Total de registros:</span> {{ $total }}
        </div>
    </div>

    <!-- Tabla de biopsias -->
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Número</th>
                <th style="width: 8%;">Tipo</th>
                <th style="width: 10%;">Fecha</th>
                <th style="width: 22%;">Paciente</th>
                <th style="width: 12%;">DUI</th>
                <th style="width: 20%;">Doctor</th>
                <th style="width: 10%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($biopsias as $biopsia)
            <tr>
                <td><strong>{{ $biopsia->nbiopsia }}</strong></td>
                <td>
                    <span class="badge badge-{{ $biopsia->tipo }}">
                        {{ ucfirst($biopsia->tipo) }}
                    </span>
                </td>
                <td>{{ $biopsia->fecha_recibida->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $biopsia->paciente->nombre }} {{ $biopsia->paciente->apellido }}</strong><br>
                    <small>{{ $biopsia->paciente->edad }} años - {{ $biopsia->paciente->sexo === 'M' ? 'Masculino' : 'Femenino' }}</small>
                </td>
                <td>{{ $biopsia->paciente->dui }}</td>
                <td>
                    Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}<br>
                    <small>{{ $biopsia->doctor->jvpm ?? 'N/A' }}</small>
                </td>
                <td>
                    <span class="badge badge-{{ $biopsia->estado ? 'activa' : 'inactiva' }}">
                        {{ $biopsia->estado ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="no-data">
                    No se encontraron biopsias de personas con los filtros aplicados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>© 2025 Laboratorio de Anatomía Patológico Echeverría - Todos los derechos reservados</strong></p>
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>