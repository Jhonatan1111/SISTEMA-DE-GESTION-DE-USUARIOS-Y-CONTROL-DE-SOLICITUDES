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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del paciente');
            $table->string('apellido')->comment('Apellido del paciente');
            $table->string('dui')->unique()->nullable()->comment('DUI del paciente');
            $table->enum('sexo', ['masculino', 'femenino'])->comment('Sexo del paciente');
            $table->date('fecha_nacimiento')->nullable()->comment('Fecha de nacimiento del paciente');
            $table->string('estado_civil')->nullable()->comment('Estado civil del paciente');
            $table->string('ocupacion')->nullable()->comment('Ocupación del paciente');
            $table->string('correo')->unique()->nullable()->comment('Correo electrónico del paciente');
            $table->string('direccion')->nullable()->comment('Dirección del paciente');
            $table->integer('celular')->unique()->nullable()->comment('Número de celular del paciente');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
