<x-guest-layout>
    <style>
        body {
            background: #e6f2ff; /* Fondo celeste suave */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h2 {
            font-size: 22px;
            font-weight: bold;
            color: #004d80;
            margin-bottom: 15px;
            text-align: center;
        }
        .text-info {
            font-size: 15px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary-custom {
            background: #0077cc;
            color: white;
            font-weight: bold;
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background: #005fa3;
        }
    </style>

    <h2>¿Olvidaste tu contraseña?</h2>

    <p class="text-info">
        No hay problema. Ingresa tu correo y te enviaremos un enlace para restablecerla.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="max-w-md mx-auto">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                          name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-4">
            <button type="submit" class="btn-primary-custom">
                {{ __('Enviar enlace de recuperación') }}
            </button>
        </div>
    </form>
</x-guest-layout>
