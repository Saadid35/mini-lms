@extends('layouts.app')
@section('title', $quiz->titre)

@section('content')
<a href="{{ route('apprenant.sous-chapitres.show', $quiz->sousChapitre) }}" class="btn btn-sm btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left"></i>
</a>
<h4 class="mb-1"><i class="bi bi-patch-question me-2 text-warning"></i>{{ $quiz->titre }}</h4>
@if($quiz->description)<p class="text-muted">{{ $quiz->description }}</p>@endif

@if($dejaPassé)
    <div class="alert alert-info d-flex align-items-center gap-2">
        <i class="bi bi-info-circle-fill fs-5"></i>
        Vous avez déjà passé ce quiz. Vous pouvez le repasser si vous le souhaitez.
    </div>
@endif

<form action="{{ route('apprenant.quiz.soumettre', $quiz) }}" method="POST">
    @csrf

    @foreach($quiz->questions as $i => $question)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">
                Question {{ $i + 1 }} / {{ $quiz->questions->count() }}
            </div>
            <div class="card-body">
                <p class="mb-3">{{ $question->question }}</p>

                @foreach($question->reponses->shuffle() as $reponse)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio"
                               name="reponses[{{ $question->id }}]"
                               id="rep_{{ $reponse->id }}"
                               value="{{ $reponse->id }}" required>
                        <label class="form-check-label" for="rep_{{ $reponse->id }}">
                            {{ $reponse->texte }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="bi bi-send me-2"></i>Soumettre mes réponses
        </button>
    </div>
</form>
@endsection
