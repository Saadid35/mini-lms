<div class="mb-3">
    <label class="form-label fw-semibold">Apprenant <span class="text-danger">*</span></label>
    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
        <option value="">— Choisir —</option>
        @foreach($apprenants as $a)
            <option value="{{ $a->id }}" {{ old('user_id', $note->user_id ?? '') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
        @endforeach
    </select>
    @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Formation <span class="text-danger">*</span></label>
    <select name="formation_id" class="form-select @error('formation_id') is-invalid @enderror" required>
        <option value="">— Choisir —</option>
        @foreach($formations as $f)
            <option value="{{ $f->id }}" {{ old('formation_id', $note->formation_id ?? '') == $f->id ? 'selected' : '' }}>{{ $f->nom }}</option>
        @endforeach
    </select>
    @error('formation_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Matière / Module <span class="text-danger">*</span></label>
    <input type="text" name="matiere" class="form-control @error('matiere') is-invalid @enderror"
           value="{{ old('matiere', $note->matiere ?? '') }}" required>
    @error('matiere')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Note <span class="text-danger">*</span> <span class="text-muted fw-normal">(sur 20)</span></label>
    <input type="number" name="note" step="0.25" min="0" max="20" class="form-control @error('note') is-invalid @enderror"
           value="{{ old('note', $note->note ?? '') }}" required style="width:130px;">
    @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Commentaire</label>
    <textarea name="commentaire" rows="2" class="form-control">{{ old('commentaire', $note->commentaire ?? '') }}</textarea>
</div>
