<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #e0f2ff;
            font-family: Arial, sans-serif;
        }

        .register-box {
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
            width: 400px;
            max-width: 90%;
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: .4rem;
            color: #444;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: .6rem .8rem;
            border: 1px solid #ccc;
            border-radius: .5rem;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
        }

        button {
            width: 100%;
            padding: .8rem;
            background: #3b82f6;
            color: #fff;
            border: none;
            border-radius: .5rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background .3s ease;
        }

        button:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Registrarse</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nombre</label>
                <input id="name" name="name" type="text" required autofocus>
            </div>

            <div class="form-group">
                <label for="last_name">Apellido</label>
                <input id="last_name" name="last_name" type="text" required>
            </div>

            <div class="form-group">
                <label for="celular">Celular</label>
                <input id="celular" name="celular" type="text" required>
            </div>

            <div class="form-group">
                <label for="email">Correo</label>
                <input id="email" name="email" type="email" required>
            </div>

            <div class="form-group">
                <label for="role">Rol</label>
                <select id="role" name="role" required>
                    <option value="">Seleccione un rol</option>
                    <option value="admin">Administrador</option>
                    <option value="empleado">Empleado</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            </div>

            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>
