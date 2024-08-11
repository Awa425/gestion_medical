<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'prenom',
        'date_naissance', 
        'adresse', 
        'telephone',
        'matricule', 
        'CNI', 
        'date_naissance', 
        'lieu_naissance', 
        'email', 
        'type_personnel_id', 
        'date_embauche', 
        'isActive'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function type()
    {
        return $this->belongsTo(TypePersonnel::class, 'type_personnel_id');
    }

    public function rotations()
    {
        return $this->hasMany(RotationPersonnel::class);
    }

    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class, 'personnel_qualifications');
    }

    public function certifications()
    {
        return $this->belongsToMany(Certification::class, 'personnel_certifications');
    }

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'personnel_formation');
    }

}
