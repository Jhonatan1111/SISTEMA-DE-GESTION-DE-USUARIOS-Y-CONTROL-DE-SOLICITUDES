<x-app-layout>
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
        </div>
    </div>
</x-app-layout>