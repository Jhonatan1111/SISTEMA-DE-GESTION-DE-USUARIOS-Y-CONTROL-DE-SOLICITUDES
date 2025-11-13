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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id()->comment('Identificador único de la mascota');
            $table->string('nombre')->comment('Nombre de la mascota');
            $table->integer('edad')->comment('Edad de la mascota');
            $table->enum('sexo', ['macho', 'hembra'])->comment('Sexo de la mascota');
            $table->string('especie')->nullable()->comment('Especie de la mascota');
            $table->string('raza')->nullable()->comment('Raza de la mascota');
            $table->string('propietario')->nullable()->comment('Propietario de la mascota');
            $table->string('correo')->unique()->nullable()->comment('Correo electrónico del propietario');
            $table->integer('celular')->unique()->nullable()->comment('Número de celular del propietario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
