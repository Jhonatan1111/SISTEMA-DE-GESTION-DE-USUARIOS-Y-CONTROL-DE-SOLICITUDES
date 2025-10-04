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
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" style="max-width:100px; display:block; margin:0 auto 15px;">
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
            <!-- <div style="display:flex; align-items:center; margin:10px 0;">
                <input type="checkbox" name="remember" id="remember" style="margin-right:5px;">
                <label for="remember">Recordarme</label>
            </div> -->
            <button type="submit" class="btn-gradient w-100">Ingresar</button>
        </form>

        <div style="text-align:center; margin-top:10px;">
            <a href="{{ route('password.request') }}" style="color:var(--color-primary); text-decoration:none;">¿Olvidaste tu contraseña?</a>
        </div>
    </main>
</body>
</html>
