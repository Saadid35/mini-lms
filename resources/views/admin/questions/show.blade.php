@extends('layouts.app')
@section('title', 'Gérer la question')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.quizzes.show', $question->quiz) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Question : {{ Str::limit($question->question, 60) }}</h4>
</div>

<div class="row g-4">
    {{-- Réponses existantes --}}
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Réponses ({{ $question->reponses->count() }})</div>
            <div class="card-body p-0">
                @forelse($question->reponses as $r)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom {{ $r->est_correcte ? 'bg-success bg-opacity-10' : '' }}">
                        <span>
                            @if($r->est_correcte)<i class="bi bi-check-circle-fill text-success me-2"></i>@else<i class="bi bi-circle text-muted me-2"></i>@endif
                            {{ $r->texte }}
                        </span>
                        <form action="{{ route('admin.reponses.destroy', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted p-3 mb-0">Aucune réponse.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Formulaire ajout réponse --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-plus-circle me-2 text-primary"></i>Ajouter une réponse</div>
            <div class="card-body">
                <form action="{{ route('admin.questions.reponses.store', $question) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Texte de la réponse <span class="text-danger">*</span></label>
                        <input type="text" name="texte" class="form-control @error('texte') is-invalid @enderror" value="{{ old('texte') }}" required>
                        @error('texte')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="est_correcte" id="est_correcte" class="form-check-input" value="1">
                        <label class="form-check-label text-success fw-semibold" for="est_correcte">
                            <i class="bi bi-check-circle me-1"></i>C'est la bonne réponse
                        </label>
                    </div>
                    <button class="btn btn-primary btn-sm w-100">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
