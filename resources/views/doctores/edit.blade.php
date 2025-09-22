<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Doctor: ') . $doctor->nombre . ' ' . $doctor->apellido }}
            </h2>
            <a href="{{ route('doctores.index') }}" 
               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('Volver a Lista') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('doctores.update', $doctor->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Información Básica -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Información Básica
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <!-- JVPM -->
                                <div class="sm:col-span-1">
                                    <x-input-label for="jvpm" :value="__('JVPM')" />
                                    <x-text-input id="jvpm" 
                                                class="block mt-1 w-full" 
                                                type="text" 
                                                name="jvpm" 
                                                :value="old('jvpm', $doctor->jvpm)" 
                                                required 
                                                maxlength="10"
                                                placeholder="Ingrese JVPM" />
                                    <x-input-error :messages="$errors->get('jvpm')" class="mt-2" />
                                </div>

                                {{-- <!-- Estado del servicio -->
                                <div class="sm:col-span-1">
                                    <x-input-label :value="__('Estado del Servicio')" />
                                    <div class="mt-1">
                                        <!-- Input hidden para enviar 0 cuando el checkbox no está marcado -->
                                        <input type="hidden" name="estado_servicio" value="0">
                                        
                                        <label class="inline-flex items-center">
                                            <input id="estado_servicio" 
                                                   name="estado_servicio" 
                                                   type="checkbox" 
                                                   value="1"
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                                   {{ old('estado_servicio', $doctor->estado_servicio) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                Doctor activo en el servicio
                                            </span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('estado_servicio')" class="mt-2" />
                                    
                                    <!-- Info del estado actual -->
                                    <p class="text-xs text-gray-500 mt-1">
                                        Estado actual: 
                                        @if($doctor->estado_servicio)
                                            <span class="text-green-600 font-medium">Activo</span>
                                        @else
                                            <span class="text-red-600 font-medium">Inactivo</span>
                                        @endif
                                    </p>
                                </div> --}}

                                <!-- Nombre -->
                                <div class="sm:col-span-1">
                                    <x-input-label for="nombre" :value="__('Nombre')" />
                                    <x-text-input id="nombre" 
                                                class="block mt-1 w-full" 
                                                type="text" 
                                                name="nombre" 
                                                :value="old('nombre', $doctor->nombre)" 
                                                required 
                                                maxlength="100"
                                                placeholder="Ingrese nombre" />
                                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                                </div>

                                <!-- Apellido -->
                                <div class="sm:col-span-1">
                                    <x-input-label for="apellido" :value="__('Apellido')" />
                                    <x-text-input id="apellido" 
                                                class="block mt-1 w-full" 
                                                type="text" 
                                                name="apellido" 
                                                :value="old('apellido', $doctor->apellido)" 
                                                required 
                                                maxlength="100"
                                                placeholder="Ingrese apellido" />
                                    <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Información de Contacto
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <!-- Celular -->
                                <div class="sm:col-span-1">
                                    <x-input-label for="celular" :value="__('Celular')" />
                                    <x-text-input id="celular" 
                                                class="block mt-1 w-full" 
                                                type="text" 
                                                name="celular" 
                                                :value="old('celular', $doctor->celular)" 
                                                required 
                                                maxlength="8"
                                                placeholder="12345678" />
                                    <x-input-error :messages="$errors->get('celular')" class="mt-2" />
                                </div>

                                <!-- Fax -->
                                <div class="sm:col-span-1">
                                    <x-input-label for="fax" :value="__('Fax (Opcional)')" />
                                    <x-text-input id="fax" 
                                                class="block mt-1 w-full" 
                                                type="text" 
                                                name="fax" 
                                                :value="old('fax', $doctor->fax)" 
                                                maxlength="11"
                                                placeholder="Ingrese fax" />
                                    <x-input-error :messages="$errors->get('fax')" class="mt-2" />
                                </div>

                                <!-- Correo -->
                                <div class="sm:col-span-2">
                                    <x-input-label for="correo" :value="__('Correo Electrónico (Opcional)')" />
                                    <x-text-input id="correo" 
                                                class="block mt-1 w-full" 
                                                type="email" 
                                                name="correo" 
                                                :value="old('correo', $doctor->correo)" 
                                                maxlength="255"
                                                placeholder="doctor@ejemplo.com" />
                                    <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Ubicación
                            </h3>
                            <div>
                                <x-input-label for="direccion" :value="__('Dirección (Opcional)')" />
                                <textarea id="direccion" 
                                        name="direccion" 
                                        rows="3" 
                                        maxlength="500"
                                        placeholder="Ingrese la dirección completa..."
                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('direccion', $doctor->direccion) }}</textarea>
                                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Máximo 500 caracteres
                                </p>
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Información del Registro
                            </h3>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Creado:</span>
                                        <span class="text-gray-600 dark:text-gray-400">
                                            {{ $doctor->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Última actualización:</span>
                                        <span class="text-gray-600 dark:text-gray-400">
                                            {{ $doctor->updated_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div class="flex flex-col sm:flex-row gap-3 sm:justify-between">
                                <a href="{{ route('doctores.index') }}" 
                                   class="inline-flex items-center justify-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 order-2 sm:order-1">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    {{ __('Cancelar') }}
                                </a>

                                <x-primary-button class="order-1 sm:order-2 justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    {{ __('Actualizar Doctor') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>