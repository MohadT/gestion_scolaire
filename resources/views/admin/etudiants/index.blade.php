
@extends('admin.layout.master')

@section('content')

<div class="col-xxl-12">

    <div class="card__wrapper">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}
        <div class="card__header d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="card__header-title mb-1">
                    Liste des étudiants
                </h4>

                <p class="text-muted small mb-0">
                    {{ $etudiants->total() }} étudiant(s)
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('etudiants.create') }}"
                   class="btn btn-primary">

                    <i class="fa-regular fa-plus me-1"></i>

                    Ajouter un étudiant

                </a>

            </div>

        </div>


        {{-- =========================================================
             MESSAGE DE SUCCÈS
        ========================================================== --}}
        @if (session('success'))

            <div class="alert alert-success alert-dismissible fade show"
                 role="alert">

                <i class="fa-regular fa-circle-check me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                </button>

            </div>

        @endif


        {{-- =========================================================
             FORMULAIRE DE RECHERCHE
             Recherche effectuée par Laravel
        ========================================================== --}}
        <div class="search-box mb-4">

            <form method="GET"
                  action="{{ route('etudiants.index') }}">

                <div class="row g-3">

                    {{-- CODE ÉTUDIANT --}}
                    <div class="col-lg-3 col-md-6">

                        <label for="code"
                               class="form-label fw-semibold">

                            <i class="fa-regular fa-id-card me-1"></i>

                            Code étudiant

                        </label>

                        <div class="search-input-wrapper">

                            <i class="fa-regular fa-search"></i>

                            <input type="text"
                                   name="code"
                                   id="code"
                                   class="form-control search-field"
                                   placeholder="Ex : ETUDIANT000001"
                                   value="{{ request('code') }}"
                                   autocomplete="off">

                        </div>

                    </div>


                    {{-- NOM --}}
                    <div class="col-lg-3 col-md-6">

                        <label for="nom"
                               class="form-label fw-semibold">

                            <i class="fa-regular fa-user me-1"></i>

                            Nom

                        </label>

                        <div class="search-input-wrapper">

                            <i class="fa-regular fa-user"></i>

                            <input type="text"
                                   name="nom"
                                   id="nom"
                                   class="form-control search-field"
                                   placeholder="Nom de l'étudiant"
                                   value="{{ request('nom') }}"
                                   autocomplete="off">

                        </div>

                    </div>


                    {{-- PRÉNOM --}}
                    <div class="col-lg-3 col-md-6">

                        <label for="prenom"
                               class="form-label fw-semibold">

                            <i class="fa-regular fa-user me-1"></i>

                            Prénom

                        </label>

                        <div class="search-input-wrapper">

                            <i class="fa-regular fa-user"></i>

                            <input type="text"
                                   name="prenom"
                                   id="prenom"
                                   class="form-control search-field"
                                   placeholder="Prénom de l'étudiant"
                                   value="{{ request('prenom') }}"
                                   autocomplete="off">

                        </div>

                    </div>


                    {{-- TUTEUR --}}
                    <div class="col-lg-3 col-md-6">

                        <label for="tuteur"
                               class="form-label fw-semibold">

                            <i class="fa-regular fa-user-tie me-1"></i>

                            Nom du tuteur

                        </label>

                        <div class="search-input-wrapper">

                            <i class="fa-regular fa-user-tie"></i>

                            <input type="text"
                                   name="tuteur"
                                   id="tuteur"
                                   class="form-control search-field"
                                   placeholder="Nom du tuteur"
                                   value="{{ request('tuteur') }}"
                                   autocomplete="off">

                        </div>

                    </div>

                </div>


                {{-- BOUTONS --}}
                <div class="d-flex gap-2 mt-3">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fa-regular fa-search me-1"></i>

                        Rechercher

                    </button>


                    @if(request()->hasAny([
                        'code',
                        'nom',
                        'prenom',
                        'tuteur'
                    ]))

                        <a href="{{ route('etudiants.index') }}"
                           class="btn btn-light">

                            <i class="fa-regular fa-rotate-left me-1"></i>

                            Réinitialiser

                        </a>

                    @endif

                </div>

            </form>

        </div>


        {{-- =========================================================
             INFORMATIONS DE RECHERCHE
        ========================================================== --}}
        @if(request()->hasAny([
            'code',
            'nom',
            'prenom',
            'tuteur'
        ]))

            <div class="alert alert-info d-flex align-items-center mb-4">

                <i class="fa-regular fa-filter me-2"></i>

                <div>

                    <strong>
                        {{ $etudiants->total() }}
                    </strong>

                    résultat(s) trouvé(s).

                    @if(request('code'))
                        Code :
                        <strong>{{ request('code') }}</strong>
                    @endif

                    @if(request('nom'))
                        — Nom :
                        <strong>{{ request('nom') }}</strong>
                    @endif

                    @if(request('prenom'))
                        — Prénom :
                        <strong>{{ request('prenom') }}</strong>
                    @endif

                    @if(request('tuteur'))
                        — Tuteur :
                        <strong>{{ request('tuteur') }}</strong>
                    @endif

                </div>

            </div>

        @endif


        {{-- =========================================================
             TABLEAU
        ========================================================== --}}
        <div class="table__wrapper table-responsive">

            <table class="table mb-20"
                   id="etudiantsTable">

                <thead>

                    <tr class="table__title">

                        {{-- CODE --}}
                        <th style="width: 150px;">

                            <i class="fa-regular fa-id-card me-2"></i>

                            Code étudiant

                        </th>


                        {{-- NOM --}}
                        <th>

                            <i class="fa-regular fa-user me-2"></i>

                            Nom

                        </th>


                        {{-- PRÉNOM --}}
                        <th>

                            <i class="fa-regular fa-user me-2"></i>

                            Prénom

                        </th>


                        {{-- ADRESSE --}}
                        <th>

                            <i class="fa-regular fa-map-marker-alt me-2"></i>

                            Adresse

                        </th>


                        {{-- TUTEUR --}}
                        <th>

                            <i class="fa-regular fa-user-tie me-2"></i>

                            Tuteur

                        </th>


                        {{-- TELEPHONE --}}
                        <th>

                            <i class="fa-regular fa-phone me-2"></i>

                            Téléphone

                        </th>


                        {{-- ACTIONS --}}
                        <th style="width: 160px;">

                            <i class="fa-regular fa-gear me-2"></i>

                            Actions

                        </th>

                    </tr>

                </thead>


                <tbody class="table__body">

                    @forelse($etudiants as $etudiant)

                        <tr>

                            {{-- =================================================
                                 CODE ÉTUDIANT
                            ================================================== --}}
                            <td>

                                <a href="{{ route('etudiants.show', $etudiant->id) }}"
                                   class="text-decoration-none">

                                    <span class="matricule-badge">

                                        <i class="fa-regular fa-graduation-cap me-1"></i>

                                        {{ $etudiant->code_etudiant }}

                                    </span>

                                </a>

                            </td>


                            {{-- NOM --}}
                            <td>

                                <span class="fw-semibold">

                                    {{ $etudiant->nom_etudiant }}

                                </span>

                            </td>


                            {{-- PRÉNOM --}}
                            <td>

                                {{ $etudiant->prenom_etudiant }}

                            </td>


                            {{-- ADRESSE --}}
                            <td>

                                <span class="text-muted small">

                                    <i class="fa-regular fa-map-marker-alt me-1"></i>

                                    {{ Str::limit(
                                        $etudiant->adresse_etudiant,
                                        30
                                    ) }}

                                </span>

                            </td>


                            {{-- TUTEUR --}}
                            <td>

                                <span>

                                    {{ $etudiant->nom_du_tuteur }}

                                </span>

                            </td>


                            {{-- TELEPHONE --}}
                            <td>

                                <a href="tel:{{ $etudiant->numero_du_tuteur }}"
                                   class="text-decoration-none">

                                    <i class="fa-regular fa-phone me-1"></i>

                                    {{ $etudiant->numero_du_tuteur }}

                                </a>

                            </td>


                            {{-- =================================================
                                 ACTIONS
                            ================================================== --}}
                            <td>

                                <div class="d-flex align-items-center justify-content-start gap-1">

                                    {{-- VOIR --}}
                                    <a href="{{ route(
                                        'etudiants.show',
                                        $etudiant->id
                                    ) }}"
                                       class="table__icon view"
                                       title="Voir détails">

                                        <i class="fa-regular fa-eye"></i>

                                    </a>


                                    {{-- MODIFIER --}}
                                    <a href="{{ route(
                                        'etudiants.edit',
                                        $etudiant->id
                                    ) }}"
                                       class="table__icon edit"
                                       title="Modifier l'étudiant">

                                        <i class="fa-regular fa-pen-to-square"></i>

                                    </a>


                                    {{-- INSCRIRE --}}
                                    <a href="{{ route(
                                        'inscriptions.create',
                                        $etudiant->id
                                    ) }}"
                                       class="table__icon inscrire"
                                       title="Inscrire à une classe">

                                        <i class="fa-regular fa-chalkboard-user"></i>

                                    </a>


                                    {{-- SUPPRIMER --}}
                                    <form action="{{ route(
                                        'etudiants.destroy',
                                        $etudiant->id
                                    ) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm(
                                              'Êtes-vous sûr de vouloir supprimer cet étudiant ?'
                                          );">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="table__icon delete border-0 bg-transparent"
                                                title="Supprimer l'étudiant">

                                            <i class="fa-regular fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="fa-regular fa-users-slash fa-2x mb-2 d-block"></i>

                                    @if(request()->hasAny([
                                        'code',
                                        'nom',
                                        'prenom',
                                        'tuteur'
                                    ]))

                                        Aucun étudiant ne correspond
                                        aux critères de recherche.

                                    @else

                                        Aucun étudiant trouvé.

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>


            {{-- =========================================================
                 PAGINATION
            ========================================================== --}}
            @if($etudiants->hasPages())

                <div class="d-flex justify-content-between align-items-center mt-4">

                    <div class="text-muted small">

                        Affichage de

                        <strong>
                            {{ $etudiants->firstItem() }}
                        </strong>

                        à

                        <strong>
                            {{ $etudiants->lastItem() }}
                        </strong>

                        sur

                        <strong>
                            {{ $etudiants->total() }}
                        </strong>

                        étudiants

                    </div>


                    <div>

                        {{ $etudiants->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     STYLE
========================================================== --}}
<style>

