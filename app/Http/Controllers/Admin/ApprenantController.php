<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class ApprenantController extends Controller
{
    public function index()
    {
        $apprenants = User::where('role', 'apprenant')
                          ->withCount('formations')
                          ->latest()
                          ->get();
        return view('admin.apprenants.index', compact('apprenants'));
    }

    public function show(User $user)
    {
        $user->load(['formations.chapitres', 'notes.formation', 'quizResults.quiz']);
        return view('admin.apprenants.show', compact('user'));
    }
}
