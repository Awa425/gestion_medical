<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hopital extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom",
        "adresse",
        "telephone",
        "isActive",

    ];

    public function specialties():BelongsToMany
    {
        return $this->belongsToMany(Specialite::class);
    }
}
