@extends('layouts.app')
@section('title', 'Modifier la question')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.questions.show', $question) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Modifier la question</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-body">
        <form action="{{ route('admin.questions.update', $question) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Quiz <span class="text-danger">*</span></label>
                <select name="quiz_id" class="form-select" required>
                    @foreach($quizzes as $qz)
                        <option value="{{ $qz->id }}" {{ old('quiz_id', $question->quiz_id) == $qz->id ? 'selected' : '' }}>{{ $qz->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
                <textarea name="question" rows="2" class="form-control" required>{{ old('question', $question->question) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Ordre</label>
                <input type="number" name="ordre" min="0" class="form-control" value="{{ old('ordre', $question->ordre) }}" style="width:100px;">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.questions.show', $question) }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
