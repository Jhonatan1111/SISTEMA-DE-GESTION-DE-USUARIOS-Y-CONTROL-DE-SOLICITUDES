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
            if (localStorage.getItem('dark-mode') === 'true') {
                document.body.classList.add('dark-mode');
            }
        });

        function toggleDarkMode() {
            const isDark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('dark-mode', isDark);
        }
    </script>

    <style>
        /* Estilo para botón volver */
        .btn-back {
            display: inline-block;
            padding: 0.4rem 0.9rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: #1a202c;
            background-color: #e2e8f0;
            border-radius: 6px;
            text-decoration: none;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            transition: background 0.2s ease;
        }

        .btn-back:hover {
            background-color: #cbd5e0;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Navbar -->
        <nav class="navbar flex justify-between items-center px-4 py-2 bg-white dark:bg-gray-800 shadow">
            <div class="flex items-center gap-3">
                <!-- Botón volver -->
                  @if (!Route::is('dashboard'))
                    <button onclick="goBack()" class="btn-back" title="Volver">🢀</button>
                @endif

                <!-- Logo -->
                <div class="logo">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-height:40px;">
                    </a>
                </div>
            </div>

            <!-- Botón cerrar sesión -->
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

    <!-- Seguridad: deshabilitar botón atrás del navegador -->
    @auth
    <script>
        (function() {
            function hacerLogout() {
                const form = document.getElementById('logout-form');
                if (form) {
                    form.submit();
                }
            }

            history.pushState(null, null, location.href);
            window.addEventListener('popstate', function() {
                history.pushState(null, null, location.href);
                alert('Por seguridad, debes usar solo los botones del sistema. Tu sesión se cerrará.');
                hacerLogout();
            });

            window.addEventListener('pageshow', function(event) {
                if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                    hacerLogout();
                }
            });
        })();
    </script>
    @endauth

    <!-- Script de historial personalizado -->
    <script>
        const maxHistory = 50;
        let historyList = JSON.parse(localStorage.getItem('myHistory')) || [];

        if (historyList.length === 0 || historyList[historyList.length - 1] !== window.location.href) {
            historyList.push(window.location.href);
            if (historyList.length > maxHistory) {
                historyList.shift();
            }
            localStorage.setItem('myHistory', JSON.stringify(historyList));
        }

        function goBack() {
            let historyList = JSON.parse(localStorage.getItem('myHistory')) || [];
            historyList.pop(); // remove current page

            if (historyList.length > 0) {
                const previousURL = historyList.pop();
                localStorage.setItem('myHistory', JSON.stringify(historyList));
                window.location.href = previousURL;
            } else {
                // Si no hay historial, redirige al dashboard
                window.location.href = "{{ route('dashboard') }}";
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
