@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-xxl-8">
        <div class="card__wrapper">
            <div class="card__title-wrap mb-20">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning bg-opacity-10 me-3">
                        <i class="fa-regular fa-pen-to-square text-warning fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card__heading-title mb-1">Modifier la classe</h5>
                        <p class="text-muted small mb-0">{{ $classe->nom }}</p>
                    </div>
                </div>
            </div>

            <!-- Erreurs de validation -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-regular fa-circle-exclamation me-2"></i>
                    <strong>Erreur !</strong> Veuillez corriger les erreurs suivantes :
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('classes.update', $classe->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Nom de la classe -->
                    <div class="col-12">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="nom">
                                    <i class="fa-regular fa-chalkboard me-1"></i>
                                    Nom de la classe <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <input class="form-control @error('nom') is-invalid @enderror"
                                       name="nom_classe"
                                       id="nom"
                                       type="text"
                                       placeholder="Ex: 6ème A, Terminale S1..."
                                       value="{{ old('nom', $classe->nom_classe) }}"
                                       required>
                                @error('nom')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Effectif -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="effectif">
                                    <i class="fa-regular fa-users me-1"></i>
                                    Effectif <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <input class="form-control @error('effectif') is-invalid @enderror"
                                       name="effectif"
                                       id="effectif"
                                       type="text"
                                       placeholder="Ex: 30 élèves, 25-30..."
                                       value="{{ old('effectif', $classe->effectif) }}"
                                       required>
                                @error('effectif')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Prix -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="prix">
                                    <i class="fa-regular fa-money-bill me-1"></i>
                                    Prix (MAD) <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <div class="input-group">
                                    <input class="form-control @error('prix') is-invalid @enderror"
                                           name="prix"
                                           id="prix"
                                           type="number"
                                           step="0.01"
                                           min="0"
                                           placeholder="Ex: 1500.00"
                                           value="{{ old('prix', $classe->prix) }}"
                                           required>
                                    <span class="input-group-text">MAD</span>
                                </div>
                                @error('prix')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="col-12 mt-4">
                        <div class="border-top pt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('classes.show', $classe->id) }}"
                                   class="btn btn-outline-secondary btn-action">
                                    <i class="fa-regular fa-arrow-left me-1"></i>
                                    Retour aux détails
                                </a>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('classes.index') }}"
                                       class="btn btn-outline-danger btn-action">
                                        <i class="fa-regular fa-xmark me-1"></i>
                                        Annuler
                                    </a>
                                    <button type="submit" class="btn btn-warning btn-action">
                                        <i class="fa-regular fa-floppy-disk me-1"></i>
                                        Mettre à jour
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Historique -->
    <div class="col-xxl-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="fa-regular fa-clock-rotate-left text-info me-2"></i>
                    Historique
                </h6>

                <div class="history-item mb-3 p-3 bg-light rounded-3">
                    <small class="text-muted d-block mb-1">
                        <i class="fa-regular fa-calendar me-1"></i>
                        Créée le
                    </small>
                    <strong>{{ $classe->created_at->format('d/m/Y à H:i') }}</strong>
                </div>

                <div class="history-item mb-3 p-3 bg-light rounded-3">
                    <small class="text-muted d-block mb-1">
                        <i class="fa-regular fa-clock me-1"></i>
                        Dernière modification
                    </small>
                    <strong>{{ $classe->updated_at->format('d/m/Y à H:i') }}</strong>
                </div>

                <div class="history-item mb-3 p-3 bg-light rounded-3">
                    <small class="text-muted d-block mb-1">
                        <i class="fa-regular fa-hashtag me-1"></i>
                        ID Classe
                    </small>
                    <strong>#{{ $classe->id }}</strong>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <i class="fa-regular fa-shield-check text-success fs-1 mb-2"></i>
                    <p class="text-muted small mb-0">
                        Les modifications seront enregistrées immédiatement.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 45px;
    height: 45px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.form-control {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 10px 15px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    background-color: #ffffff;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
}

.form__input-title label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
    border-left: none;
    border-radius: 0 10px 10px 0;
    color: #666;
    font-weight: 600;
}

.input-group .form-control {
    border-right: none;
    border-radius: 10px 0 0 10px;
}

.input-group:focus-within .input-group-text {
    border-color: #ffc107;
}

.input-group:focus-within .form-control {
    border-color: #ffc107;
}

.btn-action {
    border-radius: 10px;
    padding: 10px 24px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.history-item {
    transition: all 0.2s ease;
}

.history-item:hover {
    background-color: #e9ecef !important;
}

.alert {
    border: none;
    border-radius: 12px;
}

.alert ul {
    list-style: none;
    padding-left: 0;
}

.alert ul li::before {
    content: "•";
    margin-right: 8px;
    color: #dc3545;
}

.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}

@media (max-width: 1400px) {
    .col-xxl-8, .col-xxl-4 {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .btn-action {
        width: 100%;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;
    }
}
</style>
@endsection
