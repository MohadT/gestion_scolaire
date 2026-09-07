
@extends('admin.layout.master')

@section('content')

<div class="col-xxl-12">

    <div class="card__wrapper">

        <div class="card__header d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="card__header-title mb-1">
                    Liste des inscriptions
                </h4>
            </div>

            <a href="{{ route('etudiants.create') }}" class="btn btn-success">
                <i class="fa-regular fa-plus me-1"></i>
                Nouvel étudiant
            </a>

        </div>

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show" role="alert">

                <i class="fa-regular fa-circle-check me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                </button>

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <i class="fa-regular fa-circle-exclamation me-2"></i>

                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                </button>

            </div>

        @endif

        <div class="row g-2 mb-3">

            <div class="col-md-3">
                <input
                    type="text"
                    id="searchEtudiant"
                    class="form-control form-control-sm search-input"
                    placeholder="🔍 Étudiant..."
                    data-col="0"
                >
            </div>

            <div class="col-md-3">
                <input
                    type="text"
                    id="searchClasse"
                    class="form-control form-control-sm search-input"
                    placeholder="🔍 Classe..."
                    data-col="1"
                >
            </div>

            <div class="col-md-3">
                <input
                    type="text"
                    id="searchAnnee"
                    class="form-control form-control-sm search-input"
                    placeholder="🔍 Année scolaire..."
                    data-col="2"
                >
            </div>

            <div class="col-md-3">

                <button
                    id="resetSearch"
                    class="btn btn-outline-secondary btn-sm w-100"
                    type="button"
                >
                    <i class="fa-regular fa-xmark me-1"></i>
                    Effacer
                </button>

            </div>

        </div>

        <div class="text-muted small mb-3">

            <span id="resultCount">
                {{ $inscriptions->count() }}
            </span>

            résultat(s) sur {{ $inscriptions->total() }}

        </div>

        <div class="table__wrapper table-responsive">

            @if($inscriptions->count() > 0)

                <table class="table mb-20" id="inscriptionsTable">

                    <thead>

                        <tr class="table__title">

                            <th>Étudiant</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th>Frais scolarité</th>
                            <th>Date</th>
                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody class="table__body">

                        @foreach($inscriptions as $inscription)

                            @php
                                $fraisPaye = (float) ($inscription->frais_scolarite ?? 0);
                                $prixClasse = (float) ($inscription->classe->prix ?? 0);
                                $reste = max(0, $prixClasse - $fraisPaye);
                            @endphp

                            <tr class="searchable-row">

                                <td class="col-0">

                                    <a
                                        href="{{ route('etudiants.show', $inscription->etudiant->id) }}"
                                        class="text-decoration-none fw-semibold text-dark"
                                    >
                                        {{ $inscription->etudiant->prenom_etudiant }}
                                        {{ $inscription->etudiant->nom_etudiant }}
                                    </a>

                                </td>

                                <td class="col-1">
                                    {{ $inscription->classe->nom_classe ?? 'N/A' }}
                                </td>

                                <td class="col-2">
                                    {{ $inscription->anneeScolaire->nom_annee_scolaire ?? 'N/A' }}
                                </td>

                                <td>

                               

                                    @if($prixClasse > 0 && $fraisPaye >= $prixClasse)

                                        <span class="badge bg-success px-3 py-2 rounded-pill mt-1">
                                            <i class="fa-regular fa-circle-check me-1"></i>
                                            Payé
                                        </span>

                                    @elseif($fraisPaye > 0)

                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mt-1">
                                            <i class="fa-regular fa-circle-half-stroke me-1"></i>
                                            Partiel
                                        </span>

                                        <div class="small text-danger mt-1">
                                            Reste :
                                            {{ number_format($reste, 0, ',', ' ') }}
                                            FCFA
                                        </div>

                                    @else

                                        <span class="badge bg-danger px-3 py-2 rounded-pill mt-1">
                                            <i class="fa-regular fa-circle-xmark me-1"></i>
                                            Impayé
                                        </span>

                                        <div class="small text-danger mt-1">
                                            Reste :
                                            {{ number_format($reste, 0, ',', ' ') }}
                                            FCFA
                                        </div>

                                    @endif

                                </td>

                                <td>

                                    <span class="text-muted small">
                                        {{ $inscription->created_at ? $inscription->created_at->format('d/m/Y') : '-' }}
                                    </span>

                                </td>

                                <td>

                                    <div class="d-flex align-items-center gap-1">

                                        <a
                                            href="{{ route('inscriptions.show', $inscription->id) }}"
                                            class="table__icon view"
                                            title="Voir"
                                        >
                                            <i class="fa-regular fa-eye"></i>
                                        </a>

                                        @if($reste > 0)

                                            <a
                                                href="{{ route('inscriptions.paiement', $inscription->id) }}"
                                                class="table__icon payment"
                                                title="Effectuer un paiement"
                                            >
                                                <i class="fa-regular fa-money-bill-wave"></i>
                                            </a>

                                        @else

                                            <span
                                                class="table__icon payment-disabled"
                                                title="Scolarité déjà payée"
                                            >
                                                <i class="fa-regular fa-circle-check"></i>
                                            </span>

                                        @endif

                                        <a
                                            href="{{ route('inscriptions.edit', $inscription->id) }}"
                                            class="table__icon edit"
                                            title="Modifier"
                                        >
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>

                                        <form
                                            action="{{ route('inscriptions.destroy', $inscription->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Supprimer cette inscription ?');"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="table__icon delete border-0 bg-transparent"
                                                title="Supprimer"
                                            >
                                                <i class="fa-regular fa-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

                <div class="d-flex justify-content-between align-items-center mt-4">

                    <div class="text-muted small">
                        {{ $inscriptions->firstItem() }}
                        -
                        {{ $inscriptions->lastItem() }}
                        sur
                        {{ $inscriptions->total() }}
                    </div>

                    {{ $inscriptions->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <i class="fa-regular fa-clipboard-list fa-3x text-muted mb-3"></i>

                    <h5 class="text-muted">
                        Aucune inscription
                    </h5>

                    <a
                        href="{{ route('etudiants.index') }}"
                        class="btn btn-success mt-2"
                    >
                        <i class="fa-regular fa-plus me-1"></i>
                        Nouvelle inscription
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInputs = document.querySelectorAll('.search-input');
    const rows = document.querySelectorAll('.searchable-row');
    const resultCount = document.getElementById('resultCount');
    const resetBtn = document.getElementById('resetSearch');

    function filterRows() {

        let visibleCount = 0;

        rows.forEach(function (row) {

            let showRow = true;

            searchInputs.forEach(function (input) {

                const colIndex = input.dataset.col;
                const searchTerm = input.value.toLowerCase().trim();

                if (searchTerm !== '') {

                    const cell = row.querySelector('.col-' + colIndex);

                    if (
                        cell &&
                        !cell.textContent.toLowerCase().includes(searchTerm)
                    ) {
                        showRow = false;
                    }

                }

            });

            if (showRow) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }

        });

        resultCount.textContent = visibleCount;

    }

    searchInputs.forEach(function (input) {
        input.addEventListener('keyup', filterRows);
        input.addEventListener('input', filterRows);
    });

    resetBtn.addEventListener('click', function () {

        searchInputs.forEach(function (input) {
            input.value = '';
        });

        rows.forEach(function (row) {
            row.style.display = '';
        });

        resultCount.textContent = rows.length;

    });

    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {
            resetBtn.click();
        }

    });

});

