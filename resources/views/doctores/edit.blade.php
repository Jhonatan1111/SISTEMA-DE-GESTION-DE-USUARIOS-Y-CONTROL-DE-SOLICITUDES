<x-app-layout>
    <x-slot name="header">
        <div class="header-container">
            <h2 class="titulo">
                {{ __('Gestión de Doctores') }}
            </h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('doctores.create') }}" class="btn-nuevo">
                    {{ __('Nuevo Doctor') }}
                </a>
            @endif
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

        .btn-nuevo {
            background: #3498db;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-nuevo:hover {
            background: #2980b9;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .tabla th,
        .tabla td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla th {
            background: #3498db;
            color: white;
        }

        .tabla tr:hover {
            background: #f1f1f1;
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

        .estado-activo {
            background: #2ecc71;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
        }

        .estado-inactivo {
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
        }

        .acciones {
            display: flex;
            gap: 6px;
        }

        .btn {
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
        }

        .btn.editar {
            background: #f39c12;
            color: white;
        }

        .btn.editar:hover {
            background: #d68910;
        }

        .btn.estado {
            background: #3498db;
            color: white;
        }

        .btn.estado:hover {
            background: #2980b9;
        }

        .btn.eliminar {
            background: #e74c3c;
            color: white;
        }

        .btn.eliminar:hover {
            background: #c0392b;
        }

        .sin-datos {
            text-align: center;
            padding: 15px;
            color: #7f8c8d;
        }

        .paginacion {
            margin-top: 15px;
            text-align: center;
        }
    </style>

    <div class="container">
        <div>
            <!-- Mensajes de exito -->
            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            {{-- mensaje de error --}}
            @if (session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            <!-- Tabla de doctores -->
            <table class="tabla">
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
                                <span class="{{ $doctor->estado_servicio ? 'estado-activo' : 'estado-inactivo' }}">
                                    {{ $doctor->estado_servicio ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            @if (auth()->user()->role === 'admin')
                                <td>
                                    <div class="acciones">
                                        <a href="{{ route('doctores.edit', $doctor) }}" class="btn editar">Editar</a>

                                        <form action="{{ route('doctores.toggle-estado', $doctor) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('¿Está seguro de cambiar el estado?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn estado">
                                                {{ $doctor->estado_servicio ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('doctores.destroy', $doctor) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('¿Está seguro de eliminar este doctor? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn eliminar">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? '8' : '7' }}" class="sin-datos">
                                No hay doctores registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginación -->
            @if ($doctores->hasPages())
                <div class="paginacion">
                    {{ $doctores->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

