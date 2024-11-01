<?php
namespace App\Services;

use App\Models\Certification;
use App\Models\Formation;
use App\Models\Personnel;
use App\Models\Qualification;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PersonnelService{
    private function generateMatricule()
    {
        $prefix = "PERS_";
        $timestamp = now()->format('YmdHis');
        
        return $prefix . $timestamp ;
    }

    public function createPersonnelWithDetails(array $data){
         
            return DB::transaction(function() use ($data) {

                $matricule = $this->generateMatricule();

                $data['personnel']['matricule'] = $matricule;
                
                $personnel = Personnel::create($data['personnel']);

                if (isset($data['user'])) {
                    $userData = $data['user'];
                    $user=User::create([
                        'email' => $data['user']['email'],
                        'password' => bcrypt($data['user']['password']),
                        'personnel_id' => $personnel->id,
                    ]);
                    
                    if (isset($userData['roles'])) {
                        $user->roles()->sync($userData['roles']);
                    }
                } 
    
                if (isset($data['qualifications'])) {
                    foreach ($data['qualifications'] as $qualificationData) {
                        $qualification = Qualification::firstOrCreate(
                            ['nom_qualification' => $qualificationData['nom_qualification']],
                            ['description' => $qualificationData['description'] ?? null,]

                        );
    
                        $personnel->qualifications()->attach($qualification->id, [
                            'date_obtention' => $qualificationData['date_obtention'] ?? null,
                        ]);
                    }
                }
                if (isset($data['formations'])) {
                    foreach ($data['formations'] as $formationData) {
                        $formation = Formation::firstOrCreate(
                            ['nom_formation' => $formationData['nom_formation']],
                            [
                                'organisme_formateur' => $formationData['organisme_formateur'] ?? null,
                                'date_debut' => $formationData['date_debut'] ?? null,
                                'statut' => $formationData['statut'] ?? null,
                            ]
                            );
                            
                            $personnel->formations()->attach($formation->id, [
                                'date_inscription' => $formationData['date_inscription'] ?? null
                            ]);                 
                    }
                }

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
    
                return $personnel->load('type','user','service');
            });
    
        
    }

    public function updatePersonnelWithDetails(Personnel $personnel, array $data)
    {  
        return DB::transaction(function() use ($personnel, $data) {

            // Mettre à jour les informations du personnel
            $personnel->update($data['personnel']);

              // Mettre à jour l'utilisateur associé
            if (isset($data['user'])) {
                $userData = $data['user'];
                $user = $personnel->user;

                // Si l'utilisateur n'existe pas, on le crée
                if (!$user) {
                    $user = User::create([
                        'email' => $userData['email'],
                        'password' => bcrypt($userData['password']),
                        'personnel_id' => $personnel->id,
                    ]);
                } else {
                   if (isset($userData['email'])) {
                        $user->update([
                            'email' => $userData['email'],
                            'password' => isset($userData['password']) ? bcrypt($userData['password']) : $user->password,
                        ]);
                   }
                }

                // Assigner les rôles à l'utilisateur
                if (isset($userData['roles'])) {

                    // Récupérer les rôles actuels de l'utilisateur
                    $currentRoles = $user->roles()->pluck('roles.id')->toArray();

                     // Rôles à ajouter
                    $rolesToAdd = array_diff($userData['roles'], $currentRoles);

                     // Rôles à supprimer
                    $rolesToRemove = array_diff($currentRoles, $userData['roles']);

                      // Ajouter les nouveaux rôles
                    if (!empty($rolesToAdd)) {
                        $user->roles()->attach($rolesToAdd);
                    }

                      // Supprimer les anciens rôles
                    if (!empty($rolesToRemove)) {
                        $user->roles()->detach($rolesToRemove);
                    }
                }
            }

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
                            'date_debut' => $formationData['date_debut'] ?? null,
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

            return $personnel->load('user','service','qualifications', 'formations', 'certifications');
        });
    }

}

