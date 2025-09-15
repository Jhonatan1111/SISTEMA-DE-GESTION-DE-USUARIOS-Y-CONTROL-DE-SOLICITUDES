<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID único del trabajo');
            $table->string('queue')->index()->comment('Cola de trabajo');
            $table->longText('payload')->comment('Datos del trabajo');
            $table->unsignedTinyInteger('attempts')->comment('Número de intentos');
            $table->unsignedInteger('reserved_at')->nullable()->comment('Tiempo de reserva');
            $table->unsignedInteger('available_at')->comment('Tiempo disponible');
            $table->unsignedInteger('created_at')->comment('Tiempo de creación');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary()->comment('ID único del lote de trabajos');
            $table->string('name')->comment('Nombre del lote');
            $table->integer('total_jobs')->comment('Total de trabajos');
            $table->integer('pending_jobs')->comment('Trabajos pendientes');
            $table->integer('failed_jobs')->comment('Trabajos fallidos');
            $table->text('failed_job_ids')->comment('IDs de trabajos fallidos');
            $table->mediumText('options')->nullable()->comment('Opciones del lote');
            $table->integer('cancelled_at')->nullable()->comment('Tiempo de cancelación');
            $table->integer('created_at')->comment('Tiempo de creación');
            $table->integer('finished_at')->nullable()->comment('Tiempo de finalización');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id()->comment('ID único del trabajo fallido');
            $table->string('uuid')->unique()->comment('UUID del trabajo');
            $table->text('connection')->comment('Conexión del trabajo');
            $table->text('queue')->comment('Cola del trabajo');
            $table->longText('payload')->comment('Datos del trabajo');
            $table->longText('exception')->comment('Excepción del trabajo');
            $table->timestamp('failed_at')->useCurrent()->comment('Tiempo de fallo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};