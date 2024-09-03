<?php

namespace Database\Seeders;

use App\Models\Personnel;
use App\Models\Role;
use App\Providers\RoleServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personnelAdmin = Role::where('libelle', RoleServiceProvider::ADMIN)->pluck('id')->first();
        $pMedecin = Role::where('libelle', RoleServiceProvider::MEDECIN)->pluck('id')->first();
        $Infirmier = Role::where('libelle', RoleServiceProvider::INFIRMIER)->pluck('id')->first();

        Personnel::factory()->create([
            'name' => 'Diop',
            'prenom' => 'Awa',
            'email' => 'admin@gmail.com',
            'telephone' => '778338123',
            'adresse' => 'Dakar',
            'role_id' => $personnelAdmin,
        ]);

        Personnel::factory()->create([
            'name' => 'Diop',
            'prenom' => 'Diarra',
            'email' => 'medecin@gmail.com',
            'telephone' => '778338123',
            'adresse' => 'Dakar',
            'role_id' => $pMedecin,
        ]);

        Personnel::factory()->create([
            'name' => 'Ba',
            'prenom' => 'Oumy',
            'email' => 'infirmier@gmail.com',
            'telephone' => '778338123',
            'adresse' => 'Dakar',
            'role_id' => $Infirmier,
        ]);
    }
}
