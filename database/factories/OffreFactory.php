<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OffreFactory extends Factory
{
    public function definition()
    {
        return [
            'CV' => $this->faker->word() . '.pdf',
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['stage', 'CDD', 'CDI']),
            'etat' => $this->faker->randomElement(['ouverte', 'clôturée']),
            'id_entreprise' => \App\Models\FicheEntreprise::factory(), // Association automatique avec une entreprise
        ];
    }
}

