@extends('layouts.app')
@section('title', 'Modifier le sous-chapitre')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.sous-chapitres.show', $sousChapitre) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Modifier : {{ $sousChapitre->titre }}</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:700px;">
    <div class="card-body">
        <form action="{{ route('admin.sous-chapitres.update', $sousChapitre) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Chapitre <span class="text-danger">*</span></label>
                <select name="chapitre_id" class="form-select" required>
                    @foreach($chapitres as $c)
                        <option value="{{ $c->id }}" {{ old('chapitre_id', $sousChapitre->chapitre_id) == $c->id ? 'selected' : '' }}>
                            {{ $c->formation->nom }} › {{ $c->titre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre', $sousChapitre->titre) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Contenu</label>
                <textarea name="contenu" rows="8" class="form-control">{{ old('contenu', $sousChapitre->contenu) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Ordre</label>
                <input type="number" name="ordre" min="0" class="form-control" value="{{ old('ordre', $sousChapitre->ordre) }}" style="width:100px;">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.sous-chapitres.show', $sousChapitre) }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
