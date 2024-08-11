<?php

namespace Database\Seeders;

use App\Models\TypePersonnel;
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
        TypePersonnel::insert([
            ['libelle'=> TypeServiceProvider::MEDECIN],
            ['libelle'=> TypeServiceProvider::INFIRMIER],
            ['libelle'=> TypeServiceProvider::CAISSIER],
        ]);
    }
}
