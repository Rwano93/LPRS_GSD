<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(),
            'contenue' => $this->faker->paragraph(),
            'date_poste' => $this->faker->date(),
            'canal' => $this->faker->randomElement(['général', 'alumni', 'étudiants']),
            'id_utilisateur' => \App\Models\Utilisateur::factory(), // Association avec un utilisateur
        ];
    }
}

