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

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Saisie des notes

                        </h5>

                        <p class="text-muted small mb-0">

                            Saisissez rapidement les notes des élèves.

                        </p>

                    </div>


                    <a
                        href="{{ route('evaluations.show', $evaluation->id) }}"
                        class="btn btn-outline-secondary"
                    >

                        <i class="fa-regular fa-arrow-left me-1"></i>

                        Retour à l'évaluation

                    </a>

                </div>

            </div>


            {{-- =====================================================
                 INFORMATIONS ÉVALUATION
            ====================================================== --}}

            <div class="evaluation-header mb-4">

                <div class="row g-3">


                    {{-- ÉVALUATION --}}

                    <div class="col-xl-3 col-md-6">

                        <div class="evaluation-info">

                            <div class="evaluation-icon">

                                <i class="fa-regular fa-clipboard-check"></i>

                            </div>

                            <div>

                                <span>
                                    Évaluation
                                </span>

                                <strong>
                                    {{ $evaluation->nom_evaluation }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- MATIÈRE --}}

                    <div class="col-xl-3 col-md-6">

                        <div class="evaluation-info">

                            <div class="evaluation-icon">

                                <i class="fa-regular fa-book"></i>

                            </div>

                            <div>

                                <span>
                                    Matière
                                </span>

                                <strong>
                                    {{ $evaluation->matiere->nom_matiere ?? '—' }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- CLASSE --}}

                    <div class="col-xl-3 col-md-6">

                        <div class="evaluation-info">

                            <div class="evaluation-icon">

                                <i class="fa-regular fa-school"></i>

                            </div>

                            <div>

                                <span>
                                    Classe
                                </span>

                                <strong>
                                    {{ $evaluation->classe->nom_classe ?? '—' }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- ANNÉE --}}

                    <div class="col-xl-3 col-md-6">

                        <div class="evaluation-info">

                            <div class="evaluation-icon">

                                <i class="fa-regular fa-calendar"></i>

                            </div>

                            <div>

                                <span>
                                    Année scolaire
                                </span>

                                <strong>
                                    {{ $evaluation->anneeScolaire->nom_annee_scolaire ?? '—' }}
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ERREURS
            ====================================================== --}}

            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>

                        <i class="fa-regular fa-circle-exclamation me-1"></i>

                        Veuillez corriger les erreurs suivantes :

                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =====================================================
                 MESSAGE
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
                 FORMULAIRE
            ====================================================== --}}

            <form
                action="{{ route('notes.store') }}"
                method="POST"
            >

                @csrf

                {{-- ID ÉVALUATION --}}

                <input
                    type="hidden"
                    name="evaluation_id"
                    value="{{ $evaluation->id }}"
                >


                {{-- =================================================
                     BARRE D'ACTIONS
                ================================================== --}}

                <div class="notes-toolbar mb-3">

                    <div>

                        <strong>

                            {{ $etudiants->count() }}

                            {{ $etudiants->count() > 1
                                ? 'élèves'
                                : 'élève'
                            }}

                        </strong>

                        <span class="text-muted ms-1">

                            à noter

                        </span>

                    </div>


                    <div class="d-flex gap-2">

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary"
                            onclick="remplirToutesLesNotes()"
                        >

                            <i class="fa-regular fa-wand-magic-sparkles me-1"></i>

                            Exemple

                        </button>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="fa-regular fa-floppy-disk me-1"></i>

                            Enregistrer les notes

                        </button>

                    </div>

                </div>


                {{-- =================================================
                     TABLEAU DES ÉLÈVES
                ================================================== --}}

                <div class="table-responsive notes-table-wrapper">

                    <table class="table table-hover align-middle notes-table">

                        <thead>

                            <tr>

                                <th width="60">
                                    #
                                </th>

                                <th>
                                    Élève
                                </th>

                                <th width="180" class="text-center">
                                    Note / 20
                                </th>

                                <th>
                                    Appréciation
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($etudiants as $etudiant)

                                <tr>


                                    {{-- NUMÉRO --}}

                                    <td>

                                        <span class="student-number">

                                            {{ $loop->iteration }}

                                        </span>

                                    </td>


                                    {{-- ÉLÈVE --}}

                                    <td>

                                        <div class="student-info">

                                            <div class="student-avatar">

                                                {{ strtoupper(
                                                    substr(
                                                        $etudiant->prenom ?? $etudiant->nom,
                                                        0,
                                                        1
                                                    )
                                                ) }}

                                            </div>


                                            <div>

                                                <strong>

                                                    {{ $etudiant->prenom }}

                                                    {{ $etudiant->nom }}

                                                </strong>


                                                @if(isset($etudiant->matricule))

                                                    <small class="d-block text-muted">

                                                        Matricule :

                                                        {{ $etudiant->matricule }}

                                                    </small>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- NOTE --}}

                                    <td>

                                        <div class="note-input-wrapper">

                                            <input
                                                type="number"
                                                name="notes[{{ $etudiant->id }}][note]"
                                                class="form-control note-input"
                                                min="0"
                                                max="20"
                                                step="0.01"
                                                placeholder="—"
                                                value="{{ old(
                                                    'notes.' . $etudiant->id . '.note'
                                                ) }}"
                                            >

                                            <span>
                                                / 20
                                            </span>

                                        </div>

                                    </td>


                                    {{-- APPRÉCIATION --}}

                                    <td>

                                        <input
                                            type="text"
                                            name="notes[{{ $etudiant->id }}][appreciation]"
                                            class="form-control"
                                            maxlength="255"
                                            placeholder="Appréciation..."
                                            value="{{ old(
                                                'notes.' . $etudiant->id . '.appreciation'
                                            ) }}"
                                        >

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="4">

                                        <div class="empty-state">

                                            <div class="empty-icon">

                                                <i class="fa-regular fa-users"></i>

                                            </div>


                                            <h6>

                                                Aucun élève trouvé

                                            </h6>


                                            <p class="text-muted mb-0">

                                                Aucun élève n'est actuellement
                                                associé à cette classe.

                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                     BOUTONS BAS
                ================================================== --}}

                @if($etudiants->count())

                    <div class="form-actions mt-4">

                        <a
                            href="{{ route(
                                'evaluations.show',
                                $evaluation->id
                            ) }}"
                            class="btn btn-outline-secondary"
                        >

                            <i class="fa-regular fa-arrow-left me-1"></i>

                            Annuler

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="fa-regular fa-floppy-disk me-1"></i>

                            Enregistrer toutes les notes

                        </button>

                    </div>

                @endif

            </form>

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| EN-TÊTE ÉVALUATION
|--------------------------------------------------------------------------
*/

