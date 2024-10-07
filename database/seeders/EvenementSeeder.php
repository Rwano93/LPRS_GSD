<?php

namespace Database\Seeders;

use App\Models\Evenement;
use Illuminate\Database\Seeder;

class EvenementSeeder extends Seeder
{
    public function run()
    {
        // Crée 5 événements
        Evenement::factory(5)->create();
    }
}
