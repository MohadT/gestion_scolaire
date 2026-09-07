@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-xxl-8 col-xl-8">

        <div class="card__wrapper">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h4 class="mb-1">Effectuer un paiement</h4>
                    <p class="text-muted mb-0">
                        Enregistrer un règlement pour cette inscription.
                    </p>
                </div>

                <a href="{{ route('inscriptions.index') }}"
                   class="btn btn-outline-secondary">

                    <i class="fa-regular fa-arrow-left me-1"></i>
                    Retour

                </a>

            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-regular fa-circle-exclamation me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>Veuillez corriger les erreurs :</strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            <div class="student-card mb-4">

                <div class="student-avatar">
                    <i class="fa-regular fa-user"></i>
                </div>

                <div>

                    <h5 class="mb-1">
                        {{ $inscription->etudiant->prenom_etudiant }}
                        {{ $inscription->etudiant->nom_etudiant }}
                    </h5>

                    <p class="text-muted mb-1">
                        Classe :
                        <strong>
                            {{ $inscription->classe->nom_classe ?? 'N/A' }}
                        </strong>
                    </p>

                    <p class="text-muted mb-0">
                        Année scolaire :
                        <strong>
                            {{ $inscription->anneeScolaire->nom_annee_scolaire ?? 'N/A' }}
                        </strong>
                    </p>

                </div>

            </div>

            <div class="row g-3 mb-4">

                <div class="col-md-4">

                    <div class="payment-info">

                        <span>Frais de scolarité</span>

                        <strong>
                            {{ number_format($total, 0, ',', ' ') }} FCFA
                        </strong>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="payment-info paid">

                        <span>Déjà payé</span>

                        <strong>
                            {{ number_format($paye, 0, ',', ' ') }} FCFA
                        </strong>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="payment-info remaining">

                        <span>Reste à payer</span>

                        <strong>
                            {{ number_format($reste, 0, ',', ' ') }} FCFA
                        </strong>

                    </div>

                </div>

            </div>

            @if($reste > 0)

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="mb-4">
                            <i class="fa-regular fa-money-bill-wave text-success me-2"></i>
                            Nouveau paiement
                        </h5>

                        <form method="POST"
                              action="{{ route('inscriptions.paiement.store', $inscription->id) }}">

                            @csrf

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Montant à payer
                                    </label>

                                    <div class="input-group">

                                        <input
                                            type="number"
                                            name="montant"
                                            class="form-control"
                                            min="1"
                                            max="{{ $reste }}"
                                            step="1"
                                            value="{{ old('montant') }}"
                                            placeholder="Ex : 50000"
                                            required
                                        >

                                        <span class="input-group-text">
                                            FCFA
                                        </span>

                                    </div>

                                    <small class="text-muted">
                                        Maximum :
                                        {{ number_format($reste, 0, ',', ' ') }} FCFA
                                    </small>

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Date du paiement
                                    </label>

                                    <input
                                        type="date"
                                        name="date_paiement"
                                        class="form-control"
                                        value="{{ old('date_paiement', date('Y-m-d')) }}"
                                        required
                                    >

                                </div>

                                <div class="col-md-12">

                                    <label class="form-label">
                                        Mode de paiement
                                    </label>

                                    <select name="mode_paiement"
                                            class="form-control"
                                            required>

                                        <option value="">
                                            Sélectionner le mode de paiement
                                        </option>

                                        <option value="especes"
                                            @selected(old('mode_paiement') === 'especes')>
                                            Espèces
                                        </option>

                                        <option value="virement"
                                            @selected(old('mode_paiement') === 'virement')>
                                            Virement bancaire
                                        </option>

                                        <option value="cheque"
                                            @selected(old('mode_paiement') === 'cheque')>
                                            Chèque
                                        </option>

                                        <option value="mobile_money"
                                            @selected(old('mode_paiement') === 'mobile_money')>
                                            Mobile Money
                                        </option>

                                        <option value="autre"
                                            @selected(old('mode_paiement') === 'autre')>
                                            Autre
                                        </option>

                                    </select>

                                </div>

                                <div class="col-12">

                                    <div class="alert alert-warning mb-0">

                                        <i class="fa-regular fa-circle-info me-2"></i>

                                        Après validation, le montant sera ajouté
                                        au montant déjà payé de cette inscription.

                                    </div>

                                </div>

                                <div class="col-12 mt-4">

                                    <button type="submit"
                                            class="btn btn-success">

                                        <i class="fa-regular fa-money-bill-wave me-1"></i>
                                        Enregistrer le paiement

                                    </button>

                                    <a href="{{ route('inscriptions.index') }}"
                                       class="btn btn-outline-secondary ms-2">

                                        Annuler

                                    </a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            @else

                <div class="alert alert-success text-center py-4">

                    <i class="fa-regular fa-circle-check fa-2x mb-3"></i>

                    <h5>
                        Scolarité entièrement payée
                    </h5>

                    <p class="mb-0">
                        Cette inscription ne présente aucun reste à payer.
                    </p>

                </div>

            @endif

        </div>

    </div>

    <div class="col-xxl-4 col-xl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5 class="mb-4">
                    Résumé
                </h5>

                <div class="summary-item">

                    <span>Étudiant</span>

                    <strong>
                        {{ $inscription->etudiant->prenom_etudiant }}
                        {{ $inscription->etudiant->nom_etudiant }}
                    </strong>

                </div>

                <div class="summary-item">

                    <span>Classe</span>

                    <strong>
                        {{ $inscription->classe->nom_classe ?? 'N/A' }}
                    </strong>

                </div>

                <div class="summary-item">

                    <span>Année scolaire</span>

                    <strong>
                        {{ $inscription->anneeScolaire->nom_annee_scolaire ?? 'N/A' }}
                    </strong>

                </div>

                <div class="summary-item">

                    <span>Total</span>

                    <strong>
                        {{ number_format($total, 0, ',', ' ') }} FCFA
                    </strong>

                </div>

                <div class="summary-item">

                    <span>Déjà payé</span>

                    <strong class="text-success">
                        {{ number_format($paye, 0, ',', ' ') }} FCFA
                    </strong>

                </div>

                <div class="summary-item">

                    <span>Reste</span>

                    <strong class="text-danger">
                        {{ number_format($reste, 0, ',', ' ') }} FCFA
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.student-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    border-radius: 12px;
    background: #f8f9fa;
}

.student-avatar {
    width: 55px;
    height: 55px;
    min-width: 55px;
    border-radius: 50%;
    background: rgba(25, 135, 84, 0.12);
    color: #198754;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.payment-info {
    padding: 20px;
    border-radius: 12px;
    background: #f8f9fa;
    border: 1px solid #eeeeee;
}

.payment-info span {
    display: block;
    color: #777;
    font-size: 13px;
    margin-bottom: 7px;
}

.payment-info strong {
    font-size: 19px;
}

.payment-info.paid {
    background: rgba(25, 135, 84, 0.06);
}

.payment-info.paid strong {
    color: #198754;
}

.payment-info.remaining {
    background: rgba(220, 53, 69, 0.06);
}

.payment-info.remaining strong {
    color: #dc3545;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #eeeeee;
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-item span {
    color: #777;
}

.summary-item strong {
    text-align: right;
}

</style>

@endsection
