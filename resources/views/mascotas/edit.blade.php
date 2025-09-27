<x-app-layout>
    <x-slot name="header">
        <h2 class= "titulo">
            {{ __('Editar Mascota') }}
        </h2>
    </x-slot>

    <style>
        body {
            background-color: #f3f4f6; 
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .titulo {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }

        .form-container h2 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #333;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            font-size: 0.95rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #6366f1; 
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
        }

        .btn-cancel {
            background: #e5e7eb;
            color: #111827;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: #d1d5db;
        }

        .btn-submit {
            background: #3b82f6;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #2563eb;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
    </style>

    <div class="form-container">
        <!-- Errores -->
        @if ($errors->any())
            <div class="error-box">
                <ul style="margin-left:15px; list-style:disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mascotas.update', $mascota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $mascota->nombre) }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="edad">Edad</label>
                <input type="number" id="edad" name="edad" value="{{ old('edad', $mascota->edad) }}" required>
            </div>

            <div class="form-group">
                <label for="sexo">Sexo</label>
                <select id="sexo" name="sexo" required>
                    <option value="">Seleccionar...</option>
                    <option value="macho" {{ old('sexo', $mascota->sexo) == 'macho' ? 'selected' : '' }}>Macho</option>
                    <option value="hembra" {{ old('sexo', $mascota->sexo) == 'hembra' ? 'selected' : '' }}>Hembra</option>
                </select>
            </div>

            <div class="form-group">
                <label for="especie">Especie</label>
                <input type="text" id="especie" name="especie" value="{{ old('especie', $mascota->especie) }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="raza">Raza</label>
                <input type="text" id="raza" name="raza" value="{{ old('raza', $mascota->raza) }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="propietario">Propietario</label>
                <input type="text" id="propietario" name="propietario" value="{{ old('propietario', $mascota->propietario) }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="correo">Correo (Opcional)</label>
                <input type="email" id="correo" name="correo" value="{{ old('correo', $mascota->correo) }}" maxlength="255">
            </div>

            <div class="form-group">
                <label for="celular">Celular</label>
                <input type="text" id="celular" name="celular" value="{{ old('celular', $mascota->celular) }}" required maxlength="8">
            </div>

            <div class="form-actions">
                <a href="{{ route('mascotas.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">Actualizar Mascota</button>
            </div>
        </form>
    </div>
</x-app-layout>
