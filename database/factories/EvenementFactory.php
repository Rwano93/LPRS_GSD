<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EvenementFactory extends Factory
{
    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'lieu' => $this->faker->address(),
            'nombre_place' => $this->faker->numberBetween(10, 100),
        ];
    }
}

