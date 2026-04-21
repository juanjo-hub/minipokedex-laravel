<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Eloquent para la entidad Pokemon.
 *
 * Relaciones:
 *   - belongsTo Entrenador: cada Pokémon pertenece a un entrenador.
 *   - hasMany Combate (como local): combates en los que es pokemon_local.
 *   - hasMany Combate (como visitante): combates en los que es pokemon_visitante.
 */
class Pokemon extends Model
{
    use HasFactory;

    /**
     * Laravel pluralizaría a "pokemons", y la tabla SE LLAMA pokemons,
     * así que podríamos no declararlo. Pero lo dejamos explícito
     * para que quede claro y no haya dudas en la corrección.
     */
    protected $table = 'pokemons';

    /** Campos asignables en masa. */
    protected $fillable = [
        'nombre',
        'tipo',
        'nivel',
        'entrenador_id',
    ];

    /**
     * RELACIÓN: un Pokémon pertenece a UN entrenador.
     *
     * Laravel busca la FK entrenador_id en esta misma tabla (pokemons)
     * por convención (nombre_modelo_id).
     */
    public function entrenador(): BelongsTo
    {
        return $this->belongsTo(Entrenador::class);
    }

    /**
     * RELACIÓN: combates donde este Pokémon es el LOCAL.
     *
     * Tenemos que indicar la FK manualmente porque Laravel buscaría
     * por defecto "pokemon_id", pero aquí se llama "pokemon_local_id".
     */
    public function combatesComoLocal(): HasMany
    {
        return $this->hasMany(Combate::class, 'pokemon_local_id');
    }

    /**
     * RELACIÓN: combates donde este Pokémon es el VISITANTE.
     */
    public function combatesComoVisitante(): HasMany
    {
        return $this->hasMany(Combate::class, 'pokemon_visitante_id');
    }
}