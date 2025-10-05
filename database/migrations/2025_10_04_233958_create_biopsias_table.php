<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('biopsias', function (Blueprint $table) {
            $table->string('nbiopsia', 15)->primary()->comment('Número de biopsia siendo llave primaria');
            $table->text('diagnostico_clinico')->comment('Diagnóstico por parte del laboratorio');
            $table->date('fecha_recibida')->comment('Fecha de recepción de la biopsia');
            $table->boolean('estado')->default(true)->comment(' Estado de la biopsia');
            $table->text('diagnostico')->nullable()->comment('Diagnóstico final');
            $table->text('macroscopico')->nullable()->comment('Análisis macroscópico');
            $table->text('microscopico')->nullable()->comment('Análisis microscópico');
            $table->text('descripcion')->nullable()->comment('Descripción de la biopsia');


            //RELACIONES 
            $table->unsignedBigInteger('doctor_id')->comment('ID del doctor');
            $table->unsignedBigInteger('paciente_id')->nullable()->comment('ID del paciente');
            $table->unsignedBigInteger('mascota_id')->nullable()->comment('ID de la mascota');
            $table->unsignedBigInteger('lista_id')->nullable()->comment('ID de la lista de biopsias');
            $table->timestamps();

            //LLAVES FORANEAS
            $table->foreign('doctor_id')->references('id')->on('doctores')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('mascota_id')->references('id')->on('mascotas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('lista_id')->references('id')->on('lista_biopsias')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biopsias');
    }
};
