<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Crear Nuevo Doctor') }}
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

            <form action="{{ route('doctores.store') }}" method="POST">
                @csrf

                <div>
                    <label for="jvpm">JVPM:</label>
                    <input type="text" id="jvpm" name="jvpm" value="{{ old('jvpm') }}" required maxlength="10">
                </div>

                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="100">
                </div>

                <div>
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required maxlength="100">
                </div>

                <div>
                    <label for="celular">Celular:</label>
                    <input type="text" id="celular" name="celular" value="{{ old('celular') }}" required maxlength="8">
                </div>

                <div>
                    <label for="fax">Fax (Opcional):</label>
                    <input type="text" id="fax" name="fax" value="{{ old('fax') }}" maxlength="11">
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
                    <a href="{{ route('doctores.index') }}">Cancelar</a>
                    <button type="submit">Guardar Doctor</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>