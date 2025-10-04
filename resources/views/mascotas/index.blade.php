<x-app-layout>
    <x-slot name="header">
        <div class="admin-header">
            <h2 class="admin-title">
                {{ __('Gestión de Mascotas') }}
            </h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('mascotas.create') }}" class="btn">
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
                                <a href="{{ route('mascotas.edit', $mascota) }}" class="btn">Editar</a>

                                @if (auth()->user()->role === 'admin')
                                    <form action="{{ route('mascotas.destroy', $mascota) }}" method="POST" class="inline-form"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta mascota? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">Eliminar</button>
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
