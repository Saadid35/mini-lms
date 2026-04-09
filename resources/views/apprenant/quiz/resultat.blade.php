@extends('layouts.app')
@section('title', 'Résultat du quiz')

@section('content')
<div class="text-center mb-5 mt-3">
    @php $pct = $result->total > 0 ? round(($result->score / $result->total) * 100) : 0; @endphp

    @if($pct >= 70)
        <i class="bi bi-trophy-fill text-warning" style="font-size:4rem;"></i>
        <h3 class="mt-3 text-success">Bravo !</h3>
    @elseif($pct >= 50)
        <i class="bi bi-emoji-smile text-primary" style="font-size:4rem;"></i>
        <h3 class="mt-3 text-primary">Pas mal !</h3>
    @else
        <i class="bi bi-emoji-frown text-danger" style="font-size:4rem;"></i>
        <h3 class="mt-3 text-danger">Continuez à réviser !</h3>
    @endif

    <p class="fs-4 mt-2">
        Votre score :
        <strong class="badge fs-3 {{ $pct >= 50 ? 'bg-success' : 'bg-danger' }}">
            {{ $result->score }} / {{ $result->total }}
        </strong>
        <span class="text-muted ms-2">({{ $pct }}%)</span>
    </p>
    <p class="text-muted">{{ $quiz->titre }}</p>
</div>

{{-- Correction --}}
<h5 class="mb-3">Correction</h5>
@foreach($quiz->questions as $i => $question)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white fw-semibold">
            Q{{ $i+1 }}. {{ $question->question }}
        </div>
        <div class="card-body py-2">
            @foreach($question->reponses as $r)
                <div class="d-flex align-items-center gap-2 mb-1">
                    @if($r->est_correcte)
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="text-success fw-semibold">{{ $r->texte }}</span>
                    @else
                        <i class="bi bi-circle text-muted"></i>
                        <span class="text-muted">{{ $r->texte }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<div class="d-flex gap-2 mt-4">
    <a href="{{ route('apprenant.quiz.show', $quiz) }}" class="btn btn-outline-primary">
        <i class="bi bi-arrow-repeat me-1"></i>Repasser le quiz
    </a>
    <a href="{{ route('apprenant.formations.show', $quiz->sousChapitre->chapitre->formation) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour à la formation
    </a>
</div>
@endsection
