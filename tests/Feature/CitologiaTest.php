<?php

use App\Models\Citolgia;
use App\Models\Paciente;
use App\Models\Doctor;
use App\Models\ListaCitologia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear usuario autenticado para los tests
    $this->user = User::factory()->create();
    $this->withoutMiddleware();
    $this->actingAs($this->user);

    // Crear datos de prueba básicos
    $this->doctor = Doctor::create([
        'jvpm' => 'JVPM001',
        'nombre' => 'Dr. Juan',
        'apellido' => 'Pérez',
        'direccion' => 'Calle Principal 123',
        'celular' => '12345678',
        'fax' => '87654321',
        'correo' => 'doctor@test.com',
        'estado_servicio' => true
    ]);

    $this->paciente = Paciente::create([
        'nombre' => 'María',
        'apellido' => 'González',
        'dui' => '12345678-9',
        'edad' => 35,
        'sexo' => 'femenino',
        'correo' => 'paciente@test.com',
        'celular' => 87654321
    ]);

    $this->lista = ListaCitologia::create([
        'codigo' => 'C001',
        'diagnostico' => 'Diagnóstico de prueba',
        'macroscopico' => 'Descripción macroscópica',
        'microscopico' => 'Descripción microscópica'
    ]);
});

// ========== TESTS CRUD SIMPLIFICADOS ==========

test('creacion de citologia de persona', function () {
    // Arrange
    $datos = [
        'diagnostico_clinico' => 'Nuevo diagnóstico clínico',
        'fecha_recibida' => now()->format('Y-m-d'),
        'doctor_id' => $this->doctor->id,
        'paciente_id' => $this->paciente->id,
        'lista_id' => $this->lista->id
    ];

    // Act
    $response = $this->post('/citologias/personas', $datos);

    // Assert
    $this->assertDatabaseHas('citologias', [
        'diagnostico_clinico' => 'Nuevo diagnóstico clínico',
        'doctor_id' => $this->doctor->id,
        'paciente_id' => $this->paciente->id
    ]);

    dump('Usuario creado:', $this->user->toArray());
    dump('Datos enviados:', $datos);
    $response->assertStatus(302); // Redirect después de crear
});

test('leer citologias de personas', function () {
    // Arrange - Crear citología directamente en la base de datos
    $citologia = Citolgia::create([
        'ncitologia' => 'C202501001',
        'diagnostico_clinico' => 'Diagnóstico de prueba',
        'fecha_recibida' => now(),
        'doctor_id' => $this->doctor->id,
        'paciente_id' => $this->paciente->id,
        'estado' => true
    ]);

    // Act
    $response = $this->get('/citologias/personas');

    // Assert
    $response->assertStatus(200);
    
    // Verificar que la vista se carga correctamente
    $response->assertViewIs('citologias.personas.index');
    $response->assertViewHas('citologias');
    
    // Verificar que los datos están en la vista
    $citologias = $response->viewData('citologias');
    expect($citologias->count())->toBeGreaterThan(0);
    
    dump('Citología creada:', $citologia->ncitologia);
    dump('Total citologías en vista:', $citologias->count());
    dump('Primera citología en vista:', $citologias->first() ? $citologias->first()->ncitologia : 'Ninguna');
});

test('actualizacion de citologia', function () {
    // Arrange
    $citologia = Citolgia::create([
        'ncitologia' => 'C202501001',
        'diagnostico_clinico' => 'Diagnóstico original',
        'fecha_recibida' => now(),
        'doctor_id' => $this->doctor->id,
        'paciente_id' => $this->paciente->id,
        'estado' => true
    ]);

    $datosActualizados = [
        'diagnostico_clinico' => 'Diagnóstico actualizado',
        'fecha_recibida' => now()->format('Y-m-d'),
        'doctor_id' => $this->doctor->id,
        'paciente_id' => $this->paciente->id
    ];

    // Act
    $response = $this->put('/citologias/personas/' . $citologia->ncitologia, $datosActualizados);

    // Assert
    $this->assertDatabaseHas('citologias', [
        'ncitologia' => 'C202501001',
        'diagnostico_clinico' => 'Diagnóstico actualizado'
    ]);

    dump('Usuario:', $this->user->toArray());
    dump('Datos actualizados:', $datosActualizados);
    dump('Citología actualizada - ID:', $citologia->ncitologia);

    $response->assertStatus(302); // Redirect después de actualizar
});

// test('mostrar detalles de citologia', function () {
//     // Arrange
//     $citologia = Citolgia::create([
//         'ncitologia' => 'C202501001',
//         'diagnostico_clinico' => 'Diagnóstico de prueba',
//         'fecha_recibida' => now(),
//         'doctor_id' => $this->doctor->id,
//         'paciente_id' => $this->paciente->id,
//         'estado' => true
//     ]);

//     // Act
//     $response = $this->get('/citologias/personas/' . $citologia->ncitologia);

//     // Assert
//     $response->assertStatus(200);
//     $response->assertSee($citologia->ncitologia);
//     $response->assertSee($citologia->diagnostico_clinico);

//     dump('Citología mostrada:', $citologia->toArray());
// });

test('cambiar estado de citologia', function () {
    // Arrange
    $citologia = Citolgia::create([
        'ncitologia' => 'C202501001',
        'diagnostico_clinico' => 'Diagnóstico de prueba',
        'fecha_recibida' => now(),
        'doctor_id' => $this->doctor->id,
        'paciente_id' => $this->paciente->id,
        'estado' => true
    ]);

    // Act
    $response = $this->patch('/citologias/personas/' . $citologia->ncitologia . '/toggle-estado');

    // Assert
    $citologia->refresh();
    expect($citologia->estado)->toBeFalse();

    dump('Estado cambiado - Citología:', $citologia->ncitologia);
    dump('Nuevo estado:', $citologia->estado ? 'Activa' : 'Archivada');

    $response->assertStatus(302);
});



test('buscar lista por codigo', function () {
    // Act
    $response = $this->get('/citologias/personas/buscar-lista-codigo/C001');

    // Assert
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
        'data' => [
            'codigo' => 'C001',
            'diagnostico' => 'Diagnóstico de prueba'
        ]
    ]);

    dump('Lista encontrada:', $response->json());
});



// ========== TESTS DE VALIDACIÓN SIMPLIFICADOS ==========

test('validacion campos requeridos', function () {
    // Act
    $response = $this->post('/citologias/personas', []);

    // Assert
    $response->assertSessionHasErrors([
        'diagnostico_clinico',
        'fecha_recibida',
        'doctor_id',
        'paciente_id'
    ]);

    dump('Errores de validación encontrados correctamente');
});

test('no permite fecha futura', function () {
    // Arrange
    $datos = [
        'diagnostico_clinico' => 'Diagnóstico',
        'fecha_recibida' => now()->addDay()->format('Y-m-d'),
        'doctor_id' => $this->doctor->id,
        'paciente_id' => $this->paciente->id
    ];

    // Act
    $response = $this->post('/citologias/personas', $datos);

    // Assert
    $response->assertSessionHasErrors(['fecha_recibida']);

    dump('Validación de fecha futura funcionando correctamente');
});
