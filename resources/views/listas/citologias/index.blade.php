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

        {{-- Mensaje de éxito --}}
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

        {{-- Mensaje de error --}}
        @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md">
            <div class="flex items-center gap-3">
                <span class="text-2xl">❌</span>
                <div>
                    <p class="text-red-800 font-semibold">¡Error!</p>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Tabla de Citologías --}}
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-fixed">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-300 to-blue-400 text-grey-900">
                            <th class="px-6 py-4 text-left text-sm ">Código</th>
                            <th class="px-6 py-4 text-left text-sm font-bold w-48">Descripción</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Diagnóstico</th>
                            @if (auth()->user()->role === 'admin')
                            <th class="px-6 py-4 text-center text-sm font-bold w-32">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($listaCitologia as $lista)
                        <tr class="hover:bg-blue-50 transition-colors duration-200 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $lista->codigo }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="break-words">
                                    <span class="text-gray-900 font-semibold">{{ $lista->descripcion }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="break-words">
                                    <span class="text-gray-900 font-semibold">{{ $lista->diagnostico }}</span>
                                </div>
                            </td>


                            @if (auth()->user()->role === 'admin')
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('listas.citologias.edit', $lista->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Editar
                                    </a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? '5' : '4' }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="text-6xl"></span>
                                    <p class="text-gray-500 text-lg">No hay citologías registradas</p>
                                    @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('listas.citologias.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold mt-2">
                                        Registrar la primera citología →
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
        @if ($listaCitologia->hasPages())
        <div class="mt-8">
            {{ $listaCitologia->links() }}
        </div>
        @endif
</x-app-layout>