<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'roles' => $this->roles->pluck('libelle'), // Liste des rôles associés
            'personnel' => [
                'id' => $this->personnel->id,
                'name' => $this->personnel->nom,
                'prenom' => $this->personnel->prenom,
                'email' => $this->personnel->email,
                'telephone' => $this->personnel->telephone,
                'adresse' => $this->personnel->adresse,
                'CNI' =>$this->personnel->cni,
                'matricule' =>$this->personnel->matricule,
                'formations' => $this->personnel->formations,
                'certifications' => $this->personnel->certifications,
                'qualifications' => $this->personnel->qualifications,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
