@extends('layouts.app')
@section('title', 'Mes notes')

@section('content')
<h4 class="mb-4"><i class="bi bi-clipboard-check me-2 text-primary"></i>Mes notes</h4>

@if($notes->isEmpty())
    <div class="alert alert-info">Aucune note enregistrée pour le moment.</div>
@else
    @php
        $moyenne = $notes->avg('note');
    @endphp
    <div class="alert alert-secondary mb-4">
        <strong>Moyenne générale :</strong>
        <span class="badge fs-6 {{ $moyenne >= 10 ? 'bg-success' : 'bg-danger' }} ms-2">
            {{ number_format($moyenne, 2) }}/20
        </span>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Matière</th><th>Formation</th><th>Note</th><th>Commentaire</th></tr>
                </thead>
                <tbody>
                @foreach($notes as $n)
                    <tr>
                        <td class="fw-semibold">{{ $n->matiere }}</td>
                        <td class="text-muted small">{{ $n->formation->nom }}</td>
                        <td>
                            <span class="badge fs-6 {{ $n->note >= 10 ? 'bg-success' : 'bg-danger' }}">
                                {{ number_format($n->note, 2) }}/20
                            </span>
                        </td>
                        <td class="text-muted small">{{ $n->commentaire ?? '—' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
