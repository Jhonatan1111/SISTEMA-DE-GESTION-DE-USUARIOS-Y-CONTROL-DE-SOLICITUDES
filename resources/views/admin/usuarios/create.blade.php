<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
            {{ __('Crear Nuevo Usuario') }}
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

                    <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Nombre y Apellido -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nombre" :value="__('Nombre')" />
                                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre"
                                    :value="old('nombre')" required autofocus />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="apellido" :value="__('Apellido')" />
                                <x-text-input id="apellido" class="block mt-1 w-full" type="text" name="apellido"
                                    :value="old('apellido')" required />
                                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Celular -->
                        <div>
                            <x-input-label for="celular" :value="__('Celular')" />
                            <x-text-input id="celular" class="block mt-1 w-full" type="text" name="celular"
                                :value="old('celular')" required maxlength="8" />
                            <x-input-error :messages="$errors->get('celular')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Correo Electrónico')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Contraseña y Confirmación -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="password" :value="__('Contraseña')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mínimo 4 caracteres</p>
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required />
                            </div>
                        </div>

                        <!-- Rol -->
                        <div>
                            <x-input-label for="role" :value="__('Rol')" />
                            <select id="role" name="role" 
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" 
                                required>
                                <option value="">Seleccionar rol...</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="empleado" {{ old('role') === 'empleado' ? 'selected' : '' }}>Empleado</option>
                            </select>
                            <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                        </div>

                        <!-- Botones -->
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-4">
                            <a href="{{ route('admin.usuarios.index') }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-semibold text-center">
                                Volver
                            </a>
                            
                            <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold">
                                Crear Usuario
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
