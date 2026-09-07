@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card__wrapper">

            {{-- =====================================================
                 EN-TÊTE
            ====================================================== --}}

            <div class="card__title-wrap mb-20">

                <div>

                    <h5 class="card__heading-title mb-1">
                        Modifier l'emploi du temps
                    </h5>

                    <p class="text-muted mb-0">
                        Modifiez les informations de cet horaire.
                    </p>

                </div>

            </div>


            {{-- =====================================================
                 ERREURS
            ====================================================== --}}

            @if ($errors->any())

                <div class="alert alert-danger alert-dismissible fade show">

                    <strong>
                        Veuillez corriger les erreurs suivantes :
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- =====================================================
                 MESSAGE ERREUR
            ====================================================== --}}

            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show">

                    <i class="fa-regular fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- =====================================================
                 FORMULAIRE
            ====================================================== --}}

            <form
                action="{{ route('emplois.update', $emploi->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="row g-4">


                    {{-- =================================================
                         JOUR
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="form-group-modern">

                            <label for="jour">

                                <i class="fa-regular fa-calendar-days me-1"></i>

                                Jour

                                <span class="text-danger">*</span>

                            </label>


                            <div class="input-wrapper">

                                <i class="fa-regular fa-calendar-days"></i>

                                <select
                                    name="jour"
                                    id="jour"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        -- Sélectionner le jour --
                                    </option>

                                    <option
                                        value="Lundi"
                                        {{ old('jour', $emploi->jour) == 'Lundi' ? 'selected' : '' }}
                                    >
                                        Lundi
                                    </option>

                                    <option
                                        value="Mardi"
                                        {{ old('jour', $emploi->jour) == 'Mardi' ? 'selected' : '' }}
                                    >
                                        Mardi
                                    </option>

                                    <option
                                        value="Mercredi"
                                        {{ old('jour', $emploi->jour) == 'Mercredi' ? 'selected' : '' }}
                                    >
                                        Mercredi
                                    </option>

                                    <option
                                        value="Jeudi"
                                        {{ old('jour', $emploi->jour) == 'Jeudi' ? 'selected' : '' }}
                                    >
                                        Jeudi
                                    </option>

                                    <option
                                        value="Vendredi"
                                        {{ old('jour', $emploi->jour) == 'Vendredi' ? 'selected' : '' }}
                                    >
                                        Vendredi
                                    </option>

                                    <option
                                        value="Samedi"
                                        {{ old('jour', $emploi->jour) == 'Samedi' ? 'selected' : '' }}
                                    >
                                        Samedi
                                    </option>

                                </select>

                            </div>


                            @error('jour')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         CLASSE
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="form-group-modern">

                            <label for="classe_id">

                                <i class="fa-regular fa-school me-1"></i>

                                Classe

                                <span class="text-danger">*</span>

                            </label>


                            <div class="input-wrapper">

                                <i class="fa-regular fa-school"></i>

                                <select
                                    name="classe_id"
                                    id="classe_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        -- Sélectionner une classe --
                                    </option>

                                    @foreach($classes as $classe)

                                        <option
                                            value="{{ $classe->id }}"
                                            {{ old('classe_id', $emploi->classe_id) == $classe->id ? 'selected' : '' }}
                                        >

                                            {{ $classe->nom_classe }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            @error('classe_id')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         MATIÈRE
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="form-group-modern">

                            <label for="matiere_id">

                                <i class="fa-regular fa-book me-1"></i>

                                Matière

                                <span class="text-danger">*</span>

                            </label>


                            <div class="input-wrapper">

                                <i class="fa-regular fa-book"></i>

                                <select
                                    name="matiere_id"
                                    id="matiere_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        -- Sélectionner une matière --
                                    </option>

                                    @foreach($matieres as $matiere)

                                        <option
                                            value="{{ $matiere->id }}"
                                            {{ old('matiere_id', $emploi->matiere_id) == $matiere->id ? 'selected' : '' }}
                                        >

                                            {{ $matiere->nom_matiere }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            @error('matiere_id')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         HEURE DE DÉBUT
                    ================================================== --}}

                    <div class="col-md-3">

                        <div class="form-group-modern">

                            <label for="heure_debut">

                                <i class="fa-regular fa-clock me-1"></i>

                                Heure de début

                                <span class="text-danger">*</span>

                            </label>


                            <div class="input-wrapper">

                                <i class="fa-regular fa-clock"></i>

                                <input
                                    type="time"
                                    name="heure_debut"
                                    id="heure_debut"
                                    class="form-control"
                                    value="{{ old('heure_debut', $emploi->heure_debut) }}"
                                    required
                                >

                            </div>


                            @error('heure_debut')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         HEURE DE FIN
                    ================================================== --}}

                    <div class="col-md-3">

                        <div class="form-group-modern">

                            <label for="heure_fin">

                                <i class="fa-regular fa-clock me-1"></i>

                                Heure de fin

                                <span class="text-danger">*</span>

                            </label>


                            <div class="input-wrapper">

                                <i class="fa-regular fa-clock"></i>

                                <input
                                    type="time"
                                    name="heure_fin"
                                    id="heure_fin"
                                    class="form-control"
                                    value="{{ old('heure_fin', $emploi->heure_fin) }}"
                                    required
                                >

                            </div>


                            @error('heure_fin')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         APERÇU
                    ================================================== --}}

                    <div class="col-12">

                        <div class="schedule-preview">

                            <div class="preview-icon">

                                <i class="fa-regular fa-calendar-check"></i>

                            </div>

                            <div>

                                <small class="text-muted">
                                    Horaire actuel
                                </small>

                                <h6 class="mb-0">

                                    <span id="previewJour">
                                        {{ old('jour', $emploi->jour) ?: 'Jour' }}
                                    </span>

                                    —

                                    <span id="previewStart">
                                        {{ old('heure_debut', $emploi->heure_debut) ?: '--:--' }}
                                    </span>

                                    à

                                    <span id="previewEnd">
                                        {{ old('heure_fin', $emploi->heure_fin) ?: '--:--' }}
                                    </span>

                                </h6>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         BOUTONS
                    ================================================== --}}

                    <div class="col-12">

                        <div class="form-footer">

                            <a
                                href="{{ route('emplois.index') }}"
                                class="btn btn-light"
                            >

                                <i class="fa-regular fa-arrow-left me-1"></i>

                                Annuler

                            </a>


                            <a
                                href="{{ route('emplois.show', $emploi->id) }}"
                                class="btn btn-outline-info"
                            >

                                <i class="fa-regular fa-eye me-1"></i>

                                Voir

                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="fa-regular fa-floppy-disk me-1"></i>

                                Enregistrer les modifications

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT APERÇU
============================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const jour =
        document.getElementById('jour');

    const heureDebut =
        document.getElementById('heure_debut');

    const heureFin =
        document.getElementById('heure_fin');

    const previewJour =
        document.getElementById('previewJour');

    const previewStart =
        document.getElementById('previewStart');

    const previewEnd =
        document.getElementById('previewEnd');


    function updatePreview() {

        previewJour.textContent =
            jour.value || 'Jour';

        previewStart.textContent =
            heureDebut.value || '--:--';

        previewEnd.textContent =
            heureFin.value || '--:--';

    }


    jour.addEventListener(
        'change',
        updatePreview
    );

    heureDebut.addEventListener(
        'change',
        updatePreview
    );

    heureFin.addEventListener(
        'change',
        updatePreview
    );

});

</script>


<style>

/*
|--------------------------------------------------------------------------
| CHAMPS
|--------------------------------------------------------------------------
*/

.form-group-modern label {

    display: block;

    margin-bottom: 8px;

    color: #374151;

    font-size: 13px;

    font-weight: 600;

}

.form-group-modern label .text-danger {

    margin-left: 2px;

}


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

    z-index: 2;

    pointer-events: none;

}


.input-wrapper .form-control {

    height: 46px;

    border: 1px solid #e1e5eb;

    border-radius: 9px;

    padding-left: 42px;

    background: #fff;

    transition: all .2s ease;

}


.input-wrapper .form-control:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, .10);

}


/*
|--------------------------------------------------------------------------
| APERÇU
|--------------------------------------------------------------------------
*/

.schedule-preview {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 17px 20px;

    border-radius: 12px;

    background: #f8f9ff;

    border: 1px solid #e8ebf5;

}


.preview-icon {

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    background: #eef2ff;

    color: #4361ee;

    font-size: 18px;

    flex-shrink: 0;

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

    padding-top: 20px;

    border-top: 1px solid #edf0f5;

}


.form-footer .btn {

    height: 44px;

    padding: 0 17px;

    border-radius: 9px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| MOBILE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

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
