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

        public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function transfertsFrom()
    {
        return $this->hasMany(Transfere::class, 'from_service_id');
    }

    public function transfertsTo()
    {
        return $this->hasMany(Transfere::class, 'to_service_id');
    }

    public function salleAttente()
    {
        return $this->hasMany(SalleAttente::class, 'service_id');
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
    public function specialites(): HasMany
    {
        return $this->hasMany(Specialite::class);
    }
}
