@extends('layouts.app')
@section('title', $sousChapitre->titre)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <a href="{{ route('admin.chapitres.show', $sousChapitre->chapitre) }}" class="btn btn-sm btn-outline-secondary mb-2"><i class="bi bi-arrow-left"></i></a>
        <div class="text-muted small mb-1">{{ $sousChapitre->chapitre->formation->nom }} › {{ $sousChapitre->chapitre->titre }}</div>
        <h4 class="mb-0">{{ $sousChapitre->titre }}</h4>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.sous-chapitres.edit', $sousChapitre) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Modifier</a>
        <a href="{{ route('admin.contenus.create', ['sous_chapitre_id' => $sousChapitre->id]) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-file-plus me-1"></i>Contenu</a>
        @if(!$sousChapitre->quiz)
            <a href="{{ route('admin.quizzes.create', ['sous_chapitre_id' => $sousChapitre->id]) }}" class="btn btn-sm btn-warning"><i class="bi bi-plus-lg me-1"></i>Quiz</a>
        @endif
    </div>
</div>

{{-- Contenu du sous-chapitre --}}
@if($sousChapitre->contenu)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold"><i class="bi bi-file-richtext me-2 text-primary"></i>Contenu pédagogique</div>
        <div class="card-body">{!! $sousChapitre->contenu !!}</div>
    </div>
@endif

{{-- Contenus additionnels --}}
@if($sousChapitre->contenus->isNotEmpty())
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold"><i class="bi bi-files me-2 text-success"></i>Ressources ({{ $sousChapitre->contenus->count() }})</div>
        <div class="card-body p-0">
            @foreach($sousChapitre->contenus as $c)
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                    <div>
                        <span class="fw-semibold">{{ $c->titre }}</span>
                        @if($c->importe_ia) <span class="badge ms-1" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">IA</span> @endif
                        @if($c->lien_ressource) <a href="{{ $c->lien_ressource }}" target="_blank" class="badge bg-light text-dark border ms-1"><i class="bi bi-link-45deg"></i></a> @endif
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.contenus.edit', $c) }}" class="btn btn-sm btn-outline-primary py-0 px-2"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.contenus.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- Quiz --}}
@if($sousChapitre->quiz)
    <div class="card border-0 shadow-sm border-warning">
        <div class="card-header bg-warning bg-opacity-10 fw-semibold"><i class="bi bi-patch-question me-2 text-warning"></i>Quiz : {{ $sousChapitre->quiz->titre }}</div>
        <div class="card-body">
            <p class="text-muted small mb-2">{{ $sousChapitre->quiz->questions->count() }} question(s)</p>
            <a href="{{ route('admin.quizzes.show', $sousChapitre->quiz) }}" class="btn btn-sm btn-warning">Gérer le quiz</a>
        </div>
    </div>
@endif
@endsection
