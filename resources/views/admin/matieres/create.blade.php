@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-xxl-8">

        <div class="card__wrapper">

            {{-- En-tête --}}
            <div class="card__title-wrap mb-20">

                <div>

                    <h5 class="card__heading-title mb-1">
                        Ajouter des matières
                    </h5>

                    <p class="text-muted small mb-0">
                        Ajoutez une ou plusieurs matières dans votre établissement.
                    </p>

                </div>

            </div>


            {{-- =====================================================
                 ERREURS
            ====================================================== --}}

            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>
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
                 FORMULAIRE
            ====================================================== --}}

            <form
                action="{{ route('matieres.store') }}"
                method="POST"
                id="matiereForm"
            >

                @csrf


                {{-- =================================================
                     LISTE DES MATIÈRES
                ================================================== --}}

                <div id="matieresContainer">


                    {{-- =================================================
                         PREMIÈRE MATIÈRE
                    ================================================== --}}

                    <div class="matiere-row">

                        <div class="matiere-number">
                            1
                        </div>


                        <div class="from__input-box flex-grow-1 mb-0">

                            <div class="form__input-title">

                                <label>

                                    <i class="fa-regular fa-book me-1"></i>

                                    Nom de la matière

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

                                <input
                                    type="text"
                                    name="nom_matiere[]"
                                    class="form-control"
                                    placeholder="Ex : Mathématiques"
                                    value="{{ old('nom_matiere.0') }}"
                                    required
                                >

                            </div>

                        </div>


                        {{-- Supprimer --}}

                        <button
                            type="button"
                            class="btn btn-outline-danger remove-matiere"
                            title="Supprimer"
                        >

                            <i class="fa-regular fa-trash-can"></i>

                        </button>

                    </div>

                </div>


                {{-- =================================================
                     AJOUTER UNE MATIÈRE
                ================================================== --}}

                <div class="mt-3">

                    <button
                        type="button"
                        id="addMatiere"
                        class="btn btn-outline-primary"
                    >

                        <i class="fa-regular fa-plus me-1"></i>

                        Ajouter une matière

                    </button>

                </div>


                {{-- =================================================
                     BOUTONS
                ================================================== --}}

                <div class="col-12 mt-4">

                    <div class="border-top pt-4">

                        <div class="d-flex justify-content-end gap-3">

                            <a
                                href="{{ route('matieres.index') }}"
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

                                Enregistrer les matières

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         AIDE
    ========================================================== --}}

    <div class="col-xxl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-regular fa-lightbulb text-warning me-2"></i>

                    Informations

                </h6>


                {{-- Plusieurs matières --}}

                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-primary bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-book text-primary"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Plusieurs matières
                        </strong>

                        <p class="text-muted small mb-0">

                            Vous pouvez ajouter plusieurs matières
                            avant de les enregistrer.

                        </p>

                    </div>

                </div>


                {{-- Ajouter --}}

                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-success bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-plus text-success"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Ajouter rapidement
                        </strong>

                        <p class="text-muted small mb-0">

                            Cliquez sur « Ajouter une matière »
                            pour créer une nouvelle ligne.

                        </p>

                    </div>

                </div>


                {{-- Information --}}

                <div class="alert alert-info mb-0">

                    <i class="fa-regular fa-circle-info me-2"></i>

                    <small>

                        Le coefficient et le nombre d'heures seront définis
                        lors de l'affectation de la matière à une classe.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT
============================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const container =
        document.getElementById('matieresContainer');

    const addButton =
        document.getElementById('addMatiere');


    /*
    |--------------------------------------------------------------------------
    | Ajouter une matière
    |--------------------------------------------------------------------------
    */

    addButton.addEventListener('click', function () {

        const row =
            document.createElement('div');


        row.classList.add('matiere-row');


        row.innerHTML = `

            <div class="matiere-number">
                -
            </div>


            <div class="from__input-box flex-grow-1 mb-0">

                <div class="form__input-title">

                    <label>

                        <i class="fa-regular fa-book me-1"></i>

                        Nom de la matière

                        <span class="text-danger">*</span>

                    </label>

                </div>


                <div class="form__input">

                    <input
                        type="text"
                        name="nom_matiere[]"
                        class="form-control"
                        placeholder="Ex : Français"
                        required
                    >

                </div>

            </div>


            <button
                type="button"
                class="btn btn-outline-danger remove-matiere"
                title="Supprimer"
            >

                <i class="fa-regular fa-trash-can"></i>

            </button>

        `;


        container.appendChild(row);


        updateNumbers();

    });


    /*
    |--------------------------------------------------------------------------
    | Supprimer une matière
    |--------------------------------------------------------------------------
    */

    container.addEventListener('click', function (event) {

        const button =
            event.target.closest('.remove-matiere');


        if (!button) {

            return;

        }


        const rows =
            container.querySelectorAll('.matiere-row');


        /*
        |--------------------------------------------------------------------------
        | Garder au minimum une ligne
        |--------------------------------------------------------------------------
        */

        if (rows.length <= 1) {

            const input =
                rows[0].querySelector('input');

            input.value = '';

            input.focus();

            return;

        }


        button
            .closest('.matiere-row')
            .remove();


        updateNumbers();

    });


    /*
    |--------------------------------------------------------------------------
    | Numérotation
    |--------------------------------------------------------------------------
    */

    function updateNumbers() {

        const rows =
            container.querySelectorAll('.matiere-row');


        rows.forEach(function (row, position) {

            const number =
                row.querySelector('.matiere-number');


            number.textContent =
                position + 1;

        });

    }

});

</script>


{{-- =============================================================
     STYLE
============================================================== --}}

<style>

.form-control {

    border: 1px solid #e0e0e0;

    border-radius: 10px;

    padding: 10px 15px;

    transition: all 0.3s ease;

    font-size: 0.95rem;

    background-color: #ffffff;

}


.form-control:focus {

    border-color: #4361ee;

    box-shadow:
        0 0 0 3px rgba(67, 97, 238, 0.1);

}


.form__input-title label {

    font-weight: 600;

    color: #2c3e50;

    margin-bottom: 8px;

    font-size: 0.9rem;

}


/*
|--------------------------------------------------------------------------
| LIGNE MATIÈRE
|--------------------------------------------------------------------------
*/

.matiere-row {

    display: flex;

    align-items: flex-end;

    gap: 12px;

    padding: 15px;

    margin-bottom: 12px;

    border: 1px solid #e7e9ee;

    border-radius: 10px;

    background: #fafbfc;

    transition: all 0.2s ease;

}


.matiere-row:hover {

    border-color: #d9ddea;

    background: #ffffff;

}


/*
|--------------------------------------------------------------------------
| NUMÉRO
|--------------------------------------------------------------------------
*/

.matiere-number {

    width: 34px;

    height: 34px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    margin-bottom: 3px;

    border-radius: 8px;

    background: #eef2ff;

    color: #4361ee;

    font-size: 0.85rem;

    font-weight: 700;

}


/*
|--------------------------------------------------------------------------
| BOUTON SUPPRESSION
|--------------------------------------------------------------------------
*/

.remove-matiere {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 10px;

}


/*
|--------------------------------------------------------------------------
| ICÔNES GUIDE
|--------------------------------------------------------------------------
*/

.guide-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

}


/*
|--------------------------------------------------------------------------
| MOBILE
|--------------------------------------------------------------------------
*/

@media (max-width: 576px) {

    .matiere-row {

        align-items: stretch;

    }


    .matiere-number {

        width: 30px;

        height: 30px;

    }


    .remove-matiere {

        width: 38px;

        height: 38px;

    }

}

</style>

@endsection
