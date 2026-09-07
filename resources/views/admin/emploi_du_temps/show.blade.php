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
                            Détails de l'emploi du temps
                        </h5>

                        <p class="text-muted mb-0">
                            Consultez les informations de cet horaire.
                        </p>

                    </div>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('emplois.edit', $emploi->id) }}"
                            class="btn btn-primary"
                        >

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Modifier

                        </a>


                        <a
                            href="{{ route('emplois.index') }}"
                            class="btn btn-outline-secondary"
                        >

                            <i class="fa-regular fa-arrow-left me-1"></i>

                            Retour

                        </a>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 RÉSUMÉ
            ====================================================== --}}

            <div class="schedule-header">

                <div class="schedule-main-icon">

                    <i class="fa-regular fa-calendar-days"></i>

                </div>


                <div>

                    <span class="text-muted small">
                        Emploi du temps
                    </span>

                    <h3 class="mb-1">

                        {{ $emploi->jour }}

                    </h3>

                    <span class="time-main">

                        <i class="fa-regular fa-clock me-1"></i>

                        {{ $emploi->heure_debut }}

                        <span class="mx-1">
                            →
                        </span>

                        {{ $emploi->heure_fin }}

                    </span>

                </div>

            </div>


            {{-- =====================================================
                 INFORMATIONS
            ====================================================== --}}

            <div class="row g-4 mt-1">


                {{-- JOUR --}}

                <div class="col-xl-4 col-md-6">

                    <div class="info-card">

                        <div class="info-icon jour-icon">

                            <i class="fa-regular fa-calendar-day"></i>

                        </div>

                        <div>

                            <span>
                                Jour
                            </span>

                            <strong>
                                {{ $emploi->jour }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- HEURE DÉBUT --}}

                <div class="col-xl-4 col-md-6">

                    <div class="info-card">

                        <div class="info-icon heure-icon">

                            <i class="fa-regular fa-clock"></i>

                        </div>

                        <div>

                            <span>
                                Heure de début
                            </span>

                            <strong>
                                {{ $emploi->heure_debut }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- HEURE FIN --}}

                <div class="col-xl-4 col-md-6">

                    <div class="info-card">

                        <div class="info-icon heure-icon">

                            <i class="fa-regular fa-clock"></i>

                        </div>

                        <div>

                            <span>
                                Heure de fin
                            </span>

                            <strong>
                                {{ $emploi->heure_fin }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- CLASSE --}}

                <div class="col-xl-6 col-md-6">

                    <div class="info-card">

                        <div class="info-icon classe-icon">

                            <i class="fa-regular fa-school"></i>

                        </div>

                        <div>

                            <span>
                                Classe
                            </span>

                            <strong>

                                {{ $emploi->classe->nom_classe ?? 'Classe supprimée' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- MATIÈRE --}}

                <div class="col-xl-6 col-md-6">

                    <div class="info-card">

                        <div class="info-icon matiere-icon">

                            <i class="fa-regular fa-book"></i>

                        </div>

                        <div>

                            <span>
                                Matière
                            </span>

                            <strong>

                                {{ $emploi->matiere->nom_matiere ?? 'Matière supprimée' }}

                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 RÉSUMÉ DU COURS
            ====================================================== --}}

            <div class="course-summary mt-4">

                <div class="summary-icon">

                    <i class="fa-regular fa-circle-info"></i>

                </div>

                <div>

                    <h6 class="mb-1">
                        Résumé du cours
                    </h6>

                    <p class="mb-0 text-muted">

                        Le cours de

                        <strong>
                            {{ $emploi->matiere->nom_matiere ?? 'matière supprimée' }}
                        </strong>

                        est programmé le

                        <strong>
                            {{ $emploi->jour }}
                        </strong>

                        de

                        <strong>
                            {{ $emploi->heure_debut }}
                        </strong>

                        à

                        <strong>
                            {{ $emploi->heure_fin }}
                        </strong>

                        pour la classe

                        <strong>
                            {{ $emploi->classe->nom_classe ?? 'classe supprimée' }}
                        </strong>.

                    </p>

                </div>

            </div>


            {{-- =====================================================
                 ACTIONS
            ====================================================== --}}

            <div class="action-footer mt-4">

                <a
                    href="{{ route('emplois.index') }}"
                    class="btn btn-outline-secondary"
                >

                    <i class="fa-regular fa-arrow-left me-1"></i>

                    Retour à la liste

                </a>


                <div class="d-flex gap-2">

                    <a
                        href="{{ route('emplois.edit', $emploi->id) }}"
                        class="btn btn-primary"
                    >

                        <i class="fa-regular fa-pen-to-square me-1"></i>

                        Modifier

                    </a>


                    <form
                        action="{{ route('emplois.destroy', $emploi->id) }}"
                        method="POST"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet emploi du temps ?');"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-outline-danger"
                        >

                            <i class="fa-regular fa-trash-can me-1"></i>

                            Supprimer

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| HEADER DU PLANNING
|--------------------------------------------------------------------------
*/

