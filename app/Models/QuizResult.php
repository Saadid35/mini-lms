<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizResult extends Model
{
    use HasFactory;

    protected $table = 'quiz_results';

    protected $fillable = ['user_id', 'quiz_id', 'score', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Calcule le pourcentage
    public function getPourcentageAttribute(): float
    {
        return $this->total > 0 ? round(($this->score / $this->total) * 100, 1) : 0;
    }
}
