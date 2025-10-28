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
        Schema::create('lista_biopsias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->comment('Código único de la biopsia');
            $table->text('descripcion')->nullable()->comment('Descripción de la biopsia');
            $table->text('macroscopico')->nullable()->comment('Descripción macroscópica de la biopsia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_biopsias');
    }
};
