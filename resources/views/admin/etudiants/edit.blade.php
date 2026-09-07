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
                        <h5 class="card__heading-title mb-1">Modifier les informations de l'étudiant</h5>
                        <p class="text-muted small mb-0">
                            <i class="fa-regular fa-user-graduate me-1"></i>
                            {{ $etudiant->prenom_etudiant }} {{ $etudiant->nom_etudiant }}
                        </p>
                    </div>
                </div>
            </div>

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

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-regular fa-circle-check me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Photo de profil - SANS FOND GRIS -->
                    <div class="col-12">
                        <div class="photo-upload-section p-4 rounded-3">
                            <h6 class="fw-bold mb-3">
                                <i class="fa-regular fa-camera me-2 text-primary"></i>
                                Photo de profil
                            </h6>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="photo-preview-wrapper position-relative">
                                        <img id="photoPreview"
                                             class="rounded-circle shadow-sm"
                                             src="{{ $etudiant->photo ? asset('storage/' . $etudiant->photo) : asset('assets/images/avatar/default-avatar.png') }}"
                                             alt="Photo de profil"
                                             width="120"
                                             height="120"
                                             style="object-fit: cover; border: 3px solid #fff; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                                        <label for="photo_etudiant" class="photo-upload-btn position-absolute bottom-0 end-0">
                                            <i class="fa-regular fa-camera"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="photo_etudiant" class="form-label fw-semibold">Changer la photo</label>
                                    <input class="form-control"
                                           type="file"
                                           name="photo"
                                           id="photo_etudiant"
                                           accept="image/png, image/jpeg, image/jpg"
                                           onchange="previewImage(event)">
                                    <small class="text-muted d-block mt-1">
                                        <i class="fa-regular fa-info-circle me-1"></i>
                                        Laissez vide pour conserver la photo actuelle. Formats : JPG, PNG. Max : 2MB
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de l'étudiant -->
                    <div class="col-12">
                        <h6 class="fw-bold mb-3 section-title">
                            <i class="fa-regular fa-graduation-cap me-2 text-primary"></i>
                            Informations de l'étudiant
                        </h6>
                    </div>

                    <!-- Nom -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="nom_etudiant">
                                    Nom <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <input class="form-control"
                                       name="nom_etudiant"
                                       id="nom_etudiant"
                                       type="text"
                                       placeholder="Entrez le nom de l'étudiant"
                                       value="{{ old('nom_etudiant', $etudiant->nom_etudiant) }}"
                                       required>
                                @error('nom_etudiant')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Prénom -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="prenom_etudiant">
                                    Prénom <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <input class="form-control"
                                       name="prenom_etudiant"
                                       id="prenom_etudiant"
                                       type="text"
                                       placeholder="Entrez le prénom"
                                       value="{{ old('prenom_etudiant', $etudiant->prenom_etudiant) }}"
                                       required>
                                @error('prenom_etudiant')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div class="col-12">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="adresse_etudiant">
                                    Adresse <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <textarea class="form-control"
                                          name="adresse_etudiant"
                                          id="adresse_etudiant"
                                          rows="2"
                                          placeholder="Entrez l'adresse complète"
                                          required>{{ old('adresse_etudiant', $etudiant->adresse_etudiant) }}</textarea>
                                @error('adresse_etudiant')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations du tuteur -->
                    <div class="col-12 mt-3">
                        <h6 class="fw-bold mb-3 section-title">
                            <i class="fa-regular fa-user-tie me-2 text-success"></i>
                            Informations du tuteur
                        </h6>
                    </div>

                    <!-- Nom du tuteur -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="nom_du_tuteur">
                                    Nom du tuteur <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <input class="form-control"
                                       name="nom_du_tuteur"
                                       id="nom_du_tuteur"
                                       type="text"
                                       placeholder="Entrez le nom du tuteur"
                                       value="{{ old('nom_du_tuteur', $etudiant->nom_du_tuteur) }}"
                                       required>
                                @error('nom_du_tuteur')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Numéro du tuteur -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="numero_du_tuteur">
                                    Numéro du tuteur <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-regular fa-phone"></i>
                                    </span>
                                    <input class="form-control"
                                           name="numero_du_tuteur"
                                           id="numero_du_tuteur"
                                           type="tel"
                                           placeholder="+212 6XX XXX XXX"
                                           value="{{ old('numero_du_tuteur', $etudiant->numero_du_tuteur) }}"
                                           pattern="[0-9+\s]{8,}"
                                           required>
                                </div>
                                @error('numero_du_tuteur')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="col-12 mt-4">
                        <div class="border-top pt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('etudiants.show', $etudiant->id) }}"
                                   class="btn btn-outline-secondary btn-action">
                                    <i class="fa-regular fa-arrow-left me-1"></i>
                                    Retour aux détails
                                </a>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('etudiants.index') }}"
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

    <!-- Carte d'information -->
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
                        Créé le
                    </small>
                    <strong>{{ $etudiant->created_at->format('d/m/Y à H:i') }}</strong>
                </div>

                <div class="history-item p-3 bg-light rounded-3">
                    <small class="text-muted d-block mb-1">
                        <i class="fa-regular fa-clock me-1"></i>
                        Dernière modification
                    </small>
                    <strong>{{ $etudiant->updated_at->format('d/m/Y à H:i') }}</strong>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <i class="fa-regular fa-shield-check text-success fs-1 mb-2"></i>
                    <p class="text-muted small mb-0">
                        Les modifications seront enregistrées immédiatement après validation.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('photoPreview');

    reader.onload = function() {
        preview.src = reader.result;
    }

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>

<style>
/* Styles */
.icon-circle {
    width: 45px;
    height: 45px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

/* Section photo - FOND BLANC */
.photo-upload-section {
    background: #ffffff;
    border: 2px dashed #dee2e6;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.photo-upload-section:hover {
    border-color: #4361ee;
    background-color: #ffffff;
    box-shadow: 0 5px 20px rgba(67, 97, 238, 0.08);
}

.photo-preview-wrapper {
    display: inline-block;
}

.photo-upload-btn {
    width: 35px;
    height: 35px;
    background: #4361ee;
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(67, 97, 238, 0.3);
    border: 2px solid #ffffff;
}

.photo-upload-btn:hover {
    background: #3651d4;
    transform: scale(1.15);
    box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
}

.photo-upload-btn i {
    font-size: 14px;
}

.from__input-box {
    margin-bottom: 0;
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
    border-color: #4361ee;
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    background-color: #ffffff;
}

.form__input-title label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

.section-title {
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
    color: #2c3e50;
}

/* Input group sans fond gris */
.input-group-text {
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    border-right: none;
    border-radius: 10px 0 0 10px;
    color: #6c757d;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 10px 10px 0;
}

.input-group .form-control:focus {
    border-left: none;
}

.input-group:focus-within .input-group-text {
    border-color: #4361ee;
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

.history-item {
    transition: all 0.2s ease;
}

.history-item:hover {
    background-color: #e9ecef !important;
}

/* Animation */
.card__wrapper {
    animation: slideUp 0.5s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 1400px) {
    .col-xxl-8, .col-xxl-4 {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .photo-upload-section .row {
        flex-direction: column;
        text-align: center;
    }

    .photo-upload-section .col-auto {
        margin-bottom: 15px;
    }

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
