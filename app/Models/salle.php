<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salle extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'capacite', 'lits_restants' ,'disponible', 'service_id'];

      public function service()
      {
          return $this->belongsTo(Service::class);
      }
  
      public function admissions()
      {
          return $this->hasMany(Admission::class);
      }

}
