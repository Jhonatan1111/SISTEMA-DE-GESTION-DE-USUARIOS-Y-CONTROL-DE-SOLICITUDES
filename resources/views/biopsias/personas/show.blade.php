<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-blue-700">Detalle de Biopsia Persona</h1>
            </div>
            <a href="{{ route('biopsias.personas.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <!-- Información Básica -->
        <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 rounded-2xl shadow-xl p-6 mb-6 border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">
                Información Básica
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Número de Biopsia</label>
                    <p class="text-lg font-bold text-blue-700">{{ $biopsia->nbiopsia }}</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha Recibida</label>
                    <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($biopsia->fecha_recibida)->format('d/m/Y') }}</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Estado</label>
                    <p class="text-lg">
                        @if($biopsia->estado)
                        <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            ✓ Activa
                        </span>
                        @else
                        <span class="inline-flex items-center bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-semibold">
                            Archivada
                        </span>
                        @endif
                    </p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha de Registro</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $biopsia->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Información del Paciente -->
        <div class="bg-gradient-to-r from-green-50 via-white to-green-50 rounded-2xl shadow-xl p-6 mb-6 border border-green-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">
                Información del Paciente
            </h2>
            @if($biopsia->paciente)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nombre Completo</label>
                    <p class="text-lg font-bold text-gray-900">
                        {{ $biopsia->paciente->nombre }} {{ $biopsia->paciente->apellido }}
                    </p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">DUI</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $biopsia->paciente->dui }}</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Edad</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $biopsia->paciente->edad }} años</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Sexo</label>
                    <p class="text-lg font-semibold text-gray-900">
                        @if($biopsia->paciente->sexo === 'M' || strtolower($biopsia->paciente->sexo) == 'masculino')
                        <span class="text-blue-600">Masculino</span>
                        @elseif($biopsia->paciente->sexo === 'F' || strtolower($biopsia->paciente->sexo) == 'femenino')
                        <span class="text-pink-600">Femenino</span>
                        @else
                        <span class="text-gray-600">{{ $biopsia->paciente->sexo }}</span>
                        @endif
                    </p>
                </div>

                @if($biopsia->paciente->correo)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Correo</label>
                    <p class="text-lg font-semibold text-blue-600">{{ $biopsia->paciente->correo }}</p>
                </div>
                @endif

                @if($biopsia->paciente->celular)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Teléfono</label>
                    <p class="text-lg font-semibold text-gray-900">{{ substr($biopsia->paciente->celular, 0, 4) . '-' . substr($biopsia->paciente->celular, 4, 4) }}</p>
                </div>
                @endif
            </div>
            @else
            <div class="bg-white p-4 rounded-lg shadow-md text-center">
                <p class="text-gray-500">Sin paciente asignado</p>
            </div>
            @endif
        </div>

        <!-- Información del Doctor -->
        <div class="bg-gradient-to-r from-indigo-50 via-white to-indigo-50 rounded-2xl shadow-xl p-6 mb-6 border border-indigo-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="text-xl font-bold text-indigo-700 mb-4 border-b-2 border-indigo-200 pb-2">
                Información del Doctor
            </h2>

            @if($biopsia->doctor)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-">Nombre del Doctor</label>
                    <p class="text-lg font-bold text-gray-900">
                        Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}
                    </p>
                </div>

                @if($biopsia->doctor->correo)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Correo</label>
                    <p class="text-lg font-semibold text-gray-900">
                        <a href="mailto:{{ $biopsia->doctor->correo }}" class="text-blue-600 hover:text-blue-800">{{ $biopsia->doctor->correo }}</a>
                    </p>
                </div>
                @endif

                @if($biopsia->doctor->celular)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Celular</label>
                    <p class="text-lg font-semibold text-gray-900">{{ substr($biopsia->doctor->celular, 0, 4) . '-' . substr($biopsia->doctor->celular, 4, 4) }}</p>
                </div>
                @endif
            </div>
            @else
            <div class="bg-white p-4 rounded-lg shadow-md text-center">
                <p class="text-gray-500">Sin doctor asignado</p>
            </div>
            @endif
        </div>

        <!-- Descripción de la Muestra -->
        <div class="bg-gradient-to-r from-yellow-50 via-white to-yellow-50 rounded-2xl shadow-xl p-6 mb-6 border border-yellow-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="text-xl font-bold text-yellow-700 mb-4 border-b-2 border-yellow-200 pb-2">
                Descripción de la Muestra
            </h2>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Diagnóstico Clínico</label>
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $biopsia->diagnostico_clinico ?? 'Sin diagnóstico registrado' }}</p>
                </div>
            </div>
            @if ($biopsia->macroscopico)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Descripción Macroscópica</label>
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $biopsia->macroscopico ?? 'Sin descripción macroscópica registrada' }}</p>
                </div>
            </div>
            @endif
            @if ($biopsia->microscopico)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Descripción Microscópica</label>
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $biopsia->microscopico ?? 'Sin descripción microscópica registrada' }}</p>
                </div>
            </div>
            @endif
            @if ($biopsia->diagnostico)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Diagnóstico</label>
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $biopsia->diagnostico ?? 'Sin diagnóstico registrado' }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Detalles de la Biopsia fechas-->
        <div class="bg-gradient-to-r from-gray-50 via-white to-gray-50 rounded-2xl shadow-xl p-6 mb-8 border border-gray-200">
            <h2 class="text-xl font-bold text-gray-700 mb-4 border-b-2 border-gray-200 pb-2">
                Información del Sistema
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha de Registro</label>
                    <p class="text-lg text-gray-900">
                        {{ $biopsia->created_at->format('d/m/Y H:i:s') }}
                    </p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Última Actualización</label>
                    <p class="text-lg text-gray-900">
                        {{ $biopsia->updated_at->format('d/m/Y H:i:s') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg rounded-lg mt-8">
            <a href="{{ route('biopsias.personas.index') }}"
                class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                Volver
            </a>
            <a href="{{ route('biopsias.personas.imprimir', $biopsia) }}"
                class="px-6 py-2 bg-orange-700 hover:bg-orange-800 text-white rounded-lg font-semibold transition-transform hover:scale-105" target="_blank">
                Imprimir
            </a>
            <a href="{{ route('biopsias.personas.imprimir', $biopsia) }}"
                class="px-6 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg font-semibold transition-transform hover:scale-105" target="_blank">
                PDF
            </a>
            <a href="{{ route('biopsias.personas.edit', $biopsia) }}"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                Editar Biopsia
            </a>
        </div>
    </div>
</x-app-layout>