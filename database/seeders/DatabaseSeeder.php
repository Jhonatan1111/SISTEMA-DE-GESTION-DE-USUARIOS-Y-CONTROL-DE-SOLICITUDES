<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nombre' => 'empleado',
            'apellido' => 'empleado',
            'email' => 'empleado@example.com',
            'password' => '123456',
            'role' => 'empleado',
            'celular' => '70126656',
            'email_verified_at' => now(),
        ]);
        // Crear un usuario administrador
          User::factory()->create([
            'nombre' => 'Admin',
            'apellido' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'role' => 'admin',
            'celular' => '73664989',
            'email_verified_at' => now(),
        ]);
    } 

    
      
    
}
