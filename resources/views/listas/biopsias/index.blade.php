<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-title">
            {{ __('Lista de Biopsias') }}
        </h2>
    </x-slot>

    <div class="admin-container">
        {{-- Mensaje de éxito --}}
        @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Botón "Nueva Biopsia" solo para administradores --}}
        @if (auth()->user()->role === 'admin')
        <div class="admin-header">
            <a href="{{ route('listas.biopsias.create') }}" class="btn">
                Nueva Lista de Biopsia
            </a>
        </div>
        @endif

        {{-- Tabla de Biopsias --}}
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="codigo">Código</th>
                        <th class="descripcion">Descripción</th>
                        <th>Diagnóstico</th>
                        <th>Macroscopico</th>
                        <th>Microscopico</th>
                        @if (auth()->user()->role === 'admin')
                        <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($listaBiopsia as $lista)
                    <tr>
                        <td class="codigo">{{ $lista->codigo }}</td>
                        <td class="descripcion">{{ $lista->descripcion }}</td>
                        <td>{{ $lista->diagnostico }}</td>
                        <td>{{ $lista->macroscopico }}</td>
                        <td>{{ $lista->microscopico }}</td>
                        @if (auth()->user()->role === 'admin')
                        <td>
                            <div class="table-actions">
                                {{-- Editar --}}
                                <a href="{{ route('listas.biopsias.edit', $lista->id) }}" class="btn btn-primary">Editar</a>

                                {{-- Eliminar --}}
                                <form action="{{ route('listas.biopsias.destroy', $lista->id) }}" method="POST"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta lista?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
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
                            No hay listas de biopsia registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $listaBiopsia->links() }}
        </div>
    </div>
</x-app-layout>
