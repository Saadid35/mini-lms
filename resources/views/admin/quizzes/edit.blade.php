@extends('layouts.app')
@section('title', 'Modifier le quiz')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Modifier : {{ $quiz->titre }}</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-body">
        <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Sous-chapitre <span class="text-danger">*</span></label>
                <select name="sous_chapitre_id" class="form-select" required>
                    @foreach($sousChapitres as $sc)
                        <option value="{{ $sc->id }}" {{ old('sous_chapitre_id', $quiz->sous_chapitre_id) == $sc->id ? 'selected' : '' }}>
                            {{ $sc->chapitre->formation->nom }} › {{ $sc->chapitre->titre }} › {{ $sc->titre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre', $quiz->titre) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="2" class="form-control">{{ old('description', $quiz->description) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
