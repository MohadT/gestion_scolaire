@extends('admin.layout.master')

@section('content')

<div class="row">

    <!-- Formulaire -->
    <div class="col-xxl-8">
        <div class="card__wrapper">

            <!-- Titre -->
            <div class="card__title-wrap mb-20">
                <div class="d-flex align-items-center">

                    <div>
                        <h5 class="card__heading-title mb-1">
                            Ajouter un professeur
                        </h5>

                        <p class="text-muted small mb-0">
                            Remplissez les informations du professeur
                        </p>
                    </div>

                </div>
            </div>


            <!-- Message succès -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-regular fa-circle-check me-2"></i>
                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>
                </div>
            @endif


            <!-- Erreurs -->
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


            <!-- Formulaire -->
            <form action="{{ route('professeurs.store') }}" method="POST">

                @csrf

                <div class="row g-4">

                    <!-- Prénom -->
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
                                    class="form-control"
                                    name="prenom_prof"
                                    id="prenom_prof"
                                    type="text"
                                    placeholder="Ex : Mohamed"
                                    value="{{ old('prenom_prof') }}"
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


                    <!-- Nom -->
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
                                    class="form-control"
                                    name="nom_prof"
                                    id="nom_prof"
                                    type="text"
                                    placeholder="Ex : Diarra"
                                    value="{{ old('nom_prof') }}"
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


                    <!-- Adresse -->
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
                                    class="form-control"
                                    name="addresse"
                                    id="addresse"
                                    type="text"
                                    placeholder="Ex : Bamako, ACI 2000"
                                    value="{{ old('addresse') }}"
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


                    <!-- Téléphone -->
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
                                    class="form-control"
                                    name="telephone"
                                    id="telephone"
                                    type="tel"
                                    placeholder="Ex : 76000000"
                                    value="{{ old('telephone') }}"
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


                    <!-- Profession -->
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
                                    class="form-control"
                                    name="profession"
                                    id="profession"
                                    type="text"
                                    placeholder="Ex : Professeur de mathématiques"
                                    value="{{ old('profession') }}"
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



                    <div class="col-12">
                        <div class="border-top pt-4 mt-2">
                            <h6 class="mb-3">Compte de connexion du professeur</h6>
                            <div class="row g-4">
                                <div class="col-md-4"><label class="form-label">Identifiant *</label><input class="form-control" name="identifiant" value="{{ old('identifiant') }}" required></div>
                                <div class="col-md-4"><label class="form-label">Email *</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div>
                                <div class="col-md-4"><label class="form-label">Mot de passe *</label><input class="form-control" type="password" name="password" required></div>
                                <div class="col-md-4"><label class="form-label">Confirmation *</label><input class="form-control" type="password" name="password_confirmation" required></div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="col-12 mt-4">

                        <div class="border-top pt-4">

                            <div class="d-flex justify-content-end gap-3">

                                <!-- Annuler -->
                                <a href="{{ route('professeurs.index') }}"
                                   class="btn btn-outline-secondary btn-action">

                                    <i class="fa-regular fa-xmark me-1"></i>

                                    Annuler

                                </a>


                                <!-- Enregistrer -->
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-action">

                                    <i class="fa-regular fa-floppy-disk me-1"></i>

                                    Enregistrer le professeur

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>


    <!-- Guide -->
    <div class="col-xxl-4">

        <div class="card border-0 shadow-sm sticky-top"
             style="top: 20px;">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-3">

                    <i class="fa-regular fa-lightbulb text-warning me-2"></i>

                    Guide de saisie

                </h6>


                <!-- Nom -->
                <div class="guide-item d-flex mb-3">

                    <div class="guide-icon bg-primary bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-user text-primary"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Identité
                        </strong>

                        <p class="text-muted small mb-0">
                            Indiquez le prénom et le nom complet du professeur.
                        </p>

                    </div>

                </div>


                <!-- Adresse -->
                <div class="guide-item d-flex mb-3">

                    <div class="guide-icon bg-info bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-location-dot text-info"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Adresse
                        </strong>

                        <p class="text-muted small mb-0">
                            Indiquez l'adresse actuelle du professeur.
                        </p>

                    </div>

                </div>


                <!-- Téléphone -->
                <div class="guide-item d-flex mb-3">

                    <div class="guide-icon bg-success bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-phone text-success"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Téléphone
                        </strong>

                        <p class="text-muted small mb-0">
                            Utilisez un numéro de téléphone valide.
                        </p>

                    </div>

                </div>


                <!-- Profession -->
                <div class="guide-item d-flex">

                    <div class="guide-icon bg-warning bg-opacity-10 rounded-3 me-3">

                        <i class="fa-regular fa-briefcase text-warning"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Profession
                        </strong>

                        <p class="text-muted small mb-0">
                            Exemple : Professeur de français,
                            Mathématiques, Informatique, etc.
                        </p>

                    </div>

                </div>


                <hr class="my-4">


                <div class="text-center">

                    <i class="fa-regular fa-circle-check text-success fs-1 mb-2"></i>

                    <p class="text-muted small mb-0">
                        Après l'enregistrement, le professeur
                        apparaîtra dans la liste des professeurs.
                    </p>

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

.btn-action {
    padding: 10px 18px;
    border-radius: 8px;
}

</style>

@endsection
