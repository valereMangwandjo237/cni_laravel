<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immatriculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'prenom',
        'lieu_naissance',
        'date_naissance',
        'numero_cni',
        'status'
    ];

    public function images(){
        return $this->hasMany(Image::class, 'immat_id');
    }
}
