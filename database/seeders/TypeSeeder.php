<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\TypePersonnel;
use App\Providers\CategorieServiceProvider;
use App\Providers\TypeServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personnelAdmin = Categorie::where('libelle', CategorieServiceProvider::ADMINISTRATIF)->pluck('id')->first();
        $personnelMedecin = Categorie::where('libelle', CategorieServiceProvider::SANTE)->pluck('id')->first();
        $personnelSecurite = Categorie::where('libelle', CategorieServiceProvider::SECURITE)->pluck('id')->first();
        $personnelSoutient = Categorie::where('libelle', CategorieServiceProvider::SOUTIENT)->pluck('id')->first();
        TypePersonnel::insert([
            ['libelle'=> TypeServiceProvider::PERSONNEL_ADMINISTRATIF, 'categorie_id'=>$personnelAdmin],
            ['libelle'=> TypeServiceProvider::PERSONNEL_SANTE, 'categorie_id'=>$personnelMedecin],
            ['libelle'=> TypeServiceProvider::PERSONNEL_SECURITE, 'categorie_id'=>$personnelSecurite],
            ['libelle'=> TypeServiceProvider::PERSONNEL_SOUTIENT, 'categorie_id'=>$personnelSoutient],
        ]);
    }
    
}