.schedule-header {

    display: flex;

    align-items: center;

    gap: 20px;

    padding: 25px;

    border-radius: 14px;

    background: #f8f9ff;

    border: 1px solid #e8ebf5;

}


.schedule-main-icon {

    width: 70px;

    height: 70px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 16px;

    background: #eef2ff;

    color: #4361ee;

    font-size: 30px;

    flex-shrink: 0;

}


.schedule-header h3 {

    font-weight: 700;

    color: #1f2937;

}


.time-main {

    display: inline-flex;

    align-items: center;

    padding: 7px 11px;

    border-radius: 8px;

    background: #ffffff;

    color: #374151;

    font-size: 13px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| CARTES INFORMATIONS
|--------------------------------------------------------------------------
*/

.info-card {

    display: flex;

    align-items: center;

    gap: 15px;

    height: 100%;

    padding: 20px;

    border: 1px solid #e8eaee;

    border-radius: 12px;

    background: #ffffff;

    transition: all .2s ease;

}


.info-card:hover {

    border-color: #d8dce5;

    box-shadow: 0 4px 15px rgba(0,0,0,.04);

}


.info-icon {

    width: 48px;

    height: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    font-size: 18px;

    flex-shrink: 0;

}


.info-card span {

    display: block;

    margin-bottom: 4px;

    color: #8a929f;

    font-size: 12px;

}


.info-card strong {

    display: block;

    color: #27303f;

    font-size: 15px;

}


/*
|--------------------------------------------------------------------------
| COULEURS
|--------------------------------------------------------------------------
*/

.jour-icon {

    background: #eef2ff;

    color: #4361ee;

}


.heure-icon {

    background: #fff7ed;

    color: #ea580c;

}


.classe-icon {

    background: #f0fdf4;

    color: #16a34a;

}


.matiere-icon {

    background: #ecfeff;

    color: #0891b2;

}


/*
|--------------------------------------------------------------------------
| RÉSUMÉ
|--------------------------------------------------------------------------
*/

.course-summary {

    display: flex;

    align-items: flex-start;

    gap: 15px;

    padding: 18px 20px;

    border-radius: 12px;

    background: #f8fafc;

    border: 1px solid #e8eaee;

}


.summary-icon {

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


.course-summary h6 {

    font-weight: 700;

    color: #27303f;

}


/*
|--------------------------------------------------------------------------
| FOOTER ACTIONS
|--------------------------------------------------------------------------
*/

.action-footer {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding-top: 20px;

    border-top: 1px solid #edf0f5;

}


.action-footer .btn {

    height: 44px;

    padding: 0 16px;

    border-radius: 9px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .schedule-header {

        padding: 20px;

    }


    .schedule-main-icon {

        width: 55px;

        height: 55px;

        font-size: 23px;

    }


    .schedule-header h3 {

        font-size: 20px;

    }


    .action-footer {

        flex-direction: column;

        align-items: stretch;

    }


    .action-footer > a,
    .action-footer > div,
    .action-footer > div .btn,
    .action-footer form {

        width: 100%;

    }


    .action-footer > div {

        display: flex;

        flex-direction: column;

    }

}

</style>

@endsection
