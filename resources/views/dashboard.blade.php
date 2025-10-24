<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
                Bienvenido al Panel del Sistema
            </h1>
        </div>

        <!-- Cards Container -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Gestión de Usuarios -->
            <a href="{{ route('admin.usuarios.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8 flex justify-center">
                        <img src="/image/usuarios.png" alt="Usuarios" class="w-16 h-16 mb-2">
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                            Gestión de Usuarios
                        </h2>
                        <p class="text-gray-600 leading-relaxed">
                            Administra los usuarios registrados en el sistema.
                        </p>
                        <div class="mt-4 flex items-center text-blue-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                            Ir a usuarios →
                        </div>
                    </div>
                </div>
            </a>

            <!-- Gestión de Doctores -->
            <a href="{{ route('doctores.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 flex justify-center">
                        <img src="/image/doctores.png" alt="Doctores" class="w-16 h-16 mb-2">
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                            Gestión de Doctores
                        </h2>
                        <p class="text-gray-600 leading-relaxed">
                            Administra los doctores registrados en el sistema.
                        </p>
                        <div class="mt-4 flex items-center text-green-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                            Ir a doctores →
                        </div>
                    </div>
                </div>
            </a>

            <!-- Gestión de Pacientes -->
            <a href="{{ route('pacientes.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-8 flex justify-center">
                        <img src="/image/pacientes.png" alt="Pacientes" class="w-16 h-16 mb-2">
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">
                            Gestión de Pacientes
                        </h2>
                        <p class="text-gray-600 leading-relaxed">
                            Administra la información de los pacientes, personas y mascotas.
                        </p>
                        <div class="mt-4 flex items-center text-purple-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                            Ir a pacientes →
                        </div>
                    </div>
                </div>
            </a>

            <!-- Gestión de Biopsias -->
            <a href="{{ route('biopsias.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-8 flex justify-center">
                        <img src="/image/biopsia.png" alt="Biopsias" class="w-16 h-16 mb-2">
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-600 transition-colors">
                            Gestión de Biopsias
                        </h2>
                        <p class="text-gray-600 leading-relaxed">
                            Administra las biopsias generadas de personas y mascotas.
                        </p>
                        <div class="mt-4 flex items-center text-red-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                            Ir a biopsias →
                        </div>
                    </div>
                </div>
            </a>

             <!-- Gestión de Citologías -->
            <a href="{{ route('citologias.personas.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-8 flex justify-center">
                        <img src="/image/normal.png" alt="Biopsias" class="w-16 h-16 mb-2">
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors">
                            Gestión de Citologías
                        </h2>
                        <p class="text-gray-600 leading-relaxed">
                            Administra las citologías normales, líquidas y especiales generadas.
                        </p>
                        <div class="mt-4 flex items-center text-pink-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                            Ir a Citologías →
                        </div>
                    </div>
                </div>
            </a>

            <!-- Gestión de Listas -->
            <a href="{{ route('listas.biopsias.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-8 flex justify-center">
                        <img src="/image/lista.png" alt="Listas de Biopsias" class="w-16 h-16 mb-2">
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">
                            Gestión de Listas
                        </h2>
                        <p class="text-gray-600 leading-relaxed">
                            Muestra detalladamente las plantillas de resultados de biopsias y citologías.
                        </p>
                        <div class="mt-4 flex items-center text-amber-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                            Ver listas →
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
