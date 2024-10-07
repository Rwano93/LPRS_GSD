<?php

namespace Database\Seeders;

use App\Models\Reponse;
use Illuminate\Database\Seeder;

class ReponseSeeder extends Seeder
{
    public function run()
    {
        // Crée 30 réponses
        Reponse::factory(30)->create();
    }
}
