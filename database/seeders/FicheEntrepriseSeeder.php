<?php

namespace Database\Seeders;

use App\Models\FicheEntreprise;
use Illuminate\Database\Seeder;

class FicheEntrepriseSeeder extends Seeder
{
    public function run()
    {
        // Crée 5 entreprises
        FicheEntreprise::factory(5)->create();
    }
}

