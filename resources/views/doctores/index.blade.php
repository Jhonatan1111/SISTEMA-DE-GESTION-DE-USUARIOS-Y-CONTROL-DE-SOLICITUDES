<x-app-layout>
    <x-slot name="header">
        <div class="admin-header">
            <h2 class="admin-title">
                {{ __('Gestión de Doctores') }}
            </h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('doctores.create') }}" class="btn">
                    {{ __('Nuevo Doctor') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="admin-container">
        <!-- Mensajes -->
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <!-- Tabla de doctores -->
        <div class="table-container">
            <table class="table">
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
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('doctores.edit', $doctor) }}" class="btn btn-primary"> Editar</a>

                                        <form action="{{ route('doctores.toggle-estado', $doctor) }}" method="POST"
                                            onsubmit="return confirm('¿Está seguro de cambiar el estado?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-secondary">
                                                {{ $doctor->estado_servicio ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('doctores.destroy', $doctor) }}" method="POST"
                                            onsubmit="return confirm('¿Está seguro de eliminar este doctor? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"> Eliminar</button>
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
        </div>

        <!-- Paginación -->
        @if ($doctores->hasPages())
            <div class="mt-4">
                {{ $doctores->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
