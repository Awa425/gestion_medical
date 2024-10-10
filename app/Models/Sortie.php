<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    use HasFactory;
    protected $fillable = [ 'admission_id','date_sortie', 'motif_sortie', 'etat_sortie'];

    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

}