/*
|--------------------------------------------------------------------------
| BARRE DE RECHERCHE
|--------------------------------------------------------------------------
*/

.search-box {

    background: #f8f9fc;

    border: 1px solid #eeeeee;

    border-radius: 14px;

    padding: 20px;

}


.search-box .form-label {

    color: #555;

    font-size: 0.85rem;

    margin-bottom: 7px;

}


.search-input-wrapper {

    position: relative;

}


.search-input-wrapper > i {

    position: absolute;

    left: 14px;

    top: 50%;

    transform: translateY(-50%);

    color: #999;

    z-index: 2;

}


.search-field {

    height: 45px;

    padding-left: 40px;

    border: 1px solid #e0e0e0;

    border-radius: 9px;

    font-size: 0.9rem;

    transition: all 0.2s ease;

}


.search-field:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.08);

}


/*
|--------------------------------------------------------------------------
| CODE ÉTUDIANT
|--------------------------------------------------------------------------
*/

.matricule-badge {

    background: #f0f4ff;

    color: #4361ee;

    padding: 5px 12px;

    border-radius: 8px;

    font-size: 0.8rem;

    font-weight: 700;

    letter-spacing: 0.5px;

    white-space: nowrap;

    display: inline-flex;

    align-items: center;

    gap: 5px;

    transition: all 0.2s ease;

}


