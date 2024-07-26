<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\User;
use App\Providers\TypeServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userAdmin = Type::where('libelle', TypeServiceProvider::ADMIN)->pluck('id')->first();
        User::factory()->create([
            'name' => 'Admin',
            'prenom' => 'Admin',
            'telephone' => '778338123',
            'email' => 'admin@gmail.com',
            'adresse' => 'Dakar',
            'type_id' => $userAdmin,
        ]);
    }
}
