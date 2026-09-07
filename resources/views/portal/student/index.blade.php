@extends('admin.layout.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card__wrapper">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="mb-1">Mon espace étudiant</h4>
                    <p class="text-muted mb-0">{{ $student->prenom_etudiant }} {{ $student->nom_etudiant }} — {{ $student->code_etudiant }}</p>
                </div>
                <span class="badge bg-primary">Étudiant</span>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6"><div class="card__wrapper"><small class="text-muted">Notes disponibles</small><h3 class="mt-2 mb-0">{{ $notes->count() }}</h3></div></div>
    <div class="col-xl-4 col-md-6"><div class="card__wrapper"><small class="text-muted">Moyenne</small><h3 class="mt-2 mb-0">{{ number_format($average, 2, ',', ' ') }}/20</h3></div></div>
    <div class="col-xl-4 col-md-6"><div class="card__wrapper"><small class="text-muted">Inscriptions</small><h3 class="mt-2 mb-0">{{ $inscriptions->count() }}</h3></div></div>

    <div class="col-12">
        <div class="card__wrapper">
            <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Mes notes</h5><span class="text-muted">Sur 20</span></div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead><tr><th>Matière</th><th>Évaluation</th><th>Classe</th><th>Année</th><th>Note</th><th>Appréciation</th></tr></thead>
                    <tbody>
                    @forelse($notes as $n)
                        <tr>
                            <td>{{ $n->evaluation?->matiere?->nom_matiere ?? '-' }}</td>
                            <td>{{ $n->evaluation?->nom_evaluation ?? '-' }}</td>
                            <td>{{ $n->evaluation?->classe?->nom_classe ?? '-' }}</td>
                            <td>{{ $n->evaluation?->anneeScolaire?->nom_annee_scolaire ?? '-' }}</td>
                            <td><strong>{{ $n->note }}/20</strong></td>
                            <td>{{ $n->appreciation ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">Aucune note disponible pour le moment.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card__wrapper">
            <h5>Mes inscriptions</h5>
            <div class="table-responsive"><table class="table">
                <thead><tr><th>Année</th><th>Classe</th><th>Date</th></tr></thead>
                <tbody>@forelse($inscriptions as $i)<tr><td>{{ $i->anneeScolaire?->nom_annee_scolaire ?? '-' }}</td><td>{{ $i->classe?->nom_classe ?? '-' }}</td><td>{{ optional($i->created_at)->format('d/m/Y') }}</td></tr>@empty<tr><td colspan="3" class="text-center">Aucune inscription.</td></tr>@endforelse</tbody>
            </table></div>
        </div>
    </div>
</div>
@endsection
