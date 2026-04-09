@extends('layouts.app')
@section('title', 'Générateur IA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                 style="width:72px;height:72px;background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                <i class="bi bi-stars text-white fs-2"></i>
            </div>
            <h3 class="fw-bold mb-1">Générateur de contenu IA</h3>
            <p class="text-muted">Décrivez un sujet pédagogique et l'IA créera automatiquement<br>
            une formation complète avec chapitres, contenus et quiz.</p>
        </div>

        {{-- Erreur API --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @if(session('raw_response'))
                <details class="mb-4">
                    <summary class="text-muted small">Voir la réponse brute de l'IA</summary>
                    <pre class="bg-dark text-light p-3 rounded mt-2 small" style="overflow:auto;max-height:300px;">{{ session('raw_response') }}</pre>
                </details>
            @endif
        @endif

        {{-- Formulaire --}}
        <div class="card border-0 shadow">
            <div class="card-body p-4">
                <form action="{{ route('admin.ai-generator.generate') }}" method="POST" id="aiForm">
                    @csrf

                    {{-- Sujet --}}
                    <div class="mb-4">
                        <label for="sujet" class="form-label fw-semibold fs-6">
                            Sujet de la formation <span class="text-danger">*</span>
                        </label>
                        <textarea
                            name="sujet"
                            id="sujet"
                            rows="4"
                            class="form-control form-control-lg @error('sujet') is-invalid @enderror"
                            placeholder="Ex : Les verbes irréguliers en anglais&#10;Ex : Introduction à la comptabilité pour débutants&#10;Ex : Les bases du droit du travail français"
                            required
                        >{{ old('sujet') }}</textarea>
                        @error('sujet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Soyez précis et spécifique pour obtenir un meilleur contenu pédagogique.</div>
                    </div>

                    {{-- Paramètres de structure --}}
                    <div class="bg-light rounded p-3 mb-4">
                        <div class="fw-semibold small mb-3"><i class="bi bi-sliders me-2 text-primary"></i>Paramètres de génération</div>
                        <div class="row g-3">
                            <div class="col-sm-6 col-md-3">
                                <label for="nb_chapitres" class="form-label small fw-semibold">Chapitres</label>
                                <input type="number" name="nb_chapitres" id="nb_chapitres"
                                       class="form-control @error('nb_chapitres') is-invalid @enderror"
                                       min="1" max="10" value="{{ old('nb_chapitres', 3) }}" required>
                                @error('nb_chapitres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="nb_sous_chapitres" class="form-label small fw-semibold">Sous-chap. / chapitre</label>
                                <input type="number" name="nb_sous_chapitres" id="nb_sous_chapitres"
                                       class="form-control @error('nb_sous_chapitres') is-invalid @enderror"
                                       min="1" max="5" value="{{ old('nb_sous_chapitres', 2) }}" required>
                                @error('nb_sous_chapitres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="nb_questions" class="form-label small fw-semibold">Questions / quiz</label>
                                <input type="number" name="nb_questions" id="nb_questions"
                                       class="form-control @error('nb_questions') is-invalid @enderror"
                                       min="3" max="15" value="{{ old('nb_questions', 5) }}" required>
                                @error('nb_questions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6 col-md-3 d-flex align-items-end">
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="quiz_par_chapitre" id="quiz_par_chapitre"
                                           class="form-check-input" value="1"
                                           {{ old('quiz_par_chapitre', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-semibold" for="quiz_par_chapitre">
                                        Quiz par chapitre
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Résumé dynamique --}}
                    <div class="bg-primary bg-opacity-10 rounded p-3 mb-4" id="summary">
                        <div class="text-primary small fw-semibold mb-2">L'IA va générer :</div>
                        <div class="row g-2">
                            <div class="col-6 col-md-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-collection text-primary"></i>
                                    <span class="small">1 formation</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-journals text-success"></i>
                                    <span class="small" id="sum-chapitres">3 chapitres</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-file-text text-info"></i>
                                    <span class="small" id="sum-sc">6 sous-chapitres</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-patch-question text-warning"></i>
                                    <span class="small" id="sum-quiz">3 quiz (5 questions)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg w-100 text-white fw-semibold" id="submitBtn"
                            style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                        <i class="bi bi-stars me-2"></i>Générer avec l'IA
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-muted small mt-3">
            <i class="bi bi-info-circle me-1"></i>
            La génération peut prendre 20 à 60 secondes selon la taille du contenu demandé.
        </p>

    </div>
</div>
@endsection

@push('scripts')
<script>
// Met à jour le résumé dynamique
function updateSummary() {
    const ch  = parseInt(document.getElementById('nb_chapitres').value)    || 3;
    const sc  = parseInt(document.getElementById('nb_sous_chapitres').value) || 2;
    const q   = parseInt(document.getElementById('nb_questions').value)    || 5;
    const qpc = document.getElementById('quiz_par_chapitre').checked;

    document.getElementById('sum-chapitres').textContent = ch + ' chapitre' + (ch > 1 ? 's' : '');
    document.getElementById('sum-sc').textContent        = (ch * sc) + ' sous-chapitre' + (ch * sc > 1 ? 's' : '');
    const nbQuiz = qpc ? ch : 1;
    document.getElementById('sum-quiz').textContent      = nbQuiz + ' quiz (' + q + ' questions)';
}

['nb_chapitres','nb_sous_chapitres','nb_questions','quiz_par_chapitre'].forEach(id => {
    document.getElementById(id).addEventListener('input', updateSummary);
    document.getElementById(id).addEventListener('change', updateSummary);
});
updateSummary();

// Spinner sur submit
document.getElementById('aiForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
        Génération en cours… veuillez patienter
    `;
});
</script>
@endpush
