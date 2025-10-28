<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lista_citologias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->comment('Código único de la citología');
            $table->string('descripcion')->nullable()->comment('Descripción de la citología');
            $table->text('diagnostico')->nullable()->comment('Diagnóstico de la citología');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('lista_citologias');
    }
};
