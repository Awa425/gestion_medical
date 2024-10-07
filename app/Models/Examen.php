<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type_examen',
        'resultat',
       
    ];

    protected $casts = [
        'type_examen' => 'array',
        'resultat' => 'array',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
