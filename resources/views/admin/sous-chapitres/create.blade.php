@extends('layouts.app')
@section('title', 'Nouveau sous-chapitre')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.sous-chapitres.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Nouveau sous-chapitre</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:700px;">
    <div class="card-body">
        <form action="{{ route('admin.sous-chapitres.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Chapitre <span class="text-danger">*</span></label>
                <select name="chapitre_id" class="form-select @error('chapitre_id') is-invalid @enderror" required>
                    <option value="">— Choisir —</option>
                    @foreach($chapitres as $c)
                        <option value="{{ $c->id }}" {{ (old('chapitre_id', $selectedChapitre) == $c->id) ? 'selected' : '' }}>
                            {{ $c->formation->nom }} › {{ $c->titre }}
                        </option>
                    @endforeach
                </select>
                @error('chapitre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" required>
                @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Contenu pédagogique (HTML accepté)</label>
                <textarea name="contenu" rows="8" class="form-control">{{ old('contenu') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Ordre</label>
                <input type="number" name="ordre" min="0" class="form-control" value="{{ old('ordre', 0) }}" style="width:100px;">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Créer</button>
                <a href="{{ route('admin.sous-chapitres.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
