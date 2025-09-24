<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
            {{ __('Editar Usuario: ') }} {{ $usuario->nombre_completo }}
        </h2>
    </x-slot>

    <style>
        body {
            background-color: #e6f4ff; /* Fondo celeste suave */
            font-family: 'Segoe UI', sans-serif;
        }
        label {
            font-weight: 600;
            color: #374151;
        }
        input, select {
            border-radius: 8px !important;
        }
        input:focus, select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
        }
    </style>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nombre y Apellido -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nombre" :value="__('Nombre')" />
                                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $usuario->nombre)" required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="apellido" :value="__('Apellido')" />
                                <x-text-input id="apellido" class="block mt-1 w-full" type="text" name="apellido" :value="old('apellido', $usuario->apellido)" required />
                                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Celular -->
                        <div>
                            <x-input-label for="celular" :value="__('Celular')" />
                            <x-text-input id="celular" class="block mt-1 w-full" type="text" name="celular" :value="old('celular', $usuario->celular)" required />
                            <x-input-error :messages="$errors->get('celular')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Correo Electrónico')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $usuario->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Nota contraseña -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                                        Información sobre contraseña
                                    </h3>
                                    <p class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                                        Deja los campos de contraseña vacíos si no deseas cambiarla.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="password" :value="__('Nueva Contraseña')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mínimo 4 caracteres (opcional)</p>
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                            </div>
                        </div>

                        <!-- Rol -->
                        <div>
                            <x-input-label for="role" :value="__('Rol')" />
                            <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500" required>
                                <option value="">Seleccionar rol...</option>
                                <option value="admin" {{ old('role', $usuario->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="empleado" {{ old('role', $usuario->role) === 'empleado' ? 'selected' : '' }}>Empleado</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Info Usuario -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Información del Usuario</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">ID:</span>
                                    <span class="ml-1 text-gray-900 dark:text-gray-100">{{ $usuario->id }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Creado:</span>
                                    <span class="ml-1 text-gray-900 dark:text-gray-100">{{ $usuario->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Última actualización:</span>
                                    <span class="ml-1 text-gray-900 dark:text-gray-100">{{ $usuario->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-4">
                            <a href="{{ route('admin.usuarios.index') }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-semibold text-center flex items-center justify-center">
                                Volver
                            </a>
                            
                            <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold flex items-center justify-center">
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
