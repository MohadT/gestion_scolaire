@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card__wrapper">

            <div class="card__title-wrap mb-20">

                <div>

                    <h5 class="card__heading-title mb-1">

                        <i class="fa-regular fa-calendar-days me-1"></i>

                        Consulter un emploi du temps

                    </h5>

                    <p class="text-muted small mb-0">

                        Sélectionnez une classe et une année scolaire
                        pour afficher son emploi du temps.

                    </p>

                </div>

            </div>


            {{-- ERREURS --}}

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


            {{-- FORMULAIRE --}}

            <form
                action="{{ route('emplois.fiche.imprimer') }}"
                method="GET"
                target="_blank"
            >

                <div class="row g-4">


                    {{-- ANNÉE SCOLAIRE --}}

                    <div class="col-md-5">

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

                                        Sélectionner une année scolaire

                                    </option>


                                    @foreach($anneesScolaires as $annee)

                                        <option
                                            value="{{ $annee->id }}"
                                        >

                                            {{ $annee->nom_annee_scolaire }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- CLASSE --}}

                    <div class="col-md-5">

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

                                        Sélectionner une classe

                                    </option>


                                    @foreach($classes as $classe)

                                        <option
                                            value="{{ $classe->id }}"
                                        >

                                            {{ $classe->nom_classe }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- BOUTON --}}

                    <div class="col-md-2 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >

                            <i class="fa-regular fa-magnifying-glass me-1"></i>

                            Afficher

                        </button>

                    </div>

                </div>

            </form>


            {{-- INFORMATION --}}

            <div class="alert alert-info mt-4 mb-0">

                <i class="fa-regular fa-circle-info me-2"></i>

                Après avoir sélectionné la classe et l'année scolaire,
                l'emploi du temps s'ouvrira dans une nouvelle page
                spécialement conçue pour l'impression.

            </div>

        </div>

    </div>

</div>


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

</style>

@endsection
