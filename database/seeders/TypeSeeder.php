<?php

namespace Database\Seeders;

use App\Models\Type;
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
        Type::insert([
            ['libelle'=> TypeServiceProvider::MEDECIN],
            ['libelle'=> TypeServiceProvider::INFIRMIER],
            ['libelle'=> TypeServiceProvider::AIDE_SOIGNANT],
            ['libelle'=> TypeServiceProvider::PARAMEDICAUX],
            ['libelle'=> TypeServiceProvider::BRANCARDIER],
            ['libelle'=> TypeServiceProvider::AMBULANCIER],
            ['libelle'=> TypeServiceProvider::TECHNICIEN_DE_SURFACE],
            ['libelle'=> TypeServiceProvider::SECRETAIRE],
            ['libelle'=> TypeServiceProvider::COMPTABLE],
            ['libelle'=> TypeServiceProvider::CAISSIER],
            ['libelle'=> TypeServiceProvider::AGENT_SECURITE],
            ['libelle'=> TypeServiceProvider::ACCUEIL],
            ['libelle'=> TypeServiceProvider::DG],
            ['libelle'=> TypeServiceProvider::DRG]
        ]);
    }
}
