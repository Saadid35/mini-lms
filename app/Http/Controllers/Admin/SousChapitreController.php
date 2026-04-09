<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SousChapitre;
use App\Models\Chapitre;
use Illuminate\Http\Request;

class SousChapitreController extends Controller
{
    public function index()
    {
        $sousChapitres = SousChapitre::with('chapitre.formation')->latest()->get();
        return view('admin.sous-chapitres.index', compact('sousChapitres'));
    }

    public function create(Request $request)
    {
        $chapitres = Chapitre::with('formation')->orderBy('titre')->get();
        $selectedChapitre = $request->get('chapitre_id');
        return view('admin.sous-chapitres.create', compact('chapitres', 'selectedChapitre'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'chapitre_id' => 'required|exists:chapitres,id',
            'titre'       => 'required|string|max:255',
            'contenu'     => 'nullable|string',
            'ordre'       => 'nullable|integer|min:0',
        ]);

        SousChapitre::create($data);

        return redirect()->route('admin.chapitres.show', $data['chapitre_id'])
                         ->with('success', 'Sous-chapitre créé avec succès.');
    }

    public function show(SousChapitre $sousChapitre)
    {
        $sousChapitre->load(['contenus', 'quiz.questions.reponses']);
        return view('admin.sous-chapitres.show', compact('sousChapitre'));
    }

    public function edit(SousChapitre $sousChapitre)
    {
        $chapitres = Chapitre::with('formation')->orderBy('titre')->get();
        return view('admin.sous-chapitres.edit', compact('sousChapitre', 'chapitres'));
    }

    public function update(Request $request, SousChapitre $sousChapitre)
    {
        $data = $request->validate([
            'chapitre_id' => 'required|exists:chapitres,id',
            'titre'       => 'required|string|max:255',
            'contenu'     => 'nullable|string',
            'ordre'       => 'nullable|integer|min:0',
        ]);

        $sousChapitre->update($data);

        return redirect()->route('admin.chapitres.show', $sousChapitre->chapitre_id)
                         ->with('success', 'Sous-chapitre mis à jour.');
    }

    public function destroy(SousChapitre $sousChapitre)
    {
        $chapitreId = $sousChapitre->chapitre_id;
        $sousChapitre->delete();
        return redirect()->route('admin.chapitres.show', $chapitreId)
                         ->with('success', 'Sous-chapitre supprimé.');
    }
}
