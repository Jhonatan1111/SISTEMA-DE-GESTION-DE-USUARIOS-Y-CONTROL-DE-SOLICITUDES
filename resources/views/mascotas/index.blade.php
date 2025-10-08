<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
        <div class="flex items-center space-x-6">
            <a href="{{ route('pacientes.index') }}"
               class="text-2xl font-bold text-gray-800 {{ request()->routeIs('paciente.*') ? 'underline text-blue-700' : '' }}">
                Gestión de Personas
            </a>
            <a href="{{ route('mascotas.index') }}"
               class="text-2xl font-bold text-gray-800 {{ request()->routeIs('mascotas.*') ? 'underline text-blue-700' : '' }}">
                Gestión de Mascotas
            </a>
        </div>
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('mascotas.create') }}" class="btn btn-primary">
                {{ __('Nueva Mascota') }}
            </a>
        @endif
    </div>
    </x-slot>

    <div class="admin-container">

        <!-- Mensajes de éxito -->
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <!-- Mensajes de error -->
        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <!-- Tabla de mascotas -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
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
                            <td class="table-actions">
                                <a href="{{ route('mascotas.edit', $mascota) }}" class="btn btn-primary">Editar</a>

                                @if (auth()->user()->role === 'admin')
                                    <form action="{{ route('mascotas.destroy', $mascota) }}" method="POST" class="inline-form"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta mascota? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; font-style: italic; color: #7f8c8d;">
                                No hay mascotas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if ($mascotas->hasPages())
            <div class="paginacion">
                {{ $mascotas->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
