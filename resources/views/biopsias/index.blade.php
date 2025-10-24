<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Navegación separada -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-blue-300 p-1 rounded-lg">
                <a href="{{ route('biopsias.index') }}"
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Biopsias
                </a>
                <a href="{{ route('biopsias.personas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Personas
                </a>
                <a href="{{ route('biopsias.mascotas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Mascotas
                </a>
            </nav>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Biopsias Generales</h1>
                <p class="text-gray-600 mt-1">Gestión completa de todas las biopsias del sistema</p>
            </div>

        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Total Biopsias</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $biopsias->total() }}</p>
                    </div>
                    <div class="text-blue-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Activas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $biopsias->where('estado', 1)->count() }}</p>
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
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Archivadas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $biopsias->where('estado', 0)->count() }}</p>
                    </div>
                    <div class="text-yellow-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Este Mes</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $biopsias->where('fecha_recibida', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                    <div class="text-purple-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
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

        <!-- Tabla de biopsias -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-violet-200">
                    <thead class="bg-blue-400">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                N° Biopsia
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Fecha Recibida
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Paciente/Mascota
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Doctor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Diagnóstico
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <!-- Fragmento corregido para biopsias.index -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($biopsias as $biopsia)
                        <tr class="hover:bg-blue-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $biopsia->nbiopsia }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $biopsia->fecha_recibida->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($biopsia->paciente_id)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Persona
                                </span>
                                @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Mascota
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($biopsia->paciente_id)
                                {{ $biopsia->paciente->nombre }} {{ $biopsia->paciente->apellido }}
                                <div class="text-gray-500 text-xs">DUI: {{ $biopsia->paciente->dui ?? 'N/A' }}</div>
                                @else
                                {{ $biopsia->mascota->nombre }}
                                <div class="text-gray-500 text-xs">{{ $biopsia->mascota->propietario ?? 'N/A' }}</div>

                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate" title="{{ $biopsia->diagnostico_clinico }}">
                                    {{ Str::limit($biopsia->diagnostico_clinico, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($biopsia->estado)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Activa
                                </span>
                                @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Archivada
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <!-- ENLACES CORREGIDOS - Usar nbiopsia en lugar del objeto completo -->
                                    @if($biopsia->paciente_id)
                                    <a href="{{ route('biopsias.personas.edit', $biopsia->nbiopsia) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Editar
                                    </a>
                                    @else
                                    <a href="{{ route('biopsias.mascotas.edit', $biopsia->nbiopsia) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Editar
                                    </a>
                                    @endif

                                    <!-- Ver detalles -->


                                    <!-- Archivar/Restaurar -->
                                    @if($biopsia->estado)
                                    <form action="{{ route('biopsias.archivar', $biopsia->nbiopsia) }}" method="POST" class="inline">

                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900"
                                            onclick="return confirm('¿Está seguro de archivar esta biopsia?')">
                                            Archivar
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('biopsias.restaurar', $biopsia->nbiopsia) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            Restaurar
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                <div class="py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay biopsias registradas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza creando tu primera biopsia.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($biopsias->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $biopsias->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>