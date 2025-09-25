<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Gestión de Mascotas') }}
            </h2>
            <a href="{{ route('mascotas.create') }}">
                {{ __('Nueva Mascota') }}
            </a>
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

            <!-- Tabla de pacientes -->
            <table border="1">
                <thead>
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Propietario</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mascotas as $mascota)
                    <tr>
                        <td>{{ $mascota->nombre }}</td>
                        <td>{{ $mascota->edad }}</td>
                        <td>{{ ucfirst($mascota->sexo) }}</td>
                        <td>{{ $mascota->especie }}</td>
                        <td>{{ $mascota->raza }}</td>
                        <td>{{ $mascota->propietario }}</td>
                        <td>{{ $mascota->correo ?? 'Sin correo' }}</td>
                        <td>{{ $mascota->celular }}</td>
                        <td>
                            <div>
                                <a href="{{ route('mascotas.edit', $mascota) }}">Editar</a>
                                @if (auth()->user()->role === 'admin')

                                <form action="{{ route('mascotas.destroy', $mascota) }}" method="POST" style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta mascota? Esta acción no se puede deshacer.')">
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
                            No hay mascotas registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginación -->
            @if ($mascotas->hasPages())
            <div>
                {{ $mascotas->links() }}
            </div>
            @endif

        </div>
    </div>
</x-app-layout>