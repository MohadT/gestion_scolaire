@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-xxl-9 col-xl-10 col-12">

        <div class="card__wrapper">

            {{-- =====================================================
                 EN-TÊTE
            ====================================================== --}}

            <div class="card__title-wrap mb-20">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="card__heading-title mb-1">

                            <i class="fa-regular fa-clipboard-check me-1"></i>

                            {{ $evaluation->nom_evaluation }}

                        </h5>

                        <p class="text-muted small mb-0">

                            Détails de l'évaluation

                        </p>

                    </div>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('evaluations.index') }}"
                            class="btn btn-outline-secondary"
                        >

                            <i class="fa-regular fa-arrow-left me-1"></i>

                            Retour

                        </a>


                        <a
                            href="{{ route('evaluations.edit', $evaluation->id) }}"
                            class="btn btn-primary"
                        >

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Modifier

                        </a>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 INFORMATIONS PRINCIPALES
            ====================================================== --}}

            <div class="row g-4">


                {{-- ANNÉE SCOLAIRE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-primary bg-opacity-10 text-primary">

                            <i class="fa-regular fa-calendar"></i>

                        </div>


                        <div>

                            <span class="info-label">

                                Année scolaire

                            </span>

                            <strong class="info-value">

                                {{ $evaluation->anneeScolaire->nom_annee_scolaire ?? '—' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- CLASSE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-warning bg-opacity-10 text-warning">

                            <i class="fa-regular fa-school"></i>

                        </div>


                        <div>

                            <span class="info-label">

                                Classe

                            </span>

                            <strong class="info-value">

                                {{ $evaluation->classe->nom_classe ?? '—' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- MATIÈRE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-success bg-opacity-10 text-success">

                            <i class="fa-regular fa-book"></i>

                        </div>


                        <div>

                            <span class="info-label">

                                Matière

                            </span>

                            <strong class="info-value">

                                {{ $evaluation->matiere->nom_matiere ?? '—' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- PROFESSEUR --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-info bg-opacity-10 text-info">

                            <i class="fa-regular fa-user-tie"></i>

                        </div>


                        <div>

                            <span class="info-label">

                                Professeur

                            </span>

                            <strong class="info-value">

                                @if($evaluation->professeur)

                                    {{ $evaluation->professeur->prenom_prof }}

                                    {{ $evaluation->professeur->nom_prof }}

                                @else

                                    —

                                @endif

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- NOM --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-secondary bg-opacity-10 text-secondary">

                            <i class="fa-regular fa-clipboard"></i>

                        </div>


                        <div>

                            <span class="info-label">

                                Nom de l'évaluation

                            </span>

                            <strong class="info-value">

                                {{ $evaluation->nom_evaluation }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- TYPE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-danger bg-opacity-10 text-danger">

                            <i class="fa-regular fa-list-check"></i>

                        </div>


                        <div>

                            <span class="info-label">

                                Type

                            </span>

                            <strong class="info-value">

                                {{ $evaluation->type_evaluation }}

                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 SECTION NOTES
            ====================================================== --}}

            <div class="border-top mt-4 pt-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">

                    <div>

                        <h6 class="fw-bold mb-1">

                            <i class="fa-regular fa-chart-simple me-1"></i>

                            Notes

                        </h6>

                        <p class="text-muted small mb-0">

                            Consultez ou saisissez les notes des élèves.

                        </p>

                    </div>


                    <a
                        href="{{ route(
                            'notes.create',
                            ['evaluation_id' => $evaluation->id]
                        ) }}"
                        class="btn btn-success"
                    >

                        <i class="fa-regular fa-pen-to-square me-1"></i>

                        Saisir les notes

                    </a>

                </div>


                {{-- =================================================
                     TABLEAU DES NOTES
                ================================================== --}}

                @if($evaluation->notes && $evaluation->notes->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead>

                                <tr>

                                    <th width="60">
                                        #
                                    </th>

                                    <th>
                                        Élève
                                    </th>

                                    <th class="text-center">
                                        Note
                                    </th>

                                    <th>
                                        Appréciation
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($evaluation->notes as $note)

                                    <tr>

                                        <td>

                                            {{ $loop->iteration }}

                                        </td>


                                        <td>

                                            @if($note->etudiant)

                                                <div class="student-name">

                                                    <div class="student-avatar">

                                                        {{ strtoupper(
                                                            substr(
                                                                $note->etudiant->prenom ?? $note->etudiant->nom,
                                                                0,
                                                                1
                                                            )
                                                        ) }}

                                                    </div>


                                                    <div>

                                                        <strong>

                                                            {{ $note->etudiant->prenom }}

                                                            {{ $note->etudiant->nom }}

                                                        </strong>

                                                    </div>

                                                </div>

                                            @else

                                                <span class="text-muted">

                                                    Élève supprimé

                                                </span>

                                            @endif

                                        </td>


                                        <td class="text-center">

                                            <span class="note-badge">

                                                {{ number_format($note->note, 2, ',', ' ') }}

                                                / 20

                                            </span>

                                        </td>


                                        <td>

                                            {{ $note->appreciation ?: '—' }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-notes">

                        <div class="empty-icon">

                            <i class="fa-regular fa-file-pen"></i>

                        </div>


                        <h6>

                            Aucune note saisie

                        </h6>


                        <p class="text-muted small mb-3">

                            Les notes des élèves n'ont pas encore été
                            enregistrées pour cette évaluation.

                        </p>


                        <a
                            href="{{ route(
                                'notes.create',
                                ['evaluation_id' => $evaluation->id]
                            ) }}"
                            class="btn btn-success"
                        >

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Saisir les notes

                        </a>

                    </div>

                @endif

            </div>


            {{-- =====================================================
                 ACTIONS
            ====================================================== --}}

            <div class="border-top mt-4 pt-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <a
                        href="{{ route('evaluations.index') }}"
                        class="btn btn-outline-secondary"
                    >

                        <i class="fa-regular fa-arrow-left me-1"></i>

                        Retour aux évaluations

                    </a>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('evaluations.edit', $evaluation->id) }}"
                            class="btn btn-primary"
                        >

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Modifier

                        </a>


                        <form
                            action="{{ route('evaluations.destroy', $evaluation->id) }}"
                            method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer cette évaluation ?');"
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


    {{-- =====================================================
         PANNEAU LATÉRAL
    ====================================================== --}}

    <div class="col-xxl-3 col-xl-2 col-12">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-regular fa-circle-info text-primary me-2"></i>

                    Résumé

                </h6>


                {{-- TYPE --}}

                <div class="summary-item">

                    <span class="text-muted small">

                        Type

                    </span>

                    <strong>

                        {{ $evaluation->type_evaluation }}

                    </strong>

                </div>


                {{-- NOTES --}}

                <div class="summary-item">

                    <span class="text-muted small">

                        Notes saisies

                    </span>

                    <strong>

                        {{ $evaluation->notes ? $evaluation->notes->count() : 0 }}

                    </strong>

                </div>


                {{-- CRÉATION --}}

                <div class="summary-item">

                    <span class="text-muted small">

                        Créée le

                    </span>

                    <strong>

                        {{ $evaluation->created_at?->format('d/m/Y') }}

                    </strong>

                </div>


                {{-- MODIFICATION --}}

                <div class="summary-item mb-0">

                    <span class="text-muted small">

                        Dernière modification

                    </span>

                    <strong>

                        {{ $evaluation->updated_at?->format('d/m/Y') }}

                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| CARTES INFORMATIONS
|--------------------------------------------------------------------------
*/

.info-card {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 17px;

    border: 1px solid #e8eaf0;

    border-radius: 12px;

    background: #fff;

    transition: all 0.2s ease;

}


.info-card:hover {

    transform: translateY(-2px);

    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.05);

}


