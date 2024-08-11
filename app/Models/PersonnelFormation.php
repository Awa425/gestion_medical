<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelFormation extends Model
{
    use HasFactory;

    protected $fillable = ['personnel_id', 'formation_id', 'date_inscription'];

}
