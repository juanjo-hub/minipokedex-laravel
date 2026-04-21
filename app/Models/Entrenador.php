<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Eloquent para la entidad Entrenador.
 *
 * - $table: nombre explícito de la tabla (entrenadores, en español).
 * - $fillable: campos asignables masivamente (Entrenador::create([...])).
 * - pokemons(): relación HasMany con Pokemon.
 */
class Entrenador extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla. Lo indicamos explícitamente porque Laravel
     * pluralizaría automáticamente a "entrenadors" (convención inglesa).
     */
    protected $table = 'entrenadores';

    /**
     * Campos permitidos en asignación masiva.
     * Sin esto, Entrenador::create($request->all()) daría error.
     */
    protected $fillable = [
        'nombre',
        'ciudad',
        'edad',
    ];

    /**
     * RELACIÓN: un entrenador tiene MUCHOS Pokémon.
     *
     * Laravel busca la FK 'entrenador_id' en la tabla de pokemons
     * automáticamente (por convención: nombre_de_modelo_id).
     */
    public function pokemons(): HasMany
    {
        return $this->hasMany(Pokemon::class);
    }
}