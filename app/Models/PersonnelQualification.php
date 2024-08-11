<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelQualification extends Model
{
    use HasFactory;

    protected $fillable = ['personnel_id', 'qualification_id', 'date_obtention'];

}
