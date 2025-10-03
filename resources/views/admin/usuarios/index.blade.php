<x-app-layout>
    <x-slot name="header">
        <div class="admin-header">
            <h2 class="admin-title">Administración de Usuarios</h2>
            <a href="{{ route('admin.usuarios.create') }}" class="btn">➕ Crear Usuario</a>
        </div>
    </x-slot>

    <div class="admin-container">

        {{-- Mensajes de éxito/error --}}
        @if (session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Tabla de usuarios --}}
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->apellido }}</td>
                            <td>{{ $usuario->celular }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                <span class="{{ $usuario->role === 'admin' 
                                    ? 'bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold' 
                                    : 'bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold' }}">
                                    {{ $usuario->role === 'admin' ? 'Administrador' : 'Empleado' }}
                                </span>
                            </td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td class="table-actions">
                                <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn">✏️ Editar</a>
                                @if($usuario->id !== auth()->id())
                                    <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">🗑️ Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500">
                                No hay usuarios registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
