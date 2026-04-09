<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Formation;
use Illuminate\Http\Request;

class ChapitreController extends Controller
{
    public function index()
    {
        $chapitres = Chapitre::with('formation')->latest()->get();
        return view('admin.chapitres.index', compact('chapitres'));
    }

    public function create(Request $request)
    {
        $formations = Formation::orderBy('nom')->get();
        $selectedFormation = $request->get('formation_id');
        return view('admin.chapitres.create', compact('formations', 'selectedFormation'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'titre'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'ordre'        => 'nullable|integer|min:0',
        ]);

        Chapitre::create($data);

        return redirect()->route('admin.formations.show', $data['formation_id'])
                         ->with('success', 'Chapitre créé avec succès.');
    }

    public function show(Chapitre $chapitre)
    {
        $chapitre->load('sousChapitres.quiz');
        return view('admin.chapitres.show', compact('chapitre'));
    }

    public function edit(Chapitre $chapitre)
    {
        $formations = Formation::orderBy('nom')->get();
        return view('admin.chapitres.edit', compact('chapitre', 'formations'));
    }

    public function update(Request $request, Chapitre $chapitre)
    {
        $data = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'titre'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'ordre'        => 'nullable|integer|min:0',
        ]);

        $chapitre->update($data);

        return redirect()->route('admin.formations.show', $chapitre->formation_id)
                         ->with('success', 'Chapitre mis à jour.');
    }

    public function destroy(Chapitre $chapitre)
    {
        $formationId = $chapitre->formation_id;
        $chapitre->delete();
        return redirect()->route('admin.formations.show', $formationId)
                         ->with('success', 'Chapitre supprimé.');
    }
}
