<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiGeneratorController extends Controller
{
    public function index()
    {
        return view('admin.ai-generator');
    }

    public function generate(Request $request)
    {
        set_time_limit(180);

        $request->validate([
            'sujet'              => 'required|string|min:5|max:300',
            'nb_chapitres'       => 'required|integer|min:1|max:10',
            'nb_sous_chapitres'  => 'required|integer|min:1|max:5',
            'nb_questions'       => 'required|integer|min:3|max:15',
            'quiz_par_chapitre'  => 'nullable|boolean',
        ]);

        $sujet             = $request->input('sujet');
        $nbChapitres       = (int) $request->input('nb_chapitres');
        $nbSousChapitres   = (int) $request->input('nb_sous_chapitres');
        $nbQuestions       = (int) $request->input('nb_questions');
        $quizParChapitre   = $request->boolean('quiz_par_chapitre');

        // -------------------------------------------------------
        // Construction du JSON attendu pour le prompt
        // -------------------------------------------------------
        $exampleChapitres = [];
        for ($c = 1; $c <= $nbChapitres; $c++) {
            $sousChapitres = [];
            for ($s = 1; $s <= $nbSousChapitres; $s++) {
                $sousChapitres[] = [
                    'titre'   => "Titre du sous-chapitre {$c}.{$s}",
                    'contenu' => '<h5>Titre de section</h5><p>Contenu clair et détaillé avec mise en forme HTML : h5, p, ul/li, table, pre/code si pertinent.</p>',
                ];
            }

            $chapEntry = ['titre' => "Titre du chapitre {$c}", 'sous_chapitres' => $sousChapitres];

            if ($quizParChapitre) {
                $exampleQuestions = [];
                for ($q = 1; $q <= $nbQuestions; $q++) {
                    $exampleQuestions[] = [
                        'question' => "Question {$q} sur le chapitre {$c} ?",
                        'reponses' => ['Réponse A', 'Réponse B', 'Réponse C', 'Réponse D'],
                        'correcte' => 'Réponse A',
                    ];
                }
                $chapEntry['quiz'] = [
                    'titre'              => "Quiz du chapitre {$c}",
                    'description'        => "Quiz portant sur le chapitre {$c}",
                    'sous_chapitre_index' => 0,
                    'questions'          => $exampleQuestions,
                ];
            }

            $exampleChapitres[] = $chapEntry;
        }

        $structure = ['formation' => ['nom' => '...', 'description' => '...', 'niveau' => 'débutant'], 'chapitres' => $exampleChapitres];

        // Si un seul quiz global, l'ajouter à la racine
        if (!$quizParChapitre) {
            $exampleQuestions = [];
            for ($q = 1; $q <= $nbQuestions; $q++) {
                $exampleQuestions[] = [
                    'question' => "Question {$q} ?",
                    'reponses' => ['Réponse A', 'Réponse B', 'Réponse C', 'Réponse D'],
                    'correcte' => 'Réponse A',
                ];
            }
            $structure['quiz'] = [
                'titre'              => 'Quiz final',
                'description'        => 'Quiz de validation de la formation',
                'sous_chapitre_index' => 0,
                'questions'          => $exampleQuestions,
            ];
        }

        $jsonStructure = json_encode($structure, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $quizInstruction = $quizParChapitre
            ? "Chaque chapitre possède sa propre clé \"quiz\" contenant {$nbQuestions} questions."
            : "Il y a UN seul quiz global à la racine du JSON (clé \"quiz\") avec {$nbQuestions} questions. \"sous_chapitre_index\" est l'index global (0-based) parmi tous les sous-chapitres.";

        // -------------------------------------------------------
        // Prompt
        // -------------------------------------------------------
        $prompt = <<<PROMPT
Tu es un expert en ingénierie pédagogique. Génère un contenu de formation COMPLET et DÉTAILLÉ sur le sujet : "{$sujet}".

Réponds UNIQUEMENT avec un objet JSON valide. Aucun texte avant, aucun texte après, aucune balise markdown, aucun ```json.

STRUCTURE EXACTE à respecter ({$nbChapitres} chapitres, {$nbSousChapitres} sous-chapitres par chapitre) :
{$jsonStructure}

RÈGLES OBLIGATOIRES :
1. "niveau" : exactement l'une des valeurs : débutant, intermédiaire, avancé
2. Chaque "contenu" de sous-chapitre doit être clair et détaillé, avec une mise en forme HTML : titres <h5>, paragraphes <p>, listes <ul><li>, tableaux <table> et blocs <pre><code> si pertinents
3. Quiz : {$quizInstruction}
4. Chaque question a exactement 4 réponses dans "reponses", et "correcte" doit être identique à l'une d'elles
5. Les questions de quiz doivent tester la compréhension réelle du contenu, pas être triviales
6. JSON strictement valide, toutes les chaînes correctement échappées
PROMPT;

        // -------------------------------------------------------
        // Appel API OpenRouter
        // -------------------------------------------------------
        try {
            $response = Http::timeout(150)
                ->withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . config('services.openrouter.key'),
                    'Content-Type'  => 'application/json',
                ])
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model'      => 'anthropic/claude-3-haiku',
                    'max_tokens' => 6000,
                    'messages'   => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

            if ($response->failed()) {
                $error = $response->json('error.message', 'Erreur API inconnue');
                return back()->withInput()->with('error', "Erreur API OpenRouter : {$error}");
            }

            $rawContent = $response->json('choices.0.message.content', '');

        } catch (\Exception $e) {
            Log::error('AI Generator error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Impossible de contacter l\'API OpenRouter : ' . $e->getMessage());
        }

        // -------------------------------------------------------
        // Parse JSON — nettoyage des éventuels backticks
        // -------------------------------------------------------
        $cleanJson = trim(preg_replace('/^```(?:json)?\s*|\s*```$/m', '', $rawContent));

        $data = json_decode($cleanJson, true);

        $hasQuizData = $quizParChapitre
            ? isset($data['formation'], $data['chapitres'])
            : isset($data['formation'], $data['chapitres'], $data['quiz']);

        if (json_last_error() !== JSON_ERROR_NONE || !$hasQuizData) {
            Log::error('AI JSON parse error', ['raw' => $rawContent]);
            return back()->withInput()
                         ->with('error', 'La réponse de l\'IA n\'est pas un JSON valide. Réessayez.')
                         ->with('raw_response', $rawContent);
        }

        // -------------------------------------------------------
        // Persistance en base de données
        // -------------------------------------------------------
        $niveaux = ['débutant', 'intermédiaire', 'avancé'];
        $niveau  = in_array($data['formation']['niveau'], $niveaux) ? $data['formation']['niveau'] : 'débutant';

        $formation = Formation::create([
            'nom'         => $data['formation']['nom'],
            'description' => $data['formation']['description'],
            'niveau'      => $niveau,
        ]);

        // Index global des sous-chapitres (pour le quiz unique)
        $tousSousChapitres = [];

        foreach ($data['chapitres'] as $chapIndex => $chapData) {
            $chapitre = Chapitre::create([
                'formation_id' => $formation->id,
                'titre'        => $chapData['titre'],
                'ordre'        => $chapIndex + 1,
            ]);

            $scsDuChapitre = [];
            foreach ($chapData['sous_chapitres'] as $scIndex => $scData) {
                $sc = SousChapitre::create([
                    'chapitre_id' => $chapitre->id,
                    'titre'       => $scData['titre'],
                    'contenu'     => $scData['contenu'],
                    'ordre'       => $scIndex + 1,
                ]);
                $tousSousChapitres[] = $sc;
                $scsDuChapitre[]     = $sc;
            }

            // Quiz par chapitre
            if ($quizParChapitre && isset($chapData['quiz'])) {
                $qzData  = $chapData['quiz'];
                $scIdx   = (int) ($qzData['sous_chapitre_index'] ?? 0);
                $targetSc = $scsDuChapitre[$scIdx] ?? $scsDuChapitre[0];

                $this->createQuiz($qzData, $targetSc->id);
            }
        }

        // Quiz unique global
        if (!$quizParChapitre) {
            $qzData   = $data['quiz'];
            $scIndex  = (int) ($qzData['sous_chapitre_index'] ?? 0);
            $targetSc = $tousSousChapitres[$scIndex] ?? $tousSousChapitres[0];

            $this->createQuiz($qzData, $targetSc->id);
        }

        return redirect()
            ->route('admin.formations.show', $formation)
            ->with('success', "Formation \"{$formation->nom}\" générée par l'IA et enregistrée avec succès !");
    }

    // -------------------------------------------------------
    // Crée un quiz avec ses questions et réponses
    // -------------------------------------------------------
    private function createQuiz(array $qzData, int $sousChapitreId): Quiz
    {
        $quiz = Quiz::create([
            'sous_chapitre_id' => $sousChapitreId,
            'titre'            => $qzData['titre'],
            'description'      => $qzData['description'] ?? null,
        ]);

        foreach ($qzData['questions'] as $qIndex => $qData) {
            $question = Question::create([
                'quiz_id'  => $quiz->id,
                'question' => $qData['question'],
                'ordre'    => $qIndex + 1,
            ]);

            foreach ($qData['reponses'] as $texte) {
                Reponse::create([
                    'question_id'  => $question->id,
                    'texte'        => $texte,
                    'est_correcte' => ($texte === $qData['correcte']),
                ]);
            }
        }

        return $quiz;
    }
}
