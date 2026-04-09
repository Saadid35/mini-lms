@extends('layouts.app')
@section('title', $formation->nom)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <a href="{{ route('admin.formations.index') }}" class="btn btn-sm btn-outline-secondary mb-2"><i class="bi bi-arrow-left"></i></a>
        <h4 class="mb-1">{{ $formation->nom }}</h4>
        <span class="badge bg-secondary">{{ $formation->niveau }}</span>
        @if($formation->duree) <span class="badge bg-light text-dark border">{{ $formation->duree }}h</span> @endif
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.formations.edit', $formation) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Modifier</a>
        <a href="{{ route('admin.chapitres.create', ['formation_id' => $formation->id]) }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Ajouter un chapitre</a>
    </div>
</div>

@if($formation->description)
    <p class="text-muted mb-4">{{ $formation->description }}</p>
@endif

<div class="row g-4">
    {{-- Chapitres --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-journals me-2 text-primary"></i>Chapitres ({{ $formation->chapitres->count() }})
            </div>
            <div class="card-body p-0">
                @forelse($formation->chapitres as $chapitre)
                    <div class="border-bottom px-3 py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <a href="{{ route('admin.chapitres.show', $chapitre) }}" class="fw-semibold text-decoration-none">
                                    <i class="bi bi-book me-1 text-primary"></i>{{ $chapitre->titre }}
                                </a>
                                @if($chapitre->description)
                                    <div class="text-muted small">{{ Str::limit($chapitre->description, 80) }}</div>
                                @endif
                                <div class="mt-1">
                                    @foreach($chapitre->sousChapitres as $sc)
                                        <span class="badge bg-light text-dark border me-1 mb-1">
                                            <i class="bi bi-file-text me-1"></i>{{ $sc->titre }}
                                            @if($sc->quiz) <i class="bi bi-patch-question text-warning ms-1"></i> @endif
                                        </span>
                                    @endforeach
                                    <a href="{{ route('admin.sous-chapitres.create', ['chapitre_id' => $chapitre->id]) }}" class="badge bg-primary text-white text-decoration-none">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.chapitres.edit', $chapitre) }}" class="btn btn-xs btn-outline-primary btn-sm py-0 px-2"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.chapitres.destroy', $chapitre) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-xs btn-outline-danger btn-sm py-0 px-2"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted p-3 mb-0">Aucun chapitre. <a href="{{ route('admin.chapitres.create', ['formation_id' => $formation->id]) }}">Ajouter</a>.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Apprenants inscrits --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-people me-2 text-success"></i>Apprenants inscrits ({{ $formation->apprenants->count() }})
            </div>
            <div class="card-body">
                {{-- Formulaire d'inscription --}}
                <form action="{{ route('admin.formations.inscrire', $formation) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group input-group-sm">
                        <select name="user_id" class="form-select">
                            @foreach($apprenants as $a)
                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success">Inscrire</button>
                    </div>
                </form>
                @forelse($formation->apprenants as $a)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="bi bi-person-circle me-1 text-muted"></i>{{ $a->name }}</span>
                        <form action="{{ route('admin.formations.desinscrire', [$formation, $a]) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger btn-sm py-0 px-2" title="Désinscrire"><i class="bi bi-x-lg"></i></button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Aucun apprenant inscrit.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
