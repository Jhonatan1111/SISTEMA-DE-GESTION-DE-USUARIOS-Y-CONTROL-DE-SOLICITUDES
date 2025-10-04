<x-app-layout>
    <x-slot name="header">
        <h2 class="create-title">
            {{ __('Crear Nuevo Doctor') }}
        </h2>
    </x-slot>

    <div class="form-container">

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

        <form action="{{ route('doctores.store') }}" method="POST">
            @csrf

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="jvpm" name="jvpm" 
                        value="{{ old('jvpm') }}" placeholder="JVPM" 
                        maxlength="10" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="celular" name="celular" 
                        value="{{ old('celular') }}" placeholder="Celular"
                        maxlength="8" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="nombre" name="nombre" 
                        value="{{ old('nombre') }}" placeholder="Nombre" 
                        maxlength="100" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="apellido" name="apellido" 
                        value="{{ old('apellido') }}" placeholder="Apellido" 
                        maxlength="100" required>
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-fax"></i>
                <input type="text" id="fax" name="fax" 
                    value="{{ old('fax') }}" placeholder="Fax (Opcional)" 
                    maxlength="11">
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="correo" name="correo" 
                    value="{{ old('correo') }}" placeholder="Correo (Opcional)" 
                    maxlength="255">
            </div>

            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <textarea id="direccion" name="direccion" rows="3" maxlength="500" placeholder="Dirección (Opcional)">{{ old('direccion') }}</textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('doctores.index') }}" class="btn-cancel">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    Guardar Doctor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
