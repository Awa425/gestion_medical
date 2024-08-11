<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypePersonnel extends Model
{
    use HasFactory;

    protected $fillable = ['id','libelle', 'categorie_id'];

    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }

        public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
