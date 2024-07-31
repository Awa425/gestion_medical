<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        "libelle",
        "isActive"
    ];

    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }
}
