<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
</head>

<body>
    <main class="auth-card fade-in">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="logo" style="max-width:100px; display:block; margin:0 auto 15px;">
        <h2 class="auth-title">Restablecer Contraseña</h2>
        <p class="auth-info">Ingresa tu correo y tu nueva contraseña para actualizar tu cuenta.</p>

        @if($errors->any())
        <div class="auth-info" style="color:red;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="email"  name="email" placeholder="Correo electrónico" autofocus value="{{ old('email', $request->email) }}">
            <input type="password" name="password" placeholder="Nueva contraseña" required autocomplete="new-password">
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required autocomplete="new-password">
            <button type="submit" class="btn-gradient w-100">Restablecer contraseña</button>
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
        const passwordInput = document.querySelector('input[name="password"]');
        const confirmInput = document.querySelector('input[name="password_confirmation"]');

        if (emailInput) {
            emailInput.addEventListener('input', function() {
                this.value = this.value.trimStart();
            });
            emailInput.addEventListener('paste', function() {
                setTimeout(() => {
                    this.value = this.value.trimStart();
                }, 10);
            });
        }

        function trimOnSubmit() {
            if (emailInput) emailInput.value = emailInput.value.trim();
            if (passwordInput) passwordInput.value = passwordInput.value.trim();
            if (confirmInput) confirmInput.value = confirmInput.value.trim();
        }
        const form = document.querySelector('form');
        if (form) form.addEventListener('submit', trimOnSubmit);
    });
</script>