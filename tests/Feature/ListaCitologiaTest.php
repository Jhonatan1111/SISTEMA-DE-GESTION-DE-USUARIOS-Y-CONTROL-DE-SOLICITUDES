<?php

use App\Models\ListaCitologia;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

test('creacion de citologia', function () {
    // Arrange - Crear usuario si no existe
    $user = User::factory()->create();
    $this->withoutMiddleware();
    $this->actingAs($user);
    $citologia = ListaCitologia::factory()->create();

    //Act: 
    $response = $this->post('/listas/citologias', $citologia->toArray());

    // Assert
    $this->assertDatabaseHas('lista_citologias', $citologia->toArray());
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
    $citologia = ListaCitologia::factory()->create();

    //Act:  
    $response = $this->get('/listas/citologias');
    dump($citologia->toArray());
    dump($user->toArray());
    $response->assertStatus(200);
});

test('actualizacion de citologia', function () {
    // Arrange 
    $user = User::factory()->create(['role' => 'admin']);
    $this->actingAs($user);
    $citologia = ListaCitologia::factory()->create();
    $citologia = ListaCitologia::where('id', $citologia->id)->first();
    $data = [
        'diagnostico' => $citologia->diagnostico,
        'macroscopico' => $citologia->macroscopico,
        'microscopico' => $citologia->microscopico
    ];

    //Act: 
    $response = $this->put('/listas/citologias/' . $citologia->id, $data);

    // Assert
    $this->assertDatabaseHas('lista_citologias', $data);
    dump($user->toArray());
    dump($citologia->toArray());
    $response->assertStatus(302);
});
