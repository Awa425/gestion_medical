<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedecinResource extends JsonResource
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
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'genre' => $this->genre,
            'telephone' => $this->telephone,
            'user_id' => UserResource::make($this->user) ,
            'role_id' => RoleResource::make($this->role) ,
            'is_active' => $this->is_active,


        ];    }
}
