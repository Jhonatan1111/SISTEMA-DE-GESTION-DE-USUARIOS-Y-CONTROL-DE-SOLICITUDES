<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Administración de Usuarios</h1>
                    <p class="text-gray-600 mt-1">Administra los usuarios registrados en el sistema</p>
                </div>
                @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.usuarios.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300 hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    AGREGAR
                </a>
                @endif

            </div>
            {{-- Estadísticas --}}
            <div class="mb-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <p class="text-gray-600 text-sm font-semibold uppercase">Total de Usuarios</p>
                    <p class="text-4xl font-bold text-blue-600 mt-2">{{ $usuarios->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                    <p class="text-gray-600 text-sm font-semibold uppercase">Administradores</p>
                    <p class="text-4xl font-bold text-purple-600 mt-2">{{ $usuarios->where('role', 'admin')->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <p class="text-gray-600 text-sm font-semibold uppercase">Empleados</p>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $usuarios->where('role', 'empleado')->count() }}</p>
                </div>
            </div>
            <!-- Mensajes de éxito/error -->
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
            @endif

            {{-- Tabla de usuarios --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-200">
                        <thead class="bg-blue-400">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Celular
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Rol
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($usuarios as $usuario)
                            <tr class="hover:bg-blue-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">{{ $usuario->nombre }} {{ $usuario->apellido }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $usuario->celular }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-blue-600 text-sm">{{ $usuario->email }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($usuario->role === 'admin')
                                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-800 px-4 py-2 rounded-full text-xs font-bold">
                                        <span></span> Administrador
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-xs font-bold">
                                        <span></span> Empleado
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-500 text-sm">{{ $usuario->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 justify-center group-hover:opacity-100 transition-opacity duration-200">

                                        <a href="{{ route('admin.usuarios.show', $usuario) }}"
                                            class="text-blue-600 hover:text-blue-900 font-semibold text-sm transition-all duration-300 transform hover:scale-105 align-middle">
                                            Ver
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="text-6xl"></span>
                                        <p class="text-gray-500 text-lg">No hay usuarios registrados</p>
                                        <a href="{{ route('admin.usuarios.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold mt-2">
                                            Crear el primer usuario →
                                        </a>
                                    </div>
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