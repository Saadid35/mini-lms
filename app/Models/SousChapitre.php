<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SousChapitre extends Model
{
    use HasFactory;

    protected $table = 'sous_chapitres';

    protected $fillable = ['chapitre_id', 'titre', 'contenu', 'ordre'];

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }

    public function contenus()
    {
        return $this->hasMany(Contenu::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }
}
