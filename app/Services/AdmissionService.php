<?php
namespace App\Services;

use App\Models\Admission;
use Illuminate\Support\Facades\DB;

namespace App\Services;

use App\Models\Admission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdmissionService
{
    public function creerAdmission(array $data)
    {
        return DB::transaction(function() use ($data) {
            $admission = Admission::create([
                'dossierMedical_id' => $data['dossierMedical_id'],
                'service_id' => $data['service_id'],
                'date_admission' =>  $data['date_admission'] ?? now(),
                'motif_admission' => $data['motif_admission'],
                'etat_admission' => 'en cours',
            ]);

            return $admission->load('dossierMedical', 'service');
        });
    }

    public function showDetailAdmission($id)
    {
        $admission = Admission::find($id);
        return $admission;
  
        // if (is_null($admission)) {
        //     return response()->json([
        //         'message' => 'Admission not found.',  
        //     ], 400);        }
   
            // return response()->json([
            //     'message' => 'Admission trouvé.',  
            //     'data'=>$admission
            // ], 201);  
    }
}

