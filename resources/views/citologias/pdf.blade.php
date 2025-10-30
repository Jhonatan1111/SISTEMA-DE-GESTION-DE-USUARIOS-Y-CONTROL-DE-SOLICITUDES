<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Citologías - {{ now()->format('d/m/Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            padding: 20px;
            font-size: 12px;
        }

        .container {
            max-width: 100%;
        }

        /* Header */
        .header {
            border-bottom: 3px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo-section, .report-info {
            display: table-cell;
            vertical-align: top;
        }

        .logo-section {
            width: 50%;
        }

        .report-info {
            width: 50%;
            text-align: right;
        }

        .logo-section h1 {
            color: #10b981;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .logo-section p {
            color: #6b7280;
            font-size: 11px;
        }

        .report-info h2 {
            color: #1f2937;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .report-info p {
            color: #6b7280;
            font-size: 11px;
            margin: 3px 0;
        }

        /* Statistics */
        .statistics {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 10px 0;
        }

        .stat-card {
            display: table-cell;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 15px;
            border-radius: 5px;
            color: white;
            text-align: center;
            width: 25%;
        }

        .stat-card h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .stat-card p {
            font-size: 10px;
            opacity: 0.9;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background: #10b981;
            color: white;
        }

        thead th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tbody td {
            padding: 10px 8px;
            font-size: 10px;
            color: #374151;
        }

        /* Badge para estados */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-archived {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .tipo-badge {
            display: inline-block;
            padding: 3px 8px;
            background-color: #e0e7ff;
            color: #3730a3;
            border-radius: 8px;
            font-size: 9px;
            font-weight: 600;
            text-transform: capitalize;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 9px;
        }

        .footer p {
            margin: 3px 0;
        }

        small {
            font-size: 9px;
            color: #6b7280;
        }

        strong {
            font-weight: 600;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="logo-section">
                    <h1>Laboratorio de anatomia patologico Echeverria.</h1>
                    <p>Reporte Generado Automáticamente</p>
                </div>
                <div class="report-info">
                    <h2>Reporte de Citologías</h2>
                    <p><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</p>
                    <p><strong>Usuario:</strong> {{ auth()->user()->name ?? 'Sistema' }}</p>
                    <p><strong>Total Registros:</strong> {{ $citologias->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="statistics">
            <div class="stat-card">
                <h3>{{ $citologias->count() }}</h3>
                <p>Total</p>
            </div>
            <div class="stat-card">
                <h3>{{ $citologias->where('estado', true)->count() }}</h3>
                <p>Activas</p>
            </div>
            <div class="stat-card">
                <h3>{{ $citologias->where('estado', false)->count() }}</h3>
                <p>Inactivas</p>
            </div>
            <div class="stat-card">
                <h3>{{ $citologias->unique('paciente_id')->count() }}</h3>
                <p>Pacientes</p>
            </div>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Número</th>
                    <th style="width: 22%;">Paciente</th>
                    <th style="width: 22%;">Doctor/Remitente</th>
                    <th style="width: 12%;">Fecha</th>
                    <th style="width: 12%;">Tipo</th>
                    <th style="width: 10%;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citologias as $c)
                    <tr>
                        <td><strong>{{ $c->ncitologia }}</strong></td>
                        <td>
                            {{ $c->paciente ? $c->paciente->nombre . ' ' . $c->paciente->apellido : 'N/A' }}
                            @if($c->paciente && $c->paciente->DUI)
                                <br><small>DUI: {{ $c->paciente->DUI }}</small>
                            @endif
                        </td>
                        <td>
                            @if($c->doctor)
                                {{ $c->doctor->nombre }} {{ $c->doctor->apellido }}
                            @elseif($c->remitente_especial)
                                {{ $c->remitente_especial }}
                                <br><small>Especial</small>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $c->fecha_recibida->format('d/m/Y') }}</td>
                        <td>
                            <span class="tipo-badge">{{ ucfirst($c->tipo) }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $c->estado ? 'badge-active' : 'badge-archived' }}">
                                {{ $c->estado ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-data">
                            No se encontraron citologías para este reporte
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p><strong>© 2025 Laboratorio de anatomia patologico echeverria - Todos los derechos reservados</strong></p>
        </div>
    </div>
</body>
</html>