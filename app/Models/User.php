<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helpers de rôle
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isApprenant(): bool
    {
        return $this->role === 'apprenant';
    }

    // Relations
    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'formation_user')
                    ->withPivot('inscrit_le')
                    ->withTimestamps();
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
