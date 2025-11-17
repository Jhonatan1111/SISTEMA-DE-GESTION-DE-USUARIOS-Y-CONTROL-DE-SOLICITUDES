<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Centro de Ayuda</h1>
            <p class="text-gray-600">Videos de apoyo para funciones del sistema</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 p-8">
                @if (auth()->user()->role == 'admin')

                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="group" target="_blank">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A2 2 0 0121 14.092v.816a2 2 0 01-1.447 1.916L15 19V10zM4 6a2 2 0 012-2h7a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Registro de usuarios</h2>
                            <div class="mt-4 flex items-center text-blue-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver en YouTube →</div>
                        </div>
                    </div>
                </a>
                @endif

                <a href="https://www.youtube.com/watch?v=aqz-KE-bpKQ" class="group" target="_blank">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A2 2 0 0121 14.092v.816a2 2 0 01-1.447 1.916L15 19V10zM4 6a2 2 0 012-2h7a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">Gestión de doctores</h2>
                            <div class="mt-4 flex items-center text-green-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver en YouTube →</div>
                        </div>
                    </div>
                </a>
                <a href="https://www.youtube.com/watch?v=9bZkp7q19f0" class="group" target="_blank">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A2 2 0 0121 14.092v.816a2 2 0 01-1.447 1.916L15 19V10zM4 6a2 2 0 012-2h7a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">Módulo de Pacientes Personas</h2>
                            <div class="mt-4 flex items-center text-purple-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver en YouTube →</div>
                        </div>
                    </div>
                </a>
                <a href="https://www.youtube.com/watch?v=9bZkp7q19f0" class="group" target="_blank">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-blue-500 to-teal-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A2 2 0 0121 14.092v.816a2 2 0 01-1.447 1.916L15 19V10zM4 6a2 2 0 012-2h7a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">Módulo de Pacientes Mascotas</h2>
                            <div class="mt-4 flex items-center from-blue-500 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver en YouTube →</div>
                        </div>
                    </div>
                </a>
                <a href="https://www.youtube.com/watch?v=9bZkp7q19f0" class="group" target="_blank">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A2 2 0 0121 14.092v.816a2 2 0 01-1.447 1.916L15 19V10zM4 6a2 2 0 012-2h7a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-600 transition-colors">Módulo de biopsias</h2>
                            <div class="mt-4 flex items-center text-red-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver en YouTube →</div>
                        </div>
                    </div>
                </a>

                <a href="https://www.youtube.com/watch?v=3JZ_D3ELwOQ" class="group" target="_blank">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A2 2 0 0121 14.092v.816a2 2 0 01-1.447 1.916L15 19V10zM4 6a2 2 0 012-2h7a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors">Módulo de citologías</h2>
                            <div class="mt-4 flex items-center text-pink-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver en YouTube →</div>
                        </div>
                    </div>
                </a>
                <a href="https://www.youtube.com/watch?v=3JZ_D3ELwOQ" class="group" target="_blank">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A2 2 0 0121 14.092v.816a2 2 0 01-1.447 1.916L15 19V10zM4 6a2 2 0 012-2h7a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Módulo de Listas</h2>
                            <div class="mt-4 flex items-center text-amber-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver en YouTube →</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>