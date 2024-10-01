<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        "libelle",
        "isActive"
    ];

    public function salleAttente()
    {
        return $this->hasMany(SalleAttente::class, 'service_id');
    }
    public function specialites(): HasMany
    {
        return $this->hasMany(Specialite::class);
    }
}
