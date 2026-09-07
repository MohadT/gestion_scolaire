
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
                            Détails de l'affectation
                        </h5>

                        <p class="text-muted small mb-0">
                            Informations de la matière pour cette classe.
                        </p>

                    </div>


                    <div class="d-flex gap-2">

                        <a href="{{ route('matiere_coeficients.edit', $matiereCoeficient->id) }}"
                           class="btn btn-primary">

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Modifier

                        </a>


                        <a href="{{ route('matiere_coeficients.index') }}"
                           class="btn btn-outline-secondary">

                            <i class="fa-regular fa-arrow-left me-1"></i>

                            Retour

                        </a>

                    </div>

                </div>

            </div>


            {{-- Présentation --}}
            <div class="assignment-header mb-4">

                <div class="assignment-icon">

                    <i class="fa-regular fa-book"></i>

                </div>


                <div>

                    <h3 class="mb-1">

                        {{ $matiereCoeficient->matiere->nom_matiere ?? 'Matière supprimée' }}

                    </h3>

                    <span class="badge bg-primary-subtle text-primary">

                        {{ $matiereCoeficient->classe->nom_classe ?? 'Classe supprimée' }}

                    </span>

                </div>

            </div>


            {{-- Informations --}}
            <div class="row g-4">


                {{-- Classe --}}
                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-primary bg-opacity-10">

                            <i class="fa-regular fa-school text-primary"></i>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Classe
                            </small>

                            <strong>

                                {{ $matiereCoeficient->classe->nom_classe ?? 'Classe supprimée' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Matière --}}
                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-success bg-opacity-10">

                            <i class="fa-regular fa-book text-success"></i>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Matière
                            </small>

                            <strong>

                                {{ $matiereCoeficient->matiere->nom_matiere ?? 'Matière supprimée' }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Coefficient --}}
                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-warning bg-opacity-10">

                            <i class="fa-regular fa-calculator text-warning"></i>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Coefficient
                            </small>

                            <strong class="fs-5">

                                {{ $matiereCoeficient->coefficient }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Nombre d'heures --}}
                <div class="col-md-6">

                    <div class="info-card">

                        <div class="info-icon bg-info bg-opacity-10">

                            <i class="fa-regular fa-clock text-info"></i>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Nombre d'heures
                            </small>

                            <strong>

                                {{ $matiereCoeficient->nombre_heure }}

                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Résumé --}}
            <div class="mt-4">

                <div class="alert alert-info border-0">

                    <div class="d-flex">

                        <i class="fa-regular fa-circle-info fs-5 me-3 mt-1"></i>

                        <div>

                            <strong>
                                Configuration de la matière
                            </strong>

                            <p class="mb-0 mt-1">

                                La matière
                                <strong>
                                    {{ $matiereCoeficient->matiere->nom_matiere ?? 'Matière supprimée' }}
                                </strong>

                                est enseignée dans la classe

                                <strong>
                                    {{ $matiereCoeficient->classe->nom_classe ?? 'Classe supprimée' }}
                                </strong>

                                avec un coefficient de

                                <strong>
                                    {{ $matiereCoeficient->coefficient }}
                                </strong>

                                et un volume horaire de

                                <strong>
                                    {{ $matiereCoeficient->nombre_heure }}
                                </strong>.

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
                <a href="{{ route('matiere_coeficients.edit', $matiereCoeficient->id) }}"
                   class="action-item d-flex align-items-center mb-3">

                    <div class="action-icon bg-primary bg-opacity-10">

                        <i class="fa-regular fa-pen-to-square text-primary"></i>

                    </div>

                    <div>

                        <strong class="d-block">
                            Modifier
                        </strong>

                        <small class="text-muted">
                            Modifier cette affectation
                        </small>

                    </div>

                    <i class="fa-regular fa-chevron-right ms-auto text-muted"></i>

                </a>


                {{-- Supprimer --}}
                <form
                    action="{{ route('matiere_coeficients.destroy', $matiereCoeficient->id) }}"
                    method="POST"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation ?');"
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
                                Supprimer cette affectation
                            </small>

                        </div>

                        <i class="fa-regular fa-chevron-right ms-auto text-muted"></i>

                    </button>

                </form>


                <hr class="my-4">


                {{-- Retour --}}
                <a href="{{ route('matiere_coeficients.index') }}"
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

                            Cette configuration appartient à votre compte.
                            Les autres utilisateurs ne peuvent pas y accéder.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

.assignment-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    background: #f8f9ff;
    border-radius: 12px;
}

.assignment-icon {
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

