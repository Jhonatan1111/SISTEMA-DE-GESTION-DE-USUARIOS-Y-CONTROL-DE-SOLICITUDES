<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Editar Lista de Biopsia') }}
        </h2>
    </x-slot>

    <div class="form-container">
        <form action="{{ route('listas.biopsias.update', $listaBiopsia->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="input-group">
                <label for="codigo" class="block text-sm font-medium text-gray-700">Código * (Ej: BIO-001, PIEL-01, etc)</label>
                <input type="text"
                    name="codigo"
                    id="codigo"
                    maxlength="20"
                    value="{{ old('codigo', $listaBiopsia->codigo) }}"
                    readonly
                    placeholder=" "
                    class="@error('codigo') input-error @enderror"
                    style="text-transform: uppercase;">
                <i class="fas fa-barcode"></i> {{-- ícono placeholder, cambia según prefieras --}}
                @error('codigo')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción * (Nombre corto del tipo de biopsia)</label>
                <input type="text"
                    name="descripcion"
                    id="descripcion"
                    value="{{ old('descripcion', $listaBiopsia->descripcion) }}"
                    required
                    placeholder=" "
                    class="@error('descripcion') input-error @enderror">
                <i class="fas fa-file-alt"></i>
                @error('descripcion')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico *</label>
                <textarea name="diagnostico" id="diagnostico" rows="3" required placeholder=" " class="@error('diagnostico') input-error @enderror">{{ old('diagnostico', $listaBiopsia->diagnostico) }}</textarea>
                <i class="fas fa-stethoscope"></i>
                @error('diagnostico')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label for="macroscopico" class="block text-sm font-medium text-gray-700">Macroscópico *</label>
                <textarea name="macroscopico" id="macroscopico" rows="4" required placeholder=" " class="@error('macroscopico') input-error @enderror">{{ old('macroscopico', $listaBiopsia->macroscopico) }}</textarea>
                <i class="fas fa-eye"></i>
                @error('macroscopico')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label for="microscopico" class="block text-sm font-medium text-gray-700">Microscópico *</label>
                <textarea name="microscopico" id="microscopico" rows="4" required placeholder=" " class="@error('microscopico') input-error @enderror">{{ old('microscopico', $listaBiopsia->microscopico) }}</textarea>
                <i class="fas fa-microscope"></i>
                @error('microscopico')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('listas.biopsias.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
