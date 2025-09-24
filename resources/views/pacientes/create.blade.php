<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Crear Nuevo Paciente') }}
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

            <form action="{{ route('pacientes.store') }}" method="POST">
                @csrf

                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="255">
                </div>

                <div>
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required maxlength="255">
                </div>

                <div>
                    <label for="dui">DUI:</label>
                    <input type="text" id="dui" name="dui" value="{{ old('dui') }}" required>
                </div>

                <div>
                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad" value="{{ old('edad') }}" required>
                </div>

                <div>
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo" required>
                        <option value="">Seleccionar...</option>
                        <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>

                <div>
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
                </div>

                <div>
                    <label for="estado_civil">Estado Civil:</label>
                    <input type="text" id="estado_civil" name="estado_civil" value="{{ old('estado_civil') }}">
                </div>

                <div>
                    <label for="ocupacion">Ocupación:</label>
                    <input type="text" id="ocupacion" name="ocupacion" value="{{ old('ocupacion') }}">
                </div>

                <div>
                    <label for="celular">Celular:</label>
                    <input type="text" id="celular" name="celular" value="{{ old('celular') }}" required maxlength="8">
                </div>

                <div>
                    <label for="correo">Correo (Opcional):</label>
                    <input type="email" id="correo" name="correo" value="{{ old('correo') }}" maxlength="255">
                </div>

                <div>
                    <label for="direccion">Dirección (Opcional):</label>
                    <textarea id="direccion" name="direccion" rows="3" maxlength="500">{{ old('direccion') }}</textarea>
                </div>

                <div>
                    <a href="{{ route('pacientes.index') }}">Cancelar</a>
                    <button type="submit">Guardar Paciente</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>