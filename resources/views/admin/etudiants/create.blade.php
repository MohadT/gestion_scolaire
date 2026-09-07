@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card__wrapper student-page">

            {{-- =====================================================
                 HEADER
            ====================================================== --}}

            <div class="student-page-header">

                <div>

                    <div class="page-title-icon">

                        <i class="fa-regular fa-user-graduate"></i>

                    </div>

                    <div>

                        <h4 class="mb-1">
                            Ajouter des étudiants
                        </h4>

                        <p class="text-muted mb-0">
                            Enregistrez un ou plusieurs étudiants
                            dans votre établissement.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn btn-primary add-student-btn"
                    id="addStudentBtn"
                >

                    <i class="fa-regular fa-plus me-2"></i>

                    Ajouter un étudiant

                </button>

            </div>


            {{-- =====================================================
                 MESSAGES
            ====================================================== --}}

            @if(session('success'))

                <div class="alert alert-success custom-alert">

                    <i class="fa-regular fa-circle-check me-2"></i>

                    {{ session('success') }}

                </div>

            @endif


            @if ($errors->any())

                <div class="alert alert-danger custom-alert">

                    <div>

                        <strong>
                            Impossible d'enregistrer les étudiants
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif


            {{-- =====================================================
                 FORMULAIRE
            ====================================================== --}}

            <form
                action="{{ route('etudiants.store') }}"
                method="POST"
                id="studentsForm"
            >

                @csrf


                <div id="studentsContainer">


                    {{-- =================================================
                         PREMIER ÉTUDIANT
                    ================================================== --}}

                    <div
                        class="student-card"
                        data-index="0"
                    >

                        {{-- HEADER ÉTUDIANT --}}

                        <div class="student-card-header">

                            <div class="student-title">

                                <div class="student-number">
                                    1
                                </div>

                                <div>

                                    <h6 class="mb-0">
                                        Informations de l'étudiant
                                    </h6>

                                    <small class="text-muted">
                                        Renseignez les informations personnelles
                                    </small>

                                </div>

                            </div>

                        </div>


                        {{-- CONTENU --}}

                        <div class="student-card-body">

                            <div class="row g-4">


                                {{-- NOM --}}

                                <div class="col-xl-6 col-md-6">

                                    <div class="form-group-modern">

                                        <label for="nom_0">

                                            Nom étudiant

                                            <span>*</span>

                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-regular fa-user"></i>

                                            <input
                                                type="text"
                                                id="nom_0"
                                                name="etudiants[0][nom_etudiant]"
                                                placeholder="Ex : Traoré"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- PRÉNOM --}}

                                <div class="col-xl-6 col-md-6">

                                    <div class="form-group-modern">

                                        <label for="prenom_0">

                                            Prénom étudiant

                                            <span>*</span>

                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-regular fa-user"></i>

                                            <input
                                                type="text"
                                                id="prenom_0"
                                                name="etudiants[0][prenom_etudiant]"
                                                placeholder="Ex : Mohamed"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- ADRESSE --}}

                                <div class="col-xl-6 col-md-6">

                                    <div class="form-group-modern">

                                        <label for="adresse_0">

                                            Adresse

                                            <span>*</span>

                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-regular fa-location-dot"></i>

                                            <input
                                                type="text"
                                                id="adresse_0"
                                                name="etudiants[0][adresse_etudiant]"
                                                placeholder="Ex : Bamako, ACI 2000"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- TUTEUR --}}

                                <div class="col-xl-6 col-md-6">

                                    <div class="form-group-modern">

                                        <label for="tuteur_0">

                                            Nom du tuteur

                                            <span>*</span>

                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-regular fa-user-tie"></i>

                                            <input
                                                type="text"
                                                id="tuteur_0"
                                                name="etudiants[0][nom_du_tuteur]"
                                                placeholder="Ex : Amadou Traoré"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- TELEPHONE --}}

                                <div class="col-xl-6 col-md-6">

                                    <div class="form-group-modern">

                                        <label for="telephone_0">

                                            Téléphone du tuteur

                                            <span>*</span>

                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-regular fa-phone"></i>

                                            <input
                                                type="text"
                                                id="telephone_0"
                                                name="etudiants[0][numero_du_tuteur]"
                                                placeholder="+223 70 00 00 00"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>

                                <div class="col-12">
                                    <div class="border-top pt-3 mt-2">
                                        <h6 class="mb-3">Compte de connexion de l'étudiant</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4"><label>Identifiant <span>*</span></label><div class="input-wrapper"><input type="text" name="etudiants[0][identifiant]" value="{{ old('etudiants.0.identifiant') }}" required></div></div>
                                            <div class="col-md-4"><label>Email <span>*</span></label><div class="input-wrapper"><input type="email" name="etudiants[0][email]" value="{{ old('etudiants.0.email') }}" required></div></div>
                                            <div class="col-md-4"><label>Mot de passe <span>*</span></label><div class="input-wrapper"><input type="password" name="etudiants[0][password]" required></div></div>
                                            <div class="col-md-4"><label>Confirmation <span>*</span></label><div class="input-wrapper"><input type="password" name="etudiants[0][password_confirmation]" required></div></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     BOUTONS
                ====================================================== --}}

                <div class="form-footer">

                    <a
                        href="{{ route('etudiants.index') }}"
                        class="btn btn-light cancel-btn"
                    >

                        <i class="fa-regular fa-arrow-left me-2"></i>

                        Annuler

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary save-btn"
                    >

                        <i class="fa-regular fa-floppy-disk me-2"></i>

                        Enregistrer les étudiants

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT
============================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const addStudentBtn =
        document.getElementById('addStudentBtn');

    const studentsContainer =
        document.getElementById('studentsContainer');

    let studentIndex = 1;


    /*
    |--------------------------------------------------------------------------
    | AJOUTER UN ÉTUDIANT
    |--------------------------------------------------------------------------
    */

    addStudentBtn.addEventListener('click', function () {

        const studentForm =
            document.createElement('div');

        studentForm.classList.add(
            'student-card'
        );

        studentForm.setAttribute(
            'data-index',
            studentIndex
        );


        studentForm.innerHTML = `

            <div class="student-card-header">

                <div class="student-title">

                    <div class="student-number">
                        ${studentIndex + 1}
                    </div>

                    <div>

                        <h6 class="mb-0">
                            Informations de l'étudiant
                        </h6>

                        <small class="text-muted">
                            Renseignez les informations personnelles
                        </small>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn btn-outline-danger btn-sm remove-student"
                >

                    <i class="fa-regular fa-trash-can me-1"></i>

                    Supprimer

                </button>

            </div>


            <div class="student-card-body">

                <div class="row g-4">


                    <div class="col-xl-6 col-md-6">

                        <div class="form-group-modern">

                            <label>
                                Nom étudiant
                                <span>*</span>
                            </label>

                            <div class="input-wrapper">

                                <i class="fa-regular fa-user"></i>

                                <input
                                    type="text"
                                    name="etudiants[${studentIndex}][nom_etudiant]"
                                    placeholder="Ex : Traoré"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-6 col-md-6">

                        <div class="form-group-modern">

                            <label>
                                Prénom étudiant
                                <span>*</span>
                            </label>

                            <div class="input-wrapper">

                                <i class="fa-regular fa-user"></i>

                                <input
                                    type="text"
                                    name="etudiants[${studentIndex}][prenom_etudiant]"
                                    placeholder="Ex : Mohamed"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-6 col-md-6">

                        <div class="form-group-modern">

                            <label>
                                Adresse
                                <span>*</span>
                            </label>

                            <div class="input-wrapper">

                                <i class="fa-regular fa-location-dot"></i>

                                <input
                                    type="text"
                                    name="etudiants[${studentIndex}][adresse_etudiant]"
                                    placeholder="Ex : Bamako, ACI 2000"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-6 col-md-6">

                        <div class="form-group-modern">

                            <label>
                                Nom du tuteur
                                <span>*</span>
                            </label>

                            <div class="input-wrapper">

                                <i class="fa-regular fa-user-tie"></i>

                                <input
                                    type="text"
                                    name="etudiants[${studentIndex}][nom_du_tuteur]"
                                    placeholder="Ex : Amadou Traoré"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-6 col-md-6">

                        <div class="form-group-modern">

                            <label>
                                Téléphone du tuteur
                                <span>*</span>
                            </label>

                            <div class="input-wrapper">

                                <i class="fa-regular fa-phone"></i>

                                <input
                                    type="text"
                                    name="etudiants[${studentIndex}][numero_du_tuteur]"
                                    placeholder="+223 70 00 00 00"
                                    required
                                >

                            </div>


                                <div class="col-12">
                                    <div class="border-top pt-3 mt-2">
                                        <h6 class="mb-3">Compte de connexion</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4"><label>Identifiant <span>*</span></label><div class="input-wrapper"><input type="text" name="etudiants[${studentIndex}][identifiant]" required></div></div>
                                            <div class="col-md-4"><label>Email <span>*</span></label><div class="input-wrapper"><input type="email" name="etudiants[${studentIndex}][email]" required></div></div>
                                            <div class="col-md-4"><label>Mot de passe <span>*</span></label><div class="input-wrapper"><input type="password" name="etudiants[${studentIndex}][password]" required></div></div>
                                            <div class="col-md-4"><label>Confirmation <span>*</span></label><div class="input-wrapper"><input type="password" name="etudiants[${studentIndex}][password_confirmation]" required></div></div>
                                        </div>
                                    </div>
                                </div>


                </div>

            </div>

        `;


        studentsContainer.appendChild(studentForm);

        studentIndex++;

        updateStudentNumbers();

        studentForm.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

    });


    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER UN ÉTUDIANT
    |--------------------------------------------------------------------------
    */

    studentsContainer.addEventListener(
        'click',
        function (event) {

            const removeButton =
                event.target.closest('.remove-student');

            if (!removeButton) {
                return;
            }


            const studentForms =
                document.querySelectorAll('.student-card');


            if (studentForms.length <= 1) {

                alert(
                    'Vous devez conserver au moins un étudiant.'
                );

                return;

            }


            const studentForm =
                removeButton.closest('.student-card');

            studentForm.remove();

            updateStudentNumbers();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | NUMÉROTATION
    |--------------------------------------------------------------------------
    */

    function updateStudentNumbers() {

        const forms =
            document.querySelectorAll('.student-card');


        forms.forEach(function (form, index) {

            const number =
                form.querySelector('.student-number');

            if (number) {

                number.textContent =
                    index + 1;

            }

        });

    }

});

