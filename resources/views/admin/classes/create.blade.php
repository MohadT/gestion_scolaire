@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-xxl-8">

        <div class="card__wrapper">

            {{-- =====================================================
                 TITRE
            ====================================================== --}}
            <div class="card__title-wrap mb-20">

                <div class="d-flex align-items-center">

                    <div>

                        <h5 class="card__heading-title mb-1">
                            Ajout de nouvelles classes
                        </h5>

                        <p class="text-muted small mb-0">
                            Remplissez les informations pour créer une ou plusieurs classes
                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 MESSAGES
            ====================================================== --}}

            @if (session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @if (session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>Veuillez corriger les erreurs suivantes :</strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =====================================================
                 FORMULAIRE
            ====================================================== --}}

            <form action="{{ route('classes.store') }}"
                  method="POST"
                  id="classesForm">

                @csrf


                {{-- =================================================
                     CONTENEUR DES CLASSES
                ================================================== --}}

                <div id="classesContainer">


                    {{-- =================================================
                         PREMIÈRE CLASSE
                    ================================================== --}}

                    <div class="class-form border rounded p-4 mb-4"
                         data-index="0">

                        {{-- EN-TÊTE DU BLOC --}}

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <h6 class="mb-0">

                                <i class="fa-regular fa-chalkboard me-2"></i>

                                Classe <span class="class-number">1</span>

                            </h6>

                        </div>


                        <div class="row g-4">


                            {{-- =================================================
                                 NOM DE LA CLASSE
                            ================================================== --}}

                            <div class="col-12">

                                <div class="from__input-box">

                                    <div class="form__input-title">

                                        <label>

                                            <i class="fa-regular fa-chalkboard me-1"></i>

                                            Nom de la classe

                                            <span class="text-danger">*</span>

                                        </label>

                                    </div>

                                    <div class="form__input">

                                        <input
                                            class="form-control"
                                            name="classes[0][nom_classe]"
                                            type="text"
                                            placeholder="Ex : 6ème A, Terminale S1, CM2..."
                                            required
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- =================================================
                                 EFFECTIF
                            ================================================== --}}

                            <div class="col-md-6">

                                <div class="from__input-box">

                                    <div class="form__input-title">

                                        <label>

                                            <i class="fa-regular fa-users me-1"></i>

                                            Effectif

                                            <span class="text-danger">*</span>

                                        </label>

                                    </div>

                                    <div class="form__input">

                                        <input
                                            class="form-control"
                                            name="classes[0][effectif]"
                                            type="number"
                                            min="0"
                                            placeholder="Ex : 30"
                                            required
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- =================================================
                                 PRIX
                            ================================================== --}}

                            <div class="col-md-6">

                                <div class="from__input-box">

                                    <div class="form__input-title">

                                        <label>

                                            <i class="fa-regular fa-money-bill me-1"></i>

                                            Prix

                                            <span class="text-danger">*</span>

                                        </label>

                                    </div>

                                    <div class="form__input">

                                        <div class="input-group">

                                            <input
                                                class="form-control"
                                                name="classes[0][prix]"
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                placeholder="Ex : 1500.00"
                                                required
                                            >

                                            <span class="input-group-text">
                                                MAD
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     BOUTON + EN BAS DU FORMULAIRE
                ====================================================== --}}

                <div class="text-center mt-3 mb-4">

                    <button type="button"
                            class="btn btn-outline-primary btn-add-class"
                            id="addClassBtn">

                        <i class="fa-regular fa-plus me-1"></i>

                        Ajouter une autre classe

                    </button>

                </div>


                {{-- =====================================================
                     BOUTONS FINAUX
                ====================================================== --}}

                <div class="col-12 mt-4">

                    <div class="border-top pt-4">

                        <div class="d-flex justify-content-end gap-3">

                            <a href="{{ route('classes.index') }}"
                               class="btn btn-outline-secondary btn-action">

                                <i class="fa-regular fa-xmark me-1"></i>

                                Annuler

                            </a>


                            <button type="submit"
                                    class="btn btn-primary btn-action">

                                <i class="fa-regular fa-floppy-disk me-1"></i>

                                Enregistrer les classes

                            </button>

                        </div>

                    </div>

                </div>


            </form>

        </div>

    </div>


    {{-- =============================================================
         GUIDE
    ============================================================= --}}

    <div class="col-xxl-4">

        <div class="card border-0 shadow-sm sticky-top"
             style="top: 20px;">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-3">

                    <i class="fa-regular fa-lightbulb text-warning me-2"></i>

                    Guide de saisie

                </h6>


                {{-- NOM --}}

                <div class="guide-item d-flex mb-3">

                    <div class="guide-icon bg-primary bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-chalkboard text-primary"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Nom de la classe
                        </strong>

                        <p class="text-muted small mb-0">
                            Nom unique pour identifier la classe
                        </p>

                    </div>

                </div>


                {{-- EFFECTIF --}}

                <div class="guide-item d-flex mb-3">

                    <div class="guide-icon bg-info bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-users text-info"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Effectif
                        </strong>

                        <p class="text-muted small mb-0">
                            Nombre maximum ou prévu d'élèves
                        </p>

                    </div>

                </div>


                {{-- PRIX --}}

                <div class="guide-item d-flex">

                    <div class="guide-icon bg-success bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-money-bill text-success"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Prix
                        </strong>

                        <p class="text-muted small mb-0">
                            Montant de la scolarité de la classe
                        </p>

                    </div>

                </div>


                <hr class="my-4">


                <div class="text-center">

                    <i class="fa-regular fa-circle-check text-success fs-1 mb-2"></i>

                    <p class="text-muted small mb-0">

                        Vous pouvez ajouter plusieurs classes
                        avant de cliquer sur
                        <strong>Enregistrer les classes</strong>.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const addClassBtn =
        document.getElementById('addClassBtn');

    const classesContainer =
        document.getElementById('classesContainer');

    let classIndex = 1;


    /*
    |--------------------------------------------------------------------------
    | AJOUTER UNE CLASSE
    |--------------------------------------------------------------------------
    */

    addClassBtn.addEventListener('click', function () {

        const classForm =
            document.createElement('div');

        classForm.classList.add(
            'class-form',
            'border',
            'rounded',
            'p-4',
            'mb-4'
        );

        classForm.setAttribute(
            'data-index',
            classIndex
        );


        classForm.innerHTML = `

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h6 class="mb-0">

                    <i class="fa-regular fa-chalkboard me-2"></i>

                    Classe
                    <span class="class-number">
                        ${classIndex + 1}
                    </span>

                </h6>


                <button type="button"
                        class="btn btn-sm btn-outline-danger remove-class">

                    <i class="fa-regular fa-trash me-1"></i>

                    Retirer

                </button>

            </div>


            <div class="row g-4">


                <!-- NOM DE LA CLASSE -->

                <div class="col-12">

                    <div class="from__input-box">

                        <div class="form__input-title">

                            <label>

                                <i class="fa-regular fa-chalkboard me-1"></i>

                                Nom de la classe

                                <span class="text-danger">*</span>

                            </label>

                        </div>


                        <div class="form__input">

                            <input
                                class="form-control"
                                name="classes[${classIndex}][nom_classe]"
                                type="text"
                                placeholder="Ex : 6ème A, Terminale S1, CM2..."
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- EFFECTIF -->

                <div class="col-md-6">

                    <div class="from__input-box">

                        <div class="form__input-title">

                            <label>

                                <i class="fa-regular fa-users me-1"></i>

                                Effectif

                                <span class="text-danger">*</span>

                            </label>

                        </div>


                        <div class="form__input">

                            <input
                                class="form-control"
                                name="classes[${classIndex}][effectif]"
                                type="number"
                                min="0"
                                placeholder="Ex : 30"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- PRIX -->

                <div class="col-md-6">

                    <div class="from__input-box">

                        <div class="form__input-title">

                            <label>

                                <i class="fa-regular fa-money-bill me-1"></i>

                                Prix

                                <span class="text-danger">*</span>

                            </label>

                        </div>


                        <div class="form__input">

                            <div class="input-group">

                                <input
                                    class="form-control"
                                    name="classes[${classIndex}][prix]"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    placeholder="Ex : 1500.00"
                                    required
                                >

                                <span class="input-group-text">
                                    MAD
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        `;


        classesContainer.appendChild(classForm);

        classIndex++;

        updateClassNumbers();

    });


    /*
    |--------------------------------------------------------------------------
    | RETIRER UNE CLASSE
    |--------------------------------------------------------------------------
    */

    classesContainer.addEventListener(
        'click',
        function (event) {

            const removeButton =
                event.target.closest('.remove-class');


            if (!removeButton) {
                return;
            }


            const classForms =
                document.querySelectorAll('.class-form');


            if (classForms.length <= 1) {

                alert(
                    'Vous devez conserver au moins une classe.'
                );

                return;
            }


            const classForm =
                removeButton.closest('.class-form');

            classForm.remove();


            updateClassNumbers();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | NUMÉROTATION VISUELLE
    |--------------------------------------------------------------------------
    */

    function updateClassNumbers() {

        const forms =
            document.querySelectorAll('.class-form');


        forms.forEach(function (form, index) {

            const number =
                form.querySelector('.class-number');


            if (number) {

                number.textContent =
                    index + 1;

            }

        });

    }

});

