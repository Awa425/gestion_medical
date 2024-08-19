<?php
namespace App\Services;

use App\Models\Certification;
use App\Models\Formation;
use App\Models\Personnel;
use App\Models\Qualification;
use Illuminate\Support\Facades\DB;

class PersonnelService{

// Creation de personnel avec ou sans les details(qualification, formation ou certification)
    public function createPersonnelWithDetails(array $data){

            return DB::transaction(function() use ($data) {
                
                // Créer le personnel
                $personnel = Personnel::create($data['personnel']);
    
                // Assigner ou créer les qualifications
                if (isset($data['qualifications'])) {
                    foreach ($data['qualifications'] as $qualificationData) {
                        $qualification = Qualification::firstOrCreate(
                            ['nom_qualification' => $qualificationData['nom_qualification']],
                            ['description' => $qualificationData['description'] ?? null,]

                        );
    
                        // Lier la qualification au personnel
                        $personnel->qualifications()->attach($qualification->id, [
                            'date_obtention' => $qualificationData['date_obtention'] ?? null,
                        ]);
                    }
                }
                // Assigner ou créer les formations
                if (isset($data['formations'])) {
                    foreach ($data['formations'] as $formationData) {
                        $formation = Formation::firstOrCreate(
                            ['nom_formation' => $formationData['nom_formation']],
                            [
                                'organisme_formateur' => $formationData['organisme_formateur'] ?? null,
                                'date_debut' => $formationData['date_fin'] ?? null,
                                'statut' => $formationData['statut'] ?? null,
                            ]
                            );
                            
                            // Lier la formation au personnel
                            $personnel->formations()->attach($formation->id, [
                                'date_inscription' => $formationData['date_inscription'] ?? null
                            ]);                 
                    }
                }

                 // Assigner ou créer les certification
                 if (isset($data['certifications'])) {
                    foreach ($data['certifications'] as $certificationData) { 
                        $certification = Certification::firstOrCreate(
                            ['nom_certification' => $certificationData['nom_certification']],
                            [
                                'organisme_delivrant' => $certificationData['organisme_delivrant'] ?? null,
                                'date_obtention' => $certificationData['date_obtention'] ?? null,
                                'date_expiration' => $certificationData['date_expiration'] ?? null,
                            ]
                        );
                        // Lier la formation au personnel
                        $personnel->certifications()->attach($certification->id, [
                            'date_obtention' => $certificationData['date_obtention'] ?? null
                        ]);
                    }
                }
    
                return $personnel->load('type','qualifications', 'formations', 'certifications');
            });
    
        
    }

    // Méthode pour mettre à jour un personnel avec ses qualifications et formations
    public function updatePersonnelWithDetails(Personnel $personnel, array $data)
    {
        return DB::transaction(function() use ($personnel, $data) {
            // Mettre à jour les informations du personnel
            $personnel->update($data['personnel']);

            // Mettre à jour les qualifications
            if (isset($data['qualifications'])) {
                foreach ($data['qualifications'] as $qualificationData) {
                    $qualification = Qualification::firstOrCreate(
                        ['nom_qualification' => $qualificationData['nom_qualification']],
                        ['description' => $qualificationData['description'] ?? null,]
                    );
                    
                    $personnel->qualifications()->attach($qualification->id, [
                        'date_obtention' => $qualificationData['date_obtention'] ?? null
                    ]);
                }
            }

            // Mettre à jour les formations
            if (isset($data['formations'])) {
                foreach ($data['formations'] as $formationData) {
                    $formation = Formation::firstOrCreate(
                        ['nom_formation' => $formationData['nom_formation']],
                        [
                            'organisme_formateur' => $formationData['organisme_formateur'] ?? null,
                            'date_debut' => $formationData['date_fin'] ?? null,
                            'statut' => $formationData['statut'] ?? null,
                        ]
                    );

                    $personnel->formations()->attach($formation->id, [
                        'date_inscription' => $formationData['date_inscription'] ?? null
                    ]);
                }
            }

             // Mettre à jour les certifications
             if (isset($data['certifications'])) {
                foreach ($data['certifications'] as $certificationData) {
                    $certification = Certification::firstOrCreate(
                        ['nom_certification' => $certificationData['nom_certification']],
                        [
                            'organisme_delivrant' => $certificationData['organisme_delivrant'] ?? null,
                            'date_obtention' => $certificationData['date_obtention'] ?? null,
                            'date_expiration' => $certificationData['date_expiration'] ?? null,
                        ]
                    );

                    $personnel->certifications()->attach($certification->id, [
                        'date_obtention' => $certificationData['date_obtention'] ?? null
                    ]);
                }
            }

            return $personnel->load('qualifications', 'formations', 'certifications');
        });
    }

}

