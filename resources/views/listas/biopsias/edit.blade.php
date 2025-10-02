<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Lista de Biopsia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('listas.biopsias.update', $listaBiopsia->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="codigo" class="block text-sm font-medium text-gray-700">
                                Código * (Ej: BIO-001, PIEL-01, etc)
                            </label>
                            <input type="text"
                                name="codigo"
                                id="codigo"
                                maxlength="20"
                                value="{{ old('codigo', $listaBiopsia->codigo) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase bg-gray-100"
                                readonly
                                style="text-transform: uppercase;">
                            @error('codigo')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">
                                Descripción * (Nombre corto del tipo de biopsia)
                            </label>
                            <input type="text"
                                name="descripcion"
                                id="descripcion"
                                value="{{ old('descripcion', $listaBiopsia->descripcion) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            @error('descripcion')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="diagnostico" class="block text-sm font-medium text-gray-700">
                                Diagnóstico *
                            </label>
                            <textarea name="diagnostico"
                                id="diagnostico"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>{{ old('diagnostico', $listaBiopsia->diagnostico) }}</textarea>
                            @error('diagnostico')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="macroscopico" class="block text-sm font-medium text-gray-700">
                                Macroscópico *
                            </label>
                            <textarea name="macroscopico"
                                id="macroscopico"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>{{ old('macroscopico', $listaBiopsia->macroscopico) }}</textarea>
                            @error('macroscopico')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="microscopico" class="block text-sm font-medium text-gray-700">
                                Microscópico *
                            </label>
                            <textarea name="microscopico"
                                id="microscopico"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>{{ old('microscopico', $listaBiopsia->microscopico) }}</textarea>
                            @error('microscopico')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar
                            </button>
                            <a href="{{ route('listas.biopsias.index') }}"
                                class="text-gray-600 hover:text-gray-900">
                                Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>