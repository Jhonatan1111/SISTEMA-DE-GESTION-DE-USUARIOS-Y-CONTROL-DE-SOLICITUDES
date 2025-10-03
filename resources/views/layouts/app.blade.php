<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
             <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts y CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Modo oscuro persistente
        document.addEventListener('DOMContentLoaded', () => {
            if(localStorage.getItem('dark-mode') === 'true') {
                document.body.classList.add('dark-mode');
            }
        });

        function toggleDarkMode() {
            const isDark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('dark-mode', isDark);
        }
    </script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Navbar -->
        <nav class="navbar flex justify-between items-center px-4 py-2 bg-white dark:bg-gray-800 shadow">
            <div class="logo">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-height:40px;">
                </a>
            </div>

            <!-- Solo botón de cerrar sesión -->
            @auth
                <div class="flex items-center gap-4">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">Cerrar sesión</button>
                    </form>
                </div>
            @endauth
        </nav>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-[1900px] mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="max-w-[1900px] mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="text-center py-4 mt-8 text-gray-700 dark:text-gray-300">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }} - Todos los derechos reservados
        </footer>
    </div>
</body>
</html>
