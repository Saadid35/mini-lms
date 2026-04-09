@extends('layouts.app')
@section('title', $formation->nom)

@section('content')
<a href="{{ route('apprenant.formations.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i></a>
<h4 class="mb-1">{{ $formation->nom }}</h4>
<span class="badge bg-secondary mb-3">{{ $formation->niveau }}</span>
@if($formation->description)<p class="text-muted">{{ $formation->description }}</p>@endif

@forelse($formation->chapitres as $chapitre)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-light fw-semibold">
            <i class="bi bi-book me-2 text-primary"></i>{{ $chapitre->titre }}
        </div>
        <div class="card-body p-0">
            @forelse($chapitre->sousChapitres as $sc)
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                    <div>
                        <a href="{{ route('apprenant.sous-chapitres.show', $sc) }}" class="text-decoration-none fw-semibold">
                            <i class="bi bi-file-text me-1 text-secondary"></i>{{ $sc->titre }}
                        </a>
                        @if($sc->quiz)
                            <a href="{{ route('apprenant.quiz.show', $sc->quiz) }}" class="badge bg-warning text-dark ms-2 text-decoration-none">
                                <i class="bi bi-patch-question me-1"></i>Quiz disponible
                            </a>
                        @endif
                    </div>
                    <a href="{{ route('apprenant.sous-chapitres.show', $sc) }}" class="btn btn-sm btn-outline-primary">Lire</a>
                </div>
            @empty
                <p class="text-muted p-3 mb-0 small">Aucun contenu dans ce chapitre.</p>
            @endforelse
        </div>
    </div>
@empty
    <div class="alert alert-info">Aucun chapitre dans cette formation.</div>
@endforelse
@endsection
