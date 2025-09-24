<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('Gestión de Doctores') }}
            </h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('doctores.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    + {{ __('Nuevo Doctor') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Mensajes -->
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg shadow">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabla -->
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
                <table class="min-w-full border border-gray-200 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">JVPM</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Nombre Completo</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Dirección</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Celular</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Fax</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Correo</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Estado</th>
                            @if (auth()->user()->role === 'admin')
                                <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600 dark:text-gray-300">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctores as $doctor)
                            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $doctor->jvpm }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $doctor->nombre . ' ' . $doctor->apellido }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200" title="{{ $doctor->direccion }}">
                                    {{ $doctor->direccion ?? 'Sin dirección' }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $doctor->celular }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $doctor->fax ?? 'Sin fax' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $doctor->correo ?? 'Sin correo' }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded-full font-medium 
                                        {{ $doctor->estado_servicio ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $doctor->estado_servicio ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                @if (auth()->user()->role === 'admin')
                                    <td class="px-4 py-2 text-sm flex flex-wrap gap-2 justify-center">
                                        <a href="{{ route('doctores.edit', $doctor) }}"
                                           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Editar</a>

                                        <form action="{{ route('doctores.toggle-estado', $doctor) }}" method="POST"
                                              onsubmit="return confirm('¿Está seguro de cambiar el estado?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1 {{ $doctor->estado_servicio ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700' }} text-white rounded text-xs">
                                                {{ $doctor->estado_servicio ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('doctores.destroy', $doctor) }}" method="POST"
                                              onsubmit="return confirm('¿Está seguro de eliminar este doctor? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? '8' : '7' }}"
                                    class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No hay doctores registrados.
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
    </div>
</x-app-layout>
