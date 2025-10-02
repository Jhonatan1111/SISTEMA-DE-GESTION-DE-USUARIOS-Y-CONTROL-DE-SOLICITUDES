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
            $table->string('codigo')->nullable()->unique();
            $table->text('diagnostico')->nullable();
            $table->text('macroscopico')->nullable();
            $table->text('microscopico')->nullable();
            $table->text('descripcion')->nullable();
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
