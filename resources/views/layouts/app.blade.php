<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">

    <!-- Scripts y CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Navbar -->
        <nav class="navbar flex justify-between items-center px-4 py-2 bg-white dark:bg-gray-800 shadow">
            <div class="flex items-center gap-3">

                <!-- Logo -->
                <div class="logo" style="display: flex; justify-content: center; align-items: center;">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo" style="max-height:50px;">
                    </a>
                </div>
            </div>

            <!-- Usuario y botón cerrar sesión -->
            @auth
            <div class="flex items-center ">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="text-gray-500 dark:text-gray-300  font-medium inline-flex items-center text-size-10 px-3 py-2 border border-transparent text-sm leading-4 rounded-md dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nombre ?? Auth::user()->name }} {{ Auth::user()->apellido ?? '' }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('utils.credits')">
                            <span class="inline-flex items-center">
                                <svg class="h-4 w-4 mr-2 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.87891 7.51884C11.0505 6.49372 12.95 6.49372 14.1215 7.51884C15.2931 8.54397 15.2931 10.206 14.1215 11.2312C13.9176 11.4096 13.6917 11.5569 13.4513 11.6733C12.7056 12.0341 12.0002 12.6716 12.0002 13.5V14.25M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM12 17.25H12.0075V17.2575H12V17.25Z" />
                                </svg>
                                Créditos del sistema
                            </span>
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('utils.help')">
                            <span class="inline-flex items-center">
                                <svg class="h-4 w-4 mr-2 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                                </svg>
                                Centro de ayuda
                            </span>
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout text-blue-700 font-medium">Cerrar sesión</button>
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