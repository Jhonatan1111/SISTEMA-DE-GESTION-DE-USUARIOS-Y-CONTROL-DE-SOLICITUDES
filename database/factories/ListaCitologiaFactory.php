<?php

namespace Database\Factories;

use App\Models\ListaCitologia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ListaCitologia>
 */

class ListaCitologiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => ListaCitologia::generarCodigoLista(),
            'diagnostico' => fake()->sentence(),
            'macroscopico' => fake()->sentence(),
            'microscopico' => fake()->sentence(),
        ];
    }
}
