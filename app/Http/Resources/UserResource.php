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
            'name' => $this->name,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'adresse' => $this->telephone,
            'telephone' => $this->adresse,
            'email_verified_at' => $this->email_verified_at,
            'type_id' =>  TypeResource::make($this->type),
            'isActive' => $this->isActive,
          ];
    }
}
