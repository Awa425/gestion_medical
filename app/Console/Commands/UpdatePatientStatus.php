<?php

namespace App\Console\Commands;

use App\Models\SalleAttente;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePatientStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patients:update-status';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour l\'état des patients qui ne sont pas consultés après 24 heures';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Mettre à jour les patients dont l'état est encore "en attente" après 24h
         SalleAttente::where('etat', 'en attente')
         ->where('created_at', '<', Carbon::now()->subDay()) // Vérifie si 24h sont écoulées
         ->update(['etat' => 'non consulté']);

     $this->info('Mise à jour des patients non consultés terminée.');
    }
}
