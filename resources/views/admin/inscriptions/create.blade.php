@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-xxl-8">
        <div class="card__wrapper">
            <div class="card__title-wrap mb-20">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-success bg-opacity-10 me-3">
                        <i class="fa-regular fa-chalkboard-user text-success fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card__heading-title mb-1">
                            @if(isset($selectedEtudiant))
                                Inscrire : {{ $selectedEtudiant->prenom_etudiant }} {{ $selectedEtudiant->nom_etudiant }}
                            @else
                                Nouvelle inscription
                            @endif
                        </h5>
                        <p class="text-muted small mb-0">Associer un étudiant à une classe et annee scolaire</p>
                    </div>
                </div>
            </div>

            {{-- ✅ Message d'erreur de session --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- ✅ Message de succès --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">

                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- ✅ Erreurs de validation --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                   
                    <strong>Erreur !</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('inscriptions.store') }}" method="POST">
                @csrf

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
                                <input type="hidden" name="etudiant_id" value="{{ $selectedEtudiant->id }}">
                                <input class="form-control" type="text"
                                    value="{{ $selectedEtudiant->prenom_etudiant }} {{ $selectedEtudiant->nom_etudiant }}"
                                    disabled>
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
                                        <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
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

                    <!-- Frais de scolarité -->
                    <div class="col-md-6">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="frais_scolarite">
                                    <i class="fa-regular fa-money-bill me-1"></i>
                                    Frais de scolarité
                                </label>
                            </div>
                            <div class="form__input">
                                <input class="form-control @error('frais_scolarite') is-invalid @enderror"
                                       name="frais_scolarite" id="frais_scolarite"
                                       type="number" min="0" placeholder="0"
                                       value="{{ old('frais_scolarite') }}">
                                @error('frais_scolarite')
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
                                    @foreach($annee_scolaires as $item)
                                        <option value="{{ $item->id }}" {{ old('annee_scolaire_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nom_annee_scolaire }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('annee_scolaire_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="col-12 mt-4">
                        <div class="border-top pt-4">
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('inscriptions.index') }}" class="btn btn-outline-secondary btn-action">
                                    <i class="fa-regular fa-xmark me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-success btn-action">
                                    <i class="fa-regular fa-floppy-disk me-1"></i>Inscrire
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.icon-circle { width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center; border-radius: 12px; }
.form-control { border: 1px solid #e0e0e0; border-radius: 10px; padding: 10px 15px; font-size: 0.95rem; background: #fff; }
.form-control:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.1); }
.form__input-title label { font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 0.9rem; }
.btn-action { border-radius: 10px; padding: 10px 24px; font-weight: 500; transition: all 0.3s ease; }
.btn-action:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
.alert { border: none; border-radius: 12px; }
.alert ul { list-style: none; padding-left: 0; }
.alert ul li::before { content: "•"; margin-right: 8px; }
.bg-opacity-10 { --bs-bg-opacity: 0.1; }
@media (max-width: 768px) { .btn-action { width: 100%; } }
</style>
@endsection
