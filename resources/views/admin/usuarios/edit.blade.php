<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">Editar Usuario</h1>
                <p class="text-sm text-gray-500 mt-1">Usuario: <span class="font-semibold text-green-600">{{ $usuario->nombre_completo }}</span></p>
            </div>
            <a href="{{ route('admin.usuarios.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <!-- Errores -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Corrige los siguientes errores:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" id="formUsuario" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información Personal -->
            <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">Información Personal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="Ingrese el nombre" required autofocus>
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-1">Apellido <span class="text-red-500">*</span></label>
                        <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $usuario->apellido) }}"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="Ingrese el apellido" required>
                        <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                    </div>

                    <div>
                        <label for="celular" class="block text-sm font-semibold text-gray-700 mb-1">Celular <span class="text-red-500">*</span></label>
                        <input type="text" id="celular" name="celular" value="{{ old('celular', $usuario->celular) }}" maxlength="8"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="Ej: 78901234" required>
                        <p class="text-xs text-gray-500 mt-1">8 dígitos</p>
                        <x-input-error :messages="$errors->get('celular')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="ejemplo@correo.com" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Credenciales y Acceso -->
            <div class="bg-gradient-to-r from-green-50 via-white to-green-50 p-6 rounded-2xl shadow-xl border border-green-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">Credenciales y Acceso</h2>
                
                <!-- Info contraseña -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-blue-800">Información sobre contraseña</h3>
                            <p class="text-sm text-blue-700 mt-1">Deja los campos de contraseña vacíos si no deseas cambiarla.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Nueva Contraseña</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                            placeholder="Dejar vacío para no cambiar">
                        <p class="text-xs text-gray-500 mt-1">Mínimo 4 caracteres (opcional)</p>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                            placeholder="Confirmar nueva contraseña">
                    </div>

                    <div class="md:col-span-2">
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Rol del Usuario <span class="text-red-500">*</span></label>
                        <select id="role" name="role"
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                            required>
                            <option value="">Seleccionar rol...</option>
                            <option value="admin" {{ old('role', $usuario->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="empleado" {{ old('role', $usuario->role) === 'empleado' ? 'selected' : '' }}>Empleado</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-gradient-to-r from-gray-50 via-white to-gray-50 p-6 rounded-2xl shadow-xl border border-gray-200">
                <h2 class="text-xl font-bold text-gray-700 mb-4 border-b-2 border-gray-200 pb-2">
                    <svg class="w-5 h-5 inline mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    Información del Sistema
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">ID Usuario</p>
                        <p class="text-lg font-bold text-gray-900">{{ $usuario->id }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Fecha de Creación</p>
                        <p class="text-lg font-bold text-gray-900">{{ $usuario->created_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $usuario->created_at->format('H:i') }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Última Actualización</p>
                        <p class="text-lg font-bold text-gray-900">{{ $usuario->updated_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $usuario->updated_at->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg rounded-lg">
                <a href="{{ route('admin.usuarios.index') }}"
                    class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
</x-app-layout>