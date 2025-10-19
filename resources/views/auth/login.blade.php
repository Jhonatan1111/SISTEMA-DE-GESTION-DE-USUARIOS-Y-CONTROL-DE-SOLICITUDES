<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <main class="auth-card fade-in">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="logo" style="max-width:100px; display:block; margin:0 auto 15px;">
        <h2 class="auth-title">Iniciar Sesión</h2>

        @if(session('status'))
        <div class="auth-info" style="color:green;">{{ session('status') }}</div>
        @endif
        @if($errors->any())
        <div class="auth-info" style="color:red;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Correo electrónico" required autofocus value="{{ old('email') }}">
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" class="btn-gradient w-100">Ingresar</button>
        </form>

        <div style="text-align:center; margin-top:10px;">
            <a href="{{ route('password.request') }}" style="color:var(--color-primary); text-decoration:none;">¿Olvidaste tu contraseña?</a>
        </div>
    </main>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.querySelector('input[name="email"]');
        const passwordInput = document.querySelector('input[name="password"]');

        // Para el email
        if (emailInput) {
            // Mientras escribes - elimina TODOS los espacios del inicio
            emailInput.addEventListener('input', function(e) {
                this.value = this.value.trimStart();
            });

            // Al pegar texto - elimina espacios del inicio
            emailInput.addEventListener('paste', function(e) {
                setTimeout(() => {
                    this.value = this.value.trimStart();
                }, 10);
            });

            // Antes de enviar - elimina espacios
            emailInput.closest('form').addEventListener('submit', function(e) {
                emailInput.value = emailInput.value.trim();
            });
        }

        // Para la contraseña
        if (passwordInput) {
            passwordInput.addEventListener('input', function(e) {
                this.value = this.value.trimStart();
            });

            passwordInput.addEventListener('paste', function(e) {
                setTimeout(() => {
                    this.value = this.value.trimStart();
                }, 10);
            });

            passwordInput.closest('form').addEventListener('submit', function(e) {
                passwordInput.value = passwordInput.value.trim();
            });
        }
    });
</script>