<?php

use App\Models\ListaCitologia;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

test('creacion de citologia permanente', function () {
    // Arrange - Crear usuario si no existe
    $user = User::factory()->create();
    $this->withoutMiddleware();
    $this->actingAs($user);
    $data = [
        'codigo' => 'C001',
        'diagnostico' => 'Diagnostico de prueba',
        'macroscopico' => 'Analisis macroscopico de prueba',
        'microscopico' => 'Analisis microscopico de prueba',
    ];

    //Act: 
    $response = $this->post('/listas/citologias', $data);

    // Assert
    $this->assertDatabaseHas('lista_citologias', $data);
    $citologia = ListaCitologia::get()->firstOrFail();
    dump($user->toArray());
    dump($citologia->toArray());

    $response->assertStatus(302);
});

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
