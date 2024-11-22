<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'numero_dossier' ,'antecedents', 'diagnostics', 
        'traitements', 'prescriptions'
    ];

    protected $casts = [
        'antecedents' => 'array',
        'diagnostics' => 'array',
        'traitements' => 'array',
        'prescriptions' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class,'dossierMedical_id');
    }

    public function transferts()
    {
        return $this->hasMany(Transfere::class,'dossierMedical_id');
    }

    public function sorties()
    {
        return $this->hasMany(Sortie::class,'dossierMedical_id');
    }

    // le dossier peut être mis à jour lors des consultations
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
