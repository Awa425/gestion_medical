<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfere extends Model
{
    use HasFactory;
    protected $fillable = ['dossierMedical_id', 'from_service_id', 'to_service_id', 'date_transfert', 'motif_transfert'];

    public function dossierMedical()
    {
        return $this->belongsTo(DossierMedical::class, 'dossierMedical_id');
    }

    public function fromService()
    {
        return $this->belongsTo(Service::class, 'from_service_id'); 
    }

    public function toService()
    {
        return $this->belongsTo(Service::class, 'to_service_id');
    }
}
