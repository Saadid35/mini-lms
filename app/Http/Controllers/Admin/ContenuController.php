<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenu;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class ContenuController extends Controller
{
    public function index()
    {
        $contenus = Contenu::with('sousChapitre.chapitre.formation')->latest()->get();
        return view('admin.contenus.index', compact('contenus'));
    }

    public function create(Request $request)
    {
        $sousChapitres = SousChapitre::with('chapitre.formation')->orderBy('titre')->get();
        $selectedSousChapitre = $request->get('sous_chapitre_id');
        return view('admin.contenus.create', compact('sousChapitres', 'selectedSousChapitre'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
            'titre'            => 'required|string|max:255',
            'texte'            => 'nullable|string',
            'lien_ressource'   => 'nullable|url|max:500',
            'importe_ia'       => 'nullable|boolean',
        ]);

        $data['importe_ia'] = $request->boolean('importe_ia');
        Contenu::create($data);

        return redirect()->route('admin.sous-chapitres.show', $data['sous_chapitre_id'])
                         ->with('success', 'Contenu créé avec succès.');
    }

    public function show(Contenu $contenu)
    {
        return view('admin.contenus.show', compact('contenu'));
    }

    public function edit(Contenu $contenu)
    {
        $sousChapitres = SousChapitre::with('chapitre.formation')->orderBy('titre')->get();
        return view('admin.contenus.edit', compact('contenu', 'sousChapitres'));
    }

    public function update(Request $request, Contenu $contenu)
    {
        $data = $request->validate([
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
            'titre'            => 'required|string|max:255',
            'texte'            => 'nullable|string',
            'lien_ressource'   => 'nullable|url|max:500',
            'importe_ia'       => 'nullable|boolean',
        ]);

        $data['importe_ia'] = $request->boolean('importe_ia');
        $contenu->update($data);

        return redirect()->route('admin.sous-chapitres.show', $contenu->sous_chapitre_id)
                         ->with('success', 'Contenu mis à jour.');
    }

    public function destroy(Contenu $contenu)
    {
        $sousChapitreId = $contenu->sous_chapitre_id;
        $contenu->delete();
        return redirect()->route('admin.sous-chapitres.show', $sousChapitreId)
                         ->with('success', 'Contenu supprimé.');
    }
}
