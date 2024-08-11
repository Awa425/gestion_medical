<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoraireTravail extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'heure_debut', 'heure_fin', 'type_horaire'];

    public function rotations()
    {
        return $this->hasMany(RotationPersonnel::class);
    }

}
