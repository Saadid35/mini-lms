<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $formations = $user->formations()->withCount('chapitres')->get();
        $notes      = $user->notes()->with('formation')->latest()->take(5)->get();
        $resultats  = $user->quizResults()->with('quiz.sousChapitre')->latest()->take(5)->get();

        return view('apprenant.dashboard', compact('formations', 'notes', 'resultats'));
    }
}
