<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Editar Mascota') }}
            </h2>
        </div>
    </x-slot>

    <div>
        <div>
            <!-- Mensajes de error -->
            @if ($errors->any())
            <div>
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

                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $mascota->nombre) }}" required maxlength="255">
                </div>

                <div>
                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad" value="{{ old('edad', $mascota->edad) }}" required>
                </div>

                <div>
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo" required>
                        <option value="">Seleccionar...</option>
                        <option value="macho" {{ old('sexo', $mascota->sexo) == 'macho' ? 'selected' : '' }}>Macho</option>
                        <option value="hembra" {{ old('sexo', $mascota->sexo) == 'hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                </div>

                <div>
                    <label for="especie">Especie:</label>
                    <input type="text" id="especie" name="especie" value="{{ old('especie', $mascota->especie) }}" required maxlength="255">
                </div>

                <div>
                    <label for="raza">Raza:</label>
                    <input type="text" id="raza" name="raza" value="{{ old('raza', $mascota->raza) }}" required maxlength="255">
                </div>

                <div>
                    <label for="propietario">Propietario:</label>
                    <input type="text" id="propietario" name="propietario" value="{{ old('propietario', $mascota->propietario) }}" required maxlength="255">
                </div>
                <div>
                    <label for="correo">Correo (Opcional):</label>
                    <input type="email" id="correo" name="correo" value="{{ old('correo', $mascota->correo) }}" maxlength="255">
                </div>

                <div>
                    <label for="celular">Celular:</label>
                    <input type="text" id="celular" name="celular" value="{{ old('celular', $mascota->celular) }}" required maxlength="8">
                </div>


                <div>
                    <a href="{{ route('mascotas.index') }}">Cancelar</a>
                    <button type="submit">Actualizar Mascota</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>