.evaluation-header {

    padding: 18px;

    border: 1px solid #e8eaf0;

    border-radius: 12px;

    background: #f8f9fb;

}


.evaluation-info {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 12px;

    background: #ffffff;

    border: 1px solid #edf0f3;

    border-radius: 10px;

}


.evaluation-info span {

    display: block;

    color: #8a8f98;

    font-size: 11px;

    margin-bottom: 3px;

}


.evaluation-info strong {

    display: block;

    color: #2c3e50;

    font-size: 13px;

}


.evaluation-icon {

    width: 40px;

    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 9px;

    background: #eef2ff;

    color: #4361ee;

}


/*
|--------------------------------------------------------------------------
| BARRE
|--------------------------------------------------------------------------
*/

.notes-toolbar {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    padding: 13px 16px;

    background: #f8f9fb;

    border: 1px solid #e8eaf0;

    border-radius: 10px;

}


/*
|--------------------------------------------------------------------------
| TABLEAU
|--------------------------------------------------------------------------
*/

.notes-table-wrapper {

    border: 1px solid #e8eaf0;

    border-radius: 10px;

}


.notes-table {

    margin-bottom: 0;

}


.notes-table thead th {

    background: #f8f9fb;

    color: #374151;

    font-size: 13px;

    font-weight: 600;

    white-space: nowrap;

    padding: 13px;

}


.notes-table tbody td {

    padding: 10px 13px;

}


.notes-table tbody tr {

    transition: background 0.2s ease;

}


.notes-table tbody tr:hover {

    background: #fafbff;

}


/*
|--------------------------------------------------------------------------
| NUMÉRO
|--------------------------------------------------------------------------
*/

.student-number {

    color: #8a8f98;

    font-size: 13px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| ÉLÈVE
|--------------------------------------------------------------------------
*/

.student-info {

    display: flex;

    align-items: center;

    gap: 11px;

}


.student-avatar {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #eef2ff;

    color: #4361ee;

    font-size: 12px;

    font-weight: 700;

    flex-shrink: 0;

}


.student-info strong {

    color: #2c3e50;

    font-size: 13px;

}


/*
|--------------------------------------------------------------------------
| NOTE
|--------------------------------------------------------------------------
*/

.note-input-wrapper {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

}


.note-input {

    width: 100px;

    text-align: center;

    font-size: 15px;

    font-weight: 600;

    border-radius: 8px;

}


.note-input:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);

}


.note-input-wrapper span {

    color: #8a8f98;

    font-size: 13px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| INPUTS
|--------------------------------------------------------------------------
*/

.form-control {

    border: 1px solid #e0e0e0;

    border-radius: 8px;

    padding: 9px 12px;

    font-size: 13px;

    transition: all 0.2s ease;

}


.form-control:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);

}


/*
|--------------------------------------------------------------------------
| ACTIONS
|--------------------------------------------------------------------------
*/

.form-actions {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 10px;

    padding-top: 18px;

    border-top: 1px solid #e8eaf0;

}


/*
|--------------------------------------------------------------------------
| EMPTY
|--------------------------------------------------------------------------
*/

.empty-state {

    text-align: center;

    padding: 55px 20px;

}


.empty-icon {

    width: 65px;

    height: 65px;

    margin: 0 auto 15px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 16px;

    background: #f3f4f6;

    color: #9ca3af;

    font-size: 27px;

}


/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .notes-toolbar {

        flex-direction: column;

        align-items: stretch;

    }


    .notes-toolbar .btn {

        width: 100%;

    }


    .form-actions {

        flex-direction: column-reverse;

        align-items: stretch;

    }


    .form-actions .btn {

        width: 100%;

    }


    .note-input {

        width: 80px;

    }

}

</style>


<script>

/*
|--------------------------------------------------------------------------
| EXEMPLE RAPIDE
|--------------------------------------------------------------------------
|
| Cette fonction est seulement une aide pour tester le formulaire.
| Elle ne sauvegarde rien automatiquement.
|--------------------------------------------------------------------------
*/

function remplirToutesLesNotes()
{
    const notes = document.querySelectorAll('.note-input');

    notes.forEach(function(input) {

        if (input.value === '') {

            input.value = '10';

        }

    });
}


/*
|--------------------------------------------------------------------------
| CONTRÔLE NOTE 0 - 20
|--------------------------------------------------------------------------
*/

document.querySelectorAll('.note-input').forEach(function(input) {

    input.addEventListener('input', function() {

        let valeur = parseFloat(this.value);

        if (valeur > 20) {

            this.value = 20;

        }

        if (valeur < 0) {

            this.value = 0;

        }

    });

});

</script>

@endsection
