<div class="mb-3">
    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
           value="{{ old('nom', $formation->nom ?? '') }}" required>
    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Description</label>
    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $formation->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row g-3">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Niveau <span class="text-danger">*</span></label>
        <select name="niveau" class="form-select @error('niveau') is-invalid @enderror" required>
            @foreach(['débutant','intermédiaire','avancé'] as $n)
                <option value="{{ $n }}" {{ old('niveau', $formation->niveau ?? '') === $n ? 'selected' : '' }}>{{ ucfirst($n) }}</option>
            @endforeach
        </select>
        @error('niveau')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Durée (heures)</label>
        <input type="number" name="duree" min="1" class="form-control @error('duree') is-invalid @enderror"
               value="{{ old('duree', $formation->duree ?? '') }}">
        @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
