<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * PokemonController
 * -----------------------------------------------------------------
 * Controlador API REST para el recurso Pokemon.
 *
 * Métodos expuestos:
 *   - index()   GET    /api/pokemons        → listar
 *   - store()   POST   /api/pokemons        → crear
 *   - show()    GET    /api/pokemons/{id}   → mostrar uno
 *   - update()  PUT    /api/pokemons/{id}   → actualizar
 *   - destroy() DELETE /api/pokemons/{id}   → eliminar
 * -----------------------------------------------------------------
 */
class PokemonController extends Controller
{
    /**
     * Listar todos los Pokémon junto con su entrenador.
     * GET /api/pokemons
     */
    public function index(): JsonResponse
    {
        $pokemons = Pokemon::with('entrenador')->get();
        return response()->json($pokemons);
    }

    /**
     * Crear un nuevo Pokémon tras validar.
     * POST /api/pokemons
     */
    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre'        => 'required|string|min:2|max:100',
            'tipo'          => 'required|string|max:50',
            'nivel'         => 'required|integer|min:1|max:100',
            // exists:tabla,columna → el entrenador_id debe existir realmente
            'entrenador_id' => 'required|integer|exists:entrenadores,id',
        ]);

        $pokemon = Pokemon::create($datos);

        return response()->json($pokemon, 201);
    }

    /**
     * Mostrar un Pokémon concreto.
     * GET /api/pokemons/{id}
     */
    public function show(Pokemon $pokemon): JsonResponse
    {
        $pokemon->load('entrenador');
        return response()->json($pokemon);
    }

    /**
     * Actualizar un Pokémon.
     * PUT /api/pokemons/{id}
     */
    public function update(Request $request, Pokemon $pokemon): JsonResponse
    {
        $datos = $request->validate([
            'nombre'        => 'sometimes|required|string|min:2|max:100',
            'tipo'          => 'sometimes|required|string|max:50',
            'nivel'         => 'sometimes|required|integer|min:1|max:100',
            'entrenador_id' => 'sometimes|required|integer|exists:entrenadores,id',
        ]);

        $pokemon->update($datos);

        return response()->json($pokemon);
    }

    /**
     * Eliminar un Pokémon.
     * DELETE /api/pokemons/{id}
     */
    public function destroy(Pokemon $pokemon): JsonResponse
    {
        $pokemon->delete();
        return response()->json(null, 204);
    }
}