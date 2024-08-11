<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = ['nom_qualification', 'description'];

    public function personnel()
    {
        return $this->belongsToMany(Personnel::class, 'personnel_qualifications');
    }

}
