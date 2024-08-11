<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = ['nom_formation', 'organisme_formateur', 'date_debut', 'date_fin', 'statut'];

    public function personnel()
    {
        return $this->belongsToMany(Personnel::class, 'personnel_formations');
    }
}
