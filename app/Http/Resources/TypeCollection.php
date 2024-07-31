<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id, 
            "libelle" => ucfirst($this->libelle), 
            'profile_id' =>  ProfileResource::make($this->id),
            "isActive" => $this->isActive, 

        ];
        // return parent::toArray($request);
    }
}
