<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

// Test que NO borra los datos (se guardan permanentemente)
test('creacion de citologia permanente', function () {

    // Arrange - Crear usuario si no existe
    $user = User::firstOrCreate([
        'email' => 'test@ejemplo.com'
    ], [
        'nombre' => 'Usuario',
        'apellido' => 'Test',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'celular' => 123456789
    ]);
    
    $this->withoutMiddleware();
    $this->actingAs($user);

    $data = [
        'codigo' => 'CIT001',
        'diagnostico' => 'Diagnóstico de prueba',
        'macroscopico' => 'Análisis macroscópico de prueba',
        'microscopico' => 'Análisis microscópico de prueba',
    ];

    //Act: 
    $response = $this->post('/listas/citologias', $data);
    
    // Assert
    $response->assertStatus(302);
    $this->assertDatabaseHas('lista_citologias', $data);
    
    // Verificar que los datos se guardaron permanentemente
    $citologia = \App\Models\ListaCitologia::where('codigo', 'CIT001')->first();
    
    echo "\n✅ Datos guardados PERMANENTEMENTE en la base de datos:\n";
    echo "ID en BD: {$citologia->id}\n";
    echo "Código: {$citologia->codigo}\n";
    echo "Diagnóstico: {$citologia->diagnostico}\n";
    echo "Fecha creación: {$citologia->created_at}\n";
    echo "\n📋 Ejecuta GET /listas/citologias para verlos en la interfaz\n";
    dump($data);
})->skip(false, 'Ejecutar para guardar datos permanentemente');

// Test normal que usa RefreshDatabase (datos temporales)
test("leer los datos", function () {
    //Arrange:
    $this->withoutMiddleware();

    $user = User::factory()->create();
    $this->actingAs($user);

    //Act:
    $response = $this->get('/listas/citologias');
    $response->assertStatus(200);
})->uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('creacion de citologia temporal', function () {
    // Arrange
    $this->withoutMiddleware();

    $user = User::factory()->create();
    $this->actingAs($user);

    $data = [
        'codigo' => 'CIT002',
        'diagnostico' => 'Diagnóstico de prueba temporal',
        'macroscopico' => 'Análisis macroscópico de prueba',
        'microscopico' => 'Análisis microscópico de prueba',
    ];

    //Act: 
    $response = $this->post('/listas/citologias', $data);
    // Assert
    $response->assertStatus(302);
    $this->assertDatabaseHas('lista_citologias', $data);
    dump('Datos temporales (se borrarán)');
})->uses(Illuminate\Foundation\Testing\RefreshDatabase::class);
