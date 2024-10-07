<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FicheEntrepriseFactory extends Factory
{
    public function definition()
    {
        return [
            'nom' => $this->faker->company(),
            'rue' => $this->faker->streetAddress(),
            'code_postal' => $this->faker->postcode(),
            'ville' => $this->faker->city(),
        ];
    }
}

