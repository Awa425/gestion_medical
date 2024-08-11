<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = ['nom_certification', 'organisme_delivrant', 'date_obtention', 'date_expiration'];

    public function personnel()
    {
        return $this->belongsToMany(Personnel::class, 'personnel_certifications');
    }
}
