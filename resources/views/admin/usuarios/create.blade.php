<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Crear Nuevo Usuario') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="form-container">
                <form action="{{ route('admin.usuarios.store') }}" method="POST" id="formUsuario">
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formUsuario');
            const nombre = document.getElementById('nombre');
            const apellido = document.getElementById('apellido');
            const celular = document.getElementById('celular');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');

            // NOMBRE - Solo letras y espacios
            if (nombre) {
                nombre.addEventListener('input', function(e) {
                    this.value = this.value.trimStart();
                    this.value = this.value.replace(/[^a-záéíóúñA-ZÁÉÍÓÚÑ\s]/g, '');
                });
                nombre.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        this.value = this.value.trimStart().replace(/[^a-záéíóúñA-ZÁÉÍÓÚÑ\s]/g, '');
                    }, 10);
                });
            }

            // APELLIDO - Solo letras y espacios
            if (apellido) {
                apellido.addEventListener('input', function(e) {
                    this.value = this.value.trimStart();
                    this.value = this.value.replace(/[^a-záéíóúñA-ZÁÉÍÓÚÑ\s]/g, '');
                });
                apellido.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        this.value = this.value.trimStart().replace(/[^a-záéíóúñA-ZÁÉÍÓÚÑ\s]/g, '');
                    }, 10);
                });
            }

            // CELULAR - Solo números, máximo 8 dígitos
            if (celular) {
                celular.addEventListener('input', function(e) {
                    this.value = this.value.trimStart();
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length > 8) {
                        this.value = this.value.slice(0, 8);
                    }
                });
                celular.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        this.value = this.value.trimStart().replace(/[^0-9]/g, '').slice(0, 8);
                    }, 10);
                });
            }

            // EMAIL - Sin espacios al inicio
            if (email) {
                email.addEventListener('input', function(e) {
                    this.value = this.value.trimStart();
                });
                email.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        this.value = this.value.trimStart();
                    }, 10);
                });
            }

            // PASSWORD - Sin espacios al inicio
            if (password) {
                password.addEventListener('input', function(e) {
                    this.value = this.value.trimStart();
                });
                password.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        this.value = this.value.trimStart();
                    }, 10);
                });
            }

            // PASSWORD CONFIRMATION - Sin espacios al inicio
            if (passwordConfirm) {
                passwordConfirm.addEventListener('input', function(e) {
                    this.value = this.value.trimStart();
                });
                passwordConfirm.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        this.value = this.value.trimStart();
                    }, 10);
                });
            }

            // LIMPIAR TODO ANTES DE ENVIAR
            if (form) {
                form.addEventListener('submit', function(e) {
                    nombre.value = nombre.value.trim();
                    apellido.value = apellido.value.trim();
                    celular.value = celular.value.trim();
                    email.value = email.value.trim();
                    password.value = password.value.trim();
                    passwordConfirm.value = passwordConfirm.value.trim();
                });
            }
        });
    </script>
    @endpush
</x-app-layout>