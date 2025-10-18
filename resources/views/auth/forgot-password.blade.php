<x-guest-layout>
    <div class="flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl w-96 p-8 text-center border border-gray-200 dark:border-gray-700">
            
            <!-- Ícono decorativo -->
            <div class="flex justify-center mb-4">
                <div class="bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full p-3">
                    <i class="fas fa-lock text-2xl"></i>
                </div>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white mb-2">
                ¿Olvidaste tu contraseña?
            </h2>

            <!-- Texto informativo -->
            <p class="text-gray-600 dark:text-gray-300 text-sm mb-6">
                Ingresa tu correo y te enviaremos un enlace para restablecerla.
            </p>

            <!-- Estado -->
            <x-auth-session-status class="mb-4 text-green-600 dark:text-green-400 font-medium text-sm" :status="session('status')" />

            <!-- Formulario -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Input -->
                <div>
                    <input id="email" type="email" name="email" required autofocus
                        placeholder="Correo electrónico"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all text-gray-700 dark:text-gray-100 dark:bg-gray-700 text-sm placeholder-gray-400 dark:placeholder-gray-400">
                </div>

                <!-- Botón -->
                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md transition-all">
                    Enviar enlace de recuperación
                </button>
            </form>

            <!-- Enlace volver -->
            <div class="mt-6">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400 font-medium">
                    ← Volver al inicio de sesión
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
