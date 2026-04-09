<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::withCount(['chapitres', 'apprenants'])->latest()->get();
        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('admin.formations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau'      => 'required|in:débutant,intermédiaire,avancé',
            'duree'       => 'nullable|integer|min:1',
        ]);

        Formation::create($data);

        return redirect()->route('admin.formations.index')
                         ->with('success', 'Formation créée avec succès.');
    }

    public function show(Formation $formation)
    {
        $formation->load(['chapitres.sousChapitres.quiz', 'apprenants']);
        $apprenants = User::where('role', 'apprenant')->get();
        return view('admin.formations.show', compact('formation', 'apprenants'));
    }

    public function edit(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau'      => 'required|in:débutant,intermédiaire,avancé',
            'duree'       => 'nullable|integer|min:1',
        ]);

        $formation->update($data);

        return redirect()->route('admin.formations.index')
                         ->with('success', 'Formation mise à jour.');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();
        return redirect()->route('admin.formations.index')
                         ->with('success', 'Formation supprimée.');
    }

    // Inscrire un apprenant à la formation
    public function inscrire(Request $request, Formation $formation)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $formation->apprenants()->syncWithoutDetaching([$request->user_id]);
        return back()->with('success', 'Apprenant inscrit à la formation.');
    }

    // Désinscrire un apprenant
    public function desinscrire(Formation $formation, User $user)
    {
        $formation->apprenants()->detach($user->id);
        return back()->with('success', 'Apprenant désinscrit de la formation.');
    }
}
