<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
                {{ __('Administración de Usuarios') }}
            </h2>
            <a href="{{ route('admin.usuarios.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-md transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('Crear Usuario') }}
            </a>
        </div>
    </x-slot>

    <style>
        body {
            background-color: #e6f4ff; /* Fondo celeste suave */
            font-family: 'Segoe UI', sans-serif;
        }

        table {
            border-radius: 12px;
            overflow: hidden;
        }

        thead {
            background: linear-gradient(to right, #3b82f6, #2563eb); /* Azul degradado */
            color: white;
        }

        tbody tr:hover {
            background-color: #f1f5f9; /* Hover gris suave */
        }

        .alert-success {
            background-color: #dcfce7;
            border-left: 6px solid #22c55e;
            color: #166534;
        }

        .alert-error {
            background-color: #fee2e2;
            border-left: 6px solid #ef4444;
            color: #7f1d1d;
        }
    </style>

    <div class="py-8 px-6">
        <div class="max-w-7xl mx-auto">
            
            {{-- Mensajes de éxito/error --}}
            @if (session('success'))
                <div class="alert-success p-4 mb-6 rounded-lg shadow-md">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error p-4 mb-6 rounded-lg shadow-md">
                    ❌ {{ session('error') }}
                </div>
            @endif

            {{-- Tabla de usuarios --}}
            <div class="shadow-lg rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase">Apellido</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase">Celular</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase">Email</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase">Rol</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($usuarios as $usuario)
                                <tr class="border-b">
                                    <td class="px-6 py-4">{{ $usuario->nombre }}</td>
                                    <td class="px-6 py-4">{{ $usuario->apellido }}</td>
                                    <td class="px-6 py-4">{{ $usuario->celular }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $usuario->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $usuario->role === 'admin' 
                                                ? 'bg-red-100 text-red-800' 
                                                : 'bg-blue-100 text-blue-800' }}">
                                            {{ $usuario->role === 'admin' ? 'Administrador' : 'Empleado' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $usuario->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                                            class="px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                            Editar
                                        </a>
                                        @if ($usuario->id !== auth()->id())
                                            <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        No hay usuarios registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

