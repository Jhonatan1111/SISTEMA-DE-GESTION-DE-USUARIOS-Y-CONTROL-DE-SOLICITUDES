<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Crear Nuevo Usuario') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="form-container">
                <form action="{{ route('admin.usuarios.store') }}" method="POST">
                    @csrf

                    <!-- Nombre y Apellido -->
                    <div class="grid-2">
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" required autofocus>
                            <x-input-error :messages="$errors->get('nombre')" class="input-error" />
                        </div>

                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Apellido" required>
                            <x-input-error :messages="$errors->get('apellido')" class="input-error" />
                        </div>
                    </div>

                    <!-- Celular -->
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input id="celular" type="text" name="celular" value="{{ old('celular') }}" placeholder="Celular" maxlength="8" required>
                        <x-input-error :messages="$errors->get('celular')" class="input-error" />
                    </div>

                    <!-- Email -->
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required>
                        <x-input-error :messages="$errors->get('email')" class="input-error" />
                    </div>

                    <!-- Contraseña y Confirmación -->
                    <div class="grid-2">
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input id="password" type="password" name="password" placeholder="Contraseña" required>
                            <x-input-error :messages="$errors->get('password')" class="input-error" />
                            <p>Mínimo 4 caracteres</p>
                        </div>

                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                        </div>
                    </div>

                    <!-- Rol -->
                    <div class="input-group">
                        <i class="fas fa-user-shield"></i>
                        <select id="role" name="role" required>
                            <option value="">Seleccionar rol...</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="empleado" {{ old('role') === 'empleado' ? 'selected' : '' }}>Empleado</option>
                        </select>
                        <x-input-error :messages="$errors->get('rol')" class="input-error" />
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn-cancel">
                            Volver
                        </a>
                        <button type="submit" class="btn-submit">
                            Crear Usuario
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
