@extends('admin.layout.master')

@section('content')

<div class="row">

    {{-- =========================================================
         FORMULAIRE
    ========================================================== --}}
    <div class="col-xxl-8">

        <div class="card__wrapper">

            {{-- EN-TÊTE --}}
            <div class="card__title-wrap mb-20">

                <div>

                    <h5 class="card__heading-title mb-1">
                        Ajouter un utilisateur
                    </h5>

                    <p class="text-muted small mb-0">
                        Créez un compte administrateur, professeur,
                        comptable ou parent.
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
                 SUCCÈS
            ====================================================== --}}
            @if (session('success'))

                <div class="alert alert-success">

                    <i class="fa-light fa-circle-check me-2"></i>

                    {{ session('success') }}

                </div>

            @endif


            {{-- =====================================================
                 FORMULAIRE
            ====================================================== --}}
            <form
                action="{{ route('users.store') }}"
                method="POST"
            >

                @csrf

                <div class="row g-4">


                    {{-- =================================================
                         IDENTIFIANT
                    ================================================== --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="identifiant">

                                    <i class="fa-light fa-user me-1"></i>

                                    Identifiant

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="text"
                                    name="identifiant"
                                    id="identifiant"
                                    class="form-control"
                                    value="{{ old('identifiant') }}"
                                    placeholder="Ex : professeur.mohamed"
                                    required
                                    autofocus
                                >

                                @error('identifiant')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         EMAIL
                    ================================================== --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="email">

                                    <i class="fa-light fa-envelope me-1"></i>

                                    Adresse email

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    placeholder="exemple@email.com"
                                    required
                                >

                                @error('email')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         RÔLE
                    ================================================== --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="role">

                                    <i class="fa-light fa-user-shield me-1"></i>

                                    Rôle

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <select
                                    name="role"
                                    id="role"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Sélectionner un rôle
                                    </option>

                                    <option
                                        value="admin"
                                        @selected(old('role') === 'admin')
                                    >
                                        Administrateur
                                    </option>

                                    <option
                                        value="professeur"
                                        @selected(old('role') === 'professeur')
                                    >
                                        Professeur
                                    </option>

                                    <option
                                        value="comptable"
                                        @selected(old('role') === 'comptable')
                                    >
                                        Comptable
                                    </option>

                                    <option
                                        value="parent"
                                        @selected(old('role') === 'parent')
                                    >
                                        Parent
                                    </option>

                                </select>

                                @error('role')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         ENFANTS DU PARENT
                    ================================================== --}}
                    <div
                        class="col-12"
                        id="parentChildrenBox"
                        style="display:none;"
                    >

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="studentSearch">

                                    <i class="fa-light fa-children me-1"></i>

                                    Enfants à rattacher

                                </label>

                            </div>


                            <div class="form__input">


                                {{-- =====================================
                                     CHAMP DE RECHERCHE
                                ====================================== --}}
                                <div class="input-group mb-2">

                                    <span class="input-group-text">

                                        <i class="fa-light fa-magnifying-glass"></i>

                                    </span>

                                    <input
                                        type="text"
                                        id="studentSearch"
                                        class="form-control"
                                        placeholder="Tapez le code étudiant, nom ou prénom..."
                                        autocomplete="off"
                                    >

                                </div>


                                {{-- =====================================
                                     RÉSULTATS
                                ====================================== --}}
                                <div
                                    id="studentSearchResults"
                                    class="border rounded-3 bg-white mb-3"
                                    style="
                                        max-height:250px;
                                        overflow-y:auto;
                                        display:none;
                                    "
                                ></div>


                                {{-- =====================================
                                     ENFANTS SÉLECTIONNÉS
                                ====================================== --}}
                                <div
                                    id="selectedStudents"
                                    class="d-flex flex-wrap gap-2 mb-2"
                                ></div>


                                {{-- =====================================
                                     INPUTS CACHÉS
                                ====================================== --}}
                                <div id="selectedStudentInputs"></div>


                                <small class="text-muted">

                                    <i class="fa-light fa-circle-info me-1"></i>

                                    Recherchez un étudiant avec son code,
                                    son nom ou son prénom, puis cliquez dessus.
                                    Vous pouvez rattacher plusieurs enfants.

                                </small>


                                @error('etudiant_ids')

                                    <small class="text-danger d-block mt-2">

                                        {{ $message }}

                                    </small>

                                @enderror


                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         MOT DE PASSE
                    ================================================== --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="password">

                                    <i class="fa-light fa-lock me-1"></i>

                                    Mot de passe

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Minimum 8 caractères"
                                    required
                                >

                                @error('password')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         CONFIRMATION
                    ================================================== --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="password_confirmation">

                                    <i class="fa-light fa-lock-keyhole me-1"></i>

                                    Confirmer le mot de passe

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Répétez le mot de passe"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         BOUTONS
                    ================================================== --}}
                    <div class="col-12 mt-4">

                        <div class="border-top pt-4">

                            <div class="d-flex justify-content-end gap-3">

                                <a
                                    href="{{ route('users.index') }}"
                                    class="btn btn-outline-secondary"
                                >

                                    <i class="fa-light fa-arrow-left me-1"></i>

                                    Annuler

                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa-light fa-user-plus me-1"></i>

                                    Créer l'utilisateur

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         PANNEAU INFORMATIONS
    ========================================================== --}}
    <div class="col-xxl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-light fa-circle-info text-primary me-2"></i>

                    Informations

                </h6>


                {{-- ADMIN --}}
                <div class="d-flex align-items-start mb-4">

                    <div
                        class="guide-icon bg-primary bg-opacity-10 rounded-3 me-3"
                    >

                        <i class="fa-light fa-user-shield text-primary"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Administrateur
                        </strong>

                        <p class="text-muted small mb-0">

                            Accès complet à la gestion de
                            l'établissement.

                        </p>

                    </div>

                </div>


                {{-- PROFESSEUR --}}
                <div class="d-flex align-items-start mb-4">

                    <div
                        class="guide-icon bg-success bg-opacity-10 rounded-3 me-3"
                    >

                        <i class="fa-light fa-chalkboard-user text-success"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Professeur
                        </strong>

                        <p class="text-muted small mb-0">

                            Compte destiné à l'enseignant.

                        </p>

                    </div>

                </div>


                {{-- COMPTABLE --}}
                <div class="d-flex align-items-start mb-4">

                    <div
                        class="guide-icon bg-warning bg-opacity-10 rounded-3 me-3"
                    >

                        <i class="fa-light fa-calculator text-warning"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Comptable
                        </strong>

                        <p class="text-muted small mb-0">

                            Gestion des paiements et
                            opérations financières.

                        </p>

                    </div>

                </div>


                {{-- PARENT --}}
                <div class="d-flex align-items-start mb-4">

                    <div
                        class="guide-icon bg-info bg-opacity-10 rounded-3 me-3"
                    >

                        <i class="fa-light fa-children text-info"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Parent
                        </strong>

                        <p class="text-muted small mb-0">

                            Compte permettant de consulter
                            les informations scolaires de ses enfants.

                        </p>

                    </div>

                </div>


                {{-- INFO SÉCURITÉ --}}
                <div class="alert alert-info mb-0">

                    <i class="fa-light fa-shield-check me-2"></i>

                    <small>

                        Le mot de passe doit contenir au minimum
                        8 caractères.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     DONNÉES POUR LA RECHERCHE
