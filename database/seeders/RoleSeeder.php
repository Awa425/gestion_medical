<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Providers\RoleServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['libelle'=> RoleServiceProvider::ADMIN],
            ['libelle'=> RoleServiceProvider::ASSISTANT],
            ['libelle'=> RoleServiceProvider::MEDECIN],
            ['libelle'=> RoleServiceProvider::SECRETAIRE],
        ]);
    }
}
