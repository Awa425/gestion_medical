<?php

namespace App\Models;

use App\Providers\RoleServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Medecin extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'prenom',
        'adresse',
        'telephone',
        'email',
        'password',
        'role_id',
        'user_id',
        'isActive'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function isMedecin($medecin): bool
    {
        return $medecin->role->libelle === RoleServiceProvider::MEDECIN;
    }
}
