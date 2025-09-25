<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Crear Nueva Biopsia') }}
            </h2>
        </div>
    </x-slot>

    <div></div>
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

            <form action="{{ route('biopsias.store') }}" method="POST">
                @csrf

                <div>
                    <label for="nbiopsia">N° Biopsia:</label>
                    <input type="text" id="nbiopsia" name="nbiopsia" value="{{ old('nbiopsia') }}" required maxlength="15" placeholder="Ej: BIO-2024-001">
                </div>

                <div>
                    <label for="diagnostico_clinico">Diagnóstico Clínico:</label>
                    <textarea id="diagnostico_clinico" name="diagnostico_clinico" required maxlength="500" rows="4" placeholder="Describa el diagnóstico clínico...">{{ old('diagnostico_clinico') }}</textarea>
                </div>

                <div>
                    <label for="fecha_recibida">Fecha Recibida:</label>
                    <input type="date" id="fecha_recibida" name="fecha_recibida" value="{{ old('fecha_recibida') }}" required>
                </div>

                <div>
                    <label for="doctor_id">Doctor (Opcional):</label>
                    <select id="doctor_id" name="doctor_id">
                        <option value="">Seleccionar doctor...</option>
                        @foreach($doctores as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->nombre }} {{ $doctor->apellido }} - {{ $doctor->especialidad }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="paciente_id">Paciente (Opcional):</label>
                    <select id="paciente_id" name="paciente_id">
                        <option value="">Seleccionar paciente...</option>
                        @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                            {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->dui }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="mascota_id">Mascota (Opcional):</label>
                    <select id="mascota_id" name="mascota_id">
                        <option value="">Seleccionar mascota...</option>
                        @foreach($mascotas as $mascota)
                        <option value="{{ $mascota->id }}" {{ old('mascota_id') == $mascota->id ? 'selected' : '' }}>
                            {{ $mascota->nombre }} - {{ $mascota->especie }} ({{ $mascota->raza }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-top: 20px;">
                    <p><strong>Nota:</strong> Debe seleccionar al menos un doctor, paciente o mascota.</p>
                </div>

                <div>
                    <a href="{{ route('biopsias.index') }}">Cancelar</a>
                    <button type="submit">Crear Biopsia</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>