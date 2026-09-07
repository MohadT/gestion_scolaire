@extends('admin.layout.master')

@section('content')
<div class="col-xxl-12">
    <div class="card__wrapper">
        <!-- En-tête -->
        <div class="card__header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="card__header-title mb-1">
                    <i class="fa-regular fa-calendar me-2 text-success"></i>
                    {{ $annee_scolaire->nom_annee_scolaire }}
                </h4>
                <p class="text-muted small mb-0">Détails de l'année scolaire</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('anneescolaire.edit', $annee_scolaire->id) }}"
                   class="btn btn-outline-warning btn-action">
                    <i class="fa-regular fa-pen-to-square me-1"></i>Modifier
                </a>
                <a href="{{ route('anneescolaire.index') }}"
                   class="btn btn-outline-dark btn-action">
                    <i class="fa-regular fa-arrow-left me-1"></i>Retour
                </a>
            </div>
        </div>

        <div class="card__body">
            <div class="row g-4">
                <!-- Carte Info -->
                <div class="col-lg-4">
                    <div class="card border shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <span class="fs-1">📅</span>
                            </div>
                            <h4 class="fw-bold text-dark mb-1">{{ $annee_scolaire->nom_annee_scolaire }}</h4>
                            <span class="badge bg-success text-white px-3 py-2 rounded-pill">
                                <i class="fa-regular fa-circle-check me-1"></i>Active
                            </span>

                            <hr class="my-4">

                            <div class="text-start">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="text-muted small" style="width: 50%;">ID</span>
                                    <strong>#{{ $annee_scolaire->id }}</strong>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="text-muted small" style="width: 50%;">Inscriptions</span>
                                    <strong>{{ $inscriptions->total() }} étudiant(s)</strong>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="text-muted small" style="width: 50%;">Créée le</span>
                                    <strong>{{ $annee_scolaire->created_at->format('d/m/Y') }}</strong>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="text-muted small" style="width: 50%;">Modifiée le</span>
                                    <strong>{{ $annee_scolaire->updated_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liste des étudiants inscrits -->
                <div class="col-lg-8">
                    <div class="card border shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0">
                                <i class="fa-regular fa-users me-2 text-success"></i>
                                Étudiants inscrits
                                <span class="badge bg-success ms-2">{{ $inscriptions->total() }}</span>
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @if($inscriptions->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-3">
                                        <thead>
                                            <tr>
                                                <th>Matricule</th>
                                                <th>Nom</th>
                                                <th>Prénom</th>
                                                <th>Classe</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($inscriptions as $inscription)
                                            <tr>
                                                <td>
                                                    <span class="text-muted small">
                                                        #{{ str_pad($inscription->etudiant->id, 6, '0', STR_PAD_LEFT) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('etudiants.show', $inscription->etudiant->id) }}"
                                                       class="text-decoration-none text-dark fw-semibold">
                                                        {{ $inscription->etudiant->nom_etudiant }}
                                                    </a>
                                                </td>
                                                <td>{{ $inscription->etudiant->prenom_etudiant }}</td>
                                                <td>
                                                    @if($inscription->classe)
                                                        <span class="text-success fw-semibold small">
                                                            {{ $inscription->classe->nom_classe }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-muted small">
                                                        {{ \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('etudiants.show', $inscription->etudiant->id) }}"
                                                       class="btn btn-sm btn-outline-success rounded-circle"
                                                       title="Voir l'étudiant"
                                                       style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-muted small">
                                        {{ $inscriptions->firstItem() }} - {{ $inscriptions->lastItem() }}
                                        sur {{ $inscriptions->total() }}
                                    </div>
                                    {{ $inscriptions->links() }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <span class="fs-1 mb-3 d-block">📋</span>
                                    <h5 class="text-muted">Aucun étudiant inscrit</h5>
                                    <p class="text-muted small">
                                        Aucun étudiant pour <strong>{{ $annee_scolaire->nom_annee_scolaire }}</strong>
                                    </p>
                                    <a href="{{ route('etudiants.index') }}" class="btn btn-success mt-2">
                                        <i class="fa-regular fa-user-plus me-1"></i>
                                        Voir les étudiants
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="d-flex justify-content-between mt-4">
                <form action="{{ route('anneescolaire.destroy', $annee_scolaire->id) }}"
                      method="POST"
                      onsubmit="return confirm('Supprimer cette année scolaire ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-action">
                        <i class="fa-regular fa-trash me-1"></i>Supprimer
                    </button>
                </form>
                <div class="d-flex gap-2">
                    <a href="{{ route('anneescolaire.edit', $annee_scolaire->id) }}"
                       class="btn btn-outline-warning btn-action">
                        <i class="fa-regular fa-pen-to-square me-1"></i>Modifier
                    </a>
                    <a href="{{ route('anneescolaire.index') }}"
                       class="btn btn-outline-dark btn-action">
                        <i class="fa-regular fa-list me-1"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
}

.table thead th {
    background: #fff;
    border-bottom: 2px solid #e0e0e0;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #888;
    padding: 10px 12px;
    font-weight: 600;
}

.table tbody td {
    padding: 12px;
    vertical-align: middle;
    border-bottom: 1px solid #f5f5f5;
    font-size: 0.9rem;
}

.table tbody tr:hover {
    background-color: #fafff8;
}

.btn-action {
    border-radius: 8px;
    padding: 8px 18px;
    font-weight: 500;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.btn-action:hover {
    transform: translateY(-1px);
}

.pagination {
    margin: 0;
}

.page-link {
    border-radius: 6px;
    margin: 0 2px;
    border: none;
    color: #198754;
    padding: 6px 12px;
    font-size: 0.85rem;
}

.page-item.active .page-link {
    background: #198754;
    border-radius: 6px;
    color: white;
}

.badge {
    font-weight: 500;
}

@media (max-width: 768px) {
    .btn-action {
        width: 100%;
        margin-bottom: 5px;
    }
    .card__header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start !important;
    }
}
</style>
@endsection
