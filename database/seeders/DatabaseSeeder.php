<?php

namespace Database\Seeders;

use App\Models\Entrenador;
use App\Models\Pokemon;
use App\Models\Combate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Entrenadores fijos
        $ash = Entrenador::create([
            'nombre' => 'Ash',
            'ciudad' => 'Pueblo Paleta',
            'edad'   => 10,
        ]);

        $misty = Entrenador::create([
            'nombre' => 'Misty',
            'ciudad' => 'Ciudad Celeste',
            'edad'   => 12,
        ]);

        $brock = Entrenador::create([
            'nombre' => 'Brock',
            'ciudad' => 'Ciudad Plateada',
            'edad'   => 15,
        ]);

        // 2. Pokémon por entrenador (usando la factory)
        Pokemon::factory()->count(3)->state(['entrenador_id' => $ash->id])->create();
        Pokemon::factory()->count(2)->state(['entrenador_id' => $misty->id])->create();
        Pokemon::factory()->count(2)->state(['entrenador_id' => $brock->id])->create();

        // 3. Combates de ejemplo
        $pokemonsAsh = $ash->pokemons;
        $pokemonsMisty = $misty->pokemons;

        Combate::create([
            'pokemon_local_id'     => $pokemonsAsh->first()->id,
            'pokemon_visitante_id' => $pokemonsMisty->first()->id,
            'fecha'                => now()->subDays(5),
            'resultado'            => 'Victoria local',
        ]);

        Combate::create([
            'pokemon_local_id'     => $pokemonsMisty->last()->id,
            'pokemon_visitante_id' => $pokemonsAsh->last()->id,
            'fecha'                => now()->subDays(2),
            'resultado'            => 'Empate',
        ]);
    }
}