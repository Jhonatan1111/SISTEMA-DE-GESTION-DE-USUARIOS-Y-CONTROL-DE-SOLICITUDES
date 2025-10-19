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
                        <p class="mt-1 text-xs text-gray-500">Código no editable</p>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">
                            Descripción <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="descripcion"
                               name="descripcion"
                               value="{{ old('descripcion', $listaBiopsia->descripcion) }}"
                               required
                               class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                               placeholder="Nombre corto del tipo de biopsia">
                    </div>

                    <!-- Diagnóstico -->
                    <div>
                        <label for="diagnostico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Diagnóstico <span class="text-red-500">*</span>
                        </label>
                        <textarea id="diagnostico"
                                  name="diagnostico"
                                  rows="4"
                                  required
                                  class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                  placeholder="Ingrese el diagnóstico detallado...">{{ old('diagnostico', $listaBiopsia->diagnostico) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Análisis Detallado -->
            <div class="bg-gradient-to-r from-purple-50 via-white to-purple-50 p-6 rounded-2xl shadow-xl border border-purple-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4 border-b-2 border-purple-200 pb-2">
                    Análisis Detallado
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Macroscópico -->
                    <div>
                        <label for="macroscopico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Análisis Macroscópico
                        </label>
                        <textarea id="macroscopico"
                                  name="macroscopico"
                                  rows="4"
                                  class="w-full px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:border-purple-500 transition-all"
                                  placeholder="Descripción de observaciones macroscópicas...">{{ old('macroscopico', $listaBiopsia->macroscopico) }}</textarea>
                    </div>

                    <!-- Microscópico -->
                    <div>
                        <label for="microscopico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Análisis Microscópico
                        </label>
                        <textarea id="microscopico"
                                  name="microscopico"
                                  rows="4"
                                  class="w-full px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:border-purple-500 transition-all"
                                  placeholder="Descripción de observaciones microscópicas...">{{ old('microscopico', $listaBiopsia->microscopico) }}</textarea>
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
