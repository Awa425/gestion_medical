<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Providers\CategorieServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categorie::insert([
            ['libelle'=> CategorieServiceProvider::ADMINISTRATIF],
            ['libelle'=> CategorieServiceProvider::SANTE],
            ['libelle'=> CategorieServiceProvider::SECURITE],
            ['libelle'=> CategorieServiceProvider::SOUTIENT],
        ]);
    }
}
