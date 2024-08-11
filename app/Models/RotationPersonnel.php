<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotationPersonnel extends Model
{
    use HasFactory;

    protected $fillable = ['personnel_id', 'horaire_travail_id', 'date_affectation', 'commentaires'];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function horaire()
    {
        return $this->belongsTo(HoraireTravail::class, 'horaire_travail_id');
    }

}
