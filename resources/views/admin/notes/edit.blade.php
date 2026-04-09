@extends('layouts.app')
@section('title', 'Modifier la note')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.notes.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Modifier la note</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:500px;">
    <div class="card-body">
        <form action="{{ route('admin.notes.update', $note) }}" method="POST">
            @csrf @method('PUT')
            @include('admin.notes._form')
            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.notes.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
