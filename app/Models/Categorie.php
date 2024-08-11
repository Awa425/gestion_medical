<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "libelle",
        "isActive"
    ];

    public function typePersonnels(): HasMany
    {
        return $this->hasMany(TypePersonnel::class);
    }
}
