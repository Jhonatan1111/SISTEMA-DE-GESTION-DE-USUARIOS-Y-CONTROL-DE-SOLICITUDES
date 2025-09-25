<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Editar Paciente') }}
            </h2>
        </div>
    </x-slot>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb; /* gris suave */
            margin: 0;
            padding: 0;
        }

        .form-container {
            display: flex;
            justify-content: center;
            padding: 40px 16px;
        }

        .form-card {
            width: 100%;
            max-width: 500px;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 14px;
            color: #374151;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-cancel {
            padding: 10px 16px;
            background: #e5e7eb;
            color: #111827;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-cancel:hover {
            background: #d1d5db;
        }

        .btn-submit {
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        .errors {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            color: #991b1b;
            font-size: 14px;
        }
    </style>

    <div class="form-container">
        <div class="form-card">
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

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $paciente->nombre) }}" required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $paciente->apellido) }}" required>
                </div>

                <div class="form-group">
                    <label for="dui">DUI</label>
                    <input type="text" id="dui" name="dui" value="{{ old('dui', $paciente->dui) }}" required>
                </div>

                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" value="{{ old('edad', $paciente->edad) }}" required>
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo" required>
                        <option value="">Seleccionar...</option>
                        <option value="masculino" {{ old('sexo', $paciente->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('sexo', $paciente->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento) }}">
                </div>

                <div class="form-group">
                    <label for="estado_civil">Estado Civil</label>
                    <input type="text" id="estado_civil" name="estado_civil" value="{{ old('estado_civil', $paciente->estado_civil) }}">
                </div>

                <div class="form-group">
                    <label for="ocupacion">Ocupación</label>
                    <input type="text" id="ocupacion" name="ocupacion" value="{{ old('ocupacion', $paciente->ocupacion) }}">
                </div>

                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="text" id="celular" name="celular" value="{{ old('celular', $paciente->celular) }}" required maxlength="8">
                </div>

                <div class="form-group">
                    <label for="correo">Correo (Opcional)</label>
                    <input type="email" id="correo" name="correo" value="{{ old('correo', $paciente->correo) }}">
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección (Opcional)</label>
                    <textarea id="direccion" name="direccion" rows="3">{{ old('direccion', $paciente->direccion) }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('pacientes.index') }}" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-submit">Actualizar Paciente</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
