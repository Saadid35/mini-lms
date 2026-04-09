<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('quiz')->latest()->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create(Request $request)
    {
        $quizzes = Quiz::with('sousChapitre')->orderBy('titre')->get();
        $selectedQuiz = $request->get('quiz_id');
        return view('admin.questions.create', compact('quizzes', 'selectedQuiz'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quiz_id'  => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'ordre'    => 'nullable|integer|min:0',
        ]);

        $question = Question::create($data);

        return redirect()->route('admin.questions.show', $question)
                         ->with('success', 'Question créée. Ajoutez maintenant les réponses.');
    }

    public function show(Question $question)
    {
        $question->load('reponses', 'quiz');
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $quizzes = Quiz::with('sousChapitre')->orderBy('titre')->get();
        return view('admin.questions.edit', compact('question', 'quizzes'));
    }

    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'quiz_id'  => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'ordre'    => 'nullable|integer|min:0',
        ]);

        $question->update($data);

        return redirect()->route('admin.quizzes.show', $question->quiz_id)
                         ->with('success', 'Question mise à jour.');
    }

    public function destroy(Question $question)
    {
        $quizId = $question->quiz_id;
        $question->delete();
        return redirect()->route('admin.quizzes.show', $quizId)
                         ->with('success', 'Question supprimée.');
    }

    // Ajouter une réponse à une question
    public function storeReponse(Request $request, Question $question)
    {
        $data = $request->validate([
            'texte'       => 'required|string|max:255',
            'est_correcte' => 'nullable|boolean',
        ]);

        // S'assurer qu'une seule réponse est correcte
        if ($request->boolean('est_correcte')) {
            $question->reponses()->update(['est_correcte' => false]);
        }

        $question->reponses()->create([
            'texte'        => $data['texte'],
            'est_correcte' => $request->boolean('est_correcte'),
        ]);

        return back()->with('success', 'Réponse ajoutée.');
    }

    // Supprimer une réponse
    public function destroyReponse(Reponse $reponse)
    {
        $questionId = $reponse->question_id;
        $reponse->delete();
        return redirect()->route('admin.questions.show', $questionId)
                         ->with('success', 'Réponse supprimée.');
    }
}
