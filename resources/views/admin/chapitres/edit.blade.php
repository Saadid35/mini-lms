@extends('layouts.app')
@section('title', 'Modifier le chapitre')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.chapitres.show', $chapitre) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Modifier : {{ $chapitre->titre }}</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-body">
        <form action="{{ route('admin.chapitres.update', $chapitre) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Formation <span class="text-danger">*</span></label>
                <select name="formation_id" class="form-select" required>
                    @foreach($formations as $f)
                        <option value="{{ $f->id }}" {{ old('formation_id', $chapitre->formation_id) == $f->id ? 'selected' : '' }}>{{ $f->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre', $chapitre->titre) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="2" class="form-control">{{ old('description', $chapitre->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Ordre</label>
                <input type="number" name="ordre" min="0" class="form-control" value="{{ old('ordre', $chapitre->ordre) }}" style="width:100px;">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.chapitres.show', $chapitre) }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
