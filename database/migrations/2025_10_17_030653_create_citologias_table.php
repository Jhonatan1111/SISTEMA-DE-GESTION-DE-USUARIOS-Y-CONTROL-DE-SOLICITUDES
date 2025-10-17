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
        Schema::create('citologias', function (Blueprint $table) {
            $table->string('ncitologia', 15)->primary()->comment('Número de citología siendo llave primaria');
            $table->text('diagnostico_clinico')->comment('Diagnóstico por parte del laboratorio');
            $table->date('fecha_recibida')->comment('Fecha de recepción de la citología');
            $table->enum('tipo', ['normal', 'liquida'])->comment('Tipo de citología');
            $table->boolean('estado')->default(true)->comment(' Estado de la citología');
            $table->text('diagnostico')->nullable()->comment('Diagnóstico final');
            $table->text('macroscopico')->nullable()->comment('Análisis macroscópico');
            $table->text('microscopico')->nullable()->comment('Análisis microscópico');
            $table->timestamps();


            //RELACIONES 
            $table->unsignedBigInteger('doctor_id')->comment('ID del doctor');
            $table->unsignedBigInteger('paciente_id')->nullable()->comment('ID del paciente');
            $table->unsignedBigInteger('mascota_id')->nullable()->comment('ID de la mascota');
            $table->unsignedBigInteger('lista_id')->nullable()->comment('ID de la lista de citologías');
            $table->timestamps();

            //LLAVES FORANEAS
            $table->foreign('doctor_id')->references('id')->on('doctores')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('mascota_id')->references('id')->on('mascotas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('lista_id')->references('id')->on('lista_citologias')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citologias');
    }
};
