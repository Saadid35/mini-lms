@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-speedometer2 fs-4" style="color:#003f87;"></i>
    <h4 class="mb-0 fw-bold" style="color:#0f172a;">Tableau de bord</h4>
</div>

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;overflow:hidden;">
            <div class="card-body p-0 d-flex">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:72px;background:linear-gradient(145deg,#f97316,#ea6a0a);">
                    <i class="bi bi-collection fs-3 text-white"></i>
                </div>
                <div class="p-3">
                    <div class="fs-2 fw-bold lh-1 mb-1" style="color:#f97316;">{{ $totalFormations }}</div>
                    <div class="text-muted small fw-medium">Formations</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;overflow:hidden;">
            <div class="card-body p-0 d-flex">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:72px;background:linear-gradient(145deg,#f97316,#ea6a0a);">
                    <i class="bi bi-people fs-3 text-white"></i>
                </div>
                <div class="p-3">
                    <div class="fs-2 fw-bold lh-1 mb-1" style="color:#f97316;">{{ $totalApprenants }}</div>
                    <div class="text-muted small fw-medium">Apprenants</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;overflow:hidden;">
            <div class="card-body p-0 d-flex">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:72px;background:linear-gradient(145deg,#f97316,#ea6a0a);">
                    <i class="bi bi-patch-question fs-3 text-white"></i>
                </div>
                <div class="p-3">
                    <div class="fs-2 fw-bold lh-1 mb-1" style="color:#f97316;">{{ $totalQuizzes }}</div>
                    <div class="text-muted small fw-medium">Quiz</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent quiz results --}}
<div class="card border-0 shadow-sm" style="border-radius:14px;">
    <div class="card-header bg-white fw-semibold py-3 px-4" style="border-radius:14px 14px 0 0;border-bottom:1px solid #f1f5f9;">
        <i class="bi bi-clock-history me-2" style="color:#003f87;"></i>Derniers résultats de quiz
    </div>
    <div class="card-body p-0">
        @if($derniersResultats->isEmpty())
            <p class="text-muted p-4 mb-0">Aucun résultat pour l'instant.</p>
        @else
            <table class="table table-hover mb-0">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th class="px-4 py-3 text-muted small fw-semibold border-0">Apprenant</th>
                        <th class="py-3 text-muted small fw-semibold border-0">Quiz</th>
                        <th class="py-3 text-muted small fw-semibold border-0">Score</th>
                        <th class="py-3 text-muted small fw-semibold border-0">Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($derniersResultats as $r)
                    <tr>
                        <td class="px-4 py-3 fw-medium">{{ $r->user->name }}</td>
                        <td class="py-3">{{ $r->quiz->titre }}</td>
                        <td class="py-3">
                            @php $pass = $r->score >= $r->total / 2; @endphp
                            <span class="badge rounded-pill px-3"
                                  style="background:{{ $pass ? '#dcfce7' : '#fee2e2' }};color:{{ $pass ? '#16a34a' : '#dc2626' }};font-size:.75rem;">
                                {{ $r->score }}/{{ $r->total }}
                            </span>
                        </td>
                        <td class="py-3 text-muted small">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
