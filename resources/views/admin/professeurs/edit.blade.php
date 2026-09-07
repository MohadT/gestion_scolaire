```blade
@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-xxl-8">

        <div class="card__wrapper">

            {{-- En-tête --}}
            <div class="card__title-wrap mb-20">

                <div>
                    <h5 class="card__heading-title mb-1">
                        Modifier le professeur
                    </h5>

                    <p class="text-muted small mb-0">
                        Modifiez les informations du professeur.
                    </p>
                </div>

            </div>


            {{-- Erreurs de validation --}}
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


            {{-- Formulaire --}}
            <form action="{{ route('professeurs.update', $professeur->id) }}"
                  method="POST">

                @csrf

                @method('PUT')

                <div class="row g-4">


                    {{-- Prénom --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="prenom_prof">

                                    <i class="fa-regular fa-user me-1"></i>

                                    Prénom

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="text"
                                    name="prenom_prof"
                                    id="prenom_prof"
                                    class="form-control"
                                    placeholder="Ex : Mohamed"
                                    value="{{ old('prenom_prof', $professeur->prenom_prof) }}"
                                    required
                                >

                                @error('prenom_prof')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Nom --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="nom_prof">

                                    <i class="fa-regular fa-user me-1"></i>

                                    Nom

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="text"
                                    name="nom_prof"
                                    id="nom_prof"
                                    class="form-control"
                                    placeholder="Ex : Diarra"
                                    value="{{ old('nom_prof', $professeur->nom_prof) }}"
                                    required
                                >

                                @error('nom_prof')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Adresse --}}
                    <div class="col-12">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="addresse">

                                    <i class="fa-regular fa-location-dot me-1"></i>

                                    Adresse

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="text"
                                    name="addresse"
                                    id="addresse"
                                    class="form-control"
                                    placeholder="Ex : Bamako, ACI 2000"
                                    value="{{ old('addresse', $professeur->addresse) }}"
                                    required
                                >

                                @error('addresse')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Téléphone --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="telephone">

                                    <i class="fa-regular fa-phone me-1"></i>

                                    Téléphone

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="tel"
                                    name="telephone"
                                    id="telephone"
                                    class="form-control"
                                    placeholder="Ex : 76000000"
                                    value="{{ old('telephone', $professeur->telephone) }}"
                                    required
                                >

                                @error('telephone')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Profession --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="profession">

                                    <i class="fa-regular fa-briefcase me-1"></i>

                                    Profession

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="text"
                                    name="profession"
                                    id="profession"
                                    class="form-control"
                                    placeholder="Ex : Professeur de mathématiques"
                                    value="{{ old('profession', $professeur->profession) }}"
                                    required
                                >

                                @error('profession')

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

                                {{-- Retour --}}
                                <a href="{{ route('professeurs.index') }}"
                                   class="btn btn-outline-secondary">

                                    <i class="fa-regular fa-arrow-left me-1"></i>

                                    Annuler

                                </a>


                                {{-- Voir --}}
                                <a href="{{ route('professeurs.show', $professeur->id) }}"
                                   class="btn btn-outline-info">

                                    <i class="fa-regular fa-eye me-1"></i>

                                    Voir

                                </a>


                                {{-- Enregistrer --}}
                                <button type="submit"
                                        class="btn btn-primary">

                                    <i class="fa-regular fa-floppy-disk me-1"></i>

                                    Enregistrer les modifications

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Informations actuelles --}}
    <div class="col-xxl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <div class="text-center mb-4">

                    <div class="prof-avatar mx-auto mb-3">

                        {{ strtoupper(substr($professeur->prenom_prof, 0, 1)) }}

                    </div>

                    <h5 class="mb-1">

                        {{ $professeur->prenom_prof }}
                        {{ $professeur->nom_prof }}

                    </h5>

                    <p class="text-muted mb-0">

                        {{ $professeur->profession }}

                    </p>

                </div>


                <hr>


                <div class="info-item mb-3">

                    <small class="text-muted d-block">
                        Téléphone
                    </small>

                    <strong>

                        <i class="fa-regular fa-phone me-1"></i>

                        {{ $professeur->telephone }}

                    </strong>

                </div>


                <div class="info-item">

                    <small class="text-muted d-block">
                        Adresse
                    </small>

                    <strong>

                        <i class="fa-regular fa-location-dot me-1"></i>

                        {{ $professeur->addresse }}

                    </strong>

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

.prof-avatar {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef2ff;
    color: #4361ee;
    font-weight: 700;
    font-size: 28px;
}

</style>

@endsection
```
