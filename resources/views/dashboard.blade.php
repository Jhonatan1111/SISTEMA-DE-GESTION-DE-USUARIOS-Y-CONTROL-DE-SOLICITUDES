<x-app-layout>
    <div class="dashboard-container">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <h1 class="dashboard-title">
            Bienvenido al Panel del Sistema
        </h1>

        <div class="card-container">
             <!-- Gestión de Doctores -->
            <a href="{{ route('admin.usuarios.index') }}" class="card">
                <div class="card-icon">🧑‍🤝‍🧑</div>
                <h2 class="card-title">Gestión de Usuarios</h2>
                <p class="card-text">Administra los usuarios registrados en el sistema.</p>
            </a>
            <!-- Gestión de Doctores -->
            <a href="{{ route('doctores.index') }}" class="card">
                <div class="card-icon">👨‍⚕️</div>
                <h2 class="card-title">Gestión de Doctores</h2>
                <p class="card-text">Administra los doctores registrados en el sistema.</p>
            </a>

            <!-- Gestión de Pacientes -->
            <a href="{{ route('pacientes.index') }}" class="card">
                <div class="card-icon">🧍‍♂️🐾</div>
                <h2 class="card-title">Gestión de Pacientes</h2>
                <p class="card-text">Administra la información de los pacientes.</p>
            </a>

             <!-- Gestión de biopsias -->
            <a href="{{ route('biopsias.index') }}" class="card">
                <div class="card-icon">🔬</div>
                <h2 class="card-title">Gestión de Biopsias</h2>
                <p class="card-text">Administra las biopsias generadas de personas y mascotas.</p>
            </a>

            <!-- Gestión de Doctores -->
            <a href="{{ route('listas.biopsias.index') }}" class="card">
                <div class="card-icon">📝</div>
                <h2 class="card-title">Gestión de listas</h2>
                <p class="card-text">Muestra detalladamente una listas de las biopsias y citologías guardadas previamente.</p>
            </a>


        </div>
    </div>
</x-app-layout>
