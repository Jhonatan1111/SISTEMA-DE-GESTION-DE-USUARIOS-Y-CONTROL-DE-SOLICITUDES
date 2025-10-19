<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Citologías de Personas</h1>
                <p class="text-gray-600 mt-1">Listado de todas las citologías registradas</p>
            </div>
            <a href="{{ route('citologias.personas.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300 hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Citología
            </a>
        </div>

        <!-- Mensajes -->
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tabla -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold">N° Citología</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Tipo</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Paciente</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Doctor</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Fecha</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Estado</th>
                            <th class="px-6 py-4 text-center text-sm font-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($citologias as $citologia)
                        <tr class="hover:bg-blue-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $citologia->ncitologia }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($citologia->tipo == 'liquida')
                                <span class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    💧 Líquida
                                </span>
                                @else
                                <span class="inline-flex items-center bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    📄 Normal
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-semibold text-gray-900">
                                        {{ $citologia->paciente->nombre }} {{ $citologia->paciente->apellido }}
                                    </div>
                                    <div class="text-gray-500">
                                        {{ $citologia->paciente->DUI }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700">
                                    {{ $citologia->doctor->nombre }} {{ $citologia->doctor->apellido }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-gray-600">
                                    {{ $citologia->fecha_recibida->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($citologia->estado)
                                <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    ✓ Activa
                                </span>
                                @else
                                <span class="inline-flex items-center bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">
                                    📁 Archivada
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('citologias.personas.show', $citologia->ncitologia) }}"
                                        class="text-blue-600 hover:text-blue-900 font-semibold" title="Ver">
                                        👁️
                                    </a>
                                    <a href="{{ route('citologias.personas.edit', $citologia->ncitologia) }}"
                                        class="text-green-600 hover:text-green-900 font-semibold" title="Editar">
                                        ✏️
                                    </a>
                                    <form action="{{ route('citologias.personas.toggle-estado', $citologia->ncitologia) }}"
                                        method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-yellow-600 hover:text-yellow-900 font-semibold"
                                            title="Cambiar Estado">
                                            {{ $citologia->estado ? '📁' : '✓' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('citologias.personas.imprimir', $citologia->ncitologia) }}"
                                        class="text-purple-600 hover:text-purple-900 font-semibold"
                                        title="Imprimir"
                                        target="_blank">
                                        🖨️
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="text-6xl">🔬</span>
                                    <p class="text-gray-500 text-lg">No hay citologías registradas</p>
                                    <a href="{{ route('citologias.personas.create') }}"
                                        class="text-blue-600 hover:text-blue-800 font-semibold mt-2">
                                        Registrar la primera citología →
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if ($citologias->hasPages())
        <div class="mt-6">
            {{ $citologias->links() }}
        </div>
        @endif
    </div>
</x-app-layout>