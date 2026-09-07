
@extends('admin.layout.master')

@section('content')

<div class="row">

    {{-- Formulaire --}}
    <div class="col-xxl-8">

        <div class="card__wrapper">

            {{-- En-tête --}}
            <div class="card__title-wrap mb-20">

                <div>

                    <h5 class="card__heading-title mb-1">
                        Affecter une matière à une classe
                    </h5>

                    <p class="text-muted small mb-0">
                        Définissez le coefficient et le volume horaire
                        de la matière pour cette classe.
                    </p>

                </div>

            </div>


            {{-- Erreurs --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Veuillez corriger les erreurs suivantes :
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Message erreur --}}
            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show">

                    <i class="fa-regular fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- Formulaire --}}
            <form action="{{ route('matiere_coeficients.store') }}"
                  method="POST">

                @csrf

                <div class="row g-4">


                    {{-- Classe --}}
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


                    {{-- Matière --}}
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


                    {{-- Coefficient --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="coefficient">

                                    <i class="fa-regular fa-calculator me-1"></i>

                                    Coefficient

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

                                <input
                                    type="number"
                                    name="coefficient"
                                    id="coefficient"
                                    class="form-control"
                                    placeholder="Ex : 2"
                                    value="{{ old('coefficient') }}"
                                    min="0"
                                    step="0.01"
                                    required
                                >


                                @error('coefficient')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Nombre d'heures --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="nombre_heure">

                                    <i class="fa-regular fa-clock me-1"></i>

                                    Nombre d'heures

                                    <span class="text-danger">*</span>

                                </label>

                            </div>


                            <div class="form__input">

                                <input
                                    type="text"
                                    name="nombre_heure"
                                    id="nombre_heure"
                                    class="form-control"
                                    placeholder="Ex : 4 heures"
                                    value="{{ old('nombre_heure') }}"
                                    required
                                >


                                @error('nombre_heure')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Boutons --}}
                    <div class="col-12 mt-4">

                        <div class="border-top pt-4">

                            <div class="d-flex justify-content-end gap-3">

                                <a href="{{ route('matiere_coeficients.index') }}"
                                   class="btn btn-outline-secondary">

                                    <i class="fa-regular fa-arrow-left me-1"></i>

                                    Annuler

                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa-regular fa-floppy-disk me-1"></i>

                                    Enregistrer

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Aide --}}
    <div class="col-xxl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-regular fa-lightbulb text-warning me-2"></i>

                    Informations

                </h6>


                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-primary bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-school text-primary"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Classe
                        </strong>

                        <p class="text-muted small mb-0">
                            Sélectionnez la classe concernée.
                        </p>

                    </div>

                </div>


                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-success bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-book text-success"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Matière
                        </strong>

                        <p class="text-muted small mb-0">
                            Sélectionnez la matière à affecter.
                        </p>

                    </div>

                </div>


                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-warning bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-calculator text-warning"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Coefficient
                        </strong>

                        <p class="text-muted small mb-0">
                            Le coefficient peut être différent
                            selon la classe.
                        </p>

                    </div>

                </div>


                <div class="alert alert-info mb-0">

                    <i class="fa-regular fa-circle-info me-2"></i>

                    <small>
                        Une même matière peut être affectée à plusieurs
                        classes avec des coefficients différents.
                    </small>

                </div>

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

</style>

@endsection

