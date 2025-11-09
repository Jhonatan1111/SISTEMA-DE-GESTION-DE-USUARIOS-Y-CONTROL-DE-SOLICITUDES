<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Navegación separada -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-blue-300 p-1 rounded-lg">
                <a href="{{ route('biopsias.index') }}"
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Biopsias
                </a>
                <a href="{{ route('biopsias.personas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Personas
                </a>
                <a href="{{ route('biopsias.mascotas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Mascotas
                </a>
            </nav>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Biopsias Generales</h1>
                <p class="text-gray-600 mt-1">Gestión completa de todas las biopsias del sistema</p>
            </div>
            <a href="{{ route('biopsias.exportar-pdf', request()->all()) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                EXPORTAR PDF
            </a>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Total Biopsias</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Biopsia::count() }}</p>
                    </div>
                    <div class="text-blue-500">
                        <!-- Icono de personas y mascotas -->
                        <img src="/image/pacientes.png" alt="Pacientes" class="w-8 h-8">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Biopsias Activas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Biopsia::where('estado', 1)->count() }}</p>
                    </div>
                    <div class="text-green-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Biopsias Inactivas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Biopsia::where('estado', 0)->count() }}</p>
                    </div>
                    <div class="text-yellow-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Este Mes</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Biopsia::whereMonth('fecha_recibida', now()->month)->count() }}</p>
                    </div>
                    <div class="text-purple-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros y búsqueda (colapsable estilo "Usar Plantilla") -->
        @php
        $filters = ['buscar','categoria','tipo','estado','doctor','fecha_desde','fecha_hasta'];
        $activeCount = collect($filters)->filter(function($f){ return request($f); })->count();
        @endphp
        <div class="sticky top-2 z-10 mb-6">
            <div class="bg-green-50 border border-green-200 rounded-xl shadow-sm overflow-hidden">
                <button type="button" onclick="toggleFiltros()" class="w-full px-4 py-3 flex items-center justify-between hover:bg-green-100 transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Filtros y búsqueda</span>
                    </span>
                    <span class="text-xs text-gray-500 flex items-center gap-2">
                        <svg id="icon-filtros" class="w-5 h-5 transform transition-transform {{ $activeCount ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        {{ $activeCount }} filtro(s) activo(s)
                    </span>
                </button>

                <div id="filtros-content" class="{{ $activeCount ? '' : 'hidden' }} px-4 pb-3">
                    <form method="GET" action="{{ route('biopsias.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 p-4 items-end">
                        <!-- Campo de búsqueda -->
                        <div class="lg:col-span-4 md:col-span-2 col-span-1">
                            <div class="relative">
                                <input type="text"
                                    name="buscar"
                                    id="busqueda-rapida"
                                    value="{{ request('buscar') }}"
                                    placeholder="Buscar por paciente, mascota, doctor o diagnóstico..."
                                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-400">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Filtro por categoría (Persona/Mascota) -->
                        <div class="lg:col-span-2 col-span-1">
                            <label for="categoria" class="block text-sm text-gray-600 mb-1">Categoría</label>
                            <div class="relative">
                                <select name="categoria"
                                    class="w-full pl-3 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-400 text-sm">
                                    <option value="">Todas las categorías</option>
                                    <option value="persona" {{ request('categoria') == 'persona' ? 'selected' : '' }}>Personas</option>
                                    <option value="mascota" {{ request('categoria') == 'mascota' ? 'selected' : '' }}>Mascotas</option>
                                </select>
                            </div>
                        </div>

                        <!-- Filtro por tipo -->
                        <div class="lg:col-span-2 col-span-1">
                            <label for="tipo" class="block text-sm text-gray-600 mb-1">Tipo</label>
                            <div class="relative">
                                <select name="tipo"
                                    class="w-full pl-3 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-400 text-sm">
                                    <option value="">Todos los tipos</option>
                                    <option value="normal" {{ request('tipo') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="liquida" {{ request('tipo') == 'liquida' ? 'selected' : '' }}>Líquida</option>
                                </select>
                            </div>
                        </div>

                        <!-- Filtro por estado -->
                        <div class="lg:col-span-2 col-span-1">
                            <label for="estado" class="block text-sm text-gray-600 mb-1">Estado</label>
                            <div class="relative">
                                <select name="estado"
                                    class="w-full pl-3 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-400 text-sm">
                                    <option value="">Todos los estados</option>
                                    <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activas</option>
                                    <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivas</option>
                                </select>
                            </div>
                        </div>

                        <!-- Filtro por doctor -->
                        <div class="lg:col-span-2 col-span-1">
                            <label for="doctor" class="block text-sm text-gray-600 mb-1">Doctor</label>
                            <div class="relative">
                                <select name="doctor"
                                    class="w-full pl-3 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-400 text-sm">
                                    <option value="">Todos los doctores</option>
                                    @foreach(\App\Models\Doctor::all() as $doctor)
                                    <option value="{{ $doctor->id }}" {{ request('doctor') == $doctor->id ? 'selected' : '' }}>
                                        Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Filtro por fechas -->
                        <div class="lg:col-span-2 col-span-1">
                            <label for="fecha_desde" class="block text-sm text-gray-600 mb-1">Desde</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM6 9a1 1 0 100 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
                                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-400">
                            </div>
                        </div>
                        <div class="lg:col-span-2 col-span-1">
                            <label for="fecha_hasta" class="block text-sm text-gray-600 mb-1">Hasta</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM6 9a1 1 0 100 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-400">
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="lg:col-span-2 md:col-span-2 col-span-1 flex gap-4 items-center mt-1">
                            <button type="submit"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                                Filtrar
                            </button>
                            <a href="{{ route('biopsias.index') }}"
                                class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function toggleFiltros() {
                const content = document.getElementById('filtros-content');
                const icon = document.getElementById('icon-filtros');
                if (!content || !icon) return;
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            }
        </script>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Tabla -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Biopsia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paciente/Mascota</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnóstico</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($biopsias as $biopsia)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-blue-600">{{ $biopsia->nbiopsia }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($biopsia->tipo === 'normal')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <img src="/image/normal.png" alt="Normal" class="w-4 h-4 mr-1">
                                Normal
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <img src="/image/lavado.png" alt="Líquida" class="w-4 h-4 mr-1">
                                Líquida
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($biopsia->fecha_recibida)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($biopsia->paciente_id)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                                Persona
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                                </svg>
                                Mascota
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                @if($biopsia->paciente_id)
                                <div class="font-medium text-gray-900">
                                    {{ $biopsia->paciente->nombre ?? 'N/A' }} {{ $biopsia->paciente->apellido ?? '' }}
                                </div>
                                <div class="text-gray-500">
                                    {{ $biopsia->paciente->edad ?? 'N/A' }} años
                                </div>
                                <div class="text-gray-400 text-xs">
                                    DUI: {{ $biopsia->paciente->dui ?? 'N/A' }}
                                </div>
                                @else
                                <div class="font-medium text-gray-900">
                                    {{ $biopsia->mascota->nombre ?? 'N/A' }}
                                </div>
                                <div class="text-gray-500">
                                    {{ $biopsia->mascota->especie ?? 'N/A' }} - {{ $biopsia->mascota->raza ?? 'N/A' }}
                                </div>
                                <div class="text-gray-400 text-xs">
                                    Dueño: {{ $biopsia->mascota->propietario ?? 'N/A' }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}</div>
                            <div class="text-gray-500">{{ $biopsia->doctor->jvpm ?? 'J.V.P.M N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <textarea
                                class="w-full text-sm bg-transparent border border-gray-200 rounded-md resize-y"
                                rows="3"
                                readonly
                                title="{{ $biopsia->diagnostico_clinico }}">{{ $biopsia->diagnostico_clinico }}</textarea>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($biopsia->estado)
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Activa
                                </span>
                            </div>
                            @else
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-red-400 mr-2"></div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactiva
                                </span>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                            <div class="flex items-center space-x-2">
                                @if($biopsia->paciente_id)
                                <a href="{{ route('biopsias.personas.show', $biopsia->nbiopsia) }}"
                                    class="text-purple-600 hover:text-purple-900">
                                    Ver
                                </a>
                                @else
                                <a href="{{ route('biopsias.mascotas.show', $biopsia->nbiopsia) }}"
                                    class="text-purple-600 hover:text-purple-900">
                                    Ver
                                </a>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay biopsias registradas</h3>
                                <p class="mt-1 text-sm text-gray-500">Las biopsias aparecerán aquí cuando se registren.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($biopsias->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $biopsias->links() }}
        </div>
        @endif
    </div>
    <script>
        document.getElementById('busqueda-rapida').addEventListener('input', function(e) {
            const valor = e.target.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(fila => {
                const texto = fila.textContent.toLowerCase();
                fila.style.display = texto.includes(valor) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>