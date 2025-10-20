<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Navegación separada. -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-blue-300 p-1 rounded-lg">
                <a href="{{ route('citologias.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Citologías
                </a>
                <a href="{{ route('citologias.personas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Personas
                </a>


            </nav>
        </div>

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Índice General de Citologías</h1>
            <p class="text-gray-600 mt-1">Vista completa de todas las citologías del sistema</p>
        </div>

        <!-- Tarjetas de Estadísticas -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-4 mb-6">
            <!-- Total -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 text-white">
                <div class="text-2xl font-bold">{{ $estadisticas['total'] }}</div>
                <div class="text-sm opacity-90">Total Activas</div>
            </div>

            <!-- Personas -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-4 text-white">
                <div class="text-2xl font-bold">{{ $estadisticas['personas'] }}</div>
                <div class="text-sm opacity-90">Personas</div>
            </div>

            <!-- Mascotas -->
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-4 text-white">
                <div class="text-2xl font-bold">{{ $estadisticas['mascotas'] }}</div>
                <div class="text-sm opacity-90">Mascotas</div>
            </div>

            <!-- Normales -->
            <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-lg shadow-lg p-4 text-white">
                <div class="text-2xl font-bold">{{ $estadisticas['normales'] }}</div>
                <div class="text-sm opacity-90">📄 Normales</div>
            </div>

            <!-- Líquidas -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-4 text-white">
                <div class="text-2xl font-bold">{{ $estadisticas['liquidas'] }}</div>
                <div class="text-sm opacity-90">💧 Líquidas</div>
            </div>

            <!-- Especiales -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-4 text-white">
                <div class="text-2xl font-bold">{{ $estadisticas['especiales'] }}</div>
                <div class="text-sm opacity-90">⭐ Especiales</div>
            </div>

            <!-- Archivadas -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-4 text-white">
                <div class="text-2xl font-bold">{{ $estadisticas['archivadas'] }}</div>
                <div class="text-sm opacity-90">Archivadas</div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">🔍 Filtros</h3>

            <form method="GET" action="{{ route('citologias.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Búsqueda -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Buscar
                    </label>
                    <input type="text"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Número, paciente, doctor..."
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                </div>



                <!-- Tipo (Normal/Líquida/Especial) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Tipo
                    </label>
                    <select name="tipo"
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        <option value="">Todos los tipos</option>
                        <option value="normal" {{ request('tipo') == 'normal' ? 'selected' : '' }}>📄 Normal</option>
                        <option value="liquida" {{ request('tipo') == 'liquida' ? 'selected' : '' }}>💧 Líquida</option>
                        <option value="especial" {{ request('tipo') == 'especial' ? 'selected' : '' }}>⭐ Especial</option>
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Estado
                    </label>
                    <select name="estado"
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        <option value="">Todos los estados</option>
                        <option value="activas" {{ request('estado') == 'activas' ? 'selected' : '' }}>Activas</option>
                        <option value="archivadas" {{ request('estado') == 'archivadas' ? 'selected' : '' }}>Archivadas</option>
                    </select>
                </div>

                <!-- Botones -->
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                        Aplicar Filtros
                    </button>
                    <a href="{{ route('citologias.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Mensajes -->
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tabla -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold">N° Citología</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Tipo</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Paciente/Mascota</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Doctor</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Fecha</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Estado</th>
                            <th class="px-6 py-4 text-center text-sm font-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($citologias as $citologia)
                        <tr class="hover:bg-blue-50 transition-colors duration-200">
                            <!-- Número -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $citologia->ncitologia }}
                                </span>
                            </td>

                            <!-- Tipo -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($citologia->tipo == 'liquida')
                                <span class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    💧 Líquida
                                </span>
                                @elseif($citologia->tipo == 'especial')
                                <span class="inline-flex items-center bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    ⭐ Especial
                                </span>
                                @else
                                <span class="inline-flex items-center bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    📄 Normal
                                </span>
                                @endif
                            </td>



                            <!-- Paciente/Mascota -->
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    @if($citologia->paciente_id)
                                    <div class="font-semibold text-gray-900">
                                        {{ $citologia->paciente->nombre }} {{ $citologia->paciente->apellido }}
                                    </div>
                                    <div class="text-gray-500 text-xs">
                                        {{ $citologia->paciente->DUI }}
                                    </div>
                                    @else
                                    <div class="font-semibold text-gray-900">
                                        {{ $citologia->mascota->nombre }}
                                    </div>
                                    <div class="text-gray-500 text-xs">
                                        {{ $citologia->mascota->propietario }}
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Doctor -->
                            <td class="px-6 py-4">
                                <span class="text-gray-700">
                                    @if ($citologia->remitente_especial)
                                    {{ $citologia->remitente_especial }}
                                    @else
                                    {{ $citologia->doctor->nombre.' '.$citologia->doctor->apellido }}
                                    @endif </span>
                            </td>

                            <!-- Fecha -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-gray-600 text-sm">
                                    {{ $citologia->fecha_recibida->format('d/m/Y') }}
                                </span>
                            </td>

                            <!-- Estado -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($citologia->estado)
                                <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    ✓ Activa
                                </span>
                                @else
                                <span class="inline-flex items-center bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">
                                    📁 Archivada
                                </span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center space-x-2">
                                    @if($citologia->paciente_id)
                                    <a href="{{ route('citologias.personas.show', $citologia->ncitologia) }}"
                                        class="text-blue-600 hover:text-blue-900 font-semibold text-lg"
                                        title="Ver detalles">
                                        👁️
                                    </a>
                                    @else
                                    <a href="{{ route('citologias.show', $citologia->ncitologia) }}"
                                        class="text-blue-600 hover:text-blue-900 font-semibold text-lg"
                                        title="Ver detalles">
                                        👁️
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="text-6xl">🔬</span>
                                    <p class="text-gray-500 text-lg">No se encontraron citologías</p>
                                    @if(request()->anyFilled(['buscar', 'tipo', 'estado']))
                                    <a href="{{ route('citologias.index') }}"
                                        class="text-blue-600 hover:text-blue-800 font-semibold mt-2">
                                        Limpiar filtros →
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if ($citologias->hasPages())
        <div class="mt-6">
            {{ $citologias->appends(request()->query())->links() }}
        </div>
        @endif

        <!-- Información adicional -->
        <div class="mt-6 text-center text-gray-500 text-sm">
            Mostrando {{ $citologias->firstItem() }} - {{ $citologias->lastItem() }} de {{ $citologias->total() }} citologías
        </div>
    </div>
</x-app-layout>