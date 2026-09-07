@extends('admin.layout.master')

@section('content')

<div class="container-fluid">


    {{-- =========================================================
        EN-TÊTE
    ========================================================== --}}
    <div class="row mb-20">

        <div class="col-12">

            <div class="card__wrapper">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">


                    {{-- TITRE --}}
                    <div>

                        <h4 class="mb-2">

                            Tableau de bord

                        </h4>


                        <p class="text-muted mb-0">

                            Vue générale de votre établissement scolaire.

                            @if($anneeActive)

                                <strong class="text-primary ms-1">

                                    {{ $anneeActive->nom_annee_scolaire }}

                                </strong>

                            @else

                                <span class="text-danger ms-1">

                                    Aucune année scolaire

                                </span>

                            @endif

                        </p>

                    </div>


                    {{-- FILTRE ANNÉE --}}
                    <div>

                        <form
                            method="GET"
                            action="{{ route('admin.dashboard') }}"
                            class="d-flex align-items-center gap-2"
                        >

                            <label class="fw-semibold mb-0">

                                <i class="fa-light fa-calendar-days me-1"></i>

                                Année :

                            </label>


                            <select
                                name="annee_scolaire_id"
                                class="form-select"
                                style="min-width: 190px;"
                                onchange="this.form.submit()"
                            >

                                @forelse($anneesScolaires as $annee)

                                    <option
                                        value="{{ $annee->id }}"
                                        @selected(
                                            $anneeActiveId == $annee->id
                                        )
                                    >

                                        {{ $annee->nom_annee_scolaire }}

                                    </option>

                                @empty

                                    <option value="">

                                        Aucune année scolaire

                                    </option>

                                @endforelse

                            </select>


                            {{-- Bouton --}}
                            @if($anneesScolaires->count() > 0)

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    title="Afficher"
                                >

                                    <i class="fa-light fa-filter"></i>

                                </button>

                            @endif

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        MESSAGE SI AUCUNE ANNÉE
    ========================================================== --}}
    @if(!$anneeActive)

        <div class="alert alert-warning">

            <i class="fa-light fa-triangle-exclamation me-2"></i>

            Aucune année scolaire n'est configurée.

            Veuillez créer une année scolaire avant d'utiliser
            les statistiques du tableau de bord.

        </div>

    @endif



    {{-- =========================================================
        STATISTIQUES
    ========================================================== --}}
    <div class="row g-20">


        {{-- ÉLÈVES --}}
        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">

            <div class="card__wrapper">

                <div class="d-flex align-items-center gap-sm">

                    <div class="card__icon">

                        <span>

                            <i class="fa-sharp fa-regular fa-users"></i>

                        </span>

                    </div>


                    <div class="card__title-wrap">

                        <h6 class="card__sub-title mb-10">

                            Élèves inscrits

                        </h6>


                        <div class="d-flex flex-wrap align-items-end gap-10">

                            <h3 class="card__title">

                                {{ $totalEtudiants }}

                            </h3>


                            <span class="card__desc style_two">

                                <i class="fa-light fa-user-graduate"></i>

                                cette année

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- PROFESSEURS --}}
        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">

            <div class="card__wrapper">

                <div class="d-flex align-items-center gap-sm">

                    <div class="card__icon">

                        <span>

                            <i class="fa-sharp fa-regular fa-chalkboard-user"></i>

                        </span>

                    </div>


                    <div class="card__title-wrap">

                        <h6 class="card__sub-title mb-10">

                            Enseignants

                        </h6>


                        <div class="d-flex flex-wrap align-items-end gap-10">

                            <h3 class="card__title">

                                {{ $totalProfesseurs }}

                            </h3>


                            <span class="card__desc style_two">

                                <i class="fa-light fa-user-tie"></i>

                                enseignants

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- CLASSES --}}
        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">

            <div class="card__wrapper">

                <div class="d-flex align-items-center gap-sm">

                    <div class="card__icon">

                        <span>

                            <i class="fa-sharp fa-regular fa-chalkboard"></i>

                        </span>

                    </div>


                    <div class="card__title-wrap">

                        <h6 class="card__sub-title mb-10">

                            Classes

                        </h6>


                        <div class="d-flex flex-wrap align-items-end gap-10">

                            <h3 class="card__title">

                                {{ $totalClassesInscrites }}

                            </h3>


                            <span class="card__desc style_two">

                                <i class="fa-light fa-school"></i>

                                utilisées

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- MATIÈRES --}}
        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">

            <div class="card__wrapper">

                <div class="d-flex align-items-center gap-sm">

                    <div class="card__icon">

                        <span>

                            <i class="fa-sharp fa-regular fa-books"></i>

                        </span>

                    </div>


                    <div class="card__title-wrap">

                        <h6 class="card__sub-title mb-10">

                            Matières

                        </h6>


                        <div class="d-flex flex-wrap align-items-end gap-10">

                            <h3 class="card__title">

                                {{ $totalMatieres }}

                            </h3>


                            <span class="card__desc style_two">

                                matières

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- INSCRIPTIONS --}}
        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">

            <div class="card__wrapper">

                <div class="d-flex align-items-center gap-sm">

                    <div class="card__icon">

                        <span>

                            <i class="fa-light fa-user-check"></i>

                        </span>

                    </div>


                    <div class="card__title-wrap">

                        <h6 class="card__sub-title mb-10">

                            Inscriptions

                        </h6>


                        <div class="d-flex flex-wrap align-items-end gap-10">

                            <h3 class="card__title">

                                {{ $totalInscriptions }}

                            </h3>


                            <span class="card__desc style_two">

                                inscriptions

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ÉVALUATIONS --}}
        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">

            <div class="card__wrapper">

                <div class="d-flex align-items-center gap-sm">

                    <div class="card__icon">

                        <span>

                            <i class="fa-light fa-file-pen"></i>

                        </span>

                    </div>


                    <div class="card__title-wrap">

                        <h6 class="card__sub-title mb-10">

                            Évaluations

                        </h6>


                        <div class="d-flex flex-wrap align-items-end gap-10">

                            <h3 class="card__title">

                                {{ $totalEvaluations }}

                            </h3>


                            <span class="card__desc style_two">

                                évaluations

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- NOTES --}}
        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">

            <div class="card__wrapper">

                <div class="d-flex align-items-center gap-sm">

                    <div class="card__icon">

                        <span>

                            <i class="fa-light fa-square-poll-vertical"></i>

                        </span>

                    </div>


                    <div class="card__title-wrap">

                        <h6 class="card__sub-title mb-10">

                            Notes saisies

                        </h6>


                        <div class="d-flex flex-wrap align-items-end gap-10">

                            <h3 class="card__title">

                                {{ $totalNotes }}

                            </h3>


                            <span class="card__desc style_two">

                                notes

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- MOYENNE --}}
        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">

            <div class="card__wrapper">

                <div class="d-flex align-items-center gap-sm">

                    <div class="card__icon">

                        <span>

                            <i class="fa-light fa-chart-line"></i>

                        </span>

                    </div>


                    <div class="card__title-wrap">

                        <h6 class="card__sub-title mb-10">

                            Moyenne générale

                        </h6>


                        <div class="d-flex flex-wrap align-items-end gap-10">

                            <h3 class="card__title">

                                {{ number_format($moyenneGenerale, 2, ',', ' ') }}

                            </h3>


                            <span class="card__desc style_two">

                                / 20

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        GRAPHIQUES
    ========================================================== --}}
    <div class="row g-20 mt-1">


        {{-- GRAPHIQUE GLOBAL --}}
        <div class="col-xxl-7 col-xl-7">

            <div class="card__wrapper">

                <div class="mb-20">

                    <h5 class="card__heading-title mb-1">

                        Statistiques scolaires

                    </h5>


                    <p class="text-muted small mb-0">

                        Données de l'année :

                        <strong>

                            {{ $anneeActive?->nom_annee_scolaire ?? 'Non définie' }}

                        </strong>

                    </p>

                </div>


                <div style="height: 350px;">

                    <canvas id="schoolStatisticsChart"></canvas>

                </div>

            </div>

        </div>



        {{-- RÉPARTITION --}}
        <div class="col-xxl-5 col-xl-5">

            <div class="card__wrapper">

                <div class="mb-20">

                    <h5 class="card__heading-title mb-1">

                        Répartition

                    </h5>


                    <p class="text-muted small mb-0">

                        Vue synthétique.

                    </p>

                </div>


                <div style="height: 350px;">

                    <canvas id="schoolDistributionChart"></canvas>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        EFFECTIF PAR CLASSE
    ========================================================== --}}
    <div class="row g-20 mt-1">

        <div class="col-12">

            <div class="card__wrapper">

                <div class="d-flex justify-content-between align-items-center mb-20">

                    <div>

                        <h5 class="card__heading-title mb-1">

                            Effectif par classe

                        </h5>


                        <p class="text-muted small mb-0">

                            Répartition des élèves inscrits pour
                            l'année sélectionnée.

                        </p>

                    </div>

                </div>


                @if($classesStatistiques->count() > 0)

                    <div style="height: 350px;">

                        <canvas id="classStatisticsChart"></canvas>

                    </div>

                @else

                    <div class="text-center py-5">

                        <i class="fa-light fa-chart-column fs-1 text-muted"></i>

                        <p class="text-muted mt-3 mb-0">

                            Aucune inscription pour cette année.

                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>



    {{-- =========================================================
        RÉSUMÉ
    ========================================================== --}}
    <div class="row g-20 mt-1">


        {{-- INFORMATIONS --}}
        <div class="col-xxl-6">

            <div class="card__wrapper h-100">

                <div class="mb-20">

                    <h5 class="card__heading-title mb-1">

                        Résumé de l'année

                    </h5>

                    <p class="text-muted small mb-0">

                        {{ $anneeActive?->nom_annee_scolaire ?? 'Aucune année' }}

                    </p>

                </div>


                <div class="row g-3">


                    <div class="col-md-6">

                        <div class="dashboard-summary">

                            <i class="fa-light fa-user-graduate"></i>

                            <div>

                                <span>Élèves</span>

                                <strong>
                                    {{ $totalEtudiants }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="dashboard-summary">

                            <i class="fa-light fa-user-check"></i>

                            <div>

                                <span>Inscriptions</span>

                                <strong>
                                    {{ $totalInscriptions }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="dashboard-summary">

                            <i class="fa-light fa-file-pen"></i>

                            <div>

                                <span>Évaluations</span>

                                <strong>
                                    {{ $totalEvaluations }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="dashboard-summary">

                            <i class="fa-light fa-square-poll-vertical"></i>

                            <div>

                                <span>Notes</span>

                                <strong>
                                    {{ $totalNotes }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="dashboard-summary">

                            <i class="fa-light fa-chart-line"></i>

                            <div>

                                <span>Moyenne générale</span>

                                <strong>

                                    {{ number_format(
                                        $moyenneGenerale,
                                        2,
                                        ',',
                                        ' '
                                    ) }}

                                    /20

                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="dashboard-summary">

                            <i class="fa-light fa-trophy"></i>

                            <div>

                                <span>Meilleure note</span>

                                <strong>

                                    {{ number_format(
                                        $meilleureNote,
                                        2,
                                        ',',
                                        ' '
                                    ) }}

                                    /20

                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ÉTAT DU SYSTÈME --}}
        <div class="col-xxl-6">

            <div class="card__wrapper h-100">

                <div class="mb-20">

                    <h5 class="card__heading-title mb-1">

                        État de l'établissement

                    </h5>

                    <p class="text-muted small mb-0">

                        Vue générale de la plateforme.

                    </p>

                </div>


                {{-- Professeurs --}}
                <div class="progress-item mb-4">

                    <div class="d-flex justify-content-between mb-2">

                        <span>

                            <i class="fa-light fa-chalkboard-user me-2"></i>

                            Enseignants

                        </span>

                        <strong>
                            {{ $totalProfesseurs }}
                        </strong>

                    </div>

                </div>


                {{-- Classes --}}
                <div class="progress-item mb-4">

                    <div class="d-flex justify-content-between mb-2">

                        <span>

                            <i class="fa-light fa-chalkboard me-2"></i>

                            Classes

                        </span>

                        <strong>
                            {{ $totalClasses }}
                        </strong>

                    </div>

                </div>


                {{-- Matières --}}
                <div class="progress-item mb-4">

                    <div class="d-flex justify-content-between mb-2">

                        <span>

                            <i class="fa-light fa-book me-2"></i>

                            Matières

                        </span>

                        <strong>
                            {{ $totalMatieres }}
                        </strong>

                    </div>

                </div>


                {{-- Notes --}}
                <div class="progress-item">

                    <div class="d-flex justify-content-between mb-2">

                        <span>

                            <i class="fa-light fa-square-poll-vertical me-2"></i>

                            Notes saisies

                        </span>

                        <strong>

                            {{ $tauxNotes }}%

                        </strong>

                    </div>


                    <div class="progress"
                         style="height: 7px;">

                        <div
                            class="progress-bar"
                            role="progressbar"
                            style="width: {{ $tauxNotes }}%;"
                            aria-valuenow="{{ $tauxNotes }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                        ></div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        ACTIONS RAPIDES
    ========================================================== --}}
    <div class="row g-20 mt-1">

        <div class="col-12">

            <div class="card__wrapper">

                <div class="mb-20">

                    <h5 class="card__heading-title mb-1">

                        Actions rapides

                    </h5>

                    <p class="text-muted small mb-0">

                        Accès rapide aux fonctionnalités principales.

                    </p>

                </div>


                <div class="row g-3">


                    {{-- Élève --}}
                    <div class="col-xxl-3 col-xl-3 col-md-6">

                        <a
                            href="{{ route('etudiants.create') }}"
                            class="quick-action"
                        >

                            <div class="quick-action-icon">

                                <i class="fa-light fa-user-plus"></i>

                            </div>

                            <div>

                                <strong>
                                    Ajouter un élève
                                </strong>

                                <small>
                                    Nouvel élève
                                </small>

                            </div>

                            <i class="fa-light fa-arrow-right ms-auto"></i>

                        </a>

                    </div>


                    {{-- Professeur --}}
                    <div class="col-xxl-3 col-xl-3 col-md-6">

                        <a
                            href="{{ route('professeurs.create') }}"
                            class="quick-action"
                        >

                            <div class="quick-action-icon">

                                <i class="fa-light fa-chalkboard-user"></i>

                            </div>

                            <div>

                                <strong>
                                    Ajouter un enseignant
                                </strong>

                                <small>
                                    Nouveau professeur
                                </small>

                            </div>

                            <i class="fa-light fa-arrow-right ms-auto"></i>

                        </a>

                    </div>


                    {{-- Classe --}}
                    <div class="col-xxl-3 col-xl-3 col-md-6">

                        <a
                            href="{{ route('classes.create') }}"
                            class="quick-action"
                        >

                            <div class="quick-action-icon">

                                <i class="fa-light fa-chalkboard"></i>

                            </div>

                            <div>

                                <strong>
                                    Ajouter une classe
                                </strong>

                                <small>
                                    Nouvelle classe
                                </small>

                            </div>

                            <i class="fa-light fa-arrow-right ms-auto"></i>

                        </a>

                    </div>


                    {{-- Évaluation --}}
                    <div class="col-xxl-3 col-xl-3 col-md-6">

                        <a
                            href="{{ route('evaluations.index') }}"
                            class="quick-action"
                        >

                            <div class="quick-action-icon">

                                <i class="fa-light fa-file-pen"></i>

                            </div>

                            <div>

                                <strong>
                                    Évaluations
                                </strong>

                                <small>
                                    Gérer les évaluations
                                </small>

                            </div>

                            <i class="fa-light fa-arrow-right ms-auto"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
     STYLE
