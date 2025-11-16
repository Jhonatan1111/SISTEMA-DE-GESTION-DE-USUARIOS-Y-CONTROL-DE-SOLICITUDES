<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Créditos del Sistema</h1>
            <p class="text-gray-600">Equipo y roles del proyecto</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="mb-6">
                <p class="text-gray-600 p-6">Equipo de desarrollo</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 p-5">
                <div class="group">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-5 py-5 flex justify-center">
                            @if(file_exists(public_path('image/mario.jpg')))
                            <img src="{{ asset('image/mario.jpg') }}" alt="Mario Rodas" class="h-14 w-14 rounded-full object-cover mb-2 ring-2 ring-white shadow-lg">
                            @else
                            <div class="h-14 w-14 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 text-white flex items-center justify-center text-base font-bold ring-2 ring-white shadow-lg">MR</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h2 class="text-base font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Mario Rodas</h2>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 shadow-sm">Programador</span>
                            <p class="mt-2 text-sm text-gray-600">Información breve del integrante.</p>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-5 py-5 flex justify-center">
                            @if(file_exists(public_path('image/jhonatan.jpg')))
                            <img src="{{ asset('image/jhonatan.jpg') }}" alt="Jhonatan" class="h-14 w-14 rounded-full object-cover mb-2 ring-2 ring-white shadow-lg">
                            @else
                            <div class="h-14 w-14 rounded-full bg-gradient-to-br from-indigo-600 to-sky-600 text-white flex items-center justify-center text-base font-bold ring-2 ring-white shadow-lg">J</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h2 class="text-base font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Jhonatan</h2>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700 shadow-sm">Scrum Master</span>
                            <p class="mt-2 text-sm text-gray-600">Información breve del integrante.</p>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-5 py-5 flex justify-center">
                            @if(file_exists(public_path('image/alvaro.jpg')))
                            <img src="{{ asset('image/alvaro.jpg') }}" alt="Alvaro" class="h-14 w-14 rounded-full object-cover mb-2 ring-2 ring-white shadow-lg">
                            @else
                            <div class="h-14 w-14 rounded-full bg-gradient-to-br from-emerald-600 to-teal-600 text-white flex items-center justify-center text-base font-bold ring-2 ring-white shadow-lg">A</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h2 class="text-base font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Alvaro</h2>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 shadow-sm">Programador</span>
                            <p class="mt-2 text-sm text-gray-600">Información breve del integrante.</p>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-5 flex justify-center">
                            @if(file_exists(public_path('image/raul.jpg')))
                            <img src="{{ asset('image/raul.jpg') }}" alt="Raul" class="h-14 w-14 rounded-full object-cover mb-2 ring-2 ring-white shadow-lg">
                            @else
                            <div class="h-14 w-14 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center text-base font-bold ring-2 ring-white shadow-lg">R</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h2 class="text-base font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Raul</h2>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700 shadow-sm">Secretario</span>
                            <p class="mt-2 text-sm text-gray-600">Información breve del integrante.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mt-8">
            <div class="mb-6">
                <p class="text-gray-600 p-6">Manuales del sistema</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 p-8">
                <a href="{{ asset('utils/form.pdf') }}" class="group">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 4h7l5 5v11a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Manual de capacitación</h2>
                            <div class="mt-4 flex items-center text-emerald-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver documento →</div>
                        </div>
                    </div>
                </a>

                <a href="{{ asset('manuales/usuario.pdf') }}" class="group">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 4h7l5 5v11a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Manual de usuario</h2>
                            <div class="mt-4 flex items-center text-blue-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver documento →</div>
                        </div>
                    </div>
                </a>

                <a href="{{ asset('manuales/administrador.pdf') }}" class="group">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 4h7l5 5v11a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Manual de administrador</h2>
                            <div class="mt-4 flex items-center text-indigo-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver documento →</div>
                        </div>
                    </div>
                </a>

                <a href="{{ asset('manuales/documento_final.pdf') }}" class="group">
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-8 py-10 flex justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 4h7l5 5v11a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Documento final</h2>
                            <div class="mt-4 flex items-center text-amber-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Ver documento →</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>