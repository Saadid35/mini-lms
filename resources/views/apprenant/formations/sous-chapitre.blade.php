@extends('layouts.app')
@section('title', $sousChapitre->titre)

@section('content')
<a href="{{ route('apprenant.formations.show', $sousChapitre->chapitre->formation) }}" class="btn btn-sm btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left"></i>
</a>
<div class="text-muted small mb-1">
    {{ $sousChapitre->chapitre->formation->nom }} › {{ $sousChapitre->chapitre->titre }}
</div>
<h4 class="mb-4">{{ $sousChapitre->titre }}</h4>

{{-- Contenu principal --}}
@if($sousChapitre->contenu)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body content-body">
            {!! $sousChapitre->contenu !!}
        </div>
    </div>
@endif

{{-- Ressources additionnelles --}}
@if($sousChapitre->contenus->isNotEmpty())
    <h6 class="text-muted mb-3"><i class="bi bi-files me-2"></i>Ressources</h6>
    @foreach($sousChapitre->contenus as $c)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-semibold">
                    {{ $c->titre }}
                    @if($c->importe_ia)
                        <span class="badge ms-1" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);font-size:.65rem;">Généré par IA</span>
                    @endif
                </h6>
                @if($c->texte)<div class="text-muted">{!! nl2br(e($c->texte)) !!}</div>@endif
                @if($c->lien_ressource)
                    <a href="{{ $c->lien_ressource }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="bi bi-link-45deg me-1"></i>Accéder à la ressource
                    </a>
                @endif
            </div>
        </div>
    @endforeach
@endif

{{-- Quiz disponible --}}
@if($sousChapitre->quiz)
    <div class="card border-warning border-2 shadow-sm mt-4">
        <div class="card-body text-center py-4">
            <i class="bi bi-patch-question fs-1 text-warning d-block mb-2"></i>
            <h5 class="fw-bold">{{ $sousChapitre->quiz->titre }}</h5>
            @if($sousChapitre->quiz->description)
                <p class="text-muted">{{ $sousChapitre->quiz->description }}</p>
            @endif
            <a href="{{ route('apprenant.quiz.show', $sousChapitre->quiz) }}" class="btn btn-warning fw-semibold">
                <i class="bi bi-play-circle me-1"></i>Passer le quiz
            </a>
        </div>
    </div>
@endif
@endsection
