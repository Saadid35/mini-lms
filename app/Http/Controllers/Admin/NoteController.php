<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\User;
use App\Models\Formation;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with(['user', 'formation'])->latest()->get();
        return view('admin.notes.index', compact('notes'));
    }

    public function create()
    {
        $apprenants = User::where('role', 'apprenant')->orderBy('name')->get();
        $formations = Formation::orderBy('nom')->get();
        return view('admin.notes.create', compact('apprenants', 'formations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'formation_id' => 'required|exists:formations,id',
            'matiere'      => 'required|string|max:255',
            'note'         => 'required|numeric|min:0|max:20',
            'commentaire'  => 'nullable|string',
        ]);

        Note::create($data);

        return redirect()->route('admin.notes.index')
                         ->with('success', 'Note enregistrée.');
    }

    public function show(Note $note)
    {
        $note->load(['user', 'formation']);
        return view('admin.notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $apprenants = User::where('role', 'apprenant')->orderBy('name')->get();
        $formations = Formation::orderBy('nom')->get();
        return view('admin.notes.edit', compact('note', 'apprenants', 'formations'));
    }

    public function update(Request $request, Note $note)
    {
        $data = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'formation_id' => 'required|exists:formations,id',
            'matiere'      => 'required|string|max:255',
            'note'         => 'required|numeric|min:0|max:20',
            'commentaire'  => 'nullable|string',
        ]);

        $note->update($data);

        return redirect()->route('admin.notes.index')
                         ->with('success', 'Note mise à jour.');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('admin.notes.index')
                         ->with('success', 'Note supprimée.');
    }
}
