<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id, 
            "libelle" => ucfirst($this->libelle), 
            'profile_id' =>  ProfileResource::make($this->profile),
            "isActive" => $this->isActive, 

        ];
    }
}
