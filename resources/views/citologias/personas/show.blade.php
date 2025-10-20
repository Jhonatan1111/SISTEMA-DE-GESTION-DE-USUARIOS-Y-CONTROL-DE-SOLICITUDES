<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detalles de Citología</h1>
                <p class="text-gray-600 mt-1">Información completa de la citología {{ $citologia->ncitologia }}</p>
            </div>
            <a href="{{ route('citologias.personas.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-5 rounded-lg">
                ← Volver
            </a>
        </div>

        <!-- Información Básica -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">
                📋 Información Básica
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-600">Número de Citología</label>
                    <p class="text-lg font-bold text-gray-900">{{ $citologia->ncitologia }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600">Tipo de Citología</label>
                    <p class="text-lg">
                        @if($citologia->tipo == 'liquida')
                        <span class="inline-flex items-center bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-semibold">
                            💧 Citología Líquida
                        </span>
                        @else
                        <span class="inline-flex items-center bg-gray-100 text-gray-800 px-4 py-2 rounded-full text-sm font-semibold">
                            📄 Citología Normal
                        </span>
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600">Fecha Recibida</label>
                    <p class="text-lg text-gray-900">{{ $citologia->fecha_recibida->format('d/m/Y') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600">Estado</label>
                    <p class="text-lg">
                        @if($citologia->estado)
                        <span class="inline-flex items-center bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                            ✓ Activa
                        </span>
                        @else
                        <span class="inline-flex items-center bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-sm font-semibold">
                            📁 Archivada
                        </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Información del Paciente -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">
                👤 Información del Paciente
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-600">Nombre Completo</label>
                    <p class="text-lg font-bold text-gray-900">
                        {{ $citologia->paciente->nombre }} {{ $citologia->paciente->apellido }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600">DUI</label>
                    <p class="text-lg text-gray-900">{{ $citologia->paciente->DUI }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600">Edad</label>
                    <p class="text-lg text-gray-900">{{ $citologia->paciente->edad }} años</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600">Sexo</label>
                    <p class="text-lg text-gray-900">{{ $citologia->paciente->sexo }}</p>
                </div>
            </div>
        </div>

        <!-- Información del Doctor -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-indigo-700 mb-4 border-b-2 border-indigo-200 pb-2">
                👨‍⚕️ Remitente Responsable
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-600">Nombre del Remitente</label>

                    <p class="text-lg font-bold text-gray-900">
                        @if ($citologia->remitente_especial)
                        {{ $citologia->remitente_especial }}
                        @else
                        {{ $citologia->doctor->nombre.' '.$citologia->doctor->apellido }}
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600">Celular</label>
                    <p class="text-lg text-gray-900">@if ($citologia->remitente_especial)
                        {{ $citologia->celular_remitente_especial }}
                        @else
                        {{ $citologia->doctor->celular }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Diagnóstico Clínico -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-red-700 mb-4 border-b-2 border-red-200 pb-2">
                🩺 Diagnóstico Clínico
            </h2>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $citologia->diagnostico_clinico }}</p>
            </div>
        </div>

        <!-- Resultados -->
        @if($citologia->diagnostico || $citologia->macroscopico || $citologia->microscopico)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-purple-700 mb-4 border-b-2 border-purple-200 pb-2">
                📝 Resultados de Análisis
            </h2>

            @if($citologia->diagnostico)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Diagnóstico Final</label>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $citologia->diagnostico }}</p>
                </div>
            </div>
            @endif

            @if($citologia->macroscopico)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Análisis Macroscópico</label>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $citologia->macroscopico }}</p>
                </div>
            </div>
            @endif

            @if($citologia->microscopico)
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Análisis Microscópico</label>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $citologia->microscopico }}</p>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Botones de Acción -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('citologias.personas.edit', $citologia->ncitologia) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg">
                ✏️ Editar
            </a>
            <a href="{{ route('citologias.personas.imprimir', $citologia->ncitologia) }}"
                class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-5 rounded-lg"
                target="_blank">
                🖨️ Imprimir
            </a>
        </div>
    </div>
</x-app-layout>