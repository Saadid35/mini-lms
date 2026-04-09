@extends('layouts.app')
@section('title', 'Notes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-clipboard-check me-2 text-primary"></i>Notes</h4>
    <a href="{{ route('admin.notes.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Ajouter une note</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($notes->isEmpty())
            <p class="text-muted p-3 mb-0">Aucune note.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Apprenant</th><th>Formation</th><th>Matière</th><th>Note</th><th></th></tr></thead>
                <tbody>
                @foreach($notes as $n)
                    <tr>
                        <td>{{ $n->user->name }}</td>
                        <td class="text-muted small">{{ $n->formation->nom }}</td>
                        <td>{{ $n->matiere }}</td>
                        <td>
                            <span class="badge {{ $n->note >= 10 ? 'bg-success' : 'bg-danger' }} fs-6">
                                {{ number_format($n->note, 2) }}/20
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.notes.edit', $n) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.notes.destroy', $n) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
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
