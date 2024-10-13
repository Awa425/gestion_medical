<?php
namespace App\Services;

use App\Models\Admission;
use App\Models\Sortie;
use Illuminate\Support\Facades\DB;

class SortieService
{
    public function __construct(private AdmissionService $admissionService){}

    public function creerSortie(array $data)
    {
        
        return DB::transaction(function() use ($data) {
            $res= $this->admissionService->showDetailAdmission($data['admission_id'])->__get('etat_admission');
            if($res =='en cours'){
                $sortie = Sortie::create([
                    'admission_id' => $data['admission_id'],
                    'date_sortie' => now(),
                    'motif_sortie' => $data['motif_sortie'],
                    'etat_sortie' => $data['etat_sortie'],
                ]);
                $sortie->admission->update([
                    'etat_admission'=>'termine'
                ]);
                return response()->json([
                    'sortie' => $sortie->load('admission'),
                ], 201);
            }
            else{
                return response()->json([
                    'message' => 'Admission etait terminée.',
                   
                ]);
            }


            // return $sortie->load('admission');
        });
    }
}