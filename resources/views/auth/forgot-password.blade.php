<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
</head>

<body>
    <main class="auth-card fade-in">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="logo" style="max-width:100px; display:block; margin:0 auto 15px;">
        <h2 class="auth-title">¿Olvidaste tu contraseña?</h2>
        <p class="auth-info">Ingresa tu correo y te enviaremos un enlace para restablecerla.</p>

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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" name="email" placeholder="Correo electrónico" required autofocus value="{{ old('email') }}">
            <button type="submit" class="btn-gradient w-100">Enviar enlace de recuperación</button>
        </form>

        <div style="text-align:center; margin-top:10px;">
            <a href="{{ route('login') }}" style="color:var(--color-primary); text-decoration:none;">← Volver al inicio de sesión</a>
        </div>
    </main>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.querySelector('input[name="email"]');
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                this.value = this.value.trimStart();
            });
            emailInput.addEventListener('paste', function() {
                setTimeout(() => {
                    this.value = this.value.trimStart();
                }, 10);
            });
            emailInput.closest('form').addEventListener('submit', function() {
                emailInput.value = emailInput.value.trim();
            });
        }
    });
</script>
