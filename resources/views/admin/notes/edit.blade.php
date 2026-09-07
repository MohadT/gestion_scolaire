@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-xxl-8 col-xl-9 col-12">

        <div class="card__wrapper">

            {{-- =====================================================
                 EN-TÊTE
            ====================================================== --}}

            <div class="card__title-wrap mb-20">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="card__heading-title mb-1">

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Modifier la note

                        </h5>

                        <p class="text-muted small mb-0">

                            Modifiez la note et l'appréciation de l'élève.

                        </p>

                    </div>


                    <a
                        href="{{ route('notes.index') }}"
                        class="btn btn-outline-secondary"
                    >

                        <i class="fa-regular fa-arrow-left me-1"></i>

                        Retour aux notes

                    </a>

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
                 INFORMATIONS ÉLÈVE
            ====================================================== --}}

            <div class="student-header mb-4">

                <div class="student-avatar-large">

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


                <div>

                    <span class="text-muted small">

                        Élève

                    </span>

                    <h6 class="mb-1">

                        {{ $note->etudiant->prenom ?? '' }}

                        {{ $note->etudiant->nom ?? '' }}

                    </h6>


                    @if(isset($note->etudiant->matricule))

                        <small class="text-muted">

                            Matricule :

                            {{ $note->etudiant->matricule }}

                        </small>

                    @endif

                </div>

            </div>


            {{-- =====================================================
                 INFORMATIONS ÉVALUATION
            ====================================================== --}}

            <div class="row g-3 mb-4">


                {{-- ÉVALUATION --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-primary bg-opacity-10 text-primary">

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


                {{-- MATIÈRE --}}

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-success bg-opacity-10 text-success">

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

                        <div class="info-icon bg-warning bg-opacity-10 text-warning">

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

                        <div class="info-icon bg-info bg-opacity-10 text-info">

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

            </div>


            {{-- =====================================================
                 FORMULAIRE
            ====================================================== --}}

            <form
                action="{{ route('notes.update', $note->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="row g-4">


                    {{-- =================================================
                         NOTE
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="note">

                                    <i class="fa-regular fa-star me-1"></i>

                                    Note

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="note-input-container">

                                <input
                                    type="number"
                                    name="note"
                                    id="note"
                                    class="form-control note-input"
                                    min="0"
                                    max="20"
                                    step="0.01"
                                    value="{{ old('note', $note->note) }}"
                                    required
                                    autofocus
                                >

                                <span class="note-max">

                                    / 20

                                </span>

                            </div>


                            @error('note')

                                <small class="text-danger">

                                    {{ $message }}

                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         APPRÉCIATION
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="appreciation">

                                    <i class="fa-regular fa-comment me-1"></i>

                                    Appréciation

                                </label>

                            </div>


                            <div class="form__input">

                                <input
                                    type="text"
                                    name="appreciation"
                                    id="appreciation"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="Ex : Très bon travail"
                                    value="{{ old(
                                        'appreciation',
                                        $note->appreciation
                                    ) }}"
                                >

                            </div>


                            @error('appreciation')

                                <small class="text-danger">

                                    {{ $message }}

                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         INDICATION NOTE
                    ================================================== --}}

                    <div class="col-12">

                        <div
                            id="noteIndicator"
                            class="note-indicator"
                        >

                            <i class="fa-regular fa-circle-info me-1"></i>

                            Saisissez une note comprise entre 0 et 20.

                        </div>

                    </div>


                    {{-- =================================================
                         BOUTONS
                    ================================================== --}}

                    <div class="col-12 mt-3">

                        <div class="border-top pt-4">

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">


                                <a
                                    href="{{ route('notes.index') }}"
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

                                    Enregistrer la note

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         PANNEAU LATÉRAL
    ====================================================== --}}

    <div class="col-xxl-4 col-xl-3 col-12">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-regular fa-circle-info text-primary me-2"></i>

                    Informations

                </h6>


                {{-- ÉLÈVE --}}

                <div class="side-item">

                    <div class="side-icon bg-primary bg-opacity-10 text-primary">

                        <i class="fa-regular fa-user"></i>

                    </div>


                    <div>

                        <strong>

                            Élève

                        </strong>

                        <p>

                            {{ $note->etudiant->prenom ?? '' }}

                            {{ $note->etudiant->nom ?? '' }}

                        </p>

                    </div>

                </div>


                {{-- ÉVALUATION --}}

                <div class="side-item">

                    <div class="side-icon bg-success bg-opacity-10 text-success">

                        <i class="fa-regular fa-clipboard"></i>

                    </div>


                    <div>

                        <strong>

                            Évaluation

                        </strong>

                        <p>

                            {{ $note->evaluation->nom_evaluation ?? '—' }}

                        </p>

                    </div>

                </div>


                {{-- TYPE --}}

                <div class="side-item">

                    <div class="side-icon bg-warning bg-opacity-10 text-warning">

                        <i class="fa-regular fa-list-check"></i>

                    </div>


                    <div>

                        <strong>

                            Type

                        </strong>

                        <p>

                            {{ $note->evaluation->type_evaluation ?? '—' }}

                        </p>

                    </div>

                </div>


                <div class="alert alert-info mb-0">

                    <i class="fa-regular fa-circle-info me-2"></i>

                    <small>

                        La note est enregistrée sur une base de

                        <strong>20</strong>.

                    </small>

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

