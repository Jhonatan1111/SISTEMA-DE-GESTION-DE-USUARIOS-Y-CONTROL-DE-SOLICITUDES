<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-title">
            {{ __('Lista de Citologías') }}
        </h2>
    </x-slot>

    <div class="admin-container">
        {{-- Mensaje de éxito --}}
        @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Mensaje de error --}}
        @if (session('error'))
        <div class="alert-danger">
            {{ session('error') }}
        </div>
        @endif

        {{-- Botón "Nueva Citología" solo para administradores --}}
        @if (auth()->user()->role === 'admin')
        <div class="admin-header">
            <a href="{{ route('listas.citologias.create') }}" class="btn">
                Nueva Lista de Citología
            </a>
        </div>
        @endif

        {{-- Tabla de Citologías --}}
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="codigo">Código</th>
                        <th>Diagnóstico</th>
                        <th>Macroscópico</th>
                        <th>Microscópico</th>
                        <th>Fecha Creación</th>
                        @if (auth()->user()->role === 'admin')
                        <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($listaCitologia as $citologia)
                    <tr>
                        <td class="codigo">{{ $citologia->codigo }}</td>
                        <td>{{ Str::limit($citologia->diagnostico, 50) }}</td>
                        <td>{{ Str::limit($citologia->macroscopico, 40) }}</td>
                        <td>{{ Str::limit($citologia->microscopico, 40) }}</td>
                        <td>{{ $citologia->created_at->format('d/m/Y') }}</td>
                        @if (auth()->user()->role === 'admin')
                        <td>
                            <div class="table-actions">
                                {{-- Editar --}}
                                <a href="{{ route('listas.citologias.edit', $citologia->id) }}" class="btn btn-primary">Editar</a>

                                {{-- Eliminar --}}
                                <form action="{{ route('listas.citologias.destroy', $citologia->id) }}" method="POST"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta lista?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type=\"submit\" class=\"btn btn-danger\">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No hay listas de citología registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $listaCitologia->links() }}
        </div>
    </div>
</x-app-layout>