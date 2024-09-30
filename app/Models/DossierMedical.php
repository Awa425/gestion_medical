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

    // le dossier peut être mis à jour lors des consultations
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
