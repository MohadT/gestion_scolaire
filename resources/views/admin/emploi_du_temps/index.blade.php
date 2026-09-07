@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card__wrapper">

            {{-- =====================================================
                 EN-TÊTE
            ====================================================== --}}

            <div class="card__title-wrap mb-20">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="card__heading-title mb-1">

                            <i class="fa-regular fa-calendar-days me-1"></i>

                            Emploi du temps

                        </h5>

                        <p class="text-muted mb-0">

                            Gérez les horaires des classes et des matières.

                        </p>

                    </div>


                    <a
                        href="{{ route('emplois.create') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa-regular fa-plus me-1"></i>

                        Ajouter un horaire

                    </a>

                </div>

            </div>


            {{-- =====================================================
                 MESSAGE SUCCÈS
            ====================================================== --}}

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    <i class="fa-regular fa-circle-check me-2"></i>

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    >
                    </button>

                </div>

            @endif


            {{-- =====================================================
                 MESSAGE ERREUR
            ====================================================== --}}

            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show">

                    <i class="fa-regular fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    >
                    </button>

                </div>

            @endif


            {{-- =====================================================
                 FILTRES RAPIDES
            ====================================================== --}}

            <div class="filter-box mb-4">

                <form
                    method="GET"
                    action="{{ route('emplois.index') }}"
                >

                    <div class="row g-3 align-items-end">


                        {{-- ANNÉE SCOLAIRE --}}

                        <div class="col-xl-3 col-md-6">

                            <label
                                for="annee_scolaire_id"
                                class="filter-label"
                            >

                                <i class="fa-regular fa-calendar me-1"></i>

                                Année scolaire

                            </label>


                            <select
                                name="annee_scolaire_id"
                                id="annee_scolaire_id"
                                class="form-control"
                            >

                                <option value="">

                                    Toutes les années

                                </option>


                                @foreach($anneesScolaires as $annee)

                                    <option
                                        value="{{ $annee->id }}"
                                        {{ (string) $anneeScolaireId === (string) $annee->id ? 'selected' : '' }}
                                    >

                                        {{ $annee->nom_annee_scolaire }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- CLASSE --}}

                        <div class="col-xl-3 col-md-6">

                            <label
                                for="classe_id"
                                class="filter-label"
                            >

                                <i class="fa-regular fa-school me-1"></i>

                                Classe

                            </label>


                            <select
                                name="classe_id"
                                id="classe_id"
                                class="form-control"
                            >

                                <option value="">

                                    Toutes les classes

                                </option>


                                @foreach($classes as $classe)

                                    <option
                                        value="{{ $classe->id }}"
                                        {{ (string) $classeId === (string) $classe->id ? 'selected' : '' }}
                                    >

                                        {{ $classe->nom_classe }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- JOUR --}}

                        <div class="col-xl-2 col-md-6">

                            <label
                                for="jour"
                                class="filter-label"
                            >

                                <i class="fa-regular fa-calendar-day me-1"></i>

                                Jour

                            </label>


                            <select
                                name="jour"
                                id="jour"
                                class="form-control"
                            >

                                <option value="">

                                    Tous les jours

                                </option>


                                @foreach([
                                    'Lundi',
                                    'Mardi',
                                    'Mercredi',
                                    'Jeudi',
                                    'Vendredi',
                                    'Samedi'
                                ] as $jourOption)

                                    <option
                                        value="{{ $jourOption }}"
                                        {{ $jour === $jourOption ? 'selected' : '' }}
                                    >

                                        {{ $jourOption }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- RECHERCHE --}}

                        <div class="col-xl-2 col-md-6">

                            <label
                                for="search"
                                class="filter-label"
                            >

                                <i class="fa-regular fa-magnifying-glass me-1"></i>

                                Recherche

                            </label>


                            <input
                                type="text"
                                name="search"
                                id="search"
                                class="form-control"
                                placeholder="Classe, matière..."
                                value="{{ $search }}"
                            >

                        </div>


                        {{-- BOUTONS --}}

                        <div class="col-xl-2 col-md-12">

                            <div class="d-flex gap-2">


                                {{-- FILTRER --}}

                                <button
                                    type="submit"
                                    class="btn btn-primary flex-grow-1"
                                >

                                    <i class="fa-regular fa-filter me-1"></i>

                                    Filtrer

                                </button>


                                {{-- RÉINITIALISER --}}

                                @if(
                                    $anneeScolaireId ||
                                    $classeId ||
                                    $jour ||
                                    $search
                                )

                                    <a
                                        href="{{ route('emplois.index') }}"
                                        class="btn btn-outline-secondary"
                                        title="Réinitialiser les filtres"
                                    >

                                        <i class="fa-regular fa-xmark"></i>

                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                </form>

            </div>


            {{-- =====================================================
                 RÉSUMÉ DES FILTRES
            ====================================================== --}}

            @if(
                $anneeScolaireId ||
                $classeId ||
                $jour ||
                $search
            )

                <div class="active-filters mb-4">

                    <div class="d-flex align-items-center flex-wrap gap-2">

                        <span class="text-muted small">

                            <i class="fa-regular fa-filter me-1"></i>

                            Filtres actifs :

                        </span>


                        @if($anneeScolaireId)

                            @php

                                $anneeActive =
                                    $anneesScolaires->firstWhere(
                                        'id',
                                        $anneeScolaireId
                                    );

                            @endphp

                            @if($anneeActive)

                                <span class="filter-badge">

                                    <i class="fa-regular fa-calendar me-1"></i>

                                    {{ $anneeActive->nom_annee_scolaire }}

                                </span>

                            @endif

                        @endif


                        @if($classeId)

                            @php

                                $classeActive =
                                    $classes->firstWhere(
                                        'id',
                                        $classeId
                                    );

                            @endphp

                            @if($classeActive)

                                <span class="filter-badge">

                                    <i class="fa-regular fa-school me-1"></i>

                                    {{ $classeActive->nom_classe }}

                                </span>

                            @endif

                        @endif


                        @if($jour)

                            <span class="filter-badge">

                                <i class="fa-regular fa-calendar-day me-1"></i>

                                {{ $jour }}

                            </span>

                        @endif


                        @if($search)

                            <span class="filter-badge">

                                <i class="fa-regular fa-magnifying-glass me-1"></i>

                                {{ $search }}

                            </span>

                        @endif

                    </div>

                </div>

            @endif


            {{-- =====================================================
                 INFORMATIONS RÉSULTATS
            ====================================================== --}}

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

                <div>

                    <span class="text-muted small">

                        {{ $emplois->total() }}

                        {{ $emplois->total() > 1 ? 'créneaux' : 'créneau' }}

                    </span>

                </div>

            </div>


            {{-- =====================================================
                 TABLEAU
            ====================================================== --}}

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="60">
                                #
                            </th>

                            <th>
                                Jour
                            </th>

                            <th>
                                Heure
                            </th>

                            <th>
                                Classe
                            </th>

                            <th>
                                Matière
                            </th>

                            <th>
                                Professeur
                            </th>

                            <th>
                                Année scolaire
                            </th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($emplois as $emploi)

                            <tr>


                                {{-- NUMÉRO --}}

                                <td>

                                    {{ $emplois->firstItem() + $loop->index }}

                                </td>


                                {{-- JOUR --}}

                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="emploi-icon jour-icon">

                                            <i class="fa-regular fa-calendar-day"></i>

                                        </div>


                                        <div>

                                            <strong>

                                                {{ $emploi->jour }}

                                            </strong>


                                            <small class="d-block text-muted">

                                                Jour

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- HEURE --}}

                                <td>

                                    <div class="horaire-box">

                                        <div>

                                            <i class="fa-regular fa-clock me-1"></i>

                                            {{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H\hi') }}

                                        </div>


                                        <span>
                                            →
                                        </span>


                                        <div>

                                            {{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H\hi') }}

                                        </div>

                                    </div>

                                </td>


                                {{-- CLASSE --}}

                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="emploi-icon classe-icon">

                                            <i class="fa-regular fa-school"></i>

                                        </div>


                                        <div>

                                            <strong>

                                                {{ $emploi->classe->nom_classe ?? 'Classe supprimée' }}

                                            </strong>


                                            <small class="d-block text-muted">

                                                Classe

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- MATIÈRE --}}

                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="emploi-icon matiere-icon">

                                            <i class="fa-regular fa-book"></i>

                                        </div>


                                        <div>

                                            <strong>

                                                {{ $emploi->matiere->nom_matiere ?? 'Matière supprimée' }}

                                            </strong>


                                            <small class="d-block text-muted">

                                                Matière

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- PROFESSEUR --}}

                                <td>

                                    @if($emploi->professeur)

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="prof-avatar">

                                                {{ strtoupper(
                                                    substr(
                                                        $emploi->professeur->prenom_prof,
                                                        0,
                                                        1
                                                    )
                                                ) }}

                                            </div>


                                            <div>

                                                <strong class="small">

                                                    {{ $emploi->professeur->prenom_prof }}

                                                    {{ $emploi->professeur->nom_prof }}

                                                </strong>

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-muted">

                                            Professeur supprimé

                                        </span>

                                    @endif

                                </td>


                                {{-- ANNÉE SCOLAIRE --}}

                                <td>

                                    @if($emploi->anneeScolaire)

                                        <span class="annee-badge">

                                            <i class="fa-regular fa-calendar me-1"></i>

                                            {{ $emploi->anneeScolaire->nom_annee_scolaire }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            Année supprimée

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTIONS --}}

                                <td>

                                    <div class="d-flex justify-content-center gap-2">


                                        {{-- VOIR --}}

                                        <a
                                            href="{{ route('emplois.show', $emploi->id) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="Voir"
                                        >

                                            <i class="fa-regular fa-eye"></i>

                                        </a>


                                        {{-- MODIFIER --}}

                                        <a
                                            href="{{ route('emplois.edit', $emploi->id) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Modifier"
                                        >

                                            <i class="fa-regular fa-pen-to-square"></i>

                                        </a>


                                        {{-- SUPPRIMER --}}

                                        <form
                                            action="{{ route('emplois.destroy', $emploi->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?');"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Supprimer"
                                            >

                                                <i class="fa-regular fa-trash-can"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            {{-- =================================================
                                 AUCUN RÉSULTAT
                            ================================================== --}}

                            <tr>

                                <td colspan="8">

                                    <div class="empty-state">


                                        <div class="empty-icon">

                                            <i class="fa-regular fa-calendar-xmark"></i>

                                        </div>


                                        @if(
                                            $anneeScolaireId ||
                                            $classeId ||
                                            $jour ||
                                            $search
                                        )

                                            <h6>
                                                Aucun résultat trouvé
                                            </h6>


                                            <p class="text-muted mb-3">

                                                Aucun créneau ne correspond
                                                aux filtres sélectionnés.

                                            </p>


                                            <a
                                                href="{{ route('emplois.index') }}"
                                                class="btn btn-outline-primary"
                                            >

                                                <i class="fa-regular fa-filter-circle-xmark me-1"></i>

                                                Réinitialiser les filtres

                                            </a>

                                        @else

                                            <h6>
                                                Aucun emploi du temps
                                            </h6>


                                            <p class="text-muted mb-3">

                                                Vous n'avez encore créé
                                                aucun horaire.

                                            </p>


                                            <a
                                                href="{{ route('emplois.create') }}"
                                                class="btn btn-primary"
                                            >

                                                <i class="fa-regular fa-plus me-1"></i>

                                                Ajouter un horaire

                                            </a>

                                        @endif


                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
                 PAGINATION
            ====================================================== --}}

            @if($emplois->hasPages())

                <div class="mt-4">

                    {{ $emplois->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| FILTRES RAPIDES
|--------------------------------------------------------------------------
*/

.filter-box {

    padding: 18px;

    background: #f8f9fb;

    border: 1px solid #e8eaf0;

    border-radius: 12px;

}


.filter-label {

    display: block;

    margin-bottom: 7px;

    font-size: 13px;

    font-weight: 600;

    color: #374151;

}


.filter-box .form-control {

    min-height: 42px;

    border-radius: 8px;

}


.filter-box .btn {

    min-height: 42px;

}


/*
|--------------------------------------------------------------------------
| FILTRES ACTIFS
|--------------------------------------------------------------------------
*/

.active-filters {

    padding: 10px 14px;

    background: #f8f9fb;

    border-radius: 8px;

}


.filter-badge {

    display: inline-flex;

    align-items: center;

    padding: 5px 10px;

    border-radius: 20px;

    background: #eef2ff;

    color: #4361ee;

    font-size: 12px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| ICÔNES
|--------------------------------------------------------------------------
*/

.emploi-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    flex-shrink: 0;

}


.jour-icon {

    background: #eef2ff;

    color: #4361ee;

}


.classe-icon {

    background: #fff7ed;

    color: #ea580c;

}


.matiere-icon {

    background: #ecfdf5;

    color: #10b981;

}


/*
|--------------------------------------------------------------------------
| AVATAR PROFESSEUR
|--------------------------------------------------------------------------
*/

.prof-avatar {

    width: 34px;

    height: 34px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #f3f4f6;

    color: #374151;

    font-size: 12px;

    font-weight: 700;

}


/*
|--------------------------------------------------------------------------
| ANNÉE SCOLAIRE
|--------------------------------------------------------------------------
*/

.annee-badge {

    display: inline-flex;

    align-items: center;

    padding: 6px 10px;

    border-radius: 20px;

    background: #f3f4f6;

    color: #374151;

    font-size: 12px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| HORAIRE
|--------------------------------------------------------------------------
*/

.horaire-box {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 7px 12px;

    border-radius: 8px;

    background: #f3f4f6;

    color: #374151;

    font-size: 13px;

    font-weight: 600;

}


.horaire-box span {

    color: #9ca3af;

}


/*
|--------------------------------------------------------------------------
| TABLEAU
|--------------------------------------------------------------------------
*/

.table th {

    font-weight: 600;

    white-space: nowrap;

}


.table td {

    vertical-align: middle;

}


/*
|--------------------------------------------------------------------------
| EMPTY STATE
|--------------------------------------------------------------------------
*/

.empty-state {

    text-align: center;

    padding: 60px 20px;

}


.empty-icon {

    width: 70px;

    height: 70px;

    margin: 0 auto 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 18px;

    background: #f3f4f6;

    color: #9ca3af;

    font-size: 30px;

}


/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .card__title-wrap > div {

        width: 100%;

    }


    .card__title-wrap .btn {

        width: 100%;

    }


    .filter-box {

        padding: 14px;

    }

}

</style>

@endsection
