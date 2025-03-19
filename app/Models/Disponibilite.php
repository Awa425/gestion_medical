<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    use HasFactory;
    protected $fillable = ['medecin_id', 'date', 'heure', 'est_disponible'];

    public function medecin()
    {
        return $this->belongsTo(Personnel::class, 'medecin_id');
    }
}
