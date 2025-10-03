<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <div>
            <h2 class="create-title">
                {{ __('Editar Paciente Humano') }}
            </h2>
        </div>
    </x-slot>

    <div class="form-container">
        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre"
                        value="{{ old('nombre', $paciente->nombre) }}" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-user-tag"></i>
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido"
                        value="{{ old('apellido', $paciente->apellido) }}" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="dui" name="dui" placeholder="DUI"
                        value="{{ old('dui', $paciente->dui) }}" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-sort-numeric-up"></i>
                    <input type="number" id="edad" name="edad" placeholder="Edad"
                        value="{{ old('edad', $paciente->edad) }}" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-venus-mars"></i>
                    <select id="sexo" name="sexo" required>
                        <option value="">Sexo</option>
                        <option value="masculino" {{ old('sexo', $paciente->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('sexo', $paciente->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento', \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-ring"></i>
                    <input type="text" id="estado_civil" name="estado_civil" placeholder="Estado Civil"
                        value="{{ old('estado_civil', $paciente->estado_civil) }}">
                </div>

                <div class="input-group">
                    <i class="fas fa-briefcase"></i>
                    <input type="text" id="ocupacion" name="ocupacion" placeholder="Ocupación"
                        value="{{ old('ocupacion', $paciente->ocupacion) }}">
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="celular" name="celular" placeholder="Celular"
                        value="{{ old('celular', $paciente->celular) }}" required maxlength="8">
                </div>

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="correo" name="correo" placeholder="Correo (Opcional)"
                        value="{{ old('correo', $paciente->correo) }}">
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <textarea id="direccion" name="direccion" rows="3" placeholder="Dirección (Opcional)">{{ old('direccion', $paciente->direccion) }}</textarea>
            </div>

            <div class="form-actions" style="display: flex; justify-content: space-between; gap: 1rem;">
                <a href="{{ route('pacientes.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
