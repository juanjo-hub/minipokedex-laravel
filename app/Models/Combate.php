<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Eloquent para la entidad Combate.
 *
 * Relaciones:
 *   - belongsTo Pokemon (local)
 *   - belongsTo Pokemon (visitante)
 *
 * Ambas relaciones apuntan a la MISMA tabla (pokemons) con FKs distintas,
 * por eso en cada belongsTo hay que indicar el nombre de la FK manualmente.
 */
class Combate extends Model
{
    use HasFactory;

    /** Por convención Laravel ya busca la tabla 'combates' correctamente. */
    protected $table = 'combates';

    /** Campos asignables en masa. */
    protected $fillable = [
        'pokemon_local_id',
        'pokemon_visitante_id',
        'fecha',
        'resultado',
    ];

    /**
     * El campo 'fecha' se guarda en MySQL como DATE. Esta línea le dice
     * a Laravel que cuando lo leamos desde PHP, lo convierta
     * automáticamente en un objeto Carbon (fecha manejable).
     */
    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * RELACIÓN: el Pokémon LOCAL del combate.
     *
     * Sin segundo argumento, Laravel buscaría la FK 'pokemon_id'.
     * Como aquí se llama 'pokemon_local_id', lo indicamos a mano.
     */
    public function pokemonLocal(): BelongsTo
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_local_id');
    }

    /**
     * RELACIÓN: el Pokémon VISITANTE del combate.
     */
    public function pokemonVisitante(): BelongsTo
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_visitante_id');
    }
}