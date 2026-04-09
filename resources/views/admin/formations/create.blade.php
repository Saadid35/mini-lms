@extends('layouts.app')
@section('title', 'Nouvelle formation')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.formations.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Nouvelle formation</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-body">
        <form action="{{ route('admin.formations.store') }}" method="POST">
            @csrf
            @include('admin.formations._form')
            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-primary">Créer</button>
                <a href="{{ route('admin.formations.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
