<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizResult;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalFormations' => Formation::count(),
            'totalApprenants' => User::where('role', 'apprenant')->count(),
            'totalQuizzes'    => Quiz::count(),
            'derniersResultats' => QuizResult::with(['user', 'quiz'])->latest()->take(10)->get(),
        ]);
    }
}
