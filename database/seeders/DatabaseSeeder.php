<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UtilisateurSeeder;
use Database\Seeders\FicheEntrepriseSeeder;
use Database\Seeders\OffreSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\ReponseSeeder;
use Database\Seeders\EvenementSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UtilisateurSeeder::class,
            FicheEntrepriseSeeder::class,
            OffreSeeder::class,
            PostSeeder::class,
            ReponseSeeder::class,
            EvenementSeeder::class,
        ]);
    }
}

