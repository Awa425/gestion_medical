<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specialite extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom",
        "isActive"
    ];

     public function hopitals():BelongsToMany
    {
        return $this->belongsToMany(Hopital::class);
    }
}
