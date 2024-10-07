<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;


class UtilisateurSeeder extends Seeder
{
    public function run()
    {
       
        Utilisateur::factory(10)->create();
    }
}
