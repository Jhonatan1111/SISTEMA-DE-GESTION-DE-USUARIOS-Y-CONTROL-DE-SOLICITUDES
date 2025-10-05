<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Editar Mascota') }}
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

        <form action="{{ route('mascotas.update', $mascota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-paw"></i>
                    <input type="text" id="nombre" name="nombre"
                        value="{{ old('nombre', $mascota->nombre) }}"
                        placeholder="Nombre de la mascota" maxlength="255" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-birthday-cake"></i>
                    <input type="number" id="edad" name="edad"
                        value="{{ old('edad', $mascota->edad) }}"
                        placeholder="Edad" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-venus-mars"></i>
                    <select id="sexo" name="sexo" required>
                        <option value="">Seleccionar sexo...</option>
                        <option value="macho" {{ old('sexo', $mascota->sexo) == 'macho' ? 'selected' : '' }}>Macho</option>
                        <option value="hembra" {{ old('sexo', $mascota->sexo) == 'hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fas fa-dog"></i>
                    <input type="text" id="especie" name="especie"
                        value="{{ old('especie', $mascota->especie) }}"
                        placeholder="Especie" maxlength="255" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-dna"></i>
                    <input type="text" id="raza" name="raza"
                        value="{{ old('raza', $mascota->raza) }}"
                        placeholder="Raza" maxlength="255" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="propietario" name="propietario"
                        value="{{ old('propietario', $mascota->propietario) }}"
                        placeholder="Propietario" maxlength="255" required>
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="correo" name="correo"
                    value="{{ old('correo', $mascota->correo) }}"
                    placeholder="Correo (Opcional)" maxlength="255">
            </div>

            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" id="celular" name="celular"
                    value="{{ old('celular', $mascota->celular) }}"
                    placeholder="Celular" maxlength="8" required>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('mascotas.index') }}" class="btn-cancel">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    Actualizar Mascota
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
