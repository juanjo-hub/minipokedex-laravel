<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para la entidad Entrenador.
 *
 * Genera entrenadores con datos aleatorios realistas usando Faker.
 * Se usa desde el DatabaseSeeder o desde los tests de UT4.
 */
class EntrenadorFactory extends Factory
{
    /**
     * Define los valores por defecto de un nuevo entrenador.
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'ciudad' => fake()->city(),
            'edad'   => fake()->numberBetween(10, 60),
        ];
    }
}