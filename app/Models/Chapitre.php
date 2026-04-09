<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = ['formation_id', 'titre', 'description', 'ordre'];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function sousChapitres()
    {
        return $this->hasMany(SousChapitre::class)->orderBy('ordre');
    }
}
