<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\PokemonController;

/*
|----------------------------------------------------------------------
| Rutas API de la Mini Pokedex
|----------------------------------------------------------------------
| Usamos parameters() para forzar el nombre del parámetro a 'entrenador',
| de modo que el Route Model Binding de EntrenadorController funcione.
| Por defecto Laravel singulariza mal en inglés ('entrenadore').
*/

Route::apiResource('entrenadores', EntrenadorController::class)
     ->parameters(['entrenadores' => 'entrenador']);

Route::apiResource('pokemons', PokemonController::class)
     ->parameters(['pokemons' => 'pokemon']);