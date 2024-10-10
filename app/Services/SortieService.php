<?php
namespace App\Services;

use App\Models\Sortie;
use Illuminate\Support\Facades\DB;

class SortieService
{
    public function creerSortie(array $data)
    {
        return DB::transaction(function() use ($data) {
            $sortie = Sortie::create([
                'admission_id' => $data['admission_id'],
                'date_sortie' => now(),
                'motif_sortie' => $data['motif_sortie'],
                'etat_sortie' => $data['etat_sortie'],
            ]);

            return $sortie->load('admission');
        });
    }
}