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
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary()->comment('Clave única del cache');
            $table->mediumText('value')->comment('Valor almacenado en cache');
            $table->integer('expiration')->comment('Tiempo de expiración del cache');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary()->comment('Clave única del bloqueo');
            $table->string('owner')->comment('Propietario del bloqueo');
            $table->integer('expiration')->comment('Tiempo de expiración del bloqueo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};