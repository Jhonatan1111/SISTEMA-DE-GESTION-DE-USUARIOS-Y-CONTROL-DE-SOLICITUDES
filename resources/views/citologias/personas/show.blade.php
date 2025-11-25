<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-extrabold text-blue-700">Detalle de Citología Persona</h1>
            </div>
            <a href="{{ route('citologias.personas.index') }}" class="text-gray-600 hover:text-gray-900">
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
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Número de Citología</label>
                    <p class="text-lg font-bold text-blue-700">{{ $citologia->ncitologia }}</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha Recibida</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $citologia->fecha_recibida->format('d/m/Y') }}</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md border-l-1">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Estado</label>
                    <p class="text-lg">
                        @if($citologia->estado)
                        <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Activo
                        </span>
                        @else
                        <span class="inline-flex items-center bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-semibold">
                            Inactivo
                        </span>
                        @endif
                    </p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1 ">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Tipo de Citología</label>
                    <p class="text-lg">
                        @if($citologia->tipo == 'liquida')
                        <span class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Líquida
                        </span>
                        @elseif($citologia->tipo == 'especial')
                        <span class="inline-flex items-center bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Especial
                        </span>
                        @else
                        <span class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Normal
                        </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Información del Paciente -->
        <div class="bg-gradient-to-r from-green-50 via-white to-green-50 rounded-2xl shadow-xl p-6 mb-6 border border-green-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">
                Información del Paciente
            </h2>

            @if($citologia->paciente)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nombre Completo</label>
                    <p class="text-lg font-bold text-gray-900">
                        {{ $citologia->paciente->nombre }} {{ $citologia->paciente->apellido }}
                    </p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">DUI</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $citologia->paciente->dui }}</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Edad</label>
                    {{ $citologia->paciente->fecha_nacimiento ? $citologia->paciente->fecha_nacimiento->age . ' años' : 'N/A' }}
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Sexo</label>
                    <p class="text-lg font-semibold text-gray-900">
                        @if(strtoupper($citologia->paciente->sexo) == 'M' || strtolower($citologia->paciente->sexo) == 'masculino')
                        <span class="text-blue-600">Masculino</span>
                        @elseif(strtoupper($citologia->paciente->sexo) == 'F' || strtolower($citologia->paciente->sexo) == 'femenino')
                        <span class="text-pink-600">Femenino</span>
                        @else
                        <span class="text-gray-600">{{ $citologia->paciente->sexo }}</span>
                        @endif
                    </p>
                </div>

                @if($citologia->paciente->correo)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Correo</label>
                    <p class="text-lg font-semibold text-blue-600 break-all">{{ $citologia->paciente->correo }}</p>
                </div>
                @endif

                @if($citologia->paciente->celular)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Teléfono</label>
                    <p class="text-lg font-semibold text-gray-900">{{ substr($citologia->paciente->celular, 0, 4) . '-' . substr($citologia->paciente->celular, 4, 4) }}</p>
                </div>
                @endif
            </div>
            @else
            <div class="bg-white p-4 rounded-lg shadow-md text-center">
                <p class="text-gray-500">Sin paciente asignado</p>
            </div>
            @endif
        </div>

        <!-- Información del Doctor/Remitente -->
        <div class="bg-gradient-to-r from-indigo-50 via-white to-indigo-50 rounded-2xl shadow-xl p-6 mb-6 border border-indigo-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="text-xl font-bold text-indigo-700 mb-4 border-b-2 border-indigo-200 pb-2">
                Información del Doctor/Remitente
            </h2>

            @if($citologia->doctor)
            <div class="grid grid-cols-2 md:grid-cols-2 gap-8">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-">Nombre del Doctor</label>
                    <p class="text-lg font-bold text-gray-900">
                        Dr. {{ $citologia->doctor->nombre }} {{ $citologia->doctor->apellido }}
                    </p>
                </div>

                @if($citologia->doctor->correo)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Correo</label>
                    <p class="text-lg font-semibold text-blue-600 break-all">{{ $citologia->doctor->correo }}</p>
                </div>
                @endif

                @if($citologia->doctor->celular)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Celular</label>
                    <p class="text-lg font-semibold text-gray-900">{{ substr($citologia->doctor->celular, 0, 4) . '-' . substr($citologia->doctor->celular, 4, 4) }}</p>
                </div>
                @endif
            </div>
            @elseif($citologia->remitente_especial)
            <div class="grid grid-cols-2 md:grid-cols-2 gap-8">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nombre del Remitente</label>
                    <p class="text-lg font-bold text-gray-900">
                        {{ $citologia->remitente_especial }}
                    </p>
                </div>
                @if($citologia->celular_remitente_especial)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Celular del Remitente</label>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ substr($citologia->celular_remitente_especial, 0, 4) . '-' . substr($citologia->celular_remitente_especial, 4, 4) }}
                    </p>
                </div>
                @endif
            </div>
            @else
            <div class="bg-white p-4 rounded-lg shadow-md text-center">
                <p class="text-gray-500">Sin remitente asignado</p>
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
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1 ">
                    <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $citologia->diagnostico_clinico }}</p>
                </div>
            </div>

            @if($citologia->descripcion)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Descripción General</label>
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1 ">
                    <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $citologia->descripcion }}</p>
                </div>
            </div>
            @endif



            @if($citologia->diagnostico)
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Diagnóstico Final</label>
                <div class="bg-white p-4 rounded-lg shadow-md border-l-1 ">
                    <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $citologia->diagnostico }}</p>
                </div>
            </div>
            @endif
        </div>



        <!-- Metadatos -->
        <div class="bg-gradient-to-r from-gray-50 via-white to-gray-50 rounded-2xl shadow-xl p-6 mb-8 border border-gray-200">
            <h2 class="text-xl font-bold text-gray-700 mb-4 border-b-2 border-gray-200 pb-2">
                Información del Sistema
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha de Registro</label>
                    <p class="text-lg text-gray-900">
                        {{ $citologia->created_at->format('d/m/Y H:i:s') }}
                    </p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Última Actualización</label>
                    <p class="text-lg text-gray-900">
                        {{ $citologia->updated_at->format('d/m/Y H:i:s') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg rounded-lg mt-8">
            <a href="{{ route('citologias.personas.index') }}"
                class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                Volver
            </a>
            <a href="{{ route('citologias.personas.imprimir', $citologia->ncitologia) }}"
                class="px-6 py-2 bg-orange-700 hover:bg-orange-800 text-white rounded-lg font-semibold transition-transform hover:scale-105" target="_blank">
                Imprimir
            </a>
            @if (auth()->user()->role === 'admin')
            <a href="{{ route('citologias.personas.edit', $citologia->ncitologia) }}"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                Editar Citología
            </a>
            @endif
        </div>
    </div>
</x-app-layout>