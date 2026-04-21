<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de entrenadores Pokémon.
     * Campos según enunciado: nombre, ciudad, edad.
     */
    public function up(): void
    {
        Schema::create('entrenadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ciudad');
            $table->integer('edad');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrenadores');
    }
};