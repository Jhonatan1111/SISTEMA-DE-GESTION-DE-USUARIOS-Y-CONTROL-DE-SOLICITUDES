@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #e0f7ff;
        font-family: Arial, sans-serif;
        margin: 0;
    }

    .login-box {
        background-color: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        text-align: center;
        width: 320px;
    }

    .login-box img {
        width: 80px;
        margin-bottom: 5px;
    }

    .login-box label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .login-box input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
        box-sizing: border-box;
    }

    .login-box button {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
    }

    .login-box button:hover {
        background-color: #0056b3;
    }

    .error {
        color: red;
        margin-bottom: 10px;
        font-size: 14px;
        text-align: left;
    }
</style>

<div class="login-box">
    <img src="{{ asset('img/microscopio.png') }}" alt="Microscopio">

    <form action="{{ url('/login') }}" method="POST">
        @csrf

        <label for="email">Correo</label>
        <input type="email" id="email" name="email" placeholder="Eje. xxxxxxx@gmail.com" value="{{ old('email') }}" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Ingrese una contraseña con 6 dígitos o más" required>

        <button type="submit">Iniciar</button>
    </form>
    <p style="margin-top:10px;">
        <a href="{{ route('password.request') }}">Si olvidaste tu contraseña presiona aquí</a>
    </p>


    @if($errors->any())
        <div class="error">La contraseña no es valida</div>
    @endif
</div>
@endsection
