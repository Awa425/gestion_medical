<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Providers\ServiceHopitalServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            ['libelle'=> ServiceHopitalServiceProvider::GENERAL],
            ['libelle'=> ServiceHopitalServiceProvider::CARDIOLOGIE],
            ['libelle'=> ServiceHopitalServiceProvider::OPHTALMOLOGIE],
            ['libelle'=> ServiceHopitalServiceProvider::PEDIATRIE],
        ]);
    }
}
