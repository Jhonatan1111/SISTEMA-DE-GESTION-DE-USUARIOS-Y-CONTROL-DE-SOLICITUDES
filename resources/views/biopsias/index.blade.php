<x-app-layout>
<<<<<<< HEAD
    <div class="container mx-auto px-4 py-6">
        <!-- Navegación separada -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                <a href="{{ route('biopsias.index') }}"
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Biopsias
                </a>
                <a href="{{ route('mascotas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Mascotas
                </a>
                <a href="{{ route('biopsias.personas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Personas
                </a>

            </nav>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Biopsias Generales</h1>
                <p class="text-gray-600 mt-1">Gestión completa de todas las biopsias del sistema</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('biopsias.personas.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Nueva Biopsia Persona
                </a>
                <!-- <a href="{{ route('biopsias.mascotas.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Nueva Biopsia Mascota
            </a> -->
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
                                Tipo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Paciente/Mascota
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
                    <!-- Fragmento corregido para biopsias.index -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($biopsias as $biopsia)
                        <tr class="hover:bg-gray-50">
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
                                    <a href="{{ route('biopsias.show', $biopsia->nbiopsia) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        Ver
                                    </a>

                                    <!-- Archivar/Restaurar -->
                                    <!-- @if($biopsia->estado)
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
                                    @endif -->


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
=======
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Biopsias') }}
            </h2>
            <a href="{{ route('biopsias.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                {{ __('Nueva Biopsia') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Mensajes de éxito -->
                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <!-- Mensajes de error -->
                    @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif

                    <!-- Tabla de biopsias -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600">
                                        N° Biopsia
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600">
                                        Diagnóstico Clínico
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600">
                                        Fecha Recibida
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600">
                                        Doctor
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600">
                                        Paciente
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600">
                                        Mascota
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b border-gray-300 dark:border-gray-600">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($biopsias as $biopsia)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $biopsia->nbiopsia }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        <div class="max-w-xs truncate" title="{{ $biopsia->diagnostico_clinico }}">
                                            {{ Str::limit($biopsia->diagnostico_clinico, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $biopsia->fecha_recibida ? date('d/m/Y', strtotime($biopsia->fecha_recibida)) : 'Sin fecha' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if($biopsia->doctor)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-white">
                                                        {{ substr($biopsia->doctor->nombre, 0, 1) }}{{ substr($biopsia->doctor->apellido, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium">
                                                    Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-gray-400 italic">Sin doctor</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if($biopsia->paciente)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-white">
                                                        {{ substr($biopsia->paciente->nombre, 0, 1) }}{{ substr($biopsia->paciente->apellido, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium">
                                                    {{ $biopsia->paciente->nombre }} {{ $biopsia->paciente->apellido }}
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-gray-400 italic">Sin paciente</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if($biopsia->mascota)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-white">
                                                        {{ substr($biopsia->mascota->nombre, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium">
                                                    {{ $biopsia->mascota->nombre }}
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-gray-400 italic">Sin mascota</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('biopsias.edit', $biopsia->nbiopsia) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition duration-200 transform hover:scale-105">
                                                Editar
                                            </a>
                                            @if (auth()->user()->role === 'admin')
                                            <form action="{{ route('biopsias.destroy', $biopsia->nbiopsia) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onsubmit="return confirm('¿Está seguro de eliminar esta biopsia? Esta acción no se puede deshacer.')"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition duration-200 transform hover:scale-105">
                                                    Eliminar
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-lg font-medium">No hay biopsias registradas</p>
                                            <p class="text-sm text-gray-400 mt-1">Comienza creando tu primera biopsia</p>
                                            <a href="{{ route('biopsias.create') }}"
                                                class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">
                                                Crear Primera Biopsia
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if ($biopsias->hasPages())
                    <div class="mt-6">
                        {{ $biopsias->links() }}
                    </div>
                    @endif
                </div>
            </div>
>>>>>>> de1c (se creo migracion de biopsia, controlador y vistas, siendo asi funciona la logica de crear y vista de login pero se seguira trabajando mas en la logica)
        </div>
    </div>
</x-app-layout>