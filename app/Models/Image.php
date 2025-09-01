<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['immat_id', 'type', 'path', "nature"];

    public function immatriculation(){
        return $this->belongsTo(Immatriculation::class, 'immat_id');
    }

}
