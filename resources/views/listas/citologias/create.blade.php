<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Nueva Lista de Citología') }}
        </h2>
    </x-slot>

    <div class="form-container">
        @if (session('error'))
        <div class="alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('listas.citologias.store') }}" method="POST">
            @csrf 

            <div class="input-group">
                <label for="codigo">Código *</label>
                <input type="text"
                    name="codigo"
                    id="codigo"
                    value="{{ old('codigo', $codigoGenerado ?? '') }}"
                    class="uppercase font-bold"
                    placeholder="Código de la citología"
                    required>
                <p class="text-gray-600 text-sm mt-1">
                    Sugerido: <strong class="text-green-700">{{ $codigoGenerado ?? 'C001' }}</strong>
                </p>
                @error('codigo')
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
                <label for="macroscopico">Macroscópico</label>
                <textarea name="macroscopico" id="macroscopico" rows="4" placeholder="Descripción macroscópica">{{ old('macroscopico') }}</textarea>
                @error('macroscopico')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label for="microscopico">Microscópico</label>
                <textarea name="microscopico" id="microscopico" rows="4" placeholder="Descripción microscópica">{{ old('microscopico') }}</textarea>
                @error('microscopico')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 justify-between">
                <a href="{{ route('listas.citologias.index') }}" class="btn-cancel">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>