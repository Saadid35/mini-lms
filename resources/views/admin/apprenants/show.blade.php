@extends('layouts.app')
@section('title', $user->name)

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.apprenants.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0"><i class="bi bi-person-circle me-2 text-success"></i>{{ $user->name }}</h4>
</div>
<p class="text-muted">{{ $user->email }}</p>

<div class="row g-4">
    {{-- Formations --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-collection me-2 text-primary"></i>Formations</div>
            <div class="card-body p-0">
                @forelse($user->formations as $f)
                    <div class="px-3 py-2 border-bottom">
                        <a href="{{ route('admin.formations.show', $f) }}" class="text-decoration-none">{{ $f->nom }}</a>
                        <div class="text-muted small">{{ $f->pivot->inscrit_le ? \Carbon\Carbon::parse($f->pivot->inscrit_le)->format('d/m/Y') : '' }}</div>
                    </div>
                @empty
                    <p class="text-muted p-3 mb-0 small">Aucune formation.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Résultats quiz --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-patch-question me-2 text-warning"></i>Quiz passés</div>
            <div class="card-body p-0">
                @forelse($user->quizResults as $r)
                    <div class="px-3 py-2 border-bottom d-flex justify-content-between">
                        <span class="small">{{ $r->quiz->titre }}</span>
                        <span class="badge {{ $r->score >= $r->total/2 ? 'bg-success' : 'bg-danger' }}">{{ $r->score }}/{{ $r->total }}</span>
                    </div>
                @empty
                    <p class="text-muted p-3 mb-0 small">Aucun quiz passé.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Notes --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-clipboard-check me-2 text-primary"></i>Notes</div>
            <div class="card-body p-0">
                @forelse($user->notes as $n)
                    <div class="px-3 py-2 border-bottom d-flex justify-content-between">
                        <div>
                            <span class="small fw-semibold">{{ $n->matiere }}</span>
                            <div class="text-muted" style="font-size:.75rem;">{{ $n->formation->nom }}</div>
                        </div>
                        <span class="badge {{ $n->note >= 10 ? 'bg-success' : 'bg-danger' }}">{{ $n->note }}/20</span>
                    </div>
                @empty
                    <p class="text-muted p-3 mb-0 small">Aucune note.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
