<?php

namespace Database\Seeders;

use App\Models\Offre;
use Illuminate\Database\Seeder;

class OffreSeeder extends Seeder
{
    public function run()
    {
        // Crée 10 offres
        Offre::factory(10)->create();
    }
}

