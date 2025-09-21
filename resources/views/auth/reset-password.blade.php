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
        .form-box {
            max-width: 420px;
            margin: 40px auto;
            padding: 20px;
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

    <div class="form-box">
        <h2>Restablecer Contraseña</h2>

        <p class="text-info">
            Ingresa tu correo y tu nueva contraseña para actualizar tu cuenta.
        </p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email"
                              name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" :value="__('Nueva contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password"
                              name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <button type="submit" class="btn-primary-custom">
                    {{ __('Restablecer contraseña') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
