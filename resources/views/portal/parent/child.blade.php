@extends('admin.layout.master')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card__wrapper">

            <div class="card__title-wrap mb-20 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card__heading-title mb-1">
                        Dossier de {{ $enfant->nom_etudiant }} {{ $enfant->prenom_etudiant }}
                    </h5>
                    <p class="text-muted small mb-0">
                        Informations scolaires de votre enfant.
                    </p>
                </div>

                <a href="{{ route('parent.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-light fa-arrow-left me-1"></i>
                    Mes enfants
                </a>
            </div>

            <div class="row g-4">

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">

                            @if($enfant->photo)
                                <img
                                    src="{{ asset('storage/' . $enfant->photo) }}"
                                    alt="{{ $enfant->nom_etudiant }}"
                                    class="rounded-circle mb-3"
                                    style="width:100px;height:100px;object-fit:cover;"
                                >
                            @else
                                <div
                                    class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width:100px;height:100px;"
                                >
                                    <i class="fa-light fa-user fa-2x text-primary"></i>
                                </div>
                            @endif

                            <h5 class="mb-1">
                                {{ $enfant->nom_etudiant }} {{ $enfant->prenom_etudiant }}
                            </h5>

                            @if($enfant->code_etudiant)
                                <p class="text-muted mb-0">
                                    {{ $enfant->code_etudiant }}
                                </p>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">

                            <h6 class="fw-bold mb-4">
                                <i class="fa-light fa-graduation-cap text-primary me-2"></i>
                                Inscriptions
                            </h6>

                            @forelse($enfant->inscriptions as $inscription)
                                <div class="border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>
                                            {{ $inscription->classe->nom_classe ?? 'Classe non renseignée' }}
                                        </strong>

                                        <span class="badge bg-light text-dark">
                                            {{ $inscription->created_at?->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">
                                    Aucune inscription trouvée.
                                </p>
                            @endforelse

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
