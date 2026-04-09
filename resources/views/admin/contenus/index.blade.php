@extends('layouts.app')
@section('title', 'Contenus pédagogiques')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-files me-2 text-success"></i>Contenus pédagogiques</h4>
    <a href="{{ route('admin.contenus.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau contenu</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($contenus->isEmpty())
            <p class="text-muted p-3 mb-0">Aucun contenu.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Titre</th><th>Sous-chapitre</th><th>IA</th><th></th></tr></thead>
                <tbody>
                @foreach($contenus as $c)
                    <tr>
                        <td class="fw-semibold">{{ $c->titre }}</td>
                        <td class="small text-muted">{{ $c->sousChapitre->chapitre->formation->nom }} › {{ $c->sousChapitre->titre }}</td>
                        <td>@if($c->importe_ia)<span class="badge" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">IA</span>@endif</td>
                        <td class="text-end">
                            <a href="{{ route('admin.contenus.edit', $c) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.contenus.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
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
