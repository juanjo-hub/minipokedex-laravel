<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de Pokémon.
     * Campos según enunciado: nombre, tipo, nivel, entrenador_id.
     *
     * entrenador_id es clave foránea que apunta a la tabla 'entrenadores'.
     * Si se elimina un entrenador, también se eliminan sus Pokémon (cascade).
     */
    public function up(): void
    {
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo');
            $table->integer('nivel');

            // Clave foránea: relaciona con entrenadores.id
            $table->foreignId('entrenador_id')
                  ->constrained('entrenadores')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemons');
    }
};