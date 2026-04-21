<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pokemon;
use App\Models\Entrenador;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Tests de la API Pokemon.
 *
 * Cubre la rúbrica UT4:
 *  - Pruebas unitarias (crear, actualizar, eliminar, validación)
 *  - Pruebas de integración (endpoint GET /api/pokemons)
 *  - Uso de factories (no depende de datos reales de la BD)
 */
class PokemonApiTest extends TestCase
{
    /**
     * RefreshDatabase limpia y vuelve a crear toda la BD antes de cada test.
     * Así cada test empieza con una BD limpia y los tests no se contaminan
     * entre sí. No toca tu BD real de desarrollo, usa una BD de tests.
     */
    use RefreshDatabase;

    // ============================================================
    //   TEST 1 — Creación de un Pokémon (0,75 pts)
    // ============================================================
    public function test_se_puede_crear_un_pokemon(): void
    {
        $entrenador = Entrenador::factory()->create();

        $response = $this->postJson('/api/pokemons', [
            'nombre'        => 'Pikachu',
            'tipo'          => 'Eléctrico',
            'nivel'         => 25,
            'entrenador_id' => $entrenador->id,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'nombre' => 'Pikachu',
            'tipo'   => 'Eléctrico',
            'nivel'  => 25,
        ]);

        // Verificamos también que está en la BD
        $this->assertDatabaseHas('pokemons', [
            'nombre' => 'Pikachu',
        ]);
    }

    // ============================================================
    //   TEST 2 — Actualización de datos (0,75 pts)
    // ============================================================
    public function test_se_puede_actualizar_un_pokemon(): void
    {
        $pokemon = Pokemon::factory()->create([
            'nombre' => 'Charmander',
            'nivel'  => 5,
        ]);

        $response = $this->putJson("/api/pokemons/{$pokemon->id}", [
            'nombre' => 'Charmeleon',
            'nivel'  => 16,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'nombre' => 'Charmeleon',
            'nivel'  => 16,
        ]);

        $this->assertDatabaseHas('pokemons', [
            'id'     => $pokemon->id,
            'nombre' => 'Charmeleon',
            'nivel'  => 16,
        ]);
    }

    // ============================================================
    //   TEST 3 — Eliminación de registros (0,75 pts)
    // ============================================================
    public function test_se_puede_eliminar_un_pokemon(): void
    {
        $pokemon = Pokemon::factory()->create();

        $response = $this->deleteJson("/api/pokemons/{$pokemon->id}");

        $response->assertStatus(204);

        // Verificamos que ya no está en la BD
        $this->assertDatabaseMissing('pokemons', [
            'id' => $pokemon->id,
        ]);
    }

    // ============================================================
    //   TEST 4 — Validación de datos (0,75 pts)
    // ============================================================
    public function test_no_se_puede_crear_pokemon_sin_nombre(): void
    {
        $entrenador = Entrenador::factory()->create();

        $response = $this->postJson('/api/pokemons', [
            // nombre omitido intencionadamente
            'tipo'          => 'Fuego',
            'nivel'         => 10,
            'entrenador_id' => $entrenador->id,
        ]);

        // 422 = Unprocessable Entity (validación fallida)
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_no_se_puede_crear_pokemon_con_entrenador_inexistente(): void
    {
        $response = $this->postJson('/api/pokemons', [
            'nombre'        => 'Bulbasaur',
            'tipo'          => 'Planta',
            'nivel'         => 5,
            'entrenador_id' => 9999, // id que no existe
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['entrenador_id']);
    }

    // ============================================================
    //   TEST 5 — Pruebas de integración: endpoint GET /api/pokemons (1 pt)
    // ============================================================
    public function test_endpoint_index_devuelve_200_y_lista_json(): void
    {
        // Preparamos datos con factories (no dependemos de datos reales)
        Pokemon::factory()->count(3)->create();

        $response = $this->getJson('/api/pokemons');

        // 1) Código de estado correcto (200)
        $response->assertStatus(200);

        // 2) Estructura JSON correcta
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'nombre',
                'tipo',
                'nivel',
                'entrenador_id',
                'entrenador',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    // ============================================================
    //   TEST 6 — Show devuelve un Pokémon concreto
    // ============================================================
    public function test_endpoint_show_devuelve_el_pokemon_correcto(): void
    {
        $pokemon = Pokemon::factory()->create([
            'nombre' => 'Squirtle',
            'tipo'   => 'Agua',
        ]);

        $response = $this->getJson("/api/pokemons/{$pokemon->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id'     => $pokemon->id,
            'nombre' => 'Squirtle',
            'tipo'   => 'Agua',
        ]);
    }

    public function test_endpoint_show_devuelve_404_si_no_existe(): void
    {
        $response = $this->getJson('/api/pokemons/99999');
        $response->assertStatus(404);
    }
}