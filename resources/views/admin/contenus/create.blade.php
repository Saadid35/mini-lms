@extends('layouts.app')
@section('title', 'Nouveau contenu')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.contenus.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Nouveau contenu pédagogique</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:700px;">
    <div class="card-body">
        <form action="{{ route('admin.contenus.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Sous-chapitre <span class="text-danger">*</span></label>
                <select name="sous_chapitre_id" class="form-select @error('sous_chapitre_id') is-invalid @enderror" required>
                    <option value="">— Choisir —</option>
                    @foreach($sousChapitres as $sc)
                        <option value="{{ $sc->id }}" {{ (old('sous_chapitre_id', $selectedSousChapitre) == $sc->id) ? 'selected' : '' }}>
                            {{ $sc->chapitre->formation->nom }} › {{ $sc->chapitre->titre }} › {{ $sc->titre }}
                        </option>
                    @endforeach
                </select>
                @error('sous_chapitre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Texte / Résumé</label>
                <textarea name="texte" rows="8" class="form-control">{{ old('texte') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Lien de ressource</label>
                <input type="url" name="lien_ressource" class="form-control @error('lien_ressource') is-invalid @enderror" value="{{ old('lien_ressource') }}" placeholder="https://...">
                @error('lien_ressource')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="importe_ia" id="importe_ia" class="form-check-input" value="1" {{ old('importe_ia') ? 'checked' : '' }}>
                <label class="form-check-label" for="importe_ia">Contenu généré / importé par IA</label>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Créer</button>
                <a href="{{ route('admin.contenus.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
