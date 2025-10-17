<x-app-layout>
    
        <div class="bg-white from-slate-900 to-slate-800">
            <div class="max-w-7xl bg-gradient-to-br from-slate-50 to-slate-100 mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col sm:flex-row justify-between items-center gap-3">
                <h2 class="text-4xl font-bold text-blue-700">
                    {{ __('Lista de Citologías') }}
                </h2>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('listas.citologias.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300 hover:shadow-lg hover:scale-105 flex items-center gap-2 text-sm">
                        <span class="text-lg">➕</span> Agregar
                    </a>
                @endif
            </div>
        </div>
   
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

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
                                <th class="px-6 py-4 text-left text-sm font-bold w-24">Código</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Diagnóstico</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Macroscópico</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Microscópico</th>
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
                                            <span class="text-gray-900 font-semibold">{{ $lista->diagnostico }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="break-words">
                                            <span class="text-gray-700">{{ $lista->macroscopico ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="break-words">
                                            <span class="text-gray-600">{{ $lista->microscopico ?? '-' }}</span>
                                        </div>
                                    </td>
                                    @if (auth()->user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex gap-2 justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex-wrap">
                                                {{-- Editar --}}
                                                <a href="{{ route('listas.citologias.edit', $lista->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-lg text-xs font-semibold transition-all duration-300 hover:shadow-lg transform hover:scale-105 whitespace-nowrap">
                                                    ✏️ Editar
                                                </a>

                                                {{-- Eliminar --}}
                                                <form action="{{ route('listas.citologias.destroy', $lista->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta citología?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-lg text-xs font-semibold transition-all duration-300 hover:shadow-lg transform hover:scale-105">
                                                        🗑️ Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'admin' ? '5' : '4' }}" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <span class="text-6xl">📋</span>
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

        </div>
    </div>
</x-app-layout>