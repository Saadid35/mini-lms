@extends('layouts.app')
@section('title', $chapitre->titre)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <a href="{{ route('admin.formations.show', $chapitre->formation) }}" class="btn btn-sm btn-outline-secondary mb-2"><i class="bi bi-arrow-left"></i></a>
        <div class="text-muted small mb-1">{{ $chapitre->formation->nom }}</div>
        <h4 class="mb-0">{{ $chapitre->titre }}</h4>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.chapitres.edit', $chapitre) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Modifier</a>
        <a href="{{ route('admin.sous-chapitres.create', ['chapitre_id' => $chapitre->id]) }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Sous-chapitre</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Sous-chapitres ({{ $chapitre->sousChapitres->count() }})</div>
    <div class="card-body p-0">
        @forelse($chapitre->sousChapitres as $sc)
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
                <div>
                    <a href="{{ route('admin.sous-chapitres.show', $sc) }}" class="fw-semibold text-decoration-none">
                        <i class="bi bi-file-text me-1 text-primary"></i>{{ $sc->titre }}
                    </a>
                    <div class="mt-1">
                        @if($sc->quiz)
                            <a href="{{ route('admin.quizzes.show', $sc->quiz) }}" class="badge bg-warning text-dark text-decoration-none"><i class="bi bi-patch-question me-1"></i>Quiz : {{ $sc->quiz->titre }}</a>
                        @else
                            <a href="{{ route('admin.quizzes.create', ['sous_chapitre_id' => $sc->id]) }}" class="badge bg-light text-dark border text-decoration-none"><i class="bi bi-plus-lg me-1"></i>Créer un quiz</a>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.sous-chapitres.edit', $sc) }}" class="btn btn-sm btn-outline-primary py-0 px-2"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.sous-chapitres.destroy', $sc) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-muted p-3 mb-0">Aucun sous-chapitre. <a href="{{ route('admin.sous-chapitres.create', ['chapitre_id' => $chapitre->id]) }}">Ajouter</a>.</p>
        @endforelse
    </div>
</div>
@endsection
