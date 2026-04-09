@extends('layouts.app')
@section('title', 'Nouvelle question')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Nouvelle question</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-body">
        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Quiz <span class="text-danger">*</span></label>
                <select name="quiz_id" class="form-select @error('quiz_id') is-invalid @enderror" required>
                    <option value="">— Choisir —</option>
                    @foreach($quizzes as $qz)
                        <option value="{{ $qz->id }}" {{ (old('quiz_id', $selectedQuiz) == $qz->id) ? 'selected' : '' }}>{{ $qz->titre }}</option>
                    @endforeach
                </select>
                @error('quiz_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
                <textarea name="question" rows="2" class="form-control @error('question') is-invalid @enderror" required>{{ old('question') }}</textarea>
                @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Ordre</label>
                <input type="number" name="ordre" min="0" class="form-control" value="{{ old('ordre', 0) }}" style="width:100px;">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Créer et ajouter les réponses</button>
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
