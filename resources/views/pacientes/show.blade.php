<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">Detalle del Paciente</h1>
            </div>
            <a href="{{ route('pacientes.index') }}" class="text-gray-600 hover:text-gray-900" title="Volver">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200">
                <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">Información Personal</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Nombre</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->nombre }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Apellido</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->apellido }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">DUI</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->dui ?? 'No registrado' }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        @if($paciente->celular)

                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Celular</p>
                        <p class="text-lg font-semibold text-blue-600 break-all">{{ $paciente->celular }}</p>

                        @else
                        <p class="text-lg font-bold text-gray-700">No registrado</p>
                        @endif
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Sexo</p>
                        <p class="text-lg font-bold text-gray-900">{{ ucfirst($paciente->sexo ?? 'No registrado') }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Estado</p>
                        @if($paciente->estado)
                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-800 px-4 py-2 rounded-full text-xs font-bold">Activo</span>
                        @else
                        @endif
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Fecha de Nacimiento</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('d/m/Y') : 'No registrada' }}</p>
                        @if($paciente->fecha_nacimiento)
                        <p class="text-xs text-gray-500">{{ $paciente->fecha_nacimiento->age }} años</p>
                        @endif
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Estado Civil</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->estado_civil ?? 'No registrado' }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Ocupación</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->ocupacion ?? 'No registrada' }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 ">

                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Correo Electrónico</p>
                        <p class="text-lg font-bold text-blue-600 break-all">{{ $paciente->correo ?? 'No registrado' }}</p>

                    </div>

                    <div class="bg-white p-4 rounded-lg border border-gray-200 sm:col-span-2">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Dirección</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->direccion ?? 'No registrada' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-gray-50 via-white to-gray-50 p-6 rounded-2xl shadow-xl border border-gray-200">
                <h2 class="text-xl font-bold text-gray-700 mb-4 border-b-2 border-gray-200 pb-2">Información del Sistema</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Fecha de Creación</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->created_at ? $paciente->created_at->format('d/m/Y') : 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $paciente->created_at ? $paciente->created_at->format('H:i') : '' }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Última Actualización</p>
                        <p class="text-lg font-bold text-gray-900">{{ $paciente->updated_at ? $paciente->updated_at->format('d/m/Y') : 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $paciente->updated_at ? $paciente->updated_at->format('H:i') : '' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('pacientes.index') }}" class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">Volver</a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('pacientes.edit', $paciente) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">Editar</a>
            @endif
        </div>
    </div>
</x-app-layout>