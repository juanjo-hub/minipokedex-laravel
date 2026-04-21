<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * EntrenadorController
 * -----------------------------------------------------------------
 * Controlador API REST para el recurso Entrenador.
 *
 * Métodos expuestos:
 *   - index()   GET    /api/entrenadores        → listar
 *   - store()   POST   /api/entrenadores        → crear
 *   - show()    GET    /api/entrenadores/{id}   → mostrar uno
 *   - update()  PUT    /api/entrenadores/{id}   → actualizar
 *   - destroy() DELETE /api/entrenadores/{id}   → eliminar
 * -----------------------------------------------------------------
 */
class EntrenadorController extends Controller
{
    /**
     * Listar todos los entrenadores, incluyendo sus pokemons (eager loading).
     * GET /api/entrenadores
     */
    public function index(): JsonResponse
    {
        $entrenadores = Entrenador::with('pokemons')->get();
        return response()->json($entrenadores);
    }

    /**
     * Crear un nuevo entrenador tras validar.
     * POST /api/entrenadores
     */
    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|min:2|max:100',
            'ciudad' => 'required|string|max:100',
            'edad'   => 'required|integer|min:1|max:120',
        ]);

        $entrenador = Entrenador::create($datos);

        return response()->json($entrenador, 201);
    }

    /**
     * Mostrar un entrenador concreto.
     * GET /api/entrenadores/{id}
     */
    public function show(Entrenador $entrenador): JsonResponse
    {
        // Cargamos también sus pokemons para devolverlos juntos
        $entrenador->load('pokemons');
        return response()->json($entrenador);
    }

    /**
     * Actualizar un entrenador.
     * PUT /api/entrenadores/{id}
     */
    public function update(Request $request, Entrenador $entrenador): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'sometimes|required|string|min:2|max:100',
            'ciudad' => 'sometimes|required|string|max:100',
            'edad'   => 'sometimes|required|integer|min:1|max:120',
        ]);

        $entrenador->update($datos);

        return response()->json($entrenador);
    }

    /**
     * Eliminar un entrenador (borra también sus Pokémon por cascade).
     * DELETE /api/entrenadores/{id}
     */
    public function destroy(Entrenador $entrenador): JsonResponse
    {
        $entrenador->delete();
        return response()->json(null, 204);
    }
}