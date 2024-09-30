<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalleAttente extends Model
{
    use HasFactory;

    // Etat (en attente ou consulter)
     protected $fillable = ['patient_id', 'service_id', 'date_entree', 'etat'];

        public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
