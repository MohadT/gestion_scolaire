
@extends('admin.layout.master')

@section('content')

<div class="row">

    {{-- Informations principales --}}
    <div class="col-xxl-8">

        <div class="card__wrapper">

            {{-- En-tête --}}
            <div class="card__title-wrap mb-20">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="card__heading-title mb-1">
                            Détails de la matière
                        </h5>

                        <p class="text-muted small mb-0">
                            Consultez les informations de cette matière.
                        </p>

                    </div>


                    <div class="d-flex gap-2">

                        {{-- Modifier --}}
                        <a href="{{ route('matieres.edit', $matiere->id) }}"
                           class="btn btn-primary">

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Modifier

                        </a>


                        {{-- Retour --}}
                        <a href="{{ route('matieres.index') }}"
                           class="btn btn-outline-secondary">

                            <i class="fa-regular fa-arrow-left me-1"></i>

                            Retour

                        </a>

                    </div>

                </div>

            </div>


            {{-- Présentation --}}
            <div class="matiere-header mb-4">

                <div class="matiere-large-icon">

                    <i class="fa-regular fa-book"></i>

                </div>


                <div>

                    <h3 class="mb-1">
                        {{ $matiere->nom_matiere }}
                    </h3>

                    <span class="badge bg-primary-subtle text-primary">
                        Matière scolaire
                    </span>

                </div>

            </div>


            {{-- Informations --}}
            <div class="row g-4">

                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-primary bg-opacity-10">

                            <i class="fa-regular fa-book text-primary"></i>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Nom de la matière
                            </small>

                            <strong>
                                {{ $matiere->nom_matiere }}
                            </strong>

                        </div>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-success bg-opacity-10">

                            <i class="fa-regular fa-calendar text-success"></i>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Date d'ajout
                            </small>

                            <strong>

                                @if($matiere->created_at)

                                    {{ $matiere->created_at->format('d/m/Y à H:i') }}

                                @else

                                    -

                                @endif

                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Information importante --}}
            <div class="mt-4">

                <div class="alert alert-info border-0">

                    <div class="d-flex">

                        <i class="fa-regular fa-circle-info fs-5 me-3 mt-1"></i>

                        <div>

                            <strong>
                                Affectation aux classes
                            </strong>

                            <p class="mb-0 mt-1">

                                Le coefficient et le nombre d'heures ne sont
                                pas définis au niveau de la matière.
                                Ils seront définis lors de l'affectation
                                de cette matière à une classe.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Actions --}}
    <div class="col-xxl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-regular fa-gear me-2"></i>

                    Actions

                </h6>


                {{-- Modifier --}}
                <a href="{{ route('matieres.edit', $matiere->id) }}"
                   class="action-item d-flex align-items-center mb-3">

                    <div class="action-icon bg-primary bg-opacity-10">

                        <i class="fa-regular fa-pen-to-square text-primary"></i>

                    </div>

                    <div>

                        <strong class="d-block">
                            Modifier
                        </strong>

                        <small class="text-muted">
                            Modifier le nom de la matière
                        </small>

                    </div>

                    <i class="fa-regular fa-chevron-right ms-auto text-muted"></i>

                </a>


                {{-- Supprimer --}}
                <form
                    action="{{ route('matieres.destroy', $matiere->id) }}"
                    method="POST"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="action-item action-danger d-flex align-items-center w-100 border-0 bg-transparent text-start"
                    >

                        <div class="action-icon bg-danger bg-opacity-10">

                            <i class="fa-regular fa-trash-can text-danger"></i>

                        </div>

                        <div>

                            <strong class="d-block text-danger">
                                Supprimer
                            </strong>

                            <small class="text-muted">
                                Supprimer cette matière
                            </small>

                        </div>

                        <i class="fa-regular fa-chevron-right ms-auto text-muted"></i>

                    </button>

                </form>


                <hr class="my-4">


                {{-- Retour --}}
                <a href="{{ route('matieres.index') }}"
                   class="btn btn-outline-secondary w-100">

                    <i class="fa-regular fa-arrow-left me-1"></i>

                    Retour à la liste

                </a>

            </div>

        </div>


        {{-- Sécurité SaaS --}}
        <div class="card border-0 shadow-sm mt-4">

            <div class="card-body p-4">

                <div class="d-flex align-items-start">

                    <i class="fa-regular fa-shield-check text-success fs-4 me-3"></i>

                    <div>

                        <h6 class="fw-bold mb-1">
                            Données sécurisées
                        </h6>

                        <p class="text-muted small mb-0">

                            Cette matière appartient à votre compte.
                            Les autres utilisateurs ne peuvent pas
                            accéder à ses informations.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

.matiere-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    background: #f8f9ff;
    border-radius: 12px;
}

.matiere-large-icon {
    width: 70px;
    height: 70px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef2ff;
    color: #4361ee;
    font-size: 30px;
    flex-shrink: 0;
}

.info-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    border: 1px solid #eeeeee;
    border-radius: 12px;
    height: 100%;
}

.info-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.action-item {
    padding: 12px;
    border-radius: 10px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

.action-item:hover {
    background: #f8f9fa;
}

.action-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
}

.action-danger:hover {
    background: #fff5f5;
}

</style>

@endsection