.matricule-badge:hover {

    background: #4361ee;

    color: white;

}


/*
|--------------------------------------------------------------------------
| TABLEAU
|--------------------------------------------------------------------------
*/

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


.table tbody tr {

    transition: all 0.2s ease;

}


.table tbody tr:hover {

    background-color: #fafbfc;

}


/*
|--------------------------------------------------------------------------
| ICÔNES D'ACTIONS
|--------------------------------------------------------------------------
*/

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

    background: rgba(13, 110, 253, 0.1);

    color: #0d6efd;

}


.table__icon.edit {

    background: rgba(255, 193, 7, 0.1);

    color: #ffc107;

}


.table__icon.inscrire {

    background: rgba(25, 135, 84, 0.1);

    color: #198754;

}


.table__icon.delete {

    background: rgba(220, 53, 69, 0.1);

    color: #dc3545;

}


.table__icon:hover {

    transform: scale(1.1);

}


.table__icon.view:hover {

    background: #0d6efd;

    color: white;

}


.table__icon.edit:hover {

    background: #ffc107;

    color: white;

}


.table__icon.inscrire:hover {

    background: #198754;

    color: white;

}


.table__icon.delete:hover {

    background: #dc3545;

    color: white;

}


/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/

.pagination {

    margin: 0;

}


.page-link {

    border-radius: 8px;

    margin: 0 2px;

    border: none;

    color: #4361ee;

    padding: 8px 14px;

}


.page-item.active .page-link {

    background: #4361ee;

    border-radius: 8px;

    color: white;

}


/*
|--------------------------------------------------------------------------
| ALERT
|--------------------------------------------------------------------------
*/

.alert {

    border: none;

    border-radius: 12px;

}


/*
|--------------------------------------------------------------------------
| BOUTON
|--------------------------------------------------------------------------
*/

.btn-primary {

    border-radius: 10px;

    padding: 10px 20px;

    font-weight: 500;

    transition: all 0.2s ease;

}


.btn-primary:hover {

    transform: translateY(-1px);

    box-shadow:
        0 4px 12px rgba(13, 110, 253, 0.2);

}


/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .card__header {

        flex-direction: column;

        gap: 15px;

        align-items: flex-start !important;

    }


    .btn-primary {

        width: 100%;

    }


    .search-box {

        padding: 15px;

    }


    .matricule-badge {

        font-size: 0.7rem;

        padding: 4px 8px;

    }


    .pagination-wrapper {

        flex-direction: column;

        gap: 15px;

        align-items: flex-start !important;

    }

}
</style>
@endsection
