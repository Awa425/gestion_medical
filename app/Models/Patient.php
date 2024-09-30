<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'prenom', 'date_naissance', 'adresse', 
        'telephone', 'email', 'sexe', 'groupe_sanguin','matricule'
    ];

    public function dossierMedical()
    {
        return $this->hasOne(DossierMedical::class);
    }
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
    public function salleAttente()
    {
        return $this->belongsTo(SalleAttente::class);
    }
}
