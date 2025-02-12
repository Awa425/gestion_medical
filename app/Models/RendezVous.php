<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;
    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'service_id',
        'date_heure',
        'statut',
        'motif',
    ];

    // Relation avec Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }

    // Relation avec Médecin
    public function medecin()
    {
        return $this->belongsTo(Personnel::class,'medecin_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    
}
