@extends('admin.layout.master')

@section('content')

<div class="row">

    {{-- =========================================================
         CONTENU PRINCIPAL
    ========================================================== --}}

    <div class="col-xxl-8 col-xl-9 col-12">

        <div class="card__wrapper">

            {{-- =================================================
                 EN-TÊTE
            ================================================== --}}

            <div class="card__title-wrap mb-20">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="card__heading-title mb-1">

                            <i class="fa-regular fa-file-pen me-1"></i>

                            Détail de la note

                        </h5>

                        <p class="text-muted small mb-0">

                            Consultation des informations de la note.

                        </p>

                    </div>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('notes.index') }}"
                            class="btn btn-outline-secondary"
                        >

                            <i class="fa-regular fa-arrow-left me-1"></i>

                            Retour

                        </a>


                        <a
                            href="{{ route('notes.edit', $note->id) }}"
                            class="btn btn-primary"
                        >

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Modifier

                        </a>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 ÉLÈVE
            ================================================== --}}

            <div class="student-card mb-4">

                <div class="student-avatar">

                    {{ strtoupper(
                        substr(
                            $note->etudiant->prenom
                            ?? $note->etudiant->nom
                            ?? '?',
                            0,
                            1
                        )
                    ) }}

                </div>


                <div class="student-details">

                    <span class="label">

                        Élève

                    </span>


                    <h5>

                        {{ $note->etudiant->prenom ?? '' }}

                        {{ $note->etudiant->nom ?? '' }}

                    </h5>


                    @if(isset($note->etudiant->matricule))

                        <span class="text-muted small">

                            Matricule :

                            {{ $note->etudiant->matricule }}

                        </span>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 NOTE PRINCIPALE
            ================================================== --}}

            <div class="note-result-card mb-4">

                <div class="note-result-content">

                    <span class="note-label">

                        NOTE

                    </span>


                    <div class="note-value">

                        {{ number_format(
                            $note->note,
                            2,
                            ',',
                            ' '
                        ) }}

                        <span>/ 20</span>

                    </div>


                    @if($note->note >= 16)

                        <span class="result-badge excellent">

                            <i class="fa-regular fa-star me-1"></i>

                            Excellent

                        </span>

                    @elseif($note->note >= 14)

                        <span class="result-badge good">

                            <i class="fa-regular fa-circle-check me-1"></i>

                            Très bien

                        </span>

                    @elseif($note->note >= 10)

                        <span class="result-badge average">

                            <i class="fa-regular fa-circle-check me-1"></i>

                            Satisfaisant

                        </span>

                    @else

                        <span class="result-badge weak">

                            <i class="fa-regular fa-triangle-exclamation me-1"></i>

                            Insuffisant

                        </span>

                    @endif

                </div>


                {{-- BARRE DE PROGRESSION --}}

                <div class="progress-container">

                    <div
                        class="progress-bar-note"
                        style="width: {{ min(max(($note->note / 20) * 100, 0), 100) }}%;"
                    ></div>

                </div>

            </div>


            {{-- =================================================
                 INFORMATIONS ÉVALUATION
            ================================================== --}}

            <div class="row g-3 mb-4">


                {{-- ÉVALUATION --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon primary">

                            <i class="fa-regular fa-clipboard-check"></i>

                        </div>


                        <div>

                            <span>

                                Évaluation

                            </span>

                            <strong>

                                {{ $note->evaluation->nom_evaluation ?? '—' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- TYPE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon danger">

                            <i class="fa-regular fa-list-check"></i>

                        </div>


                        <div>

                            <span>

                                Type d'évaluation

                            </span>

                            <strong>

                                {{ $note->evaluation->type_evaluation ?? '—' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- MATIÈRE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon success">

                            <i class="fa-regular fa-book"></i>

                        </div>


                        <div>

                            <span>

                                Matière

                            </span>

                            <strong>

                                {{ $note->evaluation->matiere->nom_matiere ?? '—' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- CLASSE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon warning">

                            <i class="fa-regular fa-school"></i>

                        </div>


                        <div>

                            <span>

                                Classe

                            </span>

                            <strong>

                                {{ $note->evaluation->classe->nom_classe ?? '—' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- ANNÉE SCOLAIRE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon info">

                            <i class="fa-regular fa-calendar"></i>

                        </div>


                        <div>

                            <span>

                                Année scolaire

                            </span>

                            <strong>

                                {{ $note->evaluation->anneeScolaire->nom_annee_scolaire ?? '—' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- PROFESSEUR --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon secondary">

                            <i class="fa-regular fa-user-tie"></i>

                        </div>


                        <div>

                            <span>

                                Professeur

                            </span>

                            <strong>

                                @if($note->evaluation?->professeur)

                                    {{ $note->evaluation->professeur->prenom_prof }}

                                    {{ $note->evaluation->professeur->nom_prof }}

                                @else

                                    —

                                @endif

                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 APPRÉCIATION
            ================================================== --}}

            <div class="appreciation-card mb-4">

                <div class="appreciation-header">

                    <div class="appreciation-icon">

                        <i class="fa-regular fa-comment"></i>

                    </div>


                    <div>

                        <h6>

                            Appréciation

                        </h6>

                        <span>

                            Commentaire du professeur

                        </span>

                    </div>

                </div>


                <div class="appreciation-content">

                    @if($note->appreciation)

                        <p>

                            {{ $note->appreciation }}

                        </p>

                    @else

                        <span class="text-muted">

                            Aucune appréciation n'a été renseignée.

                        </span>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 ACTIONS
            ================================================== --}}

            <div class="border-top pt-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <a
                        href="{{ route('notes.index') }}"
                        class="btn btn-outline-secondary"
                    >

                        <i class="fa-regular fa-arrow-left me-1"></i>

                        Retour aux notes

                    </a>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('notes.edit', $note->id) }}"
                            class="btn btn-primary"
                        >

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Modifier

                        </a>


                        <form
                            action="{{ route('notes.destroy', $note->id) }}"
                            method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer cette note ?');"
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


    {{-- =========================================================
         PANNEAU LATÉRAL
    ========================================================== --}}

    <div class="col-xxl-4 col-xl-3 col-12">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-regular fa-chart-simple text-primary me-2"></i>

                    Résumé

                </h6>


                {{-- NOTE --}}

                <div class="summary-item">

                    <span>

                        Note obtenue

                    </span>

                    <strong>

                        {{ number_format($note->note, 2, ',', ' ') }}/20

                    </strong>

                </div>


                {{-- MOYENNE --}}

                <div class="summary-item">

                    <span>

                        Statut

                    </span>


                    <strong>

                        @if($note->note >= 10)

                            <span class="text-success">

                                Admis

                            </span>

                        @else

                            <span class="text-danger">

                                Sous la moyenne

                            </span>

                        @endif

                    </strong>

                </div>


                {{-- APPRÉCIATION --}}

                <div class="summary-item">

                    <span>

                        Appréciation

                    </span>

                    <strong>

                        {{ $note->appreciation ? 'Renseignée' : 'Non renseignée' }}

                    </strong>

                </div>


                {{-- CRÉATION --}}

                <div class="summary-item">

                    <span>

                        Saisie le

                    </span>

                    <strong>

                        {{ $note->created_at?->format('d/m/Y à H:i') }}

                    </strong>

                </div>


                {{-- MODIFICATION --}}

                <div class="summary-item mb-0">

                    <span>

                        Dernière modification

                    </span>

                    <strong>

                        {{ $note->updated_at?->format('d/m/Y à H:i') }}

                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| ÉLÈVE
|--------------------------------------------------------------------------
*/

.student-card {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 18px;

    border: 1px solid #e8eaf0;

    border-radius: 12px;

    background: #f8f9fb;

}


.student-avatar {

    width: 58px;

    height: 58px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #eef2ff;

    color: #4361ee;

    font-size: 19px;

    font-weight: 700;

    flex-shrink: 0;

}


.student-details .label {

    display: block;

    color: #8a8f98;

    font-size: 12px;

    margin-bottom: 3px;

}


.student-details h5 {

    margin: 0 0 3px;

    color: #2c3e50;

}


/*
|--------------------------------------------------------------------------
| NOTE
|--------------------------------------------------------------------------
*/

.note-result-card {

    padding: 28px;

    border: 1px solid #e8eaf0;

    border-radius: 14px;

    background: #fff;

    text-align: center;

}


.note-result-content {

    display: flex;

    flex-direction: column;

    align-items: center;

}


.note-label {

    color: #8a8f98;

    font-size: 12px;

    font-weight: 600;

    letter-spacing: 1px;

}


.note-value {

    margin: 5px 0 10px;

    color: #2c3e50;

    font-size: 42px;

    font-weight: 700;

}


.note-value span {

    color: #9ca3af;

    font-size: 20px;

    font-weight: 500;

}


.result-badge {

    display: inline-block;

    padding: 6px 13px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;

}


.excellent {

    background: #e8f8ef;

    color: #198754;

}


.good {

    background: #eaf2ff;

    color: #4361ee;

}


.average {

    background: #fff7df;

    color: #b58105;

}


.weak {

    background: #fdecec;

    color: #dc3545;

}


/*
|--------------------------------------------------------------------------
| PROGRESSION
|--------------------------------------------------------------------------
*/

.progress-container {

    width: 100%;

    height: 7px;

    margin-top: 20px;

    border-radius: 20px;

    background: #eef0f3;

    overflow: hidden;

}


.progress-bar-note {

    height: 100%;

    border-radius: 20px;

    background: #4361ee;

    transition: width .3s ease;

}


/*
|--------------------------------------------------------------------------
| INFORMATIONS
|--------------------------------------------------------------------------
*/

.info-card {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 14px;

    border: 1px solid #e8eaf0;

    border-radius: 10px;

    background: #fff;

}


.info-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    flex-shrink: 0;

}


.info-icon.primary {

    background: #eef2ff;

    color: #4361ee;

}


.info-icon.success {

    background: #eaf8f0;

    color: #198754;

}


.info-icon.warning {

    background: #fff7df;

    color: #b58105;

}


.info-icon.info {

    background: #e8f7fa;

    color: #0c8599;

}


.info-icon.danger {

    background: #fdecec;

    color: #dc3545;

}


.info-icon.secondary {

    background: #f1f2f4;

    color: #6b7280;

}


.info-card span {

    display: block;

    color: #8a8f98;

    font-size: 11px;

    margin-bottom: 3px;

}


.info-card strong {

    display: block;

    color: #2c3e50;

    font-size: 13px;

}


/*
|--------------------------------------------------------------------------
| APPRÉCIATION
|--------------------------------------------------------------------------
*/

.appreciation-card {

    border: 1px solid #e8eaf0;

    border-radius: 12px;

    overflow: hidden;

}


.appreciation-header {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 15px;

    background: #f8f9fb;

    border-bottom: 1px solid #e8eaf0;

}


.appreciation-icon {

    width: 40px;

    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    background: #eef2ff;

    color: #4361ee;

}


.appreciation-header h6 {

    margin: 0 0 2px;

    font-weight: 600;

}


.appreciation-header span {

    color: #8a8f98;

    font-size: 12px;

}


.appreciation-content {

    padding: 20px;

}


.appreciation-content p {

    margin: 0;

    color: #374151;

    line-height: 1.7;

    font-size: 14px;

}


/*
|--------------------------------------------------------------------------
| RÉSUMÉ
|--------------------------------------------------------------------------
*/

.summary-item {

    display: flex;

    flex-direction: column;

    gap: 4px;

    padding-bottom: 15px;

    margin-bottom: 15px;

    border-bottom: 1px solid #eef0f3;

}


.summary-item span {

    color: #8a8f98;

    font-size: 12px;

}


.summary-item strong {

    color: #2c3e50;

    font-size: 14px;

}


/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .student-card {

        align-items: flex-start;

    }


    .note-value {

        font-size: 34px;

    }

}

</style>

@endsection
