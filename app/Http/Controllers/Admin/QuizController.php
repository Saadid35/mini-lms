<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['sousChapitre.chapitre.formation', 'questions'])->latest()->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create(Request $request)
    {
        $sousChapitres = SousChapitre::with('chapitre.formation')->orderBy('titre')->get();
        $selectedSousChapitre = $request->get('sous_chapitre_id');
        return view('admin.quizzes.create', compact('sousChapitres', 'selectedSousChapitre'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
            'titre'            => 'required|string|max:255',
            'description'      => 'nullable|string',
        ]);

        $quiz = Quiz::create($data);

        return redirect()->route('admin.quizzes.show', $quiz)
                         ->with('success', 'Quiz créé. Ajoutez maintenant les questions.');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['sousChapitre.chapitre.formation', 'questions.reponses']);
        return view('admin.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        $sousChapitres = SousChapitre::with('chapitre.formation')->orderBy('titre')->get();
        return view('admin.quizzes.edit', compact('quiz', 'sousChapitres'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
            'titre'            => 'required|string|max:255',
            'description'      => 'nullable|string',
        ]);

        $quiz->update($data);

        return redirect()->route('admin.quizzes.show', $quiz)
                         ->with('success', 'Quiz mis à jour.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')
                         ->with('success', 'Quiz supprimé.');
    }
}
