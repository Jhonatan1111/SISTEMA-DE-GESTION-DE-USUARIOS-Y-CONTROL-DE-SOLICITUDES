<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Crear Nuevo Doctor') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="w-full max-w-md"> 
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">

                <!-- Mensajes de error -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-md text-sm">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('doctores.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="jvpm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">JVPM</label>
                        <input type="text" id="jvpm" name="jvpm" value="{{ old('jvpm') }}" required maxlength="10"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 
                                      focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="100"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 
                                      focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                        <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required maxlength="100"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 
                                      focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="celular" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Celular</label>
                        <input type="text" id="celular" name="celular" value="{{ old('celular') }}" required maxlength="8"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 
                                      focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="fax" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fax (Opcional)</label>
                        <input type="text" id="fax" name="fax" value="{{ old('fax') }}" maxlength="11"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 
                                      focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="correo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo (Opcional)</label>
                        <input type="email" id="correo" name="correo" value="{{ old('correo') }}" maxlength="255"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 
                                      focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección (Opcional)</label>
                        <textarea id="direccion" name="direccion" rows="3" maxlength="500"
                                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 
                                         dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 
                                         focus:ring-indigo-500 sm:text-sm">{{ old('direccion') }}</textarea>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between">
                        <a href="{{ route('doctores.index') }}"
                           class="px-3 py-2 bg-gray-600 text-white text-xs font-medium rounded-md 
                                  shadow hover:bg-gray-700 focus:outline-none focus:ring-2 
                                  focus:ring-gray-500">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-3 py-2 bg-indigo-600 text-white text-xs font-medium rounded-md 
                                       shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 
                                       focus:ring-indigo-500">
                            Guardar Doctor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

