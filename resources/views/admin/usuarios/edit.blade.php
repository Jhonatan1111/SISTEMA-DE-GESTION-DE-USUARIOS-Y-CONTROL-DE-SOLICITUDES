<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Editar Usuario: ') }} {{ $usuario->nombre_completo }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="form-container">
                
                <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre y Apellido -->
                    <div class="grid-2">
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input id="nombre" type="text" name="nombre" 
                                value="{{ old('nombre', $usuario->nombre) }}" 
                                placeholder="Nombre" required>
                            <x-input-error :messages="$errors->get('nombre')" class="input-error" />
                        </div>

                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input id="apellido" type="text" name="apellido" 
                                value="{{ old('apellido', $usuario->apellido) }}" 
                                placeholder="Apellido" required>
                            <x-input-error :messages="$errors->get('apellido')" class="input-error" />
                        </div>
                    </div>

                    <!-- Celular -->
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input id="celular" type="text" name="celular" 
                            value="{{ old('celular', $usuario->celular) }}" 
                            placeholder="Celular" maxlength="8" required>
                        <x-input-error :messages="$errors->get('celular')" class="input-error" />
                    </div>

                    <!-- Email -->
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input id="email" type="email" name="email" 
                            value="{{ old('email', $usuario->email) }}" 
                            placeholder="Correo electrónico" required>
                        <x-input-error :messages="$errors->get('email')" class="input-error" />
                    </div>

                    <!-- Info contraseña -->
                    <div class="p-3 rounded-md" style="background:#eaf4ff; border:1px solid #b6d4fe;">
                        <h3 class="text-sm font-semibold text-blue-800">Información sobre contraseña</h3>
                        <p class="text-sm text-blue-700">Deja los campos de contraseña vacíos si no deseas cambiarla.</p>
                    </div>

                    <!-- Contraseña -->
                    <div class="grid-2">
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input id="password" type="password" name="password" placeholder="Nueva Contraseña">
                            <x-input-error :messages="$errors->get('password')" class="input-error" />
                            <p>Mínimo 4 caracteres (opcional)</p>
                        </div>

                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input id="password_confirmation" type="password" 
                                name="password_confirmation" placeholder="Confirmar contraseña">
                        </div>
                    </div>

                    <!-- Rol -->
                    <div class="input-group">
                        <i class="fas fa-user-shield"></i>
                        <select id="role" name="role" required>
                            <option value="">Seleccionar rol...</option>
                            <option value="admin" {{ old('role', $usuario->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="empleado" {{ old('role', $usuario->role) === 'empleado' ? 'selected' : '' }}>Empleado</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="input-error" />
                    </div>

                    <!-- Info Usuario -->
                    <div class="p-4 rounded-md" style="background:#f3f4f6;">
                        <h3 class="font-semibold mb-2">Información del Usuario</h3>
                        <div class="grid-2">
                            <p><strong>ID:</strong> {{ $usuario->id }}</p>
                            <p><strong>Creado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn-cancel">
                            Volver
                        </a>
                        <button type="submit" class="btn-submit">
                            Actualizar Usuario
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
