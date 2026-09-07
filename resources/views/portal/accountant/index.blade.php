@extends('admin.layout.master')

@section('content')
<div class="col-xxl-12">
    <div class="card__wrapper">

        <div class="card__header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="card__header-title mb-1">Gestion des inscriptions et paiements</h4>
                <p class="text-muted mb-0">
                    Consultez les inscriptions et enregistrez les paiements des étudiants.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-regular fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-regular fa-circle-xmark me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                <button id="resetSearch" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="fa-regular fa-xmark me-1"></i>
                    Effacer
                </button>
            </div>

        </div>

        <div class="text-muted small mb-3">
            <span id="resultCount">{{ $inscriptions->count() }}</span>
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
                            <th>Total</th>
                            <th>Payé</th>
                            <th>Reste</th>
                            <th>Statut</th>
                            <th>Date inscription</th>
                            <th>Paiement</th>
                        </tr>
                    </thead>

                    <tbody class="table__body">

                        @foreach($inscriptions as $inscription)

                            @php
                                $total = (float) ($inscription->classe->prix ?? 0);
                                $paye = (float) ($inscription->frais_scolarite ?? 0);
                                $reste = max(0, $total - $paye);
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
                                    <strong>
                                        {{ number_format($total, 0, ',', ' ') }}
                                    </strong>
                                    <small>FCFA</small>
                                </td>

                                <td>
                                    <strong class="text-success">
                                        {{ number_format($paye, 0, ',', ' ') }}
                                    </strong>
                                    <small>FCFA</small>
                                </td>

                                <td>
                                    @if($reste > 0)
                                        <strong class="text-danger">
                                            {{ number_format($reste, 0, ',', ' ') }}
                                        </strong>
                                    @else
                                        <strong class="text-success">
                                            0
                                        </strong>
                                    @endif

                                    <small>FCFA</small>
                                </td>

                                <td>

                                    @if($total <= 0)

                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                            Non défini
                                        </span>

                                    @elseif($paye >= $total)

                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            <i class="fa-regular fa-circle-check me-1"></i>
                                            Payé
                                        </span>

                                    @elseif($paye > 0)

                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                            <i class="fa-regular fa-circle-half-stroke me-1"></i>
                                            Partiel
                                        </span>

                                    @else

                                        <span class="badge bg-danger px-3 py-2 rounded-pill">
                                            <i class="fa-regular fa-circle-xmark me-1"></i>
                                            Impayé
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    <span class="text-muted small">
                                        {{ $inscription->created_at?->format('d/m/Y') }}
                                    </span>
                                </td>

                                <td>

                                    @if($reste > 0)

                                        <button
                                            type="button"
                                            class="btn btn-success btn-sm payment-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#paymentModal"
                                            data-id="{{ $inscription->id }}"
                                            data-name="{{ $inscription->etudiant->prenom_etudiant }} {{ $inscription->etudiant->nom_etudiant }}"
                                            data-total="{{ $total }}"
                                            data-paye="{{ $paye }}"
                                            data-reste="{{ $reste }}"
                                        >
                                            <i class="fa-regular fa-money-bill me-1"></i>
                                            Payer
                                        </button>

                                    @else

                                        <button
                                            type="button"
                                            class="btn btn-outline-success btn-sm"
                                            disabled
                                        >
                                            <i class="fa-regular fa-circle-check me-1"></i>
                                            Soldé
                                        </button>

                                    @endif

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

                </div>

            @endif

        </div>

    </div>
</div>


<!-- MODAL PAIEMENT -->

<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="fa-regular fa-money-bill me-2"></i>
                    Enregistrer un paiement
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <form
                action="{{ route('accountant.payment.store') }}"
                method="POST"
            >

                @csrf

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="inscription_id"
                        id="payment_inscription_id"
                    >

                    <div class="student-info mb-4">

                        <div class="mb-2">
                            <strong>Étudiant :</strong>
                            <span id="payment_student_name"></span>
                        </div>

                        <div class="row">

                            <div class="col-4">
                                <div class="payment-box">
                                    <small>Total</small>
                                    <strong id="payment_total">0</strong>
                                    <span>FCFA</span>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="payment-box">
                                    <small>Déjà payé</small>
                                    <strong id="payment_paye">0</strong>
                                    <span>FCFA</span>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="payment-box reste-box">
                                    <small>Reste</small>
                                    <strong id="payment_reste">0</strong>
                                    <span>FCFA</span>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Montant du paiement
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                name="amount"
                                id="payment_amount"
                                class="form-control"
                                min="1"
                                step="0.01"
                                required
                            >

                            <span class="input-group-text">
                                FCFA
                            </span>

                        </div>

                        <small class="text-muted">
                            Le montant ne peut pas dépasser le reste à payer.
                        </small>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Annuler
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        <i class="fa-regular fa-circle-check me-1"></i>
                        Enregistrer le paiement
                    </button>

                </div>

            </form>

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


    const paymentButtons = document.querySelectorAll('.payment-btn');

    paymentButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const id = this.dataset.id;
            const name = this.dataset.name;
            const total = parseFloat(this.dataset.total);
            const paye = parseFloat(this.dataset.paye);
            const reste = parseFloat(this.dataset.reste);

            document.getElementById('payment_inscription_id').value = id;

            document.getElementById('payment_student_name').textContent = name;

            document.getElementById('payment_total').textContent =
                total.toLocaleString('fr-FR');

            document.getElementById('payment_paye').textContent =
                paye.toLocaleString('fr-FR');

            document.getElementById('payment_reste').textContent =
                reste.toLocaleString('fr-FR');

            const amountInput = document.getElementById('payment_amount');

            amountInput.value = '';
            amountInput.max = reste;

        });

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

.payment-btn {
    border-radius: 8px;
    padding: 7px 12px;
}

.payment-box {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
}

.payment-box small {
    display: block;
    color: #777;
    font-size: 11px;
    margin-bottom: 3px;
}

.payment-box strong {
    display: block;
    font-size: 15px;
}

.payment-box span {
    font-size: 10px;
    color: #777;
}

.reste-box {
    background: #fff3f3;
}

.reste-box strong {
    color: #dc3545;
}

.student-info {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
}

.alert {
    border: none;
    border-radius: 12px;
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

@media (max-width: 768px) {

    .card__header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start !important;
    }

    .table {
        min-width: 1100px;
    }

}

</style>

@endsection
