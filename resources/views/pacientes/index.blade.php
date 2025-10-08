<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
        <div class="flex items-center space-x-6">
            <a href="{{ route('pacientes.index') }}"
               class="text-2xl font-bold text-gray-800 {{ request()->routeIs('pacientes.*') ? 'underline text-blue-700' : '' }}">
                Gestión de Personas
            </a>
            <a href="{{ route('mascotas.index') }}"
               class="text-2xl font-bold text-gray-800 {{ request()->routeIs('mascotas.*') ? 'underline text-blue-700' : '' }}">
                Gestión de Mascotas
            </a>
        </div>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
            {{ __('Nuevo Paciente') }}
        </a>
    </div>
    </x-slot>

    

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>DUI</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>Fecha Nac.</th>
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
                        <td class="table-actions">
                            <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-primary">Editar</a>
                            @if (auth()->user()->role === 'admin')
                                <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" class="inline-form"
                                      onsubmit="return confirm('¿Está seguro de eliminar este paciente? Esta acción no se puede deshacer.')">
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
                            No hay pacientes registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($pacientes->hasPages())
        <div class="paginacion">
            {{ $pacientes->links() }}
        </div>
    @endif
</x-app-layout>
