<x-app-layout>
    <div class="dashboard-container">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <h1 class="dashboard-title">
            Bienvenido al Panel de Administración
        </h1>

        <div class="card-container">
             <!-- Gestión de Doctores -->
            <a href="{{ route('admin.usuarios.index') }}" class="card">
                <div class="card-icon">👨‍⚕️</div>
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
                <div class="card-icon">🧑</div>
                <h2 class="card-title">Gestión de Pacientes</h2>
                <p class="card-text">Administra la información de los pacientes.</p>
            </a>

            <!-- Resultados 
            <a href="{{ route('resultados.index') }}" class="card">
                <div class="card-icon">📊</div>
                <h2 class="card-title">Resultados</h2>
                <p class="card-text">Consulta y gestiona los resultados generados.</p>
            </a> -->
        </div>
    </div>
</x-app-layout>