.student-header {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 18px;

    border: 1px solid #e8eaf0;

    border-radius: 12px;

    background: #f8f9fb;

}


.student-avatar-large {

    width: 55px;

    height: 55px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #eef2ff;

    color: #4361ee;

    font-size: 18px;

    font-weight: 700;

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

    padding: 13px;

    border: 1px solid #e8eaf0;

    border-radius: 10px;

    background: #fff;

}


.info-icon {

    width: 40px;

    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    flex-shrink: 0;

}


.info-card span {

    display: block;

    color: #8a8f98;

    font-size: 11px;

    margin-bottom: 2px;

}


.info-card strong {

    display: block;

    color: #2c3e50;

    font-size: 13px;

}


/*
|--------------------------------------------------------------------------
| INPUT
|--------------------------------------------------------------------------
*/

.form-control {

    border: 1px solid #e0e0e0;

    border-radius: 9px;

    padding: 10px 13px;

    font-size: 14px;

}


.form-control:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);

}


.form__input-title label {

    font-weight: 600;

    color: #2c3e50;

    margin-bottom: 8px;

    font-size: 0.9rem;

}


/*
|--------------------------------------------------------------------------
| NOTE
|--------------------------------------------------------------------------
*/

.note-input-container {

    position: relative;

    display: flex;

    align-items: center;

}


.note-input {

    padding-right: 55px;

    font-size: 18px;

    font-weight: 700;

    text-align: center;

}


.note-max {

    position: absolute;

    right: 15px;

    color: #8a8f98;

    font-weight: 600;

    pointer-events: none;

}


/*
|--------------------------------------------------------------------------
| INDICATEUR
|--------------------------------------------------------------------------
*/

.note-indicator {

    padding: 10px 13px;

    border-radius: 8px;

    background: #f8f9fb;

    border: 1px solid #e8eaf0;

    color: #6b7280;

    font-size: 13px;

}


/*
|--------------------------------------------------------------------------
| PANNEAU
|--------------------------------------------------------------------------
*/

.side-item {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    margin-bottom: 20px;

}


.side-icon {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    flex-shrink: 0;

}


.side-item strong {

    display: block;

    font-size: 12px;

    color: #374151;

}


.side-item p {

    margin: 2px 0 0;

    font-size: 13px;

    color: #6b7280;

}


/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .student-header {

        align-items: flex-start;

    }

}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('note');

    const indicator = document.getElementById('noteIndicator');


    function verifierNote() {

        let valeur = parseFloat(input.value);


        if (isNaN(valeur)) {

            indicator.innerHTML =
                '<i class="fa-regular fa-circle-info me-1"></i>' +
                'Saisissez une note comprise entre 0 et 20.';

            return;

        }


        if (valeur < 0) {

            input.value = 0;

            valeur = 0;

        }


        if (valeur > 20) {

            input.value = 20;

            valeur = 20;

        }


        if (valeur >= 16) {

            indicator.innerHTML =
                '<i class="fa-regular fa-circle-check me-1"></i>' +
                'Très bon résultat.';

        }
        else if (valeur >= 14) {

            indicator.innerHTML =
                '<i class="fa-regular fa-circle-check me-1"></i>' +
                'Bon résultat.';

        }
        else if (valeur >= 10) {

            indicator.innerHTML =
                '<i class="fa-regular fa-circle-info me-1"></i>' +
                'Résultat satisfaisant.';

        }
        else {

            indicator.innerHTML =
                '<i class="fa-regular fa-triangle-exclamation me-1"></i>' +
                'Résultat inférieur à la moyenne.';

        }

    }


    input.addEventListener('input', verifierNote);

    verifierNote();

});

</script>

@endsection
