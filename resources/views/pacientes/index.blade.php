<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Gestión de Pacientes') }}
            </h2>
            <a href="{{ route('pacientes.create') }}">
                {{ __('Nuevo Paciente') }}
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
                        <td>
                            <div>
                                <a href="{{ route('pacientes.edit', $paciente) }}">Editar</a>
                                @if (auth()->user()->role === 'admin')

                                <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar este paciente? Esta acción no se puede deshacer.')">
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
                            No hay pacientes registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginación -->
            @if ($pacientes->hasPages())
            <div>
                {{ $pacientes->links() }}
            </div>
            @endif

        </div>
    </div>
</x-app-layout>