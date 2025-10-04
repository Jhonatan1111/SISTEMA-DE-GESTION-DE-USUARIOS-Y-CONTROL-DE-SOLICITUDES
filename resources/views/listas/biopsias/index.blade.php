<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Biopsias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                    @endif
                    {{-- Corregido: sin @ y con rol en lugar de role --}}
                    @if (auth()->user()->role === 'admin')
                    <div class="mb-4">
                        <a href="{{ route('listas.biopsias.create') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                            Nueva Lista de Biopsia
                        </a>
                        <p></p>
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Código</th>
                                    <th class="border border-gray-300 px-4 py-2">Descripción</th>
                                    <th class="border border-gray-300 px-4 py-2">Diagnóstico</th>
                                    <th class="border border-gray-300 px-4 py-2">Macroscopico</th>
                                    <th class="border border-gray-300 px-4 py-2">Microscopico</th>
                                    @if (auth()->user()->role === 'admin')
                                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listaBiopsia as $lista)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2 font-bold">{{ $lista->codigo }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $lista->descripcion }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $lista->diagnostico }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $lista->macroscopico }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $lista->microscopico }}</td>
                                    @if(auth()->user()->role === 'admin')

                                    <td class="border border-gray-300 px-4 py-2">
                                        {{-- Corregido: rutas con punto en lugar de guión --}}
                                        <a href="{{ route('listas.biopsias.edit', $lista->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>

                                        <form action="{{ route('listas.biopsias.destroy', $lista->id) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('¿Está seguro de eliminar esta lista?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">
                                        No hay listas de biopsia registradas
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $listaBiopsia->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>