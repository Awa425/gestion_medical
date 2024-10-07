<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'resultat',
        'traitement',
       
    ];

    protected $casts = [
        'resultat' => 'array',
        'traitement' => 'array',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
