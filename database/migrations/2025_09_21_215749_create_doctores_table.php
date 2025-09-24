<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctores', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental'); // ID autoincremental
            $table->string('jvpm', 10)->unique()->comment('Código único del doctor'); // Código único del doctor
            $table->string('nombre', 255)->comment('Nombre del doctor'); // Nombre del doctor
            $table->string('apellido', 255)->comment('Apellido del doctor'); // Apellido del doctor
            $table->string('direccion', 255)->nullable()->comment('Dirección del doctor'); // Dirección del doctor
            $table->string('celular', 10)->nullable()->unique()->comment('Número de celular del doctor'); // Número de celular del doctors
            $table->string('correo', 255)->nullable()->unique()->comment('Correo electrónico del doctor'); // Correo electrónico del doctor 
            $table->string('fax', 11)->nullable()->unique()->comment('Número de fax del doctor'); // Número de fax del doctor
            $table->boolean('estado_servicio')->default(true)->comment('Estado de servicio del doctor'); // Estado de servicio del doctor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctores');
    }
};
