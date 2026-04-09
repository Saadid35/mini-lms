<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = ['sous_chapitre_id', 'titre', 'description'];

    public function sousChapitre()
    {
        return $this->belongsTo(SousChapitre::class, 'sous_chapitre_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('ordre');
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }
}
