@extends('layouts.app')
@section('title', 'Formations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-collection me-2 text-primary"></i>Formations</h4>
    <a href="{{ route('admin.formations.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle formation
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($formations->isEmpty())
            <p class="text-muted p-3 mb-0">Aucune formation. <a href="{{ route('admin.formations.create') }}">Créer la première</a>.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Nom</th><th>Niveau</th><th>Durée</th><th>Chapitres</th><th>Apprenants</th><th></th></tr>
                </thead>
                <tbody>
                @foreach($formations as $f)
                    <tr>
                        <td class="fw-semibold">{{ $f->nom }}</td>
                        <td><span class="badge bg-secondary">{{ $f->niveau }}</span></td>
                        <td>{{ $f->duree ? $f->duree.'h' : '—' }}</td>
                        <td>{{ $f->chapitres_count }}</td>
                        <td>{{ $f->apprenants_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.formations.show', $f) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.formations.edit', $f) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.formations.destroy', $f) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette formation ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
