<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Navegación separada -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-blue-300 p-1 rounded-lg">
                <a href="{{ route('pacientes.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Personas
                </a>
                <a href="{{ route('mascotas.index') }}"
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Mascotas
                </a>
            </nav>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Mascotas</h1>
                <p class="text-gray-600 mt-1">Administra las mascotas del sistema</p>
            </div>
            <a href="{{ route('mascotas.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300 hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                AGREGAR
            </a>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Total Mascotas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $mascotas->total() }}</p>
                    </div>
                    <div class="text-purple-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Caninos</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $mascotas->filter(function($m) { return strtolower($m->especie) == 'canino' || strtolower($m->especie) == 'perro'; })->count() }}</p>
                    </div>
                    <div class="text-green-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Otros</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $mascotas->filter(function($m) { return strtolower($m->especie) == 'felino' || strtolower($m->especie) == 'gato'; })->count() }}</p>
                    </div>
                    <div class="text-orange-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                        </svg>
                    </div>
                </div>
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
        <!-- Filtro de búsqueda (server-side, compatible con paginación) -->
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <form id="search-form" method="GET" action="{{ route('mascotas.index') }}" class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar en listas de mascotas</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="search" name="q" value="{{ request('q') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Buscar por nombre, apellido, DUI, correo, dirección, contacto...">
                    </div>
                </div>
                <div class="flex-shrink-0 mt-6 flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">Buscar</button>
                    <a href="{{ route('mascotas.index') }}" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">Limpiar</a>
                </div>
            </form>
        </div>

        <!-- Tabla de mascotas -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-violet-200">
                    <thead class="bg-blue-400">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Mascota
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Especie/Raza
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Edad/Sexo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Propietario
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Contacto
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody id="mascotas-table-body" class="bg-white divide-y divide-gray-200">
                        @forelse($mascotas as $mascota)
                        <tr class="table-row hover:bg-blue-50" data-searchable="{{ $mascota->nombre }} {{ $mascota->especie }} {{ $mascota->raza }} {{ $mascota->edad }} {{ $mascota->sexo }} {{ $mascota->propietario }} {{ $mascota->contacto }} {{ $mascota->correo }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $mascota->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $mascota->especie }}
                                </div>
                                <div class="text-gray-500 text-xs">
                                    {{ $mascota->raza }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $mascota->edad }} años</div>
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ strtoupper(substr($mascota->sexo ?? '', 0, 1)) == 'M' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ ucfirst($mascota->sexo) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $mascota->propietario }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                    </svg>
                                    {{ $mascota->celular }}
                                </div>
                                @if($mascota->correo)
                                <div class="max-w-[160px] truncate text-blue-600 ">

                                    {{ $mascota->correo }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $mascota->estado ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $mascota->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('mascotas.show', $mascota) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Ver
                                    </a>
                                    <!-- Botón Activar / Desactivar -->
                                    @if (auth()->user()->role === 'admin')

                                    <form action="{{ route('mascotas.toggle-estado', $mascota) }}" method="POST"
                                        onsubmit="return confirm('¿Está seguro de cambiar el estado de esta mascota?')" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="{{ $mascota->estado ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}">
                                            {{ $mascota->estado ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay mascotas registradas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza creando tu primera mascota.</p>
                                    @if (auth()->user()->role === 'admin')
                                    <div class="mt-6">
                                        <a href="{{ route('mascotas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            Registrar Mascota
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Paginación -->
                @if($mascotas->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $mascotas->links() }}

                </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        // Auto-enviar el formulario con debounce para búsqueda server-side
        const searchInput = document.getElementById('search');
        const searchForm = document.getElementById('search-form');
        const mascotasIndexUrl = "{{ route('mascotas.index') }}";

        // Enviar sólo con Enter; limpiar con Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchForm.submit();
            } else if (e.key === 'Escape') {
                window.location = mascotasIndexUrl;
            }
        });

        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.location = mascotasIndexUrl;
            }
        });
    </script>

</x-app-layout>