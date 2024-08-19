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
        $personnelAdmin = Categorie::where('libelle', CategorieServiceProvider::PERSONNEL_ADMINISTRATIF)->pluck('id')->first();
        $personnelMedecin = Categorie::where('libelle', CategorieServiceProvider::PERSONNEL_SANTE)->pluck('id')->first();
        TypePersonnel::insert([
            ['libelle'=> TypeServiceProvider::MEDECIN, 'categorie_id'=>$personnelAdmin],
            ['libelle'=> TypeServiceProvider::INFIRMIER, 'categorie_id'=>$personnelMedecin],
            ['libelle'=> TypeServiceProvider::CAISSIER, 'categorie_id'=>$personnelAdmin],
        ]);
    }
}
