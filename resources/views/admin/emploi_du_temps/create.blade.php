@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card__wrapper timetable-create">

            {{-- =====================================================
                 HEADER
            ====================================================== --}}

            <div class="timetable-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="timetable-header-icon">
                        <i class="fa-regular fa-calendar-days"></i>
                    </div>

                    <div>

                        <h5 class="mb-1">
                            Créer l'emploi du temps
                        </h5>

                        <p class="text-muted mb-0">
                            Planifiez rapidement les cours de la classe.
                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ERREURS
            ====================================================== --}}

            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Veuillez corriger les erreurs :
                    </strong>

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

            <form
                action="{{ route('emplois.store') }}"
                method="POST"
                id="emploiForm"
                novalidate
            >

                @csrf


                {{-- =================================================
                     ANNÉE SCOLAIRE + CLASSE
                ================================================== --}}

                <div class="row g-3 mb-4">


                    {{-- ANNÉE SCOLAIRE --}}

                    <div class="col-md-6">

                        <div class="selection-card">

                            <div class="selection-icon year-icon">

                                <i class="fa-regular fa-calendar"></i>

                            </div>

                            <div class="selection-content">

                                <label for="annee_scolaire_id">

                                    Année scolaire

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="annee_scolaire_id"
                                    id="annee_scolaire_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Sélectionner l'année scolaire
                                    </option>

                                    @foreach($anneesScolaires as $annee)

                                        <option
                                            value="{{ $annee->id }}"
                                            {{ old('annee_scolaire_id') == $annee->id ? 'selected' : '' }}
                                        >

                                            {{ $annee->nom_annee_scolaire }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- CLASSE --}}

                    <div class="col-md-6">

                        <div class="selection-card">

                            <div class="selection-icon class-icon">

                                <i class="fa-regular fa-school"></i>

                            </div>

                            <div class="selection-content">

                                <label for="classe_id">

                                    Classe

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="classe_id"
                                    id="classe_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Sélectionner une classe
                                    </option>

                                    @foreach($classes as $classe)

                                        <option
                                            value="{{ $classe->id }}"
                                            {{ old('classe_id') == $classe->id ? 'selected' : '' }}
                                        >

                                            {{ $classe->nom_classe }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     CRÉNEAUX
                ================================================== --}}

                <div class="schedule-toolbar">

                    <div>

                        <h6 class="mb-1">
                            Créneaux horaires
                        </h6>

                        <small class="text-muted">
                            Ajoutez les cours un par un.
                        </small>

                    </div>


                    <button
                        type="button"
                        class="btn btn-primary"
                        id="addSlot"
                    >

                        <i class="fa-regular fa-plus me-1"></i>

                        Ajouter un créneau

                    </button>

                </div>


                {{-- =================================================
                     TABLEAU
                ================================================== --}}

                <div class="table-responsive">

                    <table class="table schedule-table">

                        <thead>

                            <tr>

                                <th width="50">
                                    #
                                </th>

                                <th>
                                    Jour
                                </th>

                                <th>
                                    Matière
                                </th>

                                <th>
                                    Professeur
                                </th>

                                <th width="150">
                                    Début
                                </th>

                                <th width="150">
                                    Fin
                                </th>

                                <th width="70"
                                    class="text-center">

                                    Action

                                </th>

                            </tr>

                        </thead>


                        <tbody id="scheduleRows">

                            {{-- =================================================
                                 PREMIER CRÉNEAU
                            ================================================== --}}

                            <tr class="schedule-row">

                                <td>

                                    <div class="row-number">
                                        1
                                    </div>

                                </td>


                                {{-- JOUR --}}

                                <td>

                                    <select
                                        name="emplois[0][jour]"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            Jour
                                        </option>

                                        <option value="Lundi">
                                            Lundi
                                        </option>

                                        <option value="Mardi">
                                            Mardi
                                        </option>

                                        <option value="Mercredi">
                                            Mercredi
                                        </option>

                                        <option value="Jeudi">
                                            Jeudi
                                        </option>

                                        <option value="Vendredi">
                                            Vendredi
                                        </option>

                                        <option value="Samedi">
                                            Samedi
                                        </option>

                                    </select>

                                </td>


                                {{-- MATIÈRE --}}

                                <td>

                                    <select
                                        name="emplois[0][matiere_id]"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            Matière
                                        </option>

                                        @foreach($matieres as $matiere)

                                            <option
                                                value="{{ $matiere->id }}"
                                            >

                                                {{ $matiere->nom_matiere }}

                                            </option>

                                        @endforeach

                                    </select>

                                </td>


                                {{-- PROFESSEUR --}}

                                <td>

                                    <select
                                        name="emplois[0][prof_id]"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            Professeur
                                        </option>

                                        @foreach($professeurs as $professeur)

                                            <option
                                                value="{{ $professeur->id }}"
                                            >

                                                {{ $professeur->prenom_prof }}
                                                {{ $professeur->nom_prof }}

                                            </option>

                                        @endforeach

                                    </select>

                                </td>


                                {{-- HEURE DÉBUT --}}

                                <td>

                                    <select
                                        name="emplois[0][heure_debut]"
                                        class="form-control heure-select"
                                        required
                                    >

                                        <option value="">
                                            Début
                                        </option>

                                    </select>

                                </td>


                                {{-- HEURE FIN --}}

                                <td>

                                    <select
                                        name="emplois[0][heure_fin]"
                                        class="form-control heure-select"
                                        required
                                    >

                                        <option value="">
                                            Fin
                                        </option>

                                    </select>

                                </td>


                                {{-- ACTION --}}

                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger remove-row"
                                        title="Supprimer"
                                    >

                                        <i class="fa-regular fa-trash-can"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                     INFORMATION
                ================================================== --}}

                <div class="quick-info">

                    <i class="fa-regular fa-circle-info"></i>

                    <span>
                        Les horaires sont proposés toutes les
                        <strong>15 minutes</strong>.
                        Exemple : <strong>14h00</strong>,
                        <strong>14h15</strong>,
                        <strong>14h30</strong>.
                    </span>

                </div>


                {{-- =================================================
                     FOOTER
                ================================================== --}}

                <div class="form-footer">

                    <a
                        href="{{ route('emplois.index') }}"
                        class="btn btn-light"
                    >

                        <i class="fa-regular fa-arrow-left me-1"></i>

                        Annuler

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary save-button"
                        id="saveButton"
                    >

                        <i class="fa-regular fa-floppy-disk me-1"></i>

                        Enregistrer l'emploi du temps

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

    /*
    |--------------------------------------------------------------------------
    | ÉLÉMENTS
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById('emploiForm');

    const rowsContainer =
        document.getElementById('scheduleRows');

    const addSlot =
        document.getElementById('addSlot');

    const saveButton =
        document.getElementById('saveButton');


    /*
    |--------------------------------------------------------------------------
    | INDEX DES CRÉNEAUX
    |--------------------------------------------------------------------------
    */

    let index = 1;


    /*
    |--------------------------------------------------------------------------
    | GÉNÉRER LES HORAIRES
    |
    | Valeur envoyée :
    | 14:00
    |
    | Texte affiché :
    | 14h00
    |--------------------------------------------------------------------------
    */

    function generateTimeOptions(placeholder) {

        let options = `
            <option value="">
                ${placeholder}
            </option>
        `;


        for (let heure = 0; heure < 24; heure++) {

            for (
                let minute = 0;
                minute < 60;
                minute += 15
            ) {

                const h =
                    String(heure).padStart(2, '0');

                const m =
                    String(minute).padStart(2, '0');


                const value =
                    `${h}:${m}`;


                const label =
                    `${h}h${m}`;


                options += `
                    <option value="${value}">
                        ${label}
                    </option>
                `;

            }

        }


        return options;

    }


    /*
    |--------------------------------------------------------------------------
    | INITIALISER LES SELECTS D'HEURES
    |--------------------------------------------------------------------------
    */

    function initializeTimeSelects() {

        const selects =
            document.querySelectorAll(
                '.heure-select'
            );


        selects.forEach(function (select) {

            const placeholder =
                select.name.includes('heure_debut')
                    ? 'Début'
                    : 'Fin';


            select.innerHTML =
                generateTimeOptions(
                    placeholder
                );

        });

    }


    initializeTimeSelects();


    /*
    |--------------------------------------------------------------------------
    | MATIÈRES
    |--------------------------------------------------------------------------
    */

    const matieres = @json(
        $matieres->map(function ($matiere) {

            return [
                'id' => $matiere->id,
                'nom' => $matiere->nom_matiere
            ];

        })->values()
    );


    /*
    |--------------------------------------------------------------------------
    | PROFESSEURS
    |--------------------------------------------------------------------------
    */

    const professeurs = @json(
        $professeurs->map(function ($professeur) {

            return [
                'id' => $professeur->id,
                'nom' =>
                    $professeur->prenom_prof
                    . ' '
                    . $professeur->nom_prof
            ];

        })->values()
    );


    /*
    |--------------------------------------------------------------------------
    | AJOUTER UN CRÉNEAU
    |--------------------------------------------------------------------------
    */

    function addScheduleRow() {

        let matiereOptions = `
            <option value="">
                Matière
            </option>
        `;


        matieres.forEach(function (matiere) {

            matiereOptions += `
                <option value="${matiere.id}">
                    ${matiere.nom}
                </option>
            `;

        });


        let professeurOptions = `
            <option value="">
                Professeur
            </option>
        `;


        professeurs.forEach(function (professeur) {

            professeurOptions += `
                <option value="${professeur.id}">
                    ${professeur.nom}
                </option>
            `;

        });


        const row =
            document.createElement('tr');


        row.classList.add(
            'schedule-row'
        );


        row.innerHTML = `

            <td>

                <div class="row-number">
                    ${index + 1}
                </div>

            </td>


            <td>

                <select
                    name="emplois[${index}][jour]"
                    class="form-control"
                    required
                >

                    <option value="">
                        Jour
                    </option>

                    <option value="Lundi">
                        Lundi
                    </option>

                    <option value="Mardi">
                        Mardi
                    </option>

                    <option value="Mercredi">
                        Mercredi
                    </option>

                    <option value="Jeudi">
                        Jeudi
                    </option>

                    <option value="Vendredi">
                        Vendredi
                    </option>

                    <option value="Samedi">
                        Samedi
                    </option>

                </select>

            </td>


            <td>

                <select
                    name="emplois[${index}][matiere_id]"
                    class="form-control"
                    required
                >

                    ${matiereOptions}

                </select>

            </td>


            <td>

                <select
                    name="emplois[${index}][prof_id]"
                    class="form-control"
                    required
                >

                    ${professeurOptions}

                </select>

            </td>


            <td>

                <select
                    name="emplois[${index}][heure_debut]"
                    class="form-control heure-select"
                    required
                >

                    ${generateTimeOptions('Début')}

                </select>

            </td>


            <td>

                <select
                    name="emplois[${index}][heure_fin]"
                    class="form-control heure-select"
                    required
                >

                    ${generateTimeOptions('Fin')}

                </select>

            </td>


            <td class="text-center">

                <button
                    type="button"
                    class="btn btn-sm btn-outline-danger remove-row"
                    title="Supprimer"
                >

                    <i class="fa-regular fa-trash-can"></i>

                </button>

            </td>

        `;


        rowsContainer.appendChild(row);


        index++;


        updateNumbers();

    }


    /*
    |--------------------------------------------------------------------------
    | BOUTON AJOUT
    |--------------------------------------------------------------------------
    */

    addSlot.addEventListener(
        'click',
        function () {

            addScheduleRow();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION D'UN CRÉNEAU
    |--------------------------------------------------------------------------
    */

    rowsContainer.addEventListener(
        'click',
        function (event) {

            const button =
                event.target.closest(
                    '.remove-row'
                );


            if (!button) {

                return;

            }


            const rows =
                rowsContainer.querySelectorAll(
                    '.schedule-row'
                );


            if (rows.length <= 1) {

                alert(
                    'Vous devez conserver au moins un créneau.'
                );

                return;

            }


            button
                .closest('.schedule-row')
                .remove();


            updateNumbers();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | NUMÉROTATION
    |--------------------------------------------------------------------------
    */

    function updateNumbers() {

        const rows =
            rowsContainer.querySelectorAll(
                '.schedule-row'
            );


        rows.forEach(
            function (row, position) {

                const number =
                    row.querySelector(
                        '.row-number'
                    );


                if (number) {

                    number.textContent =
                        position + 1;

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION DES HORAIRES AVANT ENVOI
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        function (event) {

            const rows =
                rowsContainer.querySelectorAll(
                    '.schedule-row'
                );


            let valid = true;


            rows.forEach(function (row) {

                const debut =
                    row.querySelector(
                        '[name*="[heure_debut]"]'
                    );

                const fin =
                    row.querySelector(
                        '[name*="[heure_fin]"]'
                    );


                if (
                    !debut ||
                    !fin ||
                    !debut.value ||
                    !fin.value
                ) {

                    return;

                }


                /*
                | Convertir HH:MM en minutes
                */

                const debutParts =
                    debut.value.split(':');

                const finParts =
                    fin.value.split(':');


                const debutMinutes =
                    parseInt(debutParts[0]) * 60
                    +
                    parseInt(debutParts[1]);


                const finMinutes =
                    parseInt(finParts[0]) * 60
                    +
                    parseInt(finParts[1]);


                if (
                    finMinutes <= debutMinutes
                ) {

                    valid = false;


                    debut.classList.add(
                        'is-invalid'
                    );

                    fin.classList.add(
                        'is-invalid'
                    );

                }

            });


            if (!valid) {

                event.preventDefault();


                alert(
                    'L\'heure de fin doit être supérieure à l\'heure de début.'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Éviter le double clic
            |--------------------------------------------------------------------------
            */

            saveButton.disabled = true;


            saveButton.innerHTML = `
                <i class="fa-regular fa-spinner fa-spin me-1"></i>
                Enregistrement...
            `;

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RETIRER L'ERREUR QUAND L'UTILISATEUR CHANGE L'HEURE
    |--------------------------------------------------------------------------
    */

    rowsContainer.addEventListener(
        'change',
        function (event) {

            if (
                event.target.classList.contains(
                    'heure-select'
                )
            ) {

                event.target.classList.remove(
                    'is-invalid'
                );

            }

        }
    );

});

</script>


{{-- =============================================================
     STYLE
============================================================== --}}

<style>

/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.timetable-header {

    display: flex;

    align-items: center;

    padding-bottom: 22px;

    margin-bottom: 25px;

    border-bottom: 1px solid #edf0f5;

}


.timetable-header-icon {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 13px;

    background: #eef2ff;

    color: #4361ee;

    font-size: 22px;

}


/*
|--------------------------------------------------------------------------
| SÉLECTIONS
|--------------------------------------------------------------------------
*/

.selection-card {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 16px;

    border-radius: 12px;

    background: #f8f9fc;

    border: 1px solid #e8ebf0;

}


.selection-icon {

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    flex-shrink: 0;

    font-size: 18px;

}


.year-icon {

    background: #eef2ff;

    color: #4361ee;

}


.class-icon {

    background: #ecfdf5;

    color: #10b981;

}


.selection-content {

    flex: 1;

}


.selection-content label {

    display: block;

    margin-bottom: 6px;

    color: #374151;

    font-size: 13px;

    font-weight: 600;

}


.selection-content .form-control {

    height: 43px;

    max-width: 100%;

}


/*
|--------------------------------------------------------------------------
| TOOLBAR
|--------------------------------------------------------------------------
*/

.schedule-toolbar {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 15px;

}


.schedule-toolbar h6 {

    font-weight: 700;

    color: #27303f;

}


/*
|--------------------------------------------------------------------------
| TABLE
|--------------------------------------------------------------------------
*/

.schedule-table {

    margin-bottom: 0;

    border: 1px solid #e6e9ef;

}


.schedule-table thead th {

    background: #f8f9fc;

    border-bottom: 1px solid #e6e9ef;

    color: #4b5563;

    font-size: 12px;

    font-weight: 700;

    padding: 13px;

    white-space: nowrap;

}


.schedule-table tbody td {

    padding: 8px;

    border-bottom: 1px solid #edf0f4;

    vertical-align: middle;

}


.schedule-table tbody tr:last-child td {

    border-bottom: none;

}


.schedule-table .form-control {

    height: 42px;

    border-radius: 7px;

    border-color: #e1e5eb;

    font-size: 13px;

}


.schedule-table .form-control:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, .08);

}


/*
|--------------------------------------------------------------------------
| SELECTEUR D'HEURE
|--------------------------------------------------------------------------
*/

.heure-select {

    font-weight: 600;

    color: #374151;

    cursor: pointer;

}


.heure-select option {

    font-weight: 500;

}


/*
|--------------------------------------------------------------------------
| NUMÉRO
|--------------------------------------------------------------------------
*/

.row-number {

    width: 30px;

    height: 30px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 8px;

    background: #eef2ff;

    color: #4361ee;

    font-size: 12px;

    font-weight: 700;

}


/*
|--------------------------------------------------------------------------
| ERREUR INPUT
|--------------------------------------------------------------------------
*/

.is-invalid {

    border-color: #dc3545 !important;

    box-shadow:
        0 0 0 3px rgba(220, 53, 69, .08) !important;

}


/*
|--------------------------------------------------------------------------
| INFORMATION
|--------------------------------------------------------------------------
*/

.quick-info {

    display: flex;

    align-items: center;

    gap: 9px;

    padding: 13px 0;

    color: #6b7280;

    font-size: 13px;

}


.quick-info i {

    color: #4361ee;

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

    margin-top: 15px;

    padding-top: 20px;

    border-top: 1px solid #edf0f5;

}


.form-footer .btn {

    height: 44px;

    padding: 0 17px;

    border-radius: 9px;

    font-weight: 600;

}


.save-button {

    min-width: 230px;

}


/*
|--------------------------------------------------------------------------
| MOBILE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .schedule-toolbar {

        align-items: stretch;

        flex-direction: column;

    }


    .schedule-toolbar .btn {

        width: 100%;

    }


    .selection-card {

        align-items: flex-start;

    }


    .schedule-table {

        min-width: 950px;

    }


    .form-footer {

        flex-direction: column-reverse;

        align-items: stretch;

    }


    .form-footer .btn {

        width: 100%;

    }

}

</style>

@endsection