.info-icon {

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    flex-shrink: 0;

    font-size: 18px;

}


.info-label {

    display: block;

    color: #8a8f98;

    font-size: 12px;

    margin-bottom: 3px;

}


.info-value {

    display: block;

    color: #2c3e50;

    font-size: 14px;

}


/*
|--------------------------------------------------------------------------
| ÉLÈVE
|--------------------------------------------------------------------------
*/

.student-name {

    display: flex;

    align-items: center;

    gap: 10px;

}


.student-avatar {

    width: 35px;

    height: 35px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #eef2ff;

    color: #4361ee;

    font-size: 12px;

    font-weight: 700;

}


/*
|--------------------------------------------------------------------------
| NOTE
|--------------------------------------------------------------------------
*/

.note-badge {

    display: inline-block;

    padding: 6px 12px;

    border-radius: 20px;

    background: #eefdf5;

    color: #198754;

    font-weight: 700;

    font-size: 13px;

}


/*
|--------------------------------------------------------------------------
| EMPTY NOTES
|--------------------------------------------------------------------------
*/

.empty-notes {

    text-align: center;

    padding: 50px 20px;

    border: 1px dashed #dfe3e8;

    border-radius: 12px;

    background: #fafbfc;

}


.empty-icon {

    width: 65px;

    height: 65px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin: 0 auto 15px;

    border-radius: 17px;

    background: #f3f4f6;

    color: #9ca3af;

    font-size: 27px;

}


/*
|--------------------------------------------------------------------------
| RÉSUMÉ
|--------------------------------------------------------------------------
*/

.summary-item {

    display: flex;

    flex-direction: column;

    gap: 3px;

    padding-bottom: 15px;

    margin-bottom: 15px;

    border-bottom: 1px solid #eef0f3;

}


.summary-item strong {

    color: #2c3e50;

    font-size: 14px;

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
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .info-card {

        padding: 14px;

    }

}

</style>

@endsection
