<?php

namespace Database\Factories;

use App\Models\Entrenador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para la entidad Pokemon.
 *
 * Genera Pokémon con datos aleatorios. Si no se le pasa un
 * entrenador_id, crea un entrenador nuevo automáticamente.
 */
class PokemonFactory extends Factory
{
    public function definition(): array
    {
        // Lista de tipos realistas para que el Pokémon tenga sentido
        $tipos = ['Fuego', 'Agua', 'Planta', 'Eléctrico',
                  'Hada', 'Hielo', 'Lucha', 'Psíquico'];

        return [
            'nombre'        => fake()->firstName(),
            'tipo'          => fake()->randomElement($tipos),
            'nivel'         => fake()->numberBetween(1, 100),

            // Si no se especifica, crea un Entrenador nuevo
            // y usa su id automáticamente.
            'entrenador_id' => Entrenador::factory(),
        ];
    }
}