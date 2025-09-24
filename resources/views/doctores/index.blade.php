<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Gestión de Doctores') }}
            </h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('doctores.create') }}">
                    {{ __('Nuevo Doctor') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div>
        <div>
            <!-- Mensajes de exito -->
            @if (session('success'))
                <div>{{ session('success') }}</div>
            @endif
            {{-- mensaje de error --}}
            @if (session('error'))
                <div>{{ session('error') }}</div>
            @endif

            <!-- Tabla de doctores -->
            <table border="1">
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
                                <span>{{ $doctor->estado_servicio ? 'Activo' : 'Inactivo' }}</span>
                            </td>
                            @if (auth()->user()->role === 'admin')
                                <td>
                                    <div>
                                        <a href="{{ route('doctores.edit', $doctor) }}">Editar</a>

                                        <form action="{{ route('doctores.toggle-estado', $doctor) }}" method="POST" style="display: inline;"
                                            onsubmit="return confirm('¿Está seguro de cambiar el estado?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit">
                                                {{ $doctor->estado_servicio ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('doctores.destroy', $doctor) }}" method="POST" style="display: inline;"
                                            onsubmit="return confirm('¿Está seguro de eliminar este doctor? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Eliminar</button>
                                        </form>
                                    </div>
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

            <!-- Paginación -->
            @if ($doctores->hasPages())
                <div>
                    {{ $doctores->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
