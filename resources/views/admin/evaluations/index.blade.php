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

                            <i class="fa-regular fa-clipboard-list me-1"></i>

                            Évaluations

                        </h5>

                        <p class="text-muted mb-0">

                            Gérez les évaluations de vos classes.

                        </p>

                    </div>


                    <a
                        href="{{ route('evaluations.create') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa-regular fa-plus me-1"></i>

                        Nouvelle évaluation

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
                    ></button>

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
                    ></button>

                </div>

            @endif


            {{-- =====================================================
                 FILTRES RAPIDES
            ====================================================== --}}

            <div class="filter-box mb-4">

                <form
                    method="GET"
                    action="{{ route('evaluations.index') }}"
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


                        {{-- MATIÈRE --}}

                        <div class="col-xl-3 col-md-6">

                            <label
                                for="matiere_id"
                                class="filter-label"
                            >

                                <i class="fa-regular fa-book me-1"></i>

                                Matière

                            </label>


                            <select
                                name="matiere_id"
                                id="matiere_id"
                                class="form-control"
                            >

                                <option value="">

                                    Toutes les matières

                                </option>


                                @foreach($matieres as $matiere)

                                    <option
                                        value="{{ $matiere->id }}"
                                        {{ (string) $matiereId === (string) $matiere->id ? 'selected' : '' }}
                                    >

                                        {{ $matiere->nom_matiere }}

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
                                placeholder="Évaluation..."
                                value="{{ $search }}"
                            >

                        </div>


                        {{-- BOUTONS --}}

                        <div class="col-xl-1 col-md-12">

                            <div class="d-flex gap-2">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    title="Filtrer"
                                >

                                    <i class="fa-regular fa-filter"></i>

                                </button>


                                @if(
                                    $anneeScolaireId ||
                                    $classeId ||
                                    $matiereId ||
                                    $search
                                )

                                    <a
                                        href="{{ route('evaluations.index') }}"
                                        class="btn btn-outline-secondary"
                                        title="Réinitialiser"
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
                 FILTRES ACTIFS
            ====================================================== --}}

            @if(
                $anneeScolaireId ||
                $classeId ||
                $matiereId ||
                $search
            )

                <div class="active-filters mb-4">

                    <div class="d-flex align-items-center flex-wrap gap-2">

                        <span class="text-muted small">

                            <i class="fa-regular fa-filter me-1"></i>

                            Filtres actifs :

                        </span>


                        {{-- ANNÉE --}}

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


                        {{-- CLASSE --}}

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


                        {{-- MATIÈRE --}}

                        @if($matiereId)

                            @php

                                $matiereActive =
                                    $matieres->firstWhere(
                                        'id',
                                        $matiereId
                                    );

                            @endphp


                            @if($matiereActive)

                                <span class="filter-badge">

                                    <i class="fa-regular fa-book me-1"></i>

                                    {{ $matiereActive->nom_matiere }}

                                </span>

                            @endif

                        @endif


                        {{-- RECHERCHE --}}

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
                 NOMBRE DE RÉSULTATS
            ====================================================== --}}

            <div class="d-flex justify-content-between align-items-center mb-3">

                <span class="text-muted small">

                    {{ $evaluations->total() }}

                    {{ $evaluations->total() > 1
                        ? 'évaluations'
                        : 'évaluation'
                    }}

                </span>

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
                                Évaluation
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
                                Notes
                            </th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($evaluations as $evaluation)

                            <tr>


                                {{-- NUMÉRO --}}

                                <td>

                                    {{ $evaluations->firstItem() + $loop->index }}

                                </td>


                                {{-- ÉVALUATION --}}

                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="evaluation-icon">

                                            <i class="fa-regular fa-clipboard-check"></i>

                                        </div>


                                        <div>

                                            <strong>

                                                {{ $evaluation->nom_evaluation }}

                                            </strong>


                                            <small class="d-block text-muted">

                                                {{ $evaluation->type_evaluation }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- CLASSE --}}

                                <td>

                                    @if($evaluation->classe)

                                        <span class="classe-badge">

                                            <i class="fa-regular fa-school me-1"></i>

                                            {{ $evaluation->classe->nom_classe }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Classe supprimée
                                        </span>

                                    @endif

                                </td>


                                {{-- MATIÈRE --}}

                                <td>

                                    @if($evaluation->matiere)

                                        <strong>

                                            {{ $evaluation->matiere->nom_matiere }}

                                        </strong>

                                    @else

                                        <span class="text-muted">

                                            Matière supprimée

                                        </span>

                                    @endif

                                </td>


                                {{-- PROFESSEUR --}}

                                <td>

                                    @if($evaluation->professeur)

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="prof-avatar">

                                                {{ strtoupper(
                                                    substr(
                                                        $evaluation->professeur->prenom_prof,
                                                        0,
                                                        1
                                                    )
                                                ) }}

                                            </div>


                                            <span class="small">

                                                {{ $evaluation->professeur->prenom_prof }}

                                                {{ $evaluation->professeur->nom_prof }}

                                            </span>

                                        </div>

                                    @else

                                        <span class="text-muted">

                                            Professeur supprimé

                                        </span>

                                    @endif

                                </td>


                                {{-- ANNÉE SCOLAIRE --}}

                                <td>

                                    @if($evaluation->anneeScolaire)

                                        <span class="annee-badge">

                                            <i class="fa-regular fa-calendar me-1"></i>

                                            {{ $evaluation->anneeScolaire->nom_annee_scolaire }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            Année supprimée

                                        </span>

                                    @endif

                                </td>


                                {{-- NOTES --}}

                                <td class="text-center">

                                    <a
                                        href="{{ route(
                                            'notes.create',
                                            [
                                                'evaluation_id' =>
                                                    $evaluation->id
                                            ]
                                        ) }}"
                                        class="notes-button"
                                        title="Saisir les notes"
                                    >

                                        <i class="fa-regular fa-pen-to-square me-1"></i>

                                        Saisir

                                    </a>

                                </td>


                                {{-- ACTIONS --}}

                                <td>

                                    <div class="d-flex justify-content-center gap-2">


                                        {{-- VOIR --}}

                                        <a
                                            href="{{ route(
                                                'evaluations.show',
                                                $evaluation->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="Voir"
                                        >

                                            <i class="fa-regular fa-eye"></i>

                                        </a>


                                        {{-- MODIFIER --}}

                                        <a
                                            href="{{ route(
                                                'evaluations.edit',
                                                $evaluation->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Modifier"
                                        >

                                            <i class="fa-regular fa-pen-to-square"></i>

                                        </a>


                                        {{-- SUPPRIMER --}}

                                        <form
                                            action="{{ route(
                                                'evaluations.destroy',
                                                $evaluation->id
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ? Les notes associées seront également supprimées.');"
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

                            <tr>

                                <td colspan="8">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="fa-regular fa-clipboard"></i>

                                        </div>


                                        @if(
                                            $anneeScolaireId ||
                                            $classeId ||
                                            $matiereId ||
                                            $search
                                        )

                                            <h6>

                                                Aucune évaluation trouvée

                                            </h6>


                                            <p class="text-muted mb-3">

                                                Aucune évaluation ne correspond
                                                aux critères sélectionnés.

                                            </p>


                                            <a
                                                href="{{ route('evaluations.index') }}"
                                                class="btn btn-outline-primary"
                                            >

                                                <i class="fa-regular fa-filter-circle-xmark me-1"></i>

                                                Réinitialiser les filtres

                                            </a>

                                        @else

                                            <h6>

                                                Aucune évaluation

                                            </h6>


                                            <p class="text-muted mb-3">

                                                Vous n'avez encore créé
                                                aucune évaluation.

                                            </p>


                                            <a
                                                href="{{ route('evaluations.create') }}"
                                                class="btn btn-primary"
                                            >

                                                <i class="fa-regular fa-plus me-1"></i>

                                                Créer une évaluation

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

            @if($evaluations->hasPages())

                <div class="mt-4">

                    {{ $evaluations->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| FILTRES
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
| ICÔNE ÉVALUATION
|--------------------------------------------------------------------------
*/

.evaluation-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #eef2ff;

    color: #4361ee;

    flex-shrink: 0;

}


/*
|--------------------------------------------------------------------------
| CLASSE
|--------------------------------------------------------------------------
*/

.classe-badge {

    display: inline-flex;

    align-items: center;

    padding: 6px 10px;

    border-radius: 20px;

    background: #fff7ed;

    color: #c2410c;

    font-size: 12px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| PROFESSEUR
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
| BOUTON NOTES
|--------------------------------------------------------------------------
*/

.notes-button {

    display: inline-flex;

    align-items: center;

    padding: 6px 11px;

    border-radius: 7px;

    background: #eefdf5;

    color: #198754;

    font-size: 12px;

    font-weight: 600;

    text-decoration: none;

    transition: all 0.2s ease;

}


.notes-button:hover {

    background: #198754;

    color: #fff;

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


@media (max-width: 768px) {

    .filter-box {

        padding: 14px;

    }

}

</style>

@endsection
