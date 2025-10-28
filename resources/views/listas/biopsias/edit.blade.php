<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">Editar Lista de Biopsia</h1>
                <p class="text-sm text-gray-500 mt-1">Código: <span class="font-semibold text-green-600">{{ $listaBiopsia->codigo }}</span></p>
            </div>
            <a href="{{ route('listas.biopsias.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <form action="{{ route('listas.biopsias.update', $listaBiopsia->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información Básica -->
            <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">
                    <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Información Básica
                </h2>

                <div class="space-y-4">
                    <!-- Código -->
                    <div>
                        <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-1">
                            Código <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="codigo"
                            name="codigo"
                            value="{{ old('codigo', $listaBiopsia->codigo) }}"
                            readonly
                            class="w-full px-4 py-2 bg-gray-100 border-2 border-gray-300 rounded-lg cursor-not-allowed text-gray-600 font-semibold">
                        <p class="mt-1 text-xs text-gray-500">El código no se puede modificar</p>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">
                            Descripción <span class="text-red-500">*</span>
                        </label>
                        <textarea id="descripcion"
                            name="descripcion"
                            rows="4"
                            required
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="Nombre corto del tipo de biopsia...">{{ old('descripcion', $listaBiopsia->descripcion) }}</textarea>
                    </div>

                    <!-- Macroscopico -->
                    <div>
                        <label for="macroscopico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Macroscopico <span class="text-red-500">*</span>
                        </label>
                        <textarea id="macroscopico"
                            name="macroscopico"
                            rows="4"
                            required
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="Ingrese el macroscopico detallado...">{{ old('macroscopico', $listaBiopsia->macroscopico) }}</textarea>
                    </div>
                </div>
            </div>
            <!-- Botones -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg rounded-lg">
                <a href="{{ route('listas.biopsias.index') }}"
                    class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                    Cancelar
                </a>
                <button type="reset"
                    class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                    Limpiar
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105 flex items-center gap-2">
                    Actualizar Biopsia
                </button>
            </div>
        </form>
    </div>
</x-app-layout>