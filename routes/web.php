<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Apprenant;

/*
|--------------------------------------------------------------------------
| Route publique — redirige selon le rôle
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('apprenant.dashboard');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Routes Admin (authentifié + rôle admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Générateur de contenu IA
    Route::get('/ai-generator', [Admin\AiGeneratorController::class, 'index'])->name('ai-generator');
    Route::post('/ai-generator', [Admin\AiGeneratorController::class, 'generate'])->name('ai-generator.generate');

    // Formations + inscription des apprenants
    Route::resource('formations', Admin\FormationController::class);
    Route::post('formations/{formation}/inscrire', [Admin\FormationController::class, 'inscrire'])->name('formations.inscrire');
    Route::delete('formations/{formation}/desinscrire/{user}', [Admin\FormationController::class, 'desinscrire'])->name('formations.desinscrire');

    // Chapitres
    Route::resource('chapitres', Admin\ChapitreController::class);

    // Sous-chapitres
    Route::resource('sous-chapitres', Admin\SousChapitreController::class);

    // Contenus pédagogiques
    Route::resource('contenus', Admin\ContenuController::class);

    // Quiz
    Route::resource('quizzes', Admin\QuizController::class);

    // Questions + réponses
    Route::resource('questions', Admin\QuestionController::class);
    Route::post('questions/{question}/reponses', [Admin\QuestionController::class, 'storeReponse'])->name('questions.reponses.store');
    Route::delete('reponses/{reponse}', [Admin\QuestionController::class, 'destroyReponse'])->name('reponses.destroy');

    // Apprenants
    Route::get('apprenants', [Admin\ApprenantController::class, 'index'])->name('apprenants.index');
    Route::get('apprenants/{user}', [Admin\ApprenantController::class, 'show'])->name('apprenants.show');

    // Notes
    Route::resource('notes', Admin\NoteController::class);
});

/*
|--------------------------------------------------------------------------
| Routes Apprenant (authentifié + rôle apprenant)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'apprenant'])->prefix('apprenant')->name('apprenant.')->group(function () {

    Route::get('/dashboard', [Apprenant\DashboardController::class, 'index'])->name('dashboard');

    // Mes formations et contenus
    Route::get('/formations', [Apprenant\FormationController::class, 'index'])->name('formations.index');
    Route::get('/formations/{formation}', [Apprenant\FormationController::class, 'show'])->name('formations.show');
    Route::get('/sous-chapitres/{sousChapitre}', [Apprenant\FormationController::class, 'sousChapitre'])->name('sous-chapitres.show');

    // Quiz
    Route::get('/quiz/{quiz}', [Apprenant\QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quiz}/soumettre', [Apprenant\QuizController::class, 'soumettre'])->name('quiz.soumettre');
    Route::get('/quiz/{quiz}/resultat/{result}', [Apprenant\QuizController::class, 'resultat'])->name('quiz.resultat');

    // Mes notes
    Route::get('/notes', [Apprenant\NoteController::class, 'index'])->name('notes.index');
});

// Routes profil Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
