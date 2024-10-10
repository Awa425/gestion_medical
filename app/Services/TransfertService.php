<?php
namespace App\Services;

use App\Models\Transfere;
use Illuminate\Support\Facades\DB;

class TransfertService
{
    public function creerTransfert(array $data)
    {
        return DB::transaction(function() use ($data) {
            $transfert = Transfere::create([
                'dossierMedical_id' => $data['dossierMedical_id'],
                'from_service_id' => $data['from_service_id'],
                'to_service_id' => $data['to_service_id'],
                'date_transfert' => now(),
                'motif_transfert' => $data['motif_transfert'],
            ]);

            return $transfert->load('dossierMedical', 'fromService', 'toService');
        });
    }
}