</script>


{{-- =============================================================
     DESIGN
============================================================== --}}

<style>

/*
|--------------------------------------------------------------------------
| CONTENEUR PRINCIPAL
|--------------------------------------------------------------------------
*/

.student-page {

    background: #ffffff;

}


/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.student-page-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding-bottom: 25px;

    margin-bottom: 25px;

    border-bottom: 1px solid #edf0f5;

}


.student-page-header > div:first-child {

    display: flex;

    align-items: center;

    gap: 15px;

}


.page-title-icon {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    background: #eef2ff;

    color: #4361ee;

    font-size: 22px;

}


.student-page-header h4 {

    font-weight: 700;

    color: #1f2937;

}


.add-student-btn {

    height: 44px;

    padding: 0 18px;

    border-radius: 9px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| ALERTES
|--------------------------------------------------------------------------
*/

.custom-alert {

    border-radius: 10px;

    border: none;

    margin-bottom: 20px;

}


/*
|--------------------------------------------------------------------------
| CARTE ÉTUDIANT
|--------------------------------------------------------------------------
*/

.student-card {

    border: 1px solid #e7eaf0;

    border-radius: 14px;

    margin-bottom: 20px;

    background: #ffffff;

    overflow: hidden;

    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.025);

    transition: all 0.25s ease;

}


