<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Affiche le quiz avec ses questions
    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.reponses', 'sousChapitre.chapitre.formation']);

        // Vérifie que l'apprenant est inscrit à la formation
        abort_unless(
            auth()->user()->formations()->where('formations.id', $quiz->sousChapitre->chapitre->formation_id)->exists(),
            403
        );

        // Vérifie si déjà passé
        $dejaPassé = QuizResult::where('user_id', auth()->id())
                               ->where('quiz_id', $quiz->id)
                               ->exists();

        return view('apprenant.quiz.show', compact('quiz', 'dejaPassé'));
    }

    // Soumet les réponses et calcule le score
    public function soumettre(Request $request, Quiz $quiz)
    {
        $quiz->load('questions.reponses');

        $score = 0;
        $total = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $reponseDonnee = $request->input('reponses.' . $question->id);
            $bonneReponse  = $question->reponses->firstWhere('est_correcte', true);

            if ($bonneReponse && (int) $reponseDonnee === $bonneReponse->id) {
                $score++;
            }
        }

        $result = QuizResult::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score'   => $score,
            'total'   => $total,
        ]);

        return redirect()->route('apprenant.quiz.resultat', [$quiz, $result]);
    }

    // Affiche le résultat après soumission
    public function resultat(Quiz $quiz, QuizResult $result)
    {
        abort_unless($result->user_id === auth()->id(), 403);

        $quiz->load(['questions.reponses', 'sousChapitre']);

        return view('apprenant.quiz.resultat', compact('quiz', 'result'));
    }
}
