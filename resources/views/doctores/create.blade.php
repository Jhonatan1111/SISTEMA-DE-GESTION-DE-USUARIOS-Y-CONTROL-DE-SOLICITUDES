<x-app-layout>
    <x-slot name="header">
        <div class="header-container">
            <h2 class="titulo">
                {{ __('Crear Nuevo Doctor') }}
            </h2>
        </div>
    </x-slot>

    <style>
        body {
            background-color: #f0f8ff;
        }

        .header-container {
            display: flex;
            justify-content: center;
        }

        .titulo {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }

        .form-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .form-card {
            background: white;
            width: 100%;
            max-width: 500px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .formulario {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .campo {
            display: flex;
            flex-direction: column;
        }

        .campo label {
            font-size: 14px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 5px;
        }

        .campo input,
        .campo textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .campo input:focus,
        .campo textarea:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert.error {
            background: #e74c3c;
            color: white;
        }

        .alert ul {
            margin-left: 20px;
        }

        .botones {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn.cancelar {
            background: #7f8c8d;
            color: white;
        }

        .btn.cancelar:hover {
            background: #636e72;
        }

        .btn.guardar {
            background: #3498db;
            color: white;
        }

        .btn.guardar:hover {
            background: #2980b9;
        }
    </style>

    <div class="form-container">
        <div class="form-card">

            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="alert error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('doctores.store') }}" method="POST" class="formulario">
                @csrf

                <div class="campo">
                    <label for="jvpm">JVPM</label>
                    <input type="text" id="jvpm" name="jvpm" value="{{ old('jvpm') }}" required maxlength="10">
                </div>

                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="100">
                </div>

                <div class="campo">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required maxlength="100">
                </div>

                <div class="campo">
                    <label for="celular">Celular</label>
                    <input type="text" id="celular" name="celular" value="{{ old('celular') }}" required maxlength="8">
                </div>

                <div class="campo">
                    <label for="fax">Fax (Opcional)</label>
                    <input type="text" id="fax" name="fax" value="{{ old('fax') }}" maxlength="11">
                </div>

                <div class="campo">
                    <label for="correo">Correo (Opcional)</label>
                    <input type="email" id="correo" name="correo" value="{{ old('correo') }}" maxlength="255">
                </div>

                <div class="campo">
                    <label for="direccion">Dirección (Opcional)</label>
                    <textarea id="direccion" name="direccion" rows="3" maxlength="500">{{ old('direccion') }}</textarea>
                </div>

                <!-- Botones -->
                <div class="botones">
                    <a href="{{ route('doctores.index') }}" class="btn cancelar">Cancelar</a>
                    <button type="submit" class="btn guardar">Guardar Doctor</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
