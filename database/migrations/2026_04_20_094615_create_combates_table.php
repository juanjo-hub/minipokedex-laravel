<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('combates', function (Blueprint $table) {
//             $table->id();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('combates');
//     }
// };

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de combates entre Pokémon.
     * Campos según enunciado: pokemon_local_id, pokemon_visitante_id,
     * fecha, resultado.
     *
     * Tiene DOS claves foráneas, ambas apuntando a la misma tabla (pokemons).
     * Por eso no podemos usar constrained() sin argumento — tenemos que
     * indicar explícitamente a qué tabla apuntan.
     */
    public function up(): void
    {
        Schema::create('combates', function (Blueprint $table) {
            $table->id();

            // Primera FK: el Pokémon local del combate
            $table->foreignId('pokemon_local_id')
                  ->constrained('pokemons')
                  ->onDelete('cascade');

            // Segunda FK: el Pokémon visitante del combate
            $table->foreignId('pokemon_visitante_id')
                  ->constrained('pokemons')
                  ->onDelete('cascade');

            $table->date('fecha');
            $table->string('resultado'); // Ej: "Victoria local", "Empate"

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combates');
    }
};