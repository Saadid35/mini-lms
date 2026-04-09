@extends('layouts.app')
@section('title', $quiz->titre)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <a href="{{ route('admin.sous-chapitres.show', $quiz->sousChapitre) }}" class="btn btn-sm btn-outline-secondary mb-2"><i class="bi bi-arrow-left"></i></a>
        <div class="text-muted small mb-1">{{ $quiz->sousChapitre->chapitre->formation->nom }} › {{ $quiz->sousChapitre->titre }}</div>
        <h4 class="mb-0"><i class="bi bi-patch-question me-2 text-warning"></i>{{ $quiz->titre }}</h4>
        @if($quiz->description)<p class="text-muted mb-0">{{ $quiz->description }}</p>@endif
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Modifier</a>
        <a href="{{ route('admin.questions.create', ['quiz_id' => $quiz->id]) }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Question</a>
    </div>
</div>

@forelse($quiz->questions as $q)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Q{{ $loop->iteration }}. {{ $q->question }}</span>
            <div class="d-flex gap-1">
                <a href="{{ route('admin.questions.show', $q) }}" class="btn btn-sm btn-outline-secondary py-0 px-2"><i class="bi bi-pencil-square"></i></a>
                <form action="{{ route('admin.questions.destroy', $q) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette question ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
        <div class="card-body py-2">
            @forelse($q->reponses as $r)
                <span class="badge me-1 mb-1 {{ $r->est_correcte ? 'bg-success' : 'bg-light text-dark border' }}">
                    @if($r->est_correcte)<i class="bi bi-check-lg me-1"></i>@endif
                    {{ $r->texte }}
                </span>
            @empty
                <span class="text-muted small">Aucune réponse.</span>
            @endforelse
        </div>
    </div>
@empty
    <div class="alert alert-info">Aucune question. <a href="{{ route('admin.questions.create', ['quiz_id' => $quiz->id]) }}">Ajouter la première</a>.</div>
@endforelse
@endsection
