@extends('layouts.app')
@section('title', 'Questions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Questions</h4>
    <a href="{{ route('admin.questions.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouvelle question</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($questions->isEmpty())
            <p class="text-muted p-3 mb-0">Aucune question.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Question</th><th>Quiz</th><th></th></tr></thead>
                <tbody>
                @foreach($questions as $q)
                    <tr>
                        <td>{{ Str::limit($q->question, 70) }}</td>
                        <td class="text-muted small">{{ $q->quiz->titre }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.questions.show', $q) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.questions.edit', $q) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