</script>


{{-- =============================================================
     STYLE
============================================================= --}}

<style>

.class-form {

    background: #fafbfc;

    border-color: #e5e7eb !important;

    transition: all 0.2s ease;

}


.class-form:hover {

    border-color: #d0d5dd !important;

}


.class-form h6 {

    font-weight: 600;

    color: #343a40;

}


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

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);

}


.form__input-title label {

    font-weight: 600;

    color: #2c3e50;

    margin-bottom: 8px;

    font-size: 0.9rem;

}


.input-group-text {

    background-color: #f8f9fa;

    border: 1px solid #e0e0e0;

    border-left: none;

    border-radius: 0 10px 10px 0;

    color: #666;

    font-weight: 600;

}


.input-group .form-control {

    border-right: none;

    border-radius: 10px 0 0 10px;

}


.input-group:focus-within .input-group-text {

    border-color: #4361ee;

}


.input-group:focus-within .form-control {

    border-right: none;

}


/*
|--------------------------------------------------------------------------
| BOUTON AJOUT
|--------------------------------------------------------------------------
*/

.btn-add-class {

    border-radius: 10px;

    padding: 10px 25px;

    font-weight: 600;

    border: 2px dashed #4361ee;

    transition: all 0.3s ease;

}


.btn-add-class:hover {

    background: #4361ee;

    color: white;

    transform: translateY(-2px);

    box-shadow: 0 6px 15px rgba(67, 97, 238, 0.2);

}


.btn-action {

    border-radius: 10px;

    padding: 10px 24px;

    font-weight: 500;

    transition: all 0.3s ease;

}


.btn-action:hover {

    transform: translateY(-2px);

    box-shadow: 0 8px 20px rgba(0,0,0,0.12);

}


.guide-icon {

    width: 40px;

    height: 40px;

    min-width: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

}


.guide-item {

    transition: all 0.2s ease;

    padding: 8px;

    border-radius: 10px;

}


.guide-item:hover {

    background-color: #f8f9fa;

}


.bg-opacity-10 {

    --bs-bg-opacity: 0.1;

}


.alert {

    border: none;

    border-radius: 12px;

}


.alert ul {

    list-style: none;

    padding-left: 0;

}


.alert ul li::before {

    content: "•";

    margin-right: 8px;

    color: #dc3545;

}


@media (max-width: 1400px) {

    .col-xxl-8,
    .col-xxl-4 {

        width: 100%;

    }

}


@media (max-width: 768px) {

    .btn-action {

        width: 100%;

    }

}

</style>

@endsection
