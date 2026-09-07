@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card__wrapper">

            {{-- En-tête --}}
            <div class="card__title-wrap mb-20">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="card__heading-title mb-1">
                            Matières par classe
                        </h5>

                        <p class="text-muted small mb-0">
                            Gérez les coefficients et volumes horaires des matières
                            selon chaque classe.
                        </p>

                    </div>


                    {{-- Ajouter --}}
                    <a href="{{ route('matiere_coeficients.create') }}"
                       class="btn btn-primary">

                        <i class="fa-regular fa-plus me-1"></i>

                        Affecter une matière

                    </a>

                </div>

            </div>


            {{-- Message succès --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show"
                     role="alert">

                    <i class="fa-regular fa-circle-check me-2"></i>

                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- Message erreur --}}
            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show"
                     role="alert">

                    <i class="fa-regular fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- Recherche --}}
            <div class="row mb-4">

                <div class="col-md-8 col-lg-6">

                    <form method="GET"
                          action="{{ route('matiere_coeficients.index') }}">

                        <div class="input-group">

                            <span class="input-group-text bg-white">

                                <i class="fa-regular fa-magnifying-glass"></i>

                            </span>


                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Rechercher par classe ou matière..."
                                value="{{ request('search') }}"
                            >


                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="fa-regular fa-magnifying-glass me-1"></i>

                                Rechercher

                            </button>


                            @if(request('search'))

                                <a href="{{ route('matiere_coeficients.index') }}"
                                   class="btn btn-outline-secondary">

                                    <i class="fa-regular fa-xmark me-1"></i>

                                    Effacer

                                </a>

                            @endif

                        </div>

                    </form>

                </div>

            </div>


            {{-- Tableau --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Classe</th>

                            <th>Matière</th>

                            <th>Coefficient</th>

                            <th>Nombre d'heures</th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($matiereCoeficients as $matiereCoeficient)

                            <tr>

                                {{-- Numéro --}}
                                <td>

                                    {{ $matiereCoeficients->firstItem() + $loop->index }}

                                </td>


                                {{-- Classe --}}
                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="classe-avatar me-3">

                                            <i class="fa-regular fa-school"></i>

                                        </div>

                                        <div>

                                            <h6 class="mb-0">

                                                {{ $matiereCoeficient->classe->nom_classe ?? 'Classe supprimée' }}

                                            </h6>

                                            <small class="text-muted">
                                                Classe
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- Matière --}}
                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="matiere-avatar me-3">

                                            <i class="fa-regular fa-book"></i>

                                        </div>

                                        <div>

                                            <h6 class="mb-0">

                                                {{ $matiereCoeficient->matiere->nom_matiere ?? 'Matière supprimée' }}

                                            </h6>

                                            <small class="text-muted">
                                                Matière scolaire
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- Coefficient --}}
                                <td>

                                    <span class="badge bg-primary-subtle text-primary coefficient-badge">

                                        {{ $matiereCoeficient->coefficient }}

                                    </span>

                                </td>


                                {{-- Nombre d'heures --}}
                                <td>

                                    <span class="fw-semibold">

                                        <i class="fa-regular fa-clock me-1"></i>

                                        {{ $matiereCoeficient->nombre_heure }}

                                    </span>

                                    <small class="text-muted">
                                        heure(s)
                                    </small>

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Voir --}}
                                        <a href="{{ route('matiere_coeficients.show', $matiereCoeficient->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Voir">

                                            <i class="fa-regular fa-eye"></i>

                                        </a>


                                        {{-- Modifier --}}
                                        <a href="{{ route('matiere_coeficients.edit', $matiereCoeficient->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Modifier">

                                            <i class="fa-regular fa-pen-to-square"></i>

                                        </a>


                                        {{-- Supprimer --}}
                                        <form
                                            action="{{ route('matiere_coeficients.destroy', $matiereCoeficient->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation ?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Supprimer"
                                            >

                                                <i class="fa-regular fa-trash-can"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <div class="empty-state">

                                        <i class="fa-regular fa-book-open fs-1 text-muted mb-3"></i>


                                        @if(request('search'))

                                            <h6>
                                                Aucun résultat trouvé
                                            </h6>

                                            <p class="text-muted mb-3">

                                                Aucune classe ou matière ne correspond
                                                à votre recherche.

                                            </p>


                                            <a href="{{ route('matiere_coeficients.index') }}"
                                               class="btn btn-outline-primary">

                                                Réinitialiser la recherche

                                            </a>

                                        @else

                                            <h6>
                                                Aucune matière affectée
                                            </h6>

                                            <p class="text-muted mb-3">

                                                Vous n'avez encore affecté aucune matière
                                                à une classe.

                                            </p>


                                            <a href="{{ route('matiere_coeficients.create') }}"
                                               class="btn btn-primary">

                                                <i class="fa-regular fa-plus me-1"></i>

                                                Affecter une matière

                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($matiereCoeficients->hasPages())

                <div class="mt-4">

                    {{ $matiereCoeficients->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<style>

.classe-avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef2ff;
    color: #4361ee;
    font-size: 17px;
}

.matiere-avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0fdf4;
    color: #16a34a;
    font-size: 17px;
}

.coefficient-badge {
    font-size: 0.9rem;
    padding: 7px 10px;
}

.table th {
    font-weight: 600;
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
}

.empty-state {
    padding: 30px 10px;
}

</style>

@endsection

