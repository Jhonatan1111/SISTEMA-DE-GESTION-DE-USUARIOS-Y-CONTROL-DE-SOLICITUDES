<x-app-layout>
    <x-slot name="header">
        <div class="header-container">
            <h2 class="titulo">
                {{ __('Gestión de Pacientes') }}
            </h2>
            <a href="{{ route('pacientes.create') }}" class="btn nuevo"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                {{ __('Nuevo Paciente') }}
            </a>
        </div>
    </x-slot>

    <style>
        body {
            background-color: #f0f8ff;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .titulo {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }

        .btn {
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn.nuevo {
            background: #2563eb;
            color: white;
            text-align: left;
            padding: 12px;
            font-weight: 600;
        }

        .btn.nuevo:hover {
            background: #1d4ed8;
        } 

        .btn.editar {
            background: #3498db;
            color: white;
            margin-right: 5px;
        }

        .btn.editar:hover {
            background: #2980b9;
        }

        .btn.eliminar {
            background: #e74c3c;
            color: white;
            border: none;
        }

        .btn.eliminar:hover {
            background: #c0392b;
        }

        .tabla-container {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 8px;
        }

        .tabla th, .tabla td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        .tabla th {
            background: #2563eb;
            color: white;
            font-size: 14px;
        }

        .tabla tr:nth-child(even) {
            background: #f9f9f9;
        }

        .tabla tr:hover {
            background: #ecf7ff;
        }

        .acciones {
            display: flex;
            gap: 5px;
        }

        .inline-form {
            display: inline;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert.success {
            background: #2ecc71;
            color: white;
        }

        .alert.error {
            background: #e74c3c;
            color: white;
        }

        .paginacion {
            margin-top: 15px;
        }
    </style>

    <div class="tabla-container">

        <!-- Mensajes de éxito -->
        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <!-- Mensajes de error -->
        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <!-- Tabla de pacientes -->
        <table class="tabla">
            <thead>
                <tr>
                    <th>DUI</th>
                    <th>Nombre Completo</th>
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pacientes as $paciente)
                    <tr>
                        <td>{{ $paciente->dui }}</td>
                        <td>{{ $paciente->nombre . ' ' . $paciente->apellido }}</td>
                        <td>{{ $paciente->edad }}</td>
                        <td>{{ ucfirst($paciente->sexo) }}</td>
                        <td>{{ $paciente->fecha_nacimiento ? date('d/m/Y', strtotime($paciente->fecha_nacimiento)) : 'Sin fecha' }}</td>
                        <td>{{ $paciente->celular }}</td>
                        <td>{{ $paciente->correo ?? 'Sin correo' }}</td>
                        <td title="{{ $paciente->direccion }}">{{ $paciente->direccion ?? 'Sin dirección' }}</td>
                        <td class="acciones">
                            <a href="{{ route('pacientes.edit', $paciente) }}" class="btn editar">Editar</a>
                            @if (auth()->user()->role === 'admin')
                                <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" class="inline-form"
                                      onsubmit="return confirm('¿Está seguro de eliminar este paciente? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn eliminar">Eliminar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; font-style: italic; color: #7f8c8d;">
                            No hay pacientes registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginación -->
        @if ($pacientes->hasPages())
            <div class="paginacion">
                {{ $pacientes->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
