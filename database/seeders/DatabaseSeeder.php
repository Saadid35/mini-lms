<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use App\Models\Contenu;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // Utilisateurs
        // -------------------------------------------------------
        $admin = User::create([
            'name'     => 'Admin LMS',
            'email'    => 'admin@lms.fr',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $apprenant = User::create([
            'name'     => 'Alice Martin',
            'email'    => 'alice@lms.fr',
            'password' => Hash::make('password'),
            'role'     => 'apprenant',
        ]);

        // -------------------------------------------------------
        // Formation : Anglais — Verbes irréguliers
        // -------------------------------------------------------
        $formation = Formation::create([
            'nom'         => 'Anglais — Maîtriser les verbes irréguliers',
            'description' => 'Formation pédagogique pour apprendre et mémoriser les verbes irréguliers anglais les plus courants.',
            'niveau'      => 'débutant',
            'duree'       => 4,
        ]);

        // Inscription de l'apprenant
        $formation->apprenants()->attach($apprenant->id);

        // -------------------------------------------------------
        // Chapitre 1 : Introduction
        // -------------------------------------------------------
        $chapitre1 = Chapitre::create([
            'formation_id' => $formation->id,
            'titre'        => 'Introduction aux verbes irréguliers',
            'description'  => 'Comprendre ce qu\'est un verbe irrégulier et pourquoi ils sont importants.',
            'ordre'        => 1,
        ]);

        $sc1 = SousChapitre::create([
            'chapitre_id' => $chapitre1->id,
            'titre'       => 'Qu\'est-ce qu\'un verbe irrégulier ?',
            'contenu'     => '<h5>Définition</h5>
<p>Un verbe irrégulier (<em>irregular verb</em>) est un verbe dont la conjugaison au <strong>prétérit</strong> (passé simple) et au <strong>participe passé</strong> ne suit pas la règle générale qui consiste à ajouter <em>-ed</em>.</p>
<h5>Exemple de comparaison</h5>
<table class="table table-bordered table-sm">
<thead><tr><th>Type</th><th>Infinitif</th><th>Prétérit</th><th>Participe passé</th></tr></thead>
<tbody>
<tr><td>Régulier</td><td>work</td><td>worked</td><td>worked</td></tr>
<tr><td>Irrégulier</td><td>go</td><td>went</td><td>gone</td></tr>
<tr><td>Irrégulier</td><td>be</td><td>was/were</td><td>been</td></tr>
</tbody>
</table>
<p>En anglais, il existe environ <strong>200 verbes irréguliers</strong> courants. Les maîtriser est indispensable pour parler et écrire correctement.</p>',
            'ordre'       => 1,
        ]);

        Contenu::create([
            'sous_chapitre_id' => $sc1->id,
            'titre'            => 'Ressource : Liste complète des verbes irréguliers',
            'texte'            => 'Ce contenu a été généré et structuré avec l\'aide de l\'IA pour offrir une introduction claire aux verbes irréguliers anglais.',
            'lien_ressource'   => null,
            'importe_ia'       => true,
        ]);

        // -------------------------------------------------------
        // Chapitre 2 : Les 10 verbes irréguliers indispensables
        // -------------------------------------------------------
        $chapitre2 = Chapitre::create([
            'formation_id' => $formation->id,
            'titre'        => 'Les 10 verbes irréguliers indispensables',
            'description'  => 'Focus sur les verbes les plus utilisés dans la vie courante.',
            'ordre'        => 2,
        ]);

        $sc2 = SousChapitre::create([
            'chapitre_id' => $chapitre2->id,
            'titre'       => 'Tableau des 10 verbes à connaître absolument',
            'contenu'     => '<h5>Les 10 verbes irréguliers incontournables</h5>
<p>Voici les verbes irréguliers les plus fréquents. Apprenez-les par cœur !</p>
<table class="table table-bordered table-hover table-sm">
<thead class="table-dark"><tr><th>Infinitif</th><th>Traduction</th><th>Prétérit</th><th>Participe passé</th></tr></thead>
<tbody>
<tr><td><strong>be</strong></td><td>être</td><td>was / were</td><td>been</td></tr>
<tr><td><strong>have</strong></td><td>avoir</td><td>had</td><td>had</td></tr>
<tr><td><strong>do</strong></td><td>faire</td><td>did</td><td>done</td></tr>
<tr><td><strong>go</strong></td><td>aller</td><td>went</td><td>gone</td></tr>
<tr><td><strong>get</strong></td><td>obtenir/devenir</td><td>got</td><td>gotten / got</td></tr>
<tr><td><strong>see</strong></td><td>voir</td><td>saw</td><td>seen</td></tr>
<tr><td><strong>know</strong></td><td>savoir/connaître</td><td>knew</td><td>known</td></tr>
<tr><td><strong>come</strong></td><td>venir</td><td>came</td><td>come</td></tr>
<tr><td><strong>take</strong></td><td>prendre</td><td>took</td><td>taken</td></tr>
<tr><td><strong>say</strong></td><td>dire</td><td>said</td><td>said</td></tr>
</tbody>
</table>
<p class="text-muted"><em>Astuce : créez des phrases simples avec chaque verbe pour mieux les mémoriser.</em></p>',
            'ordre'       => 1,
        ]);

        Contenu::create([
            'sous_chapitre_id' => $sc2->id,
            'titre'            => 'Les 10 verbes irréguliers — contenu généré par IA',
            'texte'            => "Contenu pédagogique structuré généré avec l'aide de l'IA.\n\nBE → was/were → been\nHAVE → had → had\nDO → did → done\nGO → went → gone\nGET → got → gotten\nSEE → saw → seen\nKNOW → knew → known\nCOME → came → come\nTAKE → took → taken\nSAY → said → said",
            'importe_ia'       => true,
        ]);

        // -------------------------------------------------------
        // Sous-chapitre 3 : Méthode de mémorisation
        // -------------------------------------------------------
        $sc3 = SousChapitre::create([
            'chapitre_id' => $chapitre2->id,
            'titre'       => 'Méthodes pour mémoriser les verbes irréguliers',
            'contenu'     => '<h5>Stratégies efficaces</h5>
<ul>
<li><strong>La répétition espacée</strong> : révisez avec des flashcards (ex. Anki) en augmentant progressivement les intervalles.</li>
<li><strong>Les groupes par pattern</strong> : classez les verbes par similitudes (ex. sing/sang/sung, ring/rang/rung, drink/drank/drunk).</li>
<li><strong>Les phrases contextuelles</strong> : intégrez chaque verbe dans une phrase que vous connaissez bien.</li>
<li><strong>La musique et les chansons</strong> : associez des verbes irréguliers à des mélodies mémorables.</li>
</ul>
<h5>Pattern courant : i → a → u</h5>
<table class="table table-bordered table-sm">
<thead><tr><th>Infinitif</th><th>Prétérit</th><th>Participe passé</th></tr></thead>
<tbody>
<tr><td>sing</td><td>sang</td><td>sung</td></tr>
<tr><td>drink</td><td>drank</td><td>drunk</td></tr>
<tr><td>swim</td><td>swam</td><td>swum</td></tr>
<tr><td>ring</td><td>rang</td><td>rung</td></tr>
</tbody>
</table>',
            'ordre'       => 2,
        ]);

        // -------------------------------------------------------
        // Quiz lié au sous-chapitre 2 (les 10 verbes)
        // -------------------------------------------------------
        $quiz = Quiz::create([
            'sous_chapitre_id' => $sc2->id,
            'titre'            => 'Quiz : Les 10 verbes irréguliers indispensables',
            'description'      => 'Testez votre connaissance des 10 verbes irréguliers les plus courants en anglais.',
        ]);

        // Questions et réponses
        $questionsData = [
            [
                'question' => 'Quel est le prétérit du verbe "go" (aller) ?',
                'reponses' => ['goed', 'went', 'gone', 'goes'],
                'correcte' => 'went',
            ],
            [
                'question' => 'Quel est le participe passé du verbe "see" (voir) ?',
                'reponses' => ['sawed', 'saw', 'seen', 'seed'],
                'correcte' => 'seen',
            ],
            [
                'question' => 'Quel est le prétérit du verbe "have" (avoir) ?',
                'reponses' => ['haved', 'had', 'have', 'has'],
                'correcte' => 'had',
            ],
            [
                'question' => 'Quel est le participe passé du verbe "do" (faire) ?',
                'reponses' => ['doed', 'did', 'done', 'does'],
                'correcte' => 'done',
            ],
            [
                'question' => 'Quel est le prétérit du verbe "come" (venir) ?',
                'reponses' => ['came', 'comed', 'come', 'coming'],
                'correcte' => 'came',
            ],
            [
                'question' => 'Quel est le participe passé du verbe "know" (savoir) ?',
                'reponses' => ['knowed', 'knew', 'known', 'knows'],
                'correcte' => 'known',
            ],
            [
                'question' => 'Quel est le prétérit du verbe "take" (prendre) ?',
                'reponses' => ['taked', 'took', 'taken', 'takes'],
                'correcte' => 'took',
            ],
        ];

        foreach ($questionsData as $i => $qData) {
            $question = Question::create([
                'quiz_id'  => $quiz->id,
                'question' => $qData['question'],
                'ordre'    => $i + 1,
            ]);

            foreach ($qData['reponses'] as $texteReponse) {
                Reponse::create([
                    'question_id'  => $question->id,
                    'texte'        => $texteReponse,
                    'est_correcte' => ($texteReponse === $qData['correcte']),
                ]);
            }
        }

        // -------------------------------------------------------
        // Note de démo
        // -------------------------------------------------------
        Note::create([
            'user_id'      => $apprenant->id,
            'formation_id' => $formation->id,
            'matiere'      => 'Verbes irréguliers anglais',
            'note'         => 15.50,
            'commentaire'  => 'Très bonne participation, quelques erreurs sur les participes passés.',
        ]);
    }
}
