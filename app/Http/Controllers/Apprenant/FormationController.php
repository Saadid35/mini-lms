<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\SousChapitre;

class FormationController extends Controller
{
    // Liste des formations auxquelles l'apprenant est inscrit
    public function index()
    {
        $formations = auth()->user()->formations()->withCount('chapitres')->get();
        return view('apprenant.formations.index', compact('formations'));
    }

    // Détail d'une formation : chapitres et sous-chapitres
    public function show(Formation $formation)
    {
        // Vérifie que l'apprenant est bien inscrit
        abort_unless(
            auth()->user()->formations()->where('formations.id', $formation->id)->exists(),
            403,
            'Vous n\'êtes pas inscrit à cette formation.'
        );

        $formation->load('chapitres.sousChapitres.quiz');
        return view('apprenant.formations.show', compact('formation'));
    }

    // Affiche le contenu d'un sous-chapitre
    public function sousChapitre(SousChapitre $sousChapitre)
    {
        $sousChapitre->load(['contenus', 'quiz', 'chapitre.formation']);

        // Vérifie que l'apprenant est inscrit à la formation parente
        abort_unless(
            auth()->user()->formations()->where('formations.id', $sousChapitre->chapitre->formation_id)->exists(),
            403
        );

        return view('apprenant.formations.sous-chapitre', compact('sousChapitre'));
    }
}
