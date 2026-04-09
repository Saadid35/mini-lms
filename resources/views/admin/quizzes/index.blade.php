@extends('layouts.app')
@section('title', 'Quiz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-patch-question me-2 text-warning"></i>Quiz</h4>
    <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau quiz</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($quizzes->isEmpty())
            <p class="text-muted p-3 mb-0">Aucun quiz.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Titre</th><th>Sous-chapitre</th><th>Questions</th><th></th></tr></thead>
                <tbody>
                @foreach($quizzes as $q)
                    <tr>
                        <td class="fw-semibold">{{ $q->titre }}</td>
                        <td class="small text-muted">{{ $q->sousChapitre->chapitre->formation->nom }} › {{ $q->sousChapitre->titre }}</td>
                        <td><span class="badge bg-secondary">{{ $q->questions->count() }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.quizzes.show', $q) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.quizzes.edit', $q) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.quizzes.destroy', $q) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce quiz et toutes ses questions ?')">
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
