@extends('layouts.app')
@section('title', 'Apprenants')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-people me-2 text-success"></i>Apprenants</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($apprenants->isEmpty())
            <p class="text-muted p-3 mb-0">Aucun apprenant enregistré.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Nom</th><th>Email</th><th>Formations</th><th></th></tr></thead>
                <tbody>
                @foreach($apprenants as $a)
                    <tr>
                        <td class="fw-semibold">{{ $a->name }}</td>
                        <td class="text-muted">{{ $a->email }}</td>
                        <td><span class="badge bg-secondary">{{ $a->formations_count }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.apprenants.show', $a) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
