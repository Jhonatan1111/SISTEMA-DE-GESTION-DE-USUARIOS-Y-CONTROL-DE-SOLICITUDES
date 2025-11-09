<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Biopsias</title>
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
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            color: #1e40af;
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
            width: 50%;
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
            background-color: #2563eb;
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

        .badge-persona {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-mascota {
            background-color: #d1fae5;
            color: #065f46;
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

        /* Detalle de filtros */
        .detalle-box {
            border: 1px solid #e5e7eb;
            border-left: 3px solid #2563eb;
            background: #f9fafb;
            padding: 8px;
            margin-bottom: 10px;
        }
        .detalle-grid {
            display: table;
            width: 100%;
            margin-top: 6px;
        }
        .detalle-item {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
            font-size: 9px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Laboratorio de Anatomía Patológico Echeverría</h1>
        <p>Reporte de Biopsias</p>
    </div>

    <!-- Info -->
    <div class="info">
        <div class="info-item">
            <span class="info-label">Fecha de generación:</span> {{ $fecha }}
            <br>
            <span class="info-label">Hora:</span> {{ $hora }}
        </div>
        <div class="info-item" style="text-align: right;">
            <span class="info-label">Total de registros:</span> {{ $total }}
        </div>
    </div>

    <!-- Detalle de filtros aplicados -->
    @php
        $categoriaTexto = isset($filtros['categoria'])
            ? ($filtros['categoria'] === 'persona' ? 'Personas' : ($filtros['categoria'] === 'mascota' ? 'Mascotas' : 'Todas'))
            : 'Todas';
        $tipoTexto = $filtros['tipo'] ?? 'Todos';
        $estadoTexto = isset($filtros['estado'])
            ? ($filtros['estado'] == '1' ? 'Activas' : ($filtros['estado'] == '0' ? 'Inactivas' : 'Todos'))
            : 'Todos';
        $doctorTexto = $doctorNombre ?? 'Todos';
        $buscarTexto = $filtros['buscar'] ?? '—';
    @endphp

    <div class="detalle-box">
        <span class="info-label">Detalle del reporte</span>
        <div class="detalle-grid">
            <div class="detalle-item">
                <span class="info-label">Categoría:</span> {{ $categoriaTexto }}<br>
                <span class="info-label">Tipo:</span> {{ ucfirst($tipoTexto) }}
            </div>
            <div class="detalle-item">
                <span class="info-label">Estado:</span> {{ $estadoTexto }}<br>
                <span class="info-label">Doctor:</span> {{ $doctorTexto }}
            </div>
            <div class="detalle-item">
                <span class="info-label">Búsqueda:</span> {{ $buscarTexto }}
            </div>
        </div>
    </div>

    <!-- Tabla de biopsias -->
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">N° Biopsia</th>
                <th style="width: 8%;">Tipo</th>
                <th style="width: 10%;">Categoría</th>
                <th style="width: 8%;">Fecha</th>
                <th style="width: 20%;">Paciente/Mascota</th>
                <th style="width: 18%;">Doctor</th>
                <th style="width: 18%;">Diagnóstico</th>
                <th style="width: 8%;">Estado</th>
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
                <td>
                    @if($biopsia->paciente_id)
                    <span class="badge badge-persona">Persona</span>
                    @else
                    <span class="badge badge-mascota">Mascota</span>
                    @endif
                </td>
                <td>{{ $biopsia->fecha_recibida->format('d/m/Y') }}</td>
                <td>
                    @if($biopsia->paciente)
                    <strong>{{ $biopsia->paciente->nombre }} {{ $biopsia->paciente->apellido }}</strong><br>
                    <small>DUI: {{ $biopsia->paciente->dui }}</small>
                    @else
                    <strong>{{ $biopsia->mascota->nombre }}</strong><br>
                    <small>{{ $biopsia->mascota->especie }} - {{ $biopsia->mascota->dueno }}</small>
                    @endif
                </td>
                <td>
                    Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}
                </td>
                <td>{{ Str::limit($biopsia->diagnostico_clinico, 60) }}</td>
                <td>
                    <span class="badge badge-{{ $biopsia->estado ? 'activa' : 'inactiva' }}">
                        {{ $biopsia->estado ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
            </tr>
            
            @empty
            <tr>
                <td colspan="8" class="no-data">
                    No se encontraron biopsias con los filtros aplicados
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