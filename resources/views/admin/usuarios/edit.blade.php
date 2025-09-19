{{-- 
ARCHIVO: resources/views/admin/usuarios/edit.blade.php
DESCRIPCIÓN: Formulario para editar usuarios existentes (Tailwind CSS)
--}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuario: ') }} {{ $usuario->nombre_completo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <x-input-label for="nombre" :value="__('Nombre')" />
                                <x-text-input id="nombre" 
                                            class="block mt-1 w-full" 
                                            type="text" 
                                            name="nombre" 
                                            :value="old('nombre', $usuario->nombre)" 
                                            required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <!-- Apellido -->
                            <div>
                                <x-input-label for="apellido" :value="__('Apellido')" />
                                <x-text-input id="apellido" 
                                            class="block mt-1 w-full" 
                                            type="text" 
                                            name="apellido" 
                                            :value="old('apellido', $usuario->apellido)" 
                                            required />
                                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Correo Electrónico')" />
                            <x-text-input id="email" 
                                        class="block mt-1 w-full" 
                                        type="email" 
                                        name="email" 
                                        :value="old('email', $usuario->email)" 
                                        required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Nota sobre contraseña -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                        Información sobre contraseña
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                        <p>Deja los campos de contraseña vacíos si no deseas cambiarla.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nueva Contraseña -->
                            <div>
                                <x-input-label for="password" :value="__('Nueva Contraseña')" />
                                <x-text-input id="password" 
                                            class="block mt-1 w-full"
                                            type="password"
                                            name="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mínimo 6 caracteres (opcional)</p>
                            </div>

                            <!-- Confirmar Nueva Contraseña -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                                <x-text-input id="password_confirmation" 
                                            class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation" />
                            </div>
                        </div>

                        <!-- Rol -->
                        <div>
                            <x-input-label for="rol" :value="__('Rol')" />
                            <select id="rol" 
                                    name="rol" 
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                    required>
                                <option value="">Seleccionar rol...</option>
                                <option value="admin" {{ old('rol', $usuario->rol) === 'admin' ? 'selected' : '' }}>
                                    Administrador
                                </option>
                                <option value="empleado" {{ old('rol', $usuario->rol) === 'empleado' ? 'selected' : '' }}>
                                    Empleado
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                        </div>

                        <!-- Información del Usuario -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Información del Usuario</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">ID:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $usuario->id }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Creado:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $usuario->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Última actualización:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $usuario->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.usuarios.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Volver
                            </a>
                            
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                {{ __('Actualizar Usuario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>