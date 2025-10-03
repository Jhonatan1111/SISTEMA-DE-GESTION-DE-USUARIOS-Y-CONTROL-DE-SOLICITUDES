<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Editar Doctor') }}
        </h2>
    </x-slot>

    <div class="form-container">
        <!-- Errores -->
        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctores.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="jvpm" name="jvpm" 
                        value="{{ old('jvpm', $doctor->jvpm) }}" 
                        placeholder="JVPM" maxlength="10" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="celular" name="celular" 
                        value="{{ old('celular', $doctor->celular) }}" 
                        placeholder="Celular" maxlength="8" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="nombre" name="nombre" 
                        value="{{ old('nombre', $doctor->nombre) }}" 
                        placeholder="Nombre" maxlength="255" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="apellido" name="apellido" 
                        value="{{ old('apellido', $doctor->apellido) }}" 
                        placeholder="Apellido" maxlength="255" required>
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" id="direccion" name="direccion" 
                    value="{{ old('direccion', $doctor->direccion) }}" 
                    placeholder="Dirección" maxlength="500">
            </div>

            <div class="input-group">
                <i class="fas fa-fax"></i>
                <input type="text" id="fax" name="fax" 
                    value="{{ old('fax', $doctor->fax) }}" 
                    placeholder="Fax (Opcional)" maxlength="11">
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="correo" name="correo" 
                    value="{{ old('correo', $doctor->correo) }}" 
                    placeholder="Correo (Opcional)" maxlength="255">
            </div>

            <div class="input-group">
                <i class="fas fa-toggle-on"></i>
                <select id="estado_servicio" name="estado_servicio" required>
                    <option value="1" {{ old('estado_servicio', $doctor->estado_servicio) == 1 ? 'selected' : '' }}>
                        Activo
                    </option>
                    <option value="0" {{ old('estado_servicio', $doctor->estado_servicio) == 0 ? 'selected' : '' }}>
                        Inactivo
                    </option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('doctores.index') }}" class="btn-cancel">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    Actualizar Doctor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
