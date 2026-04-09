<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question', 'ordre'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }

    public function bonneReponse()
    {
        return $this->hasOne(Reponse::class)->where('est_correcte', true);
    }
}