============================================================= --}}
<style>

.quick-action {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 16px;

    border: 1px solid #e8e8e8;

    border-radius: 10px;

    text-decoration: none;

    color: inherit;

    transition: all .25s ease;

    background: #fff;

}

.quick-action:hover {

    transform: translateY(-2px);

    border-color: #4361ee;

    box-shadow: 0 6px 20px rgba(0,0,0,.06);

    color: inherit;

}

.quick-action-icon {

    width: 44px;

    height: 44px;

    min-width: 44px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: rgba(67, 97, 238, .10);

    color: #4361ee;

    font-size: 18px;

}

.quick-action strong {

    display: block;

    font-size: 14px;

    margin-bottom: 3px;

}

.quick-action small {

    display: block;

    color: #888;

    font-size: 12px;

}

.dashboard-summary {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 15px;

    border: 1px solid #eeeeee;

    border-radius: 10px;

}

.dashboard-summary > i {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: rgba(67, 97, 238, .10);

    color: #4361ee;

    font-size: 18px;

}

.dashboard-summary span {

    display: block;

    color: #777;

    font-size: 12px;

    margin-bottom: 3px;

}

.dashboard-summary strong {

    display: block;

    font-size: 17px;

}

</style>



{{-- =============================================================
     CHART.JS
============================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =====================================================
           GRAPHIQUE STATISTIQUES
        ====================================================== */

        const statisticsCanvas =
            document.getElementById(
                'schoolStatisticsChart'
            );


        if (statisticsCanvas) {

            new Chart(
                statisticsCanvas.getContext('2d'),
                {

                    type: 'bar',

                    data: {

                        labels: [

                            'Élèves',

                            'Inscriptions',

                            'Évaluations',

                            'Notes'

                        ],

                        datasets: [{

                            label: 'Année sélectionnée',

                            data: [

                                {{ $totalEtudiants }},

                                {{ $totalInscriptions }},

                                {{ $totalEvaluations }},

                                {{ $totalNotes }}

                            ],

                            borderWidth: 1

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {

                                display: false

                            }

                        },

                        scales: {

                            y: {

                                beginAtZero: true,

                                ticks: {

                                    precision: 0

                                }

                            }

                        }

                    }

                }
            );

        }



        /* =====================================================
           GRAPHIQUE CIRCULAIRE
        ====================================================== */

        const distributionCanvas =
            document.getElementById(
                'schoolDistributionChart'
            );


        if (distributionCanvas) {

            new Chart(
                distributionCanvas.getContext('2d'),
                {

                    type: 'doughnut',

                    data: {

                        labels: [

                            'Élèves',

                            'Enseignants',

                            'Classes',

                            'Matières'

                        ],

                        datasets: [{

                            data: [

                                {{ $totalEtudiants }},

                                {{ $totalProfesseurs }},

                                {{ $totalClasses }},

                                {{ $totalMatieres }}

                            ],

                            borderWidth: 1

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {

                                position: 'bottom'

                            }

                        }

                    }

                }
            );

        }



        /* =====================================================
           GRAPHIQUE PAR CLASSE
        ====================================================== */

        const classCanvas =
            document.getElementById(
                'classStatisticsChart'
            );


        if (classCanvas) {

            new Chart(
                classCanvas.getContext('2d'),
                {

                    type: 'bar',

                    data: {

                        labels: @json($graphClasses),

                        datasets: [{

                            label: 'Élèves inscrits',

                            data: @json($graphEffectifs),

                            borderWidth: 1

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {

                                display: false

                            }

                        },

                        scales: {

                            y: {

                                beginAtZero: true,

                                ticks: {

                                    precision: 0

                                }

                            }

                        }

                    }

                }
            );

        }

    }

);

</script>

@endsection
