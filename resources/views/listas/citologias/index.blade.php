<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Navegación separada -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-blue-300 p-1 rounded-lg">
                <a href="{{ route('listas.biopsias.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Biopsias
                </a>
                <a href="{{ route('listas.citologias.index') }}"
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Citologías
                </a>
                <a href="{{ route('sobres.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Imprimir Sobres
            </nav>
        </div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Lista de Citologías</h1>
                <p class="text-gray-600 mt-1">Gestión de listas predefinidas para citologías</p>
            </div>
            @if (auth()->user()->role === 'admin')
            <a href="{{ route('listas.citologias.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300 hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Lista
            </a>
            @endif
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
                        Buscar en listas de citologías
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
                            placeholder="Buscar por código, descripción o diagnóstico..."
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

        {{-- Tabla de Citologías --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-violet-200">
                    <thead class="bg-blue-400">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider font-bold">
                                Código
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider font-bold">
                                Descripción
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider font-bold">
                                Diagnóstico
                            </th>
                            @if (auth()->user()->role === 'admin')
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider font-bold">
                                Acciones
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="citologias-table-body">
                        @forelse ($listaCitologia as $lista)
                        <tr class="hover:bg-blue-50 table-row" data-searchable="{{ strtolower($lista->codigo . ' ' . $lista->descripcion . ' ' . $lista->diagnostico) }}">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center justify-center bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $lista->codigo }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium text-gray-900">{{ $lista->descripcion }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <textarea class="text-sm text-gray-900 w-full resize-none border-none bg-transparent text-center" rows="2" readonly>{{ $lista->diagnostico ?? 'N/A' }}</textarea>
                            </td>

                            @if (auth()->user()->role === 'admin')
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('listas.citologias.edit', $lista->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Editar
                                    </a>
                                    <form action="{{ route('listas.citologias.destroy', $lista->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta lista?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                <div class="py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay listas de citología registradas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza creando tu primera lista de plantilla.</p>
                                    @if (auth()->user()->role === 'admin')
                                    <div class="mt-6">
                                        <a href="{{ route('listas.citologias.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            Crear Lista
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->
            @if($listaCitologia->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $listaCitologia->links() }}
            </div>
            @endif
        </div>
    </div>

    <script>
        function filterTable() {
            const searchInput = document.getElementById('search');
            const searchTerm = searchInput.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table-row');
            const emptyRow = document.querySelector('tbody tr:last-child');
            let visibleRows = 0;

            tableRows.forEach(row => {
                const searchableText = row.getAttribute('data-searchable');
                if (searchableText && searchableText.includes(searchTerm)) {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Mostrar/ocultar mensaje de "no hay registros"
            if (emptyRow) {
                if (visibleRows === 0 && searchTerm !== '') {
                    // Crear mensaje de "no se encontraron resultados" si no existe
                    let noResultsRow = document.getElementById('no-results-row');
                    if (!noResultsRow) {
                        noResultsRow = document.createElement('tr');
                        noResultsRow.id = 'no-results-row';
                        noResultsRow.innerHTML = `
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                <div class="py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron resultados</h3>
                                    <p class="mt-1 text-sm text-gray-500">Intenta con otros términos de búsqueda.</p>
                                </div>
                            </td>
                        `;
                        document.getElementById('citologias-table-body').appendChild(noResultsRow);
                    }
                    noResultsRow.style.display = '';
                } else {
                    const noResultsRow = document.getElementById('no-results-row');
                    if (noResultsRow) {
                        noResultsRow.style.display = 'none';
                    }
                }
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