============================================================== --}}
@php

    $studentsForSearch = $etudiants->map(function ($etudiant) {

        return [

            'id' => $etudiant->id,

            'code' => $etudiant->code_etudiant,

            'nom' => $etudiant->nom_etudiant,

            'prenom' => $etudiant->prenom_etudiant,

        ];

    })->values();

@endphp


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

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);

}


.form__input-title label {

    font-weight: 600;

    color: #2c3e50;

    margin-bottom: 8px;

    font-size: 0.9rem;

}


.guide-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

}


.student-result {

    cursor: pointer;

    transition: background-color 0.15s ease;

}


.student-result:hover {

    background-color: #f5f7ff !important;

}


.student-result:focus {

    background-color: #f5f7ff !important;

    outline: none;

}


.student-result + .student-result {

    border-top: 1px solid #eeeeee !important;

}


#studentSearchResults {

    position: relative;

    z-index: 1000;

}


#selectedStudents .badge {

    font-size: 0.85rem;

    border-radius: 8px;

}


#selectedStudents .btn-close {

    opacity: 1;

}


#selectedStudents {

    min-height: 5px;

}

</style>


{{-- =============================================================
     JAVASCRIPT
============================================================== --}}
<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =========================================================
       ÉLÉMENTS
    ========================================================== */

    const role =
        document.getElementById('role');

    const box =
        document.getElementById('parentChildrenBox');

    const searchInput =
        document.getElementById('studentSearch');

    const resultsBox =
        document.getElementById('studentSearchResults');

    const selectedBox =
        document.getElementById('selectedStudents');

    const hiddenInputs =
        document.getElementById('selectedStudentInputs');


    /* =========================================================
       LISTE DES ÉTUDIANTS
    ========================================================== */

    const students =
        @json($studentsForSearch);


    /* =========================================================
       ÉTUDIANTS SÉLECTIONNÉS
    ========================================================== */

    const selected =
        new Map();


    /* =========================================================
       RESTAURER APRÈS ERREUR
    ========================================================== */

    const oldIds =
        @json(
            array_map(
                'intval',
                old('etudiant_ids', [])
            )
        );


    oldIds.forEach(function (id) {


        const student =
            students.find(function (student) {

                return Number(student.id) === Number(id);

            });


        if (student) {

            selected.set(
                Number(student.id),
                student
            );

        }

    });


    /* =========================================================
       AFFICHER / CACHER LE BLOC PARENT
    ========================================================== */

    function toggleParentChildren() {


        if (!role || !box) {

            return;

        }


        if (role.value === 'parent') {

            box.style.display = 'block';

        } else {

            box.style.display = 'none';

            if (resultsBox) {

                resultsBox.style.display = 'none';

            }

        }

    }


    /* =========================================================
       AFFICHER LES ENFANTS SÉLECTIONNÉS
    ========================================================== */

    function renderSelected() {


        selectedBox.innerHTML = '';

        hiddenInputs.innerHTML = '';


        selected.forEach(function (student) {


            const badge =
                document.createElement('span');


            badge.className =
                'badge bg-primary d-inline-flex align-items-center gap-2 p-2';


            badge.innerHTML = `

                <span>

                    ${
                        student.code
                        ? student.code + ' — '
                        : ''
                    }

                    ${student.nom}
                    ${student.prenom}

                </span>


                <button

                    type="button"

                    class="btn-close btn-close-white"

                    aria-label="Retirer ${student.nom} ${student.prenom}"

                    style="font-size:8px;"

                ></button>

            `;


            /* =============================================
               BOUTON SUPPRESSION
            ============================================== */

            const removeButton =
                badge.querySelector('button');


            removeButton.addEventListener(
                'click',
                function () {


                    selected.delete(
                        Number(student.id)
                    );


                    renderSelected();

                }
            );


            selectedBox.appendChild(
                badge
            );


            /* =============================================
               INPUT CACHÉ
            ============================================== */

            const input =
                document.createElement('input');


            input.type =
                'hidden';


            input.name =
                'etudiant_ids[]';


            input.value =
                student.id;


            hiddenInputs.appendChild(
                input
            );

        });

    }


    /* =========================================================
       AFFICHER LES RÉSULTATS DE RECHERCHE
    ========================================================== */

    function renderResults(query) {


        resultsBox.innerHTML = '';


        const search =
            query.trim().toLowerCase();


        /* =============================================
           RECHERCHE VIDE
        ============================================== */

        if (!search) {

            resultsBox.style.display =
                'none';

            return;

        }


        /* =============================================
           FILTRAGE
        ============================================== */

        const matches =
            students
                .filter(function (student) {


                    const code =
                        String(
                            student.code || ''
                        ).toLowerCase();


                    const nom =
                        String(
                            student.nom || ''
                        ).toLowerCase();


                    const prenom =
                        String(
                            student.prenom || ''
                        ).toLowerCase();


                    const fullName =
                        (
                            nom +
                            ' ' +
                            prenom
                        );


                    return (

                        code.includes(search)

                        ||

                        nom.includes(search)

                        ||

                        prenom.includes(search)

                        ||

                        fullName.includes(search)

                    );


                })
                .slice(0, 15);


        /* =============================================
           AUCUN RÉSULTAT
        ============================================== */

        if (matches.length === 0) {


            resultsBox.innerHTML = `

                <div class="p-3 text-muted">

                    <i class="fa-light fa-circle-exclamation me-1"></i>

                    Aucun étudiant trouvé.

                </div>

            `;


            resultsBox.style.display =
                'block';


            return;

        }


        /* =============================================
           AFFICHER LES RÉSULTATS
        ============================================== */

        matches.forEach(function (student) {


            const item =
                document.createElement('button');


            item.type =
                'button';


            item.className =
                'w-100 text-start border-0 bg-white p-3 student-result';


            item.innerHTML = `

                <div class="d-flex align-items-center">


                    <div

                        class="
                            rounded-circle
                            bg-primary
                            bg-opacity-10
                            d-flex
                            align-items-center
                            justify-content-center
                            me-3
                        "

                        style="
                            width:40px;
                            height:40px;
                        "

                    >

                        <i class="fa-light fa-user text-primary"></i>

                    </div>


                    <div>


                        <strong>

                            ${student.nom}
                            ${student.prenom}

                        </strong>


                        <div class="small text-muted">


                            ${
                                student.code

                                ? 'Code : ' + student.code

                                : 'Code non renseigné'

                            }


                        </div>


                    </div>


                </div>

            `;


            /* =========================================
               CLIQUER SUR UN ÉTUDIANT
            ========================================== */

            item.addEventListener(
                'click',
                function () {


                    selected.set(

                        Number(student.id),

                        student

                    );


                    renderSelected();


                    searchInput.value =
                        '';


                    resultsBox.innerHTML =
                        '';


                    resultsBox.style.display =
                        'none';


                    searchInput.focus();

                }
            );


            resultsBox.appendChild(
                item
            );

        });


        resultsBox.style.display =
            'block';

    }


    /* =========================================================
       RECHERCHE AUTOMATIQUE
    ========================================================== */

    if (searchInput) {


        searchInput.addEventListener(
            'input',
            function () {


                renderResults(
                    this.value
                );


            }
        );


    }


    /* =========================================================
       FERMER LES RÉSULTATS
    ========================================================== */

    document.addEventListener(
        'click',
        function (event) {


            if (

                resultsBox

                &&

                searchInput

                &&

                !resultsBox.contains(
                    event.target
                )

                &&

                event.target !== searchInput

            ) {


                resultsBox.style.display =
                    'none';

            }

        }
    );


    /* =========================================================
       CHANGEMENT DE RÔLE
    ========================================================== */

    if (role) {


        role.addEventListener(
            'change',
            toggleParentChildren
        );


    }


    /* =========================================================
       INITIALISATION
    ========================================================== */

    toggleParentChildren();

    renderSelected();


});

</script>

@endsection
