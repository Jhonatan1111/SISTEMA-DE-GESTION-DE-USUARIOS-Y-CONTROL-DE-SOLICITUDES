<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Respaldo del Sistema</h1>
                    <p class="text-gray-600 mt-1">Crear y administrar respaldos del proyecto</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('admin.backups.store') }}">
                        @csrf
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300">
                            Crear respaldo del sistema
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.backups.store.datos') }}">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300">
                            Crear respaldo de datos
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @endif

            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-4">
                Tamaño máximo de subida actual: <strong>{{ $uploadMax ?? 'N/A' }}</strong> | Tamaño máximo de POST: <strong>{{ $postMax ?? 'N/A' }}</strong>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamaño</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($files as $file)
                            <tr class="hover:bg-blue-50">
                                <td class="px-6 py-4 whitespace-nowrap font-mono text-sm">{{ $file['name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ number_format($file['size'] / 1024, 2) }} KB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ date('d/m/Y H:i:s', $file['time']) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.backups.download', $file['name']) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Descargar</a>
                                        <form method="POST" action="{{ route('admin.backups.destroy', $file['name']) }}" onsubmit="return confirm('¿Eliminar respaldo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">No hay respaldos creados</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Restaurar desde archivo</h2>
                <p class="text-gray-600 mb-4">Sube un respaldo generado por esta página para restaurar los datos y archivos. No requiere pasos técnicos.</p>
                <form method="POST" action="{{ route('admin.backups.restore') }}" enctype="multipart/form-data" class="flex items-center gap-4">
                    @csrf
                    <input type="file" name="file" accept=".zip" class="block w-full text-sm text-gray-700" required />
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-5 rounded-lg transition-all duration-300">
                        Restaurar
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-3">Se restaurará el contenido de <code>storage/app</code> y la base de datos (SQLite copiará el archivo; MySQL importará datos del JSON incluido).</p>
            </div>
        </div>
    </div>
</x-app-layout>