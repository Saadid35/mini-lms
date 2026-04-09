@extends('layouts.app')
@section('title', 'Sous-chapitres')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-file-text me-2 text-primary"></i>Sous-chapitres</h4>
    <a href="{{ route('admin.sous-chapitres.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($sousChapitres->isEmpty())
            <p class="text-muted p-3 mb-0">Aucun sous-chapitre.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Titre</th><th>Chapitre</th><th>Formation</th><th></th></tr></thead>
                <tbody>
                @foreach($sousChapitres as $sc)
                    <tr>
                        <td class="fw-semibold">{{ $sc->titre }}</td>
                        <td>{{ $sc->chapitre->titre }}</td>
                        <td>{{ $sc->chapitre->formation->nom }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.sous-chapitres.show', $sc) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.sous-chapitres.edit', $sc) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.sous-chapitres.destroy', $sc) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
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
