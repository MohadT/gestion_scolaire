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

                        Bulletin de notes

                    </h5>

                    <p class="text-muted mb-0">

                        Sélectionnez l'année scolaire,
                        la classe et l'étudiant.

                    </p>

                </div>

            </div>


            {{-- =====================================================
                MESSAGE D'ERREUR
            ====================================================== --}}

            @if(session('error'))

                <div class="alert alert-danger">

                    <i class="fa-regular fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                </div>

            @endif


            {{-- =====================================================
                ERREURS DE VALIDATION
            ====================================================== --}}

            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Veuillez corriger les erreurs suivantes :
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

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
                action="{{ route('notes.bulletin.afficher') }}"
                method="GET"
            >

                <div class="row g-4">


                    {{-- =================================================
                        ANNÉE SCOLAIRE
                    ================================================== --}}

                    <div class="col-md-4">

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
                                        Sélectionner l'année scolaire
                                    </option>


                                    @foreach($anneesScolaires as $annee)

                                        <option
                                            value="{{ $annee->id }}"
                                            {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}
                                        >

                                            {{ $annee->nom_annee_scolaire }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        CLASSE
                    ================================================== --}}

                    <div class="col-md-4">

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
                                        Sélectionner la classe
                                    </option>


                                    @foreach($classes as $classe)

                                        <option
                                            value="{{ $classe->id }}"
                                            {{ request('classe_id') == $classe->id ? 'selected' : '' }}
                                        >

                                            {{ $classe->nom_classe }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        ÉTUDIANT
                    ================================================== --}}

                    <div class="col-md-4">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="etudiant_id">

                                    <i class="fa-regular fa-user-graduate me-1"></i>

                                    Étudiant

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

                                <select
                                    name="etudiant_id"
                                    id="etudiant_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Sélectionner l'étudiant
                                    </option>


                                    @foreach($etudiants as $etudiant)

                                        <option
                                            value="{{ $etudiant->id }}"
                                            {{ request('etudiant_id') == $etudiant->id ? 'selected' : '' }}
                                        >

                                            {{ $etudiant->nom_etudiant }}
                                            {{ $etudiant->prenom_etudiant }}

                                            @if($etudiant->code_etudiant)

                                                — {{ $etudiant->code_etudiant }}

                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        BOUTONS
                    ================================================== --}}

                    <div class="col-12 mt-4">

                        <div class="border-top pt-4">

                            <div class="d-flex justify-content-end gap-2">

                                <a
                                    href="{{ route('notes.index') }}"
                                    class="btn btn-outline-secondary"
                                >

                                    <i class="fa-regular fa-arrow-left me-1"></i>

                                    Retour

                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa-regular fa-file-lines me-1"></i>

                                    Afficher le bulletin

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =============================================================
    STYLE
============================================================= --}}

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
        0 0 0 3px
        rgba(67, 97, 238, 0.1);

}


.form__input-title label {

    font-weight: 600;

    color: #2c3e50;

    margin-bottom: 8px;

    font-size: 0.9rem;

}

</style>

@endsection
