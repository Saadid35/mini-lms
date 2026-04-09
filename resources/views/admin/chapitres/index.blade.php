@extends('layouts.app')
@section('title', 'Chapitres')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-journals me-2 text-primary"></i>Chapitres</h4>
    <a href="{{ route('admin.chapitres.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau chapitre</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($chapitres->isEmpty())
            <p class="text-muted p-3 mb-0">Aucun chapitre.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Titre</th><th>Formation</th><th>Ordre</th><th></th></tr></thead>
                <tbody>
                @foreach($chapitres as $c)
                    <tr>
                        <td class="fw-semibold">{{ $c->titre }}</td>
                        <td><a href="{{ route('admin.formations.show', $c->formation) }}" class="text-decoration-none">{{ $c->formation->nom }}</a></td>
                        <td>{{ $c->ordre }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.chapitres.show', $c) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.chapitres.edit', $c) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.chapitres.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
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
