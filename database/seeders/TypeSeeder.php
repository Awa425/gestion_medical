<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Type;
use App\Providers\ProfileServiceProvider;
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
        $admin = Profile::where('libelle', ProfileServiceProvider::PERSONNEL_ADMINISTRATIF)->pluck('id')->first();
        $sante = Profile::where('libelle', ProfileServiceProvider::PERSONNEL_SANTE)->pluck('id')->first();

        Type::insert([
            ['libelle'=> TypeServiceProvider::MEDECIN,'profile_id' => $sante],
            ['libelle'=> TypeServiceProvider::INFIRMIER,'profile_id'=> $sante],
            ['libelle'=> TypeServiceProvider::DG,'profile_id'=> $admin],
        ]);
    }
}
