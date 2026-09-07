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
                        <h5 class="card__heading-title mb-1">Modifier l'inscription</h5>
                        <p class="text-muted small mb-0">
                            {{ $inscription->etudiant->prenom_etudiant }} {{ $inscription->etudiant->nom_etudiant }}
                            - {{ $inscription->classe->nom_classe }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Message d'erreur --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-regular fa-circle-exclamation me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Erreurs de validation --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-regular fa-circle-exclamation me-2"></i>
                    <strong>Erreur !</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('inscriptions.update', $inscription->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Étudiant -->
                    <div class="col-12">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="etudiant_id">
                                    <i class="fa-regular fa-user-graduate me-1"></i>
                                    Étudiant <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <select class="form-control @error('etudiant_id') is-invalid @enderror"
                                        name="etudiant_id" id="etudiant_id" required>
                                    <option value="">-- Sélectionner un étudiant --</option>
                                    @foreach($etudiants as $etudiant)
                                        <option value="{{ $etudiant->id }}"
                                            {{ old('etudiant_id', $inscription->etudiant_id) == $etudiant->id ? 'selected' : '' }}>
                                            {{ $etudiant->prenom_etudiant }} {{ $etudiant->nom_etudiant }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('etudiant_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Classe -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="classe_id">
                                    <i class="fa-regular fa-chalkboard me-1"></i>
                                    Classe <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <select class="form-control @error('classe_id') is-invalid @enderror"
                                        name="classe_id" id="classe_id" required>
                                    <option value="">-- Sélectionner une classe --</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}"
                                            {{ old('classe_id', $inscription->classe_id) == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom_classe }} ({{ $classe->effectif }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('classe_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Année scolaire -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="annee_scolaire_id">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    Année scolaire <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <select class="form-control @error('annee_scolaire_id') is-invalid @enderror"
                                        name="annee_scolaire_id" id="annee_scolaire_id" required>
                                    <option value="">-- Sélectionner --</option>
                                    @php
                                        $annees = \App\Models\Annee_scolaire::where('user_id', Auth::id())
                                            ->orderBy('nom_annee_scolaire', 'desc')->get();
                                    @endphp
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}"
                                            {{ old('annee_scolaire_id', $inscription->annee_scolaire_id) == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom_annee_scolaire }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('annee_scolaire_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Frais de scolarité -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="frais_scolarite">
                                    <i class="fa-regular fa-money-bill me-1"></i>
                                    Frais de scolarité (MAD)
                                </label>
                            </div>
                            <div class="form__input">
                                <input class="form-control @error('frais_scolarite') is-invalid @enderror"
                                       name="frais_scolarite" id="frais_scolarite"
                                       type="number" step="0.01" min="0" placeholder="0"
                                       value="{{ old('frais_scolarite', $inscription->frais_scolarite) }}">
                                @error('frais_scolarite')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="col-12 mt-4">
                        <div class="border-top pt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('inscriptions.show', $inscription->id) }}"
                                   class="btn btn-outline-secondary btn-action">
                                    <i class="fa-regular fa-arrow-left me-1"></i>Retour
                                </a>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('inscriptions.index') }}"
                                       class="btn btn-outline-danger btn-action">
                                        <i class="fa-regular fa-xmark me-1"></i>Annuler
                                    </a>
                                    <button type="submit" class="btn btn-warning btn-action">
                                        <i class="fa-regular fa-floppy-disk me-1"></i>Mettre à jour
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
                <div class="mb-3 p-3 bg-light rounded-3">
                    <small class="text-muted d-block">Créée le</small>
                    <strong>{{ $inscription->created_at->format('d/m/Y à H:i') }}</strong>
                </div>
                <div class="p-3 bg-light rounded-3">
                    <small class="text-muted d-block">Dernière modification</small>
                    <strong>{{ $inscription->updated_at->format('d/m/Y à H:i') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle { width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center; border-radius: 12px; }
.form-control, .form-select { border: 1px solid #e0e0e0; border-radius: 10px; padding: 10px 15px; font-size: 0.95rem; background: #fff; }
.form-control:focus, .form-select:focus { border-color: #ffc107; box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1); }
.form__input-title label { font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 0.9rem; }
.btn-action { border-radius: 10px; padding: 10px 24px; font-weight: 500; transition: all 0.3s ease; }
.btn-action:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
.alert { border: none; border-radius: 12px; }
.alert ul { list-style: none; padding-left: 0; }
.alert ul li::before { content: "•"; margin-right: 8px; }
.bg-opacity-10 { --bs-bg-opacity: 0.1; }
@media (max-width: 768px) { .btn-action { width: 100%; } .d-flex.justify-content-between { flex-direction: column; gap: 10px; } }
</style>
@endsection
