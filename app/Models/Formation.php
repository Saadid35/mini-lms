<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'niveau', 'duree'];

    public function chapitres()
    {
        return $this->hasMany(Chapitre::class)->orderBy('ordre');
    }

    public function apprenants()
    {
        return $this->belongsToMany(User::class, 'formation_user')
                    ->withPivot('inscrit_le')
                    ->withTimestamps();
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