.student-card:hover {

    border-color: #d8deeb;

    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.05);

}


/*
|--------------------------------------------------------------------------
| HEADER CARTE
|--------------------------------------------------------------------------
*/

.student-card-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 18px 22px;

    background: #f8f9fc;

    border-bottom: 1px solid #edf0f5;

}


.student-title {

    display: flex;

    align-items: center;

    gap: 13px;

}


.student-title h6 {

    font-size: 15px;

    font-weight: 700;

    color: #27303f;

}


.student-number {

    width: 36px;

    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #4361ee;

    color: #ffffff;

    font-size: 14px;

    font-weight: 700;

}


/*
|--------------------------------------------------------------------------
| CORPS CARTE
|--------------------------------------------------------------------------
*/

.student-card-body {

    padding: 25px 22px 10px;

}


/*
|--------------------------------------------------------------------------
| CHAMPS
|--------------------------------------------------------------------------
*/

.form-group-modern {

    margin-bottom: 5px;

}


.form-group-modern label {

    display: block;

    margin-bottom: 8px;

    color: #374151;

    font-size: 13px;

    font-weight: 600;

}


.form-group-modern label span {

    color: #ef4444;

    margin-left: 2px;

}


/*
|--------------------------------------------------------------------------
| INPUT AVEC ICONE
|--------------------------------------------------------------------------
*/

.input-wrapper {

    position: relative;

}


.input-wrapper > i {

    position: absolute;

    left: 14px;

    top: 50%;

    transform: translateY(-50%);

    color: #9ca3af;

    font-size: 15px;

    pointer-events: none;

}


.input-wrapper input {

    width: 100%;

    height: 46px;

    border: 1px solid #e1e5eb;

    border-radius: 9px;

    padding: 0 15px 0 42px;

    background: #ffffff;

    color: #374151;

    font-size: 14px;

    outline: none;

    transition: all 0.2s ease;

}


.input-wrapper input::placeholder {

    color: #a5acb8;

}


.input-wrapper input:hover {

    border-color: #cbd1dc;

}


.input-wrapper input:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.10);

}


/*
|--------------------------------------------------------------------------
| FOOTER
|--------------------------------------------------------------------------
*/

.form-footer {

    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 10px;

    padding-top: 22px;

    margin-top: 5px;

    border-top: 1px solid #edf0f5;

}


.cancel-btn,
.save-btn {

    height: 44px;

    padding: 0 18px;

    border-radius: 9px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .student-page-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .add-student-btn {

        width: 100%;

    }


    .student-card-header {

        align-items: flex-start;

        gap: 15px;

    }


    .student-card-header .remove-student {

        padding: 6px 9px;

    }


    .student-card-body {

        padding: 20px 15px 5px;

    }


    .form-footer {

        flex-direction: column-reverse;

        align-items: stretch;

    }


    .cancel-btn,
    .save-btn {

        width: 100%;

    }

}

</style>

@endsection
