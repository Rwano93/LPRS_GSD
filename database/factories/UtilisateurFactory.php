<?php

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UtilisateurFactory extends Factory
{
    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'age' => $this->faker->numberBetween(18, 60),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // mot de passe par défaut
            'remember_token' => Str::random(10),
        ];
    }
}

