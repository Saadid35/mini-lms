@extends('layouts.app')
@section('title', 'Mes formations')

@section('content')
<h4 class="mb-4"><i class="bi bi-collection me-2 text-primary"></i>Mes formations</h4>

@forelse($formations as $f)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">{{ $f->nom }}</h5>
                <span class="badge bg-secondary me-2">{{ $f->niveau }}</span>
                @if($f->duree)<span class="text-muted small">{{ $f->duree }}h</span>@endif
                @if($f->description)<p class="text-muted small mb-0 mt-1">{{ Str::limit($f->description, 100) }}</p>@endif
                <div class="text-muted small mt-1">{{ $f->chapitres_count }} chapitre(s)</div>
            </div>
            <a href="{{ route('apprenant.formations.show', $f) }}" class="btn btn-primary btn-sm">
                Accéder au cours <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
@empty
    <div class="alert alert-info">Vous n'êtes inscrit à aucune formation pour le moment.</div>
@endforelse
@endsection
