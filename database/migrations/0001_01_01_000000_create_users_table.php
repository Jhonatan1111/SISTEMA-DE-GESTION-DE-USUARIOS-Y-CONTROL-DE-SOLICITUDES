<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del usuario');
            $table->string('apellido')->comment('Apellido del usuario');
            $table->string('email')->unique()->comment('Correo electrónico del usuario');
            $table->timestamp('email_verified_at')->nullable()->comment('Fecha de verificación del correo electrónico');
            $table->string('password')->comment('Contraseña del usuario');
            $table->string('celular', 11)->comment('Número de celular del usuario');
            $table->enum('role', ['admin','empleado'])->default('empleado')->comment('Rol del usuario');
            $table->rememberToken()->comment('Token de recordatorio de sesión');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary()->comment('Correo electrónico del usuario');
            $table->string('token')->comment('Token de restablecimiento de contraseña');
            $table->timestamp('created_at')->nullable()->comment('Fecha de creación del token');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary()->comment('ID de la sesión');
            $table->foreignId('user_id')->nullable()->index()->comment('ID del usuario');
            $table->string('ip_address', 45)->nullable()->comment('Dirección IP del usuario');
            $table->text('user_agent')->nullable()->comment('Agente de usuario');
            $table->longText('payload')->comment('Datos de la sesión');
            $table->integer('last_activity')->index()->comment('Última actividad del usuario');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
