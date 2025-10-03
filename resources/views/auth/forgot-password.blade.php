<x-guest-layout>
    <div class="auth-card fade-in">
        <h2 class="auth-title">¿Olvidaste tu contraseña?</h2>
        <p class="auth-info">No hay problema. Ingresa tu correo y te enviaremos un enlace para restablecerla.</p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input id="email" type="email" name="email" placeholder="Correo electrónico" required autofocus>
            <button type="submit" class="btn-gradient w-100">Enviar enlace de recuperación</button>
        </form>
    </div>
</x-guest-layout>
