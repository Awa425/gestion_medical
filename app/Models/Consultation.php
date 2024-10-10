<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'dossier_medical_id', 
        "libelle",
        "date_consultation",
        "notes",
        "isActive"
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Personnel::class, 'medecin_id');
    }

    public function diagnostics()
    {
        return $this->hasMany(Diagnostic::class);
    }

    public function admission()
    {
        return $this->hasOne(Admission::class);
    }
    public function examens()
    {
        return $this->hasMany(Examen::class);
    }


}
