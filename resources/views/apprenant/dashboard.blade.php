@extends('layouts.app')
@section('title', 'Mon tableau de bord')

@section('content')
<h4 class="mb-4">Bonjour, <span class="text-primary">{{ auth()->user()->name }}</span> !</h4>

<div class="row g-4">
    {{-- Mes formations --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-collection me-2 text-primary"></i>Mes formations</span>
                <a href="{{ route('apprenant.formations.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @forelse($formations as $f)
                    <div class="px-3 py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('apprenant.formations.show', $f) }}" class="fw-semibold text-decoration-none">{{ $f->nom }}</a>
                            <div class="text-muted small"><span class="badge bg-secondary">{{ $f->niveau }}</span> · {{ $f->chapitres_count }} chapitre(s)</div>
                        </div>
                        <a href="{{ route('apprenant.formations.show', $f) }}" class="btn btn-sm btn-outline-secondary">Accéder <i class="bi bi-arrow-right"></i></a>
                    </div>
                @empty
                    <p class="text-muted p-3 mb-0">Vous n'êtes inscrit à aucune formation.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        {{-- Derniers résultats quiz --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-patch-question me-2 text-warning"></i>Mes derniers quiz</div>
            <div class="card-body p-0">
                @forelse($resultats as $r)
                    <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                        <span class="small">{{ $r->quiz->titre }}</span>
                        <span class="badge {{ $r->score >= $r->total/2 ? 'bg-success' : 'bg-danger' }}">{{ $r->score }}/{{ $r->total }}</span>
                    </div>
                @empty
                    <p class="text-muted p-3 mb-0 small">Aucun quiz passé.</p>
                @endforelse
            </div>
        </div>

        {{-- Mes notes récentes --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-clipboard-check me-2 text-primary"></i>Mes notes récentes</span>
                <a href="{{ route('apprenant.notes.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @forelse($notes as $n)
                    <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <span class="small fw-semibold">{{ $n->matiere }}</span>
                            <div class="text-muted" style="font-size:.75rem;">{{ $n->formation->nom }}</div>
                        </div>
                        <span class="badge fs-6 {{ $n->note >= 10 ? 'bg-success' : 'bg-danger' }}">{{ $n->note }}/20</span>
                    </div>
                @empty
                    <p class="text-muted p-3 mb-0 small">Aucune note.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
