<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Administración de Doctores</h1>
                <p class="text-gray-600 mt-1">Administra los doctores registrados en el sistema</p>
            </div>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('doctores.create') }}" 
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
                    <p class="text-gray-600 text-sm font-semibold uppercase">Total de Doctores</p>
                    <p class="text-4xl font-bold text-blue-600 mt-2">{{ $doctores->total() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <p class="text-gray-600 text-sm font-semibold uppercase">Activos</p>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $doctores->where('estado_servicio', true)->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                    <p class="text-gray-600 text-sm font-semibold uppercase">Inactivos</p>
                    <p class="text-4xl font-bold text-red-600 mt-2">{{ $doctores->where('estado_servicio', false)->count() }}</p>
                </div>
            </div>

            {{-- Mensajes de éxito/error --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md animate-pulse-subtle">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">✅</span>
                        <div>
                            <p class="text-green-800 font-semibold">¡Éxito!</p>
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md animate-pulse-subtle">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">❌</span>
                        <div>
                            <p class="text-red-800 font-semibold">Error</p>
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tabla de doctores --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-200">
                        <thead class="bg-blue-400">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Doctor
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Contactos
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Fax</th>
                                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Dirección
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Estado
                                </th>
                                @if (auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($doctores as $doctor)
                                <tr class="hover:bg-blue-50">
                                    <!-- <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $doctor->jvpm }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $doctor->nombre . ' ' . $doctor->apellido }}</span>
                                    </td> -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $doctor->nombre }} {{ $doctor->apellido }}
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            JVPM: {{ $doctor->jvpm }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                            </svg>
                                            {{ $doctor->celular }}
                                        </div>
                                        @if($doctor->correo)
                                        <div class="flex items-center text-blue-600 text-xs mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                            </svg>
                                            {{ $doctor->correo }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-600">{{ $doctor->fax ?? 'Sin fax' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="max-w-[150px] truncate" title="{{ $doctor->direccion }}">
                                            {{ $doctor->direccion ?? 'Sin dirección' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($doctor->estado_servicio)
                                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-4 py-2 rounded-full text-xs font-bold">
                                                <span></span> Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-800 px-4 py-2 rounded-full text-xs font-bold">
                                                <span></span> Inactivo
                                            </span>
                                        @endif
                                    </td>
                                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <!-- Botón Editar -->
                                            <a href="{{ route('doctores.edit', $doctor) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                Editar
                                            </a>
                                            <!-- Botón Activar / Desactivar -->
                                            <form action="{{ route('doctores.toggle-estado', $doctor) }}" method="POST"
                                                onsubmit="return confirm('¿Está seguro de cambiar el estado de este doctor?')" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="{{ $doctor->estado_servicio ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}">
                                                    {{ $doctor->estado_servicio ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'admin' ? '8' : '7' }}" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <span class="text-6xl"></span>
                                            <p class="text-gray-500 text-lg">No hay doctores registrados</p>
                                            @if (auth()->user()->role === 'admin')
                                                <a href="{{ route('doctores.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold mt-2">
                                                    Registrar el primer doctor →
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Paginación --}}
            @if ($doctores->hasPages())
                <div class="mt-8">
                    {{ $doctores->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>