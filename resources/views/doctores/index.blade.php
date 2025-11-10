<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Administración de Doctores</h1>
                    <p class="text-gray-600 mt-1">Administra los doctores registrados en el sistema</p>
                </div>
                <a href="{{ route('doctores.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300 hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    AGREGAR
                </a>

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
            <!-- Filtro de búsqueda -->
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            Buscar en listas de doctores
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text"
                                id="search"
                                name="search"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Buscar por nombre, apellido, fax, correo, dirección, contacto..."
                                onkeyup="filterTable()">
                        </div>
                    </div>
                    <div class="flex-shrink-0 mt-6">
                        <button type="button"
                            onclick="clearSearch()"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>

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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody id="doctores-table-body" class="bg-white divide-y divide-gray-200">
                            @forelse($doctores as $doctor)
                            <tr class="table-row hover:bg-blue-50" data-searchable="{{ $doctor->nombre }} {{ $doctor->apellido }} {{ $doctor->jvpm }} {{ $doctor->celular }} {{ $doctor->correo }} {{ $doctor->direccion }} {{ $doctor->estado_servicio ? 'activo' : 'inactivo' }} {{ $doctor->fax }}">
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
                                        <!-- Botón Ver -->
                                        <a href="{{ route('doctores.show', $doctor) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            Ver
                                        </a>
                                        <!-- Botón Activar / Desactivar -->
                                        @if (auth()->user()->role === 'admin')

                                        <form action="{{ route('doctores.toggle-estado', $doctor) }}" method="POST"
                                            onsubmit="return confirm('¿Está seguro de cambiar el estado de este doctor?')" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="{{ $doctor->estado_servicio ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}">
                                                {{ $doctor->estado_servicio ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                        @endif

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
    <script>
        function normalizeText(str) {
            return (str || '')
                .toString()
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, ''); // quitar acentos
        }

        function filterTable() {
            const searchInput = document.getElementById('search');
            const searchTerm = normalizeText(searchInput.value);
            const tbody = document.getElementById('doctores-table-body');
            const tableRows = tbody.querySelectorAll('tr.table-row');
            let visibleRows = 0;

            tableRows.forEach(row => {
                const rawText = row.getAttribute('data-searchable') || row.textContent;
                const searchableText = normalizeText(rawText);
                const matches = !searchTerm || searchableText.includes(searchTerm);
                row.style.display = matches ? '' : 'none';
                if (matches) visibleRows++;
            });

            // Quitar mensaje previo
            const existingNoResults = document.getElementById('no-results-row');
            if (existingNoResults) existingNoResults.remove();

            // Crear mensaje de "no se encontraron resultados"
            if (searchTerm && visibleRows === 0) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.id = 'no-results-row';
                noResultsRow.innerHTML = `
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        <div class="py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron resultados</h3>
                            <p class="mt-1 text-sm text-gray-500">Intenta con otros términos de búsqueda.</p>
                        </div>
                    </td>
                `;
                tbody.appendChild(noResultsRow);
            }
        }

        function clearSearch() {
            const searchInput = document.getElementById('search');
            searchInput.value = '';
            filterTable();
        }

        // Agregar evento para limpiar búsqueda con Escape
        document.getElementById('search').addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                clearSearch();
            }
        });
    </script>
</x-app-layout>