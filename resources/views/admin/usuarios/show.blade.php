<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">Detalle de Usuario</h1>
            </div>
            <a href="{{ route('admin.usuarios.index') }}" class="text-gray-600 hover:text-gray-900" title="Volver">
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
                        <p class="text-lg font-bold text-gray-900">{{ $usuario->nombre }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Apellido</p>
                        <p class="text-lg font-bold text-gray-900">{{ $usuario->apellido }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Celular</p>
                        <p class="text-lg font-bold text-gray-900">{{ $usuario->celular }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Rol</p>
                        @if($usuario->role === 'admin')
                        <span class="inline-flex items-center gap-2 bg-red-100 text-red-800 px-4 py-2 rounded-full text-xs font-bold">
                            Administrador
                        </span>
                        @else
                        <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-xs font-bold">
                            Empleado
                        </span>
                        @endif

                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 sm:col-span-2">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Correo Electrónico</p>
                        <p class="text-lg font-bold text-blue-700">{{ $usuario->email }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-gray-50 via-white to-gray-50 p-6 rounded-2xl shadow-xl border border-gray-200">
                <h2 class="text-xl font-bold text-gray-700 mb-4 border-b-2 border-gray-200 pb-2">Información del Sistema</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Fecha de Creación</p>
                        <p class="text-lg font-bold text-gray-900">{{ $usuario->created_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $usuario->created_at->format('H:i') }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Última Actualización</p>
                        <p class="text-lg font-bold text-gray-900">{{ $usuario->updated_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $usuario->updated_at->format('H:i') }}</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.usuarios.index') }}" class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">Volver</a>
            <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">Editar</a>
            @if($usuario->id !== auth()->id())
            <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')" class="inline m-0 p-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">Eliminar</button>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>