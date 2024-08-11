<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonnelResource extends JsonResource
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
            'name' => $this->name,
            'prenom' => $this->prenom,
            'date_naissance' => $this->datte_naissance,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'type_personnel' => TypePersonnelResource::make($this->type),
            'date_embauche' => $this->date_embauche,
            'isActive' => $this->isActive,
        ];
    }
}
