@extends('admin.layout.master')

@section('content')

<div class="row">

    {{-- =====================================================
         FORMULAIRE
    ====================================================== --}}

    <div class="col-xxl-8 col-xl-9 col-12">

        <div class="card__wrapper">

            {{-- EN-TÊTE --}}

            <div class="card__title-wrap mb-20">

                <div>

                    <h5 class="card__heading-title mb-1">

                        <i class="fa-regular fa-clipboard-list me-1"></i>

                        Nouvelle évaluation

                    </h5>

                    <p class="text-muted small mb-0">

                        Créez une évaluation pour une classe et une matière.

                    </p>

                </div>

            </div>


            {{-- =================================================
                 ERREURS
            ================================================== --}}

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


            {{-- =================================================
                 FORMULAIRE
            ================================================== --}}

            <form
                action="{{ route('evaluations.store') }}"
                method="POST"
            >

                @csrf


                <div class="row g-4">


                    {{-- =================================================
                         ANNÉE SCOLAIRE
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="annee_scolaire_id">

                                    <i class="fa-regular fa-calendar me-1"></i>

                                    Année scolaire

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

                                <select
                                    name="annee_scolaire_id"
                                    id="annee_scolaire_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">

                                        -- Sélectionner l'année scolaire --

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


                                @error('annee_scolaire_id')

                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         CLASSE
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="classe_id">

                                    <i class="fa-regular fa-school me-1"></i>

                                    Classe

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

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
                                            {{ old('classe_id') == $classe->id ? 'selected' : '' }}
                                        >

                                            {{ $classe->nom_classe }}

                                        </option>

                                    @endforeach

                                </select>


                                @error('classe_id')

                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         MATIÈRE
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="matiere_id">

                                    <i class="fa-regular fa-book me-1"></i>

                                    Matière

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

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
                                            {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}
                                        >

                                            {{ $matiere->nom_matiere }}

                                        </option>

                                    @endforeach

                                </select>


                                @error('matiere_id')

                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         PROFESSEUR
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="professeur_id">

                                    <i class="fa-regular fa-user-tie me-1"></i>

                                    Professeur

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

                                <select
                                    name="professeur_id"
                                    id="professeur_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">

                                        -- Sélectionner un professeur --

                                    </option>


                                    @foreach($professeurs as $professeur)

                                        <option
                                            value="{{ $professeur->id }}"
                                            {{ old('professeur_id') == $professeur->id ? 'selected' : '' }}
                                        >

                                            {{ $professeur->prenom_prof }}

                                            {{ $professeur->nom_prof }}

                                        </option>

                                    @endforeach

                                </select>


                                @error('professeur_id')

                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         NOM DE L'ÉVALUATION
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="nom_evaluation">

                                    <i class="fa-regular fa-clipboard me-1"></i>

                                    Nom de l'évaluation

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

                                <input
                                    type="text"
                                    name="nom_evaluation"
                                    id="nom_evaluation"
                                    class="form-control"
                                    placeholder="Ex : Devoir surveillé 1"
                                    value="{{ old('nom_evaluation') }}"
                                    maxlength="255"
                                    required
                                >


                                @error('nom_evaluation')

                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         TYPE D'ÉVALUATION
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="type_evaluation">

                                    <i class="fa-regular fa-list-check me-1"></i>

                                    Type d'évaluation

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

                                <select
                                    name="type_evaluation"
                                    id="type_evaluation"
                                    class="form-control"
                                    required
                                >

                                    <option value="">

                                        -- Sélectionner le type --

                                    </option>


                                    <option
                                        value="Devoir"
                                        {{ old('type_evaluation') == 'Devoir' ? 'selected' : '' }}
                                    >

                                        Devoir

                                    </option>


                                    <option
                                        value="Interrogation"
                                        {{ old('type_evaluation') == 'Interrogation' ? 'selected' : '' }}
                                    >

                                        Interrogation

                                    </option>


                                    <option
                                        value="Composition"
                                        {{ old('type_evaluation') == 'Composition' ? 'selected' : '' }}
                                    >

                                        Composition

                                    </option>


                                    <option
                                        value="Examen"
                                        {{ old('type_evaluation') == 'Examen' ? 'selected' : '' }}
                                    >

                                        Examen

                                    </option>


                                    <option
                                        value="Contrôle continu"
                                        {{ old('type_evaluation') == 'Contrôle continu' ? 'selected' : '' }}
                                    >

                                        Contrôle continu

                                    </option>


                                    <option
                                        value="Autre"
                                        {{ old('type_evaluation') == 'Autre' ? 'selected' : '' }}
                                    >

                                        Autre

                                    </option>

                                </select>


                                @error('type_evaluation')

                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         APERÇU
                    ================================================== --}}

                    <div class="col-12">

                        <div class="evaluation-preview">

                            <div class="preview-icon">

                                <i class="fa-regular fa-clipboard-check"></i>

                            </div>


                            <div>

                                <strong>

                                    Création de l'évaluation

                                </strong>

                                <p class="text-muted small mb-0">

                                    Après l'enregistrement, vous pourrez
                                    saisir rapidement les notes de tous
                                    les élèves de la classe.

                                </p>

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
                                    href="{{ route('evaluations.index') }}"
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

                                    Créer l'évaluation

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         PANNEAU D'AIDE
    ====================================================== --}}

    <div class="col-xxl-4 col-xl-3 col-12">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-regular fa-lightbulb text-warning me-2"></i>

                    Comment ça fonctionne ?

                </h6>


                {{-- ANNÉE --}}

                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-primary bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-calendar text-primary"></i>

                    </div>


                    <div>

                        <strong class="small">

                            Année scolaire

                        </strong>

                        <p class="text-muted small mb-0">

                            Sélectionnez l'année concernée par
                            l'évaluation.

                        </p>

                    </div>

                </div>


                {{-- CLASSE --}}

                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-warning bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-school text-warning"></i>

                    </div>


                    <div>

                        <strong class="small">

                            Classe

                        </strong>

                        <p class="text-muted small mb-0">

                            L'évaluation sera associée aux élèves
                            de cette classe.

                        </p>

                    </div>

                </div>


                {{-- MATIÈRE --}}

                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-success bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-book text-success"></i>

                    </div>


                    <div>

                        <strong class="small">

                            Matière

                        </strong>

                        <p class="text-muted small mb-0">

                            Choisissez la matière concernée.

                        </p>

                    </div>

                </div>


                {{-- NOTES --}}

                <div class="alert alert-info mb-0">

                    <i class="fa-regular fa-circle-info me-2"></i>

                    <small>

                        Une fois l'évaluation créée, vous pourrez
                        saisir les notes de tous les élèves de la
                        classe depuis une seule page.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| INPUTS
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| LABELS
|--------------------------------------------------------------------------
*/

.form__input-title label {

    font-weight: 600;

    color: #2c3e50;

    margin-bottom: 8px;

    font-size: 0.9rem;

}


/*
|--------------------------------------------------------------------------
| APERÇU
|--------------------------------------------------------------------------
*/

.evaluation-preview {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 16px;

    border-radius: 10px;

    background: #f8f9fb;

    border: 1px solid #e8eaf0;

}


.preview-icon {

    width: 44px;

    height: 44px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 10px;

    background: #eef2ff;

    color: #4361ee;

    font-size: 18px;

}


/*
|--------------------------------------------------------------------------
| ICÔNES AIDE
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
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .evaluation-preview {

        align-items: flex-start;

    }

}

</style>

@endsection
