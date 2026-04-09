<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    public function index()
    {
        $notes = auth()->user()->notes()->with('formation')->latest()->get();
        return view('apprenant.notes.index', compact('notes'));
    }
}
