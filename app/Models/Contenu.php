<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contenu extends Model
{
    use HasFactory;

    protected $fillable = ['sous_chapitre_id', 'titre', 'texte', 'lien_ressource', 'importe_ia'];

    protected $casts = [
        'importe_ia' => 'boolean',
    ];

    public function sousChapitre()
    {
        return $this->belongsTo(SousChapitre::class, 'sous_chapitre_id');
    }
}
