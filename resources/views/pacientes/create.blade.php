<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Crear Nuevo Paciente') }}
        </h2>
    </x-slot>

    <div class="form-container">
        <!-- Errores -->
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="input-error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pacientes.store') }}" method="POST">
            @csrf

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre"
                           value="{{ old('nombre') }}" required maxlength="255">
                </div>

                <div class="input-group">
                    <i class="fas fa-user-tag"></i>
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido"
                           value="{{ old('apellido') }}" required maxlength="255">
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="dui" name="dui" placeholder="DUI"
                           value="{{ old('dui') }}" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-birthday-cake"></i>
                    <input type="number" id="edad" name="edad" placeholder="Edad"
                           value="{{ old('edad') }}" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-venus-mars"></i>
                    <select id="sexo" name="sexo" required>
                        <option value="">Sexo</option>
                        <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                           value="{{ old('fecha_nacimiento') }}">
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-ring"></i>
                    <input type="text" id="estado_civil" name="estado_civil" placeholder="Estado Civil"
                           value="{{ old('estado_civil') }}">
                </div>

                <div class="input-group">
                    <i class="fas fa-briefcase"></i>
                    <input type="text" id="ocupacion" name="ocupacion" placeholder="Ocupación"
                           value="{{ old('ocupacion') }}">
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-phone-alt"></i>
                    <input type="text" id="celular" name="celular" placeholder="Celular"
                           value="{{ old('celular') }}" required maxlength="8">
                </div>

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="correo" name="correo" placeholder="Correo (Opcional)"
                           value="{{ old('correo') }}" maxlength="255">
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <textarea id="direccion" name="direccion" rows="3" maxlength="500"
                          placeholder="Dirección (Opcional)">{{ old('direccion') }}</textarea>
            </div>

            <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('pacientes.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">Guardar Paciente</button>
            </div>
        </form>
    </div>
</x-app-layout>
