<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Nueva Lista de Biopsia') }}
        </h2>
    </x-slot>

    <div class="form-container">
        <form action="{{ route('listas.biopsias.store') }}" method="POST">
            @csrf 

            <div class="input-group">
                <label for="codigo_generado">Código (Auto-generado)</label>
                <input type="text"
                    id="codigo_generado"
                    value="{{ $codigoGenerado }}"
                    readonly
                    class="uppercase font-bold"
                    placeholder="Código generado automáticamente">
                <p class="text-gray-600 text-sm mt-1">
                    Este código <strong class="text-green-700">{{ $codigoGenerado }}</strong> se asignará automáticamente al guardar
                </p>
            </div>

            <div class="input-group">
                <label for="descripcion">Descripción * (Nombre corto del tipo de biopsia)</label>
                <input type="text"
                    name="descripcion"
                    id="descripcion"
                    value="{{ old('descripcion') }}"
                    placeholder="Descripción corta"
                    required>
                @error('descripcion')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label for="diagnostico">Diagnóstico *</label>
                <textarea name="diagnostico" id="diagnostico" rows="3" placeholder="Diagnóstico detallado" required>{{ old('diagnostico') }}</textarea>
                @error('diagnostico')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label for="macroscopico">Macroscópico *</label>
                <textarea name="macroscopico" id="macroscopico" rows="4" placeholder="Descripción macroscópica" required>{{ old('macroscopico') }}</textarea>
                @error('macroscopico')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label for="microscopico">Microscópico *</label>
                <textarea name="microscopico" id="microscopico" rows="4" placeholder="Descripción microscópica" required>{{ old('microscopico') }}</textarea>
                @error('microscopico')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 justify-between">
    <a href="{{ route('listas.biopsias.index') }}" class="btn-cancel">
        Cancelar
    </a>
    <button type="submit" class="btn-submit">
        Guardar
    </button>
</div>
        </form>
    </div>
</x-app-layout>
