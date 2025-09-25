<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Gestión de Doctores') }}
            </h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('doctores.create') }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                    {{ __('Nuevo Doctor') }}
                </a>
            @endif
        </div>
    </x-slot>

    <style>
        body {
            background-color: #f0f9ff; /* Fondo azul celeste claro */
            font-family: 'Segoe UI', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        th {
            background-color: #2563eb;
            color: white;
            text-align: left;
            padding: 12px;
            font-weight: 600;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
        }
        .btn-edit:hover {
            background: #1d4ed8;
        }

        .btn-toggle {
            background: #f59e0b;
            color: white;
        }
        .btn-toggle:hover {
            background: #d97706;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }
        .btn-delete:hover {
            background: #b91c1c;
        }
    </style>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Mensajes de exito -->
            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            {{-- mensaje de error --}}
            @if (session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <!-- Tabla de doctores -->
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>JVPM</th>
                            <th>Nombre Completo</th>
                            <th>Dirección</th>
                            <th>Celular</th>
                            <th>Fax</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            @if (auth()->user()->role === 'admin')
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctores as $doctor)
                            <tr>
                                <td>{{ $doctor->jvpm }}</td>
                                <td>{{ $doctor->nombre . ' ' . $doctor->apellido }}</td>
                                <td title="{{ $doctor->direccion }}">{{ $doctor->direccion ?? 'Sin dirección' }}</td>
                                <td>{{ $doctor->celular }}</td>
                                <td>{{ $doctor->fax ?? 'Sin fax' }}</td>
                                <td>{{ $doctor->correo ?? 'Sin correo' }}</td>
                                <td>
                                    <span class="px-2 py-1 rounded text-sm font-medium 
                                        {{ $doctor->estado_servicio ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $doctor->estado_servicio ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                @if (auth()->user()->role === 'admin')
                                    <td class="space-x-2">
                                        <a href="{{ route('doctores.edit', $doctor) }}" class="btn btn-edit">Editar</a>

                                        <form action="{{ route('doctores.toggle-estado', $doctor) }}" method="POST" style="display: inline;"
                                            onsubmit="return confirm('¿Está seguro de cambiar el estado?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-toggle">
                                                {{ $doctor->estado_servicio ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('doctores.destroy', $doctor) }}" method="POST" style="display: inline;"
                                            onsubmit="return confirm('¿Está seguro de eliminar este doctor? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">Eliminar</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? '8' : '7' }}" style="text-align: center;">
                                    No hay doctores registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if ($doctores->hasPages())
                <div class="mt-4">
                    {{ $doctores->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
