<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Admission extends Model
{
    use HasFactory;
    protected $fillable = ['dossierMedical_id','consultation_id', 'service_id', 'date_admission', 'motif_admission', 'etat_admission'];

    public function dossierMedical()
    {
        return $this->belongsTo(DossierMedical::class, 'dossierMedical_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function consultation(){
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }

    public function sortie(){
        return $this->hasOne(Sortie::class);

    }
}
