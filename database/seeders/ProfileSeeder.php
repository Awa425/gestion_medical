<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Providers\ProfileServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Profile::insert([
            ['libelle'=> ProfileServiceProvider::PERSONNEL_ADMINISTRATIF],
            ['libelle'=> ProfileServiceProvider::PERSONNEL_SANTE],
            ['libelle'=> ProfileServiceProvider::PERSONNEL_SOUTIENT],
        ]);
        
    }
}
