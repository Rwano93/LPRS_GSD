<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReponseFactory extends Factory
{
    public function definition()
    {
        return [
            'contenue' => $this->faker->paragraph(),
            'date_reponse' => $this->faker->date(),
            'id_post' => \App\Models\Post::factory(), // Association avec un post
        ];
    }
}

