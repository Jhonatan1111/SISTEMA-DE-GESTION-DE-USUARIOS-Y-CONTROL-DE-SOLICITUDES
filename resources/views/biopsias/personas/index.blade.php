<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Navegación separada -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                <a href="{{ route('biopsias.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Biopsias
                </a>
                <a href="{{ route('biopsias.personas.index') }}"
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Personas
                </a>
                <a href="{{ route('mascotas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Mascotas
                </a>

            </nav>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Biopsias - Personas</h1>
                <p class="text-gray-600 mt-1">Gestión completa de biopsias para pacientes humanos</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('biopsias.personas.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nueva Biopsia
                </a>
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exportar Datos
                </button>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Total Biopsias Personas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Biopsia::personas()->count() }}</p>
                    </div>
                    <div class="text-blue-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Biopsias Activas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Biopsia::personas()->activas()->count() }}</p>
                    </div>
                    <div class="text-green-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Biopsias Inactivas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Biopsia::personas()->where('estado', 0)->count() }}</p>
                    </div>
                    <div class="text-yellow-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Este Mes</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Biopsia::personas()->whereMonth('fecha_recibida', now()->month)->count() }}</p>
                    </div>
                    <div class="text-purple-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros y búsqueda -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <div class="flex flex-wrap gap-4 items-center">
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <input type="text" placeholder="Buscar por paciente, doctor o diagnóstico..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos los estados</option>
                    <option value="1">Activas</option>
                    <option value="0">Inactivas</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos los doctores</option>
                    @foreach(\App\Models\Doctor::all() as $doctor)
                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}</option>
                    @endforeach
                </select>
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

        <!-- Tabla de biopsias -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                N° Biopsia
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha Recibida
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Paciente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Doctor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Diagnóstico
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($biopsias as $biopsia)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $biopsia->nbiopsia }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $biopsia->fecha_recibida->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-800">
                                                @if($biopsia->paciente_id && $biopsia->paciente)
                                                {{ substr($biopsia->paciente->nombre, 0, 1) }}{{ substr($biopsia->paciente->apellido, 0, 1) }}
                                                @elseif($biopsia->mascota_id && $biopsia->mascota)
                                                {{ substr($biopsia->mascota->nombre, 0, 1) }}{{ substr($biopsia->mascota->propietario ?? 'M', 0, 1) }}
                                                @else
                                                N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            @if($biopsia->paciente_id && $biopsia->paciente)
                                            {{ $biopsia->paciente->nombre }} {{ $biopsia->paciente->apellido }}
                                            @elseif($biopsia->mascota_id && $biopsia->mascota)
                                            {{ $biopsia->mascota->nombre }}
                                            @else
                                            Información no disponible
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            @if($biopsia->paciente_id && $biopsia->paciente)
                                            DUI: {{ $biopsia->paciente->dui ?? 'N/A' }}
                                            @elseif($biopsia->mascota_id && $biopsia->mascota)
                                            Propietario: {{ $biopsia->mascota->propietario ?? 'N/A' }}
                                            @else
                                            Tipo: N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="font-medium">Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}</div>
                                <div class="text-gray-500">{{ $biopsia->doctor->especialidad ?? 'Especialidad N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate" title="{{ $biopsia->diagnostico_clinico }}">
                                    {{ Str::limit($biopsia->diagnostico_clinico, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($biopsia->estado)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Activa
                                </span>
                                @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Inactiva
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <div class="relative inline-block text-left">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="toggleDropdown('{{ $biopsia->nbiopsia }}')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                            Acciones
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div id="dropdown-{{ $biopsia->nbiopsia }}" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                            <div class="py-1">
                                                <a href="{{ route('biopsias.personas.show', $biopsia->nbiopsia) }}"
                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Ver detalles
                                                </a>
                                                <a href="{{ route('biopsias.personas.edit', $biopsia->nbiopsia) }}"
                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Editar
                                                </a>
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                    </svg>
                                                    Imprimir
                                                </a>
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Descargar PDF
                                                </a>
                                                <div class="border-t border-gray-100"></div>
                                                <form action="{{ route('biopsias.personas.toggle-estado', $biopsia->nbiopsia) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50">
                                                        @if($biopsia->estado)
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Desactivar
                                                        @else
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Activar
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                <div class="py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay biopsias de personas registradas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza creando tu primera biopsia para personas.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('biopsias.personas.create') }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Nueva Biopsia
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>

    @push('scripts')
    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById('dropdown-' + id);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

            // Cerrar todos los otros dropdowns
            allDropdowns.forEach(d => {
                if (d.id !== 'dropdown-' + id) {
                    d.classList.add('hidden');
                }
            });

            // Toggle el dropdown actual
            dropdown.classList.toggle('hidden');
        }

        // Cerrar dropdowns al hacer click fuera
        document.addEventListener('click', function(event) {
            const isDropdownButton = event.target.closest('button[onclick^="toggleDropdown"]');
            const isDropdownContent = event.target.closest('[id^="dropdown-"]');

            if (!isDropdownButton && !isDropdownContent) {
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                allDropdowns.forEach(d => d.classList.add('hidden'));
            }
        });

        // Funcionalidad de búsqueda en tiempo real
        document.querySelector('input[placeholder*="Buscar"]').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm) || searchTerm === '') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .hover\:bg-gray-50:hover {
            background-color: #f9fafb;
        }

        .transition-colors {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .border-l-4 {
            border-left-width: 4px;
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .z-10 {
            z-index: 10;
        }

        .ring-1 {
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        .ring-black {
            --tw-ring-color: rgba(0, 0, 0, 1);
        }

        .ring-opacity-5 {
            --tw-ring-opacity: 0.05;
        }

        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .grid-cols-1 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }

            .flex-wrap {
                flex-wrap: wrap;
            }

            .min-w-64 {
                min-width: 100%;
            }
        }
    </style>
    @endpush
</x-app-layout>