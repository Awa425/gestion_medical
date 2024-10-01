<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalleAttente extends Model
{
    use HasFactory;

    // Etat (en attente ou consulter)
     protected $fillable = ['patient_id', 'service_id', 'date_entree', 'etat'];

     public function patient()
     {
         return $this->belongsTo(Patient::class, 'patient_id');
     }
 
     public function service()
     {
         return $this->belongsTo(Service::class, 'service_id');
     }
}