</script>

<style>

.search-input {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 0.85rem;
    padding: 8px 12px;
}

.search-input:focus {
    border-color: #198754;
    box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.1);
}

.table thead th {
    background: #f8f9fa;
    border-bottom: 2px solid #e0e0e0;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #666;
    padding: 12px 15px;
    font-weight: 600;
    white-space: nowrap;
}

.table tbody td {
    padding: 14px 15px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.9rem;
}

.table tbody tr:hover {
    background-color: #fafbfc;
}

.payment-cell {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.payment-cell strong {
    color: #198754;
}

.table__icon {
    width: 35px;
    height: 35px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
    font-size: 14px;
    text-decoration: none;
}

.table__icon.view {
    background: rgba(13, 110, 253, 0.12);
    color: #0d6efd;
}

.table__icon.view:hover {
    background: #0d6efd;
    color: white;
    transform: scale(1.1);
}

.table__icon.payment {
    background: rgba(25, 135, 84, 0.12);
    color: #198754;
}

.table__icon.payment:hover {
    background: #198754;
    color: white;
    transform: scale(1.1);
}

.table__icon.payment-disabled {
    background: rgba(25, 135, 84, 0.08);
    color: #198754;
    cursor: not-allowed;
}

.table__icon.edit {
    background: rgba(255, 193, 7, 0.12);
    color: #e0a800;
}

.table__icon.edit:hover {
    background: #ffc107;
    color: #000;
    transform: scale(1.1);
}

.table__icon.delete {
    background: rgba(220, 53, 69, 0.12);
    color: #dc3545;
}

.table__icon.delete:hover {
    background: #dc3545;
    color: white;
    transform: scale(1.1);
}

.pagination {
    margin: 0;
}

.page-link {
    border-radius: 8px;
    margin: 0 2px;
    border: none;
    color: #198754;
    padding: 8px 14px;
}

.page-item.active .page-link {
    background: #198754;
    color: white;
    border-radius: 8px;
}

.alert {
    border: none;
    border-radius: 12px;
}

@media (max-width: 768px) {

    .card__header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start !important;
    }

    .card__header .btn {
        width: 100%;
    }

}

</style>

@endsection

