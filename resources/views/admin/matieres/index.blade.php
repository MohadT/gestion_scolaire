
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
                            Liste des matières
                        </h5>

                        <p class="text-muted small mb-0">
                            Gérez les matières de votre établissement.
                        </p>

                    </div>


                    <a href="{{ route('matieres.create') }}"
                       class="btn btn-primary">

                        <i class="fa-regular fa-plus me-1"></i>

                        Ajouter une matière

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
                          action="{{ route('matieres.index') }}">

                        <div class="input-group">

                            <span class="input-group-text bg-white">

                                <i class="fa-regular fa-magnifying-glass"></i>

                            </span>


                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Rechercher une matière..."
                                value="{{ request('search') }}"
                            >


                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="fa-regular fa-magnifying-glass me-1"></i>

                                Rechercher

                            </button>


                            @if(request('search'))

                                <a href="{{ route('matieres.index') }}"
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

                            <th>Matière</th>

                            <th>Date d'ajout</th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($matieres as $matiere)

                            <tr>

                                {{-- Numéro --}}
                                <td>

                                    {{ $matieres->firstItem() + $loop->index }}

                                </td>


                                {{-- Matière --}}
                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="matiere-avatar me-3">

                                            <i class="fa-regular fa-book"></i>

                                        </div>

                                        <div>

                                            <h6 class="mb-0">

                                                {{ $matiere->nom_matiere }}

                                            </h6>

                                            <small class="text-muted">
                                                Matière scolaire
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- Date --}}
                                <td>

                                    @if($matiere->created_at)

                                        {{ $matiere->created_at->format('d/m/Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Voir --}}
                                        <a href="{{ route('matieres.show', $matiere->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Voir">

                                            <i class="fa-regular fa-eye"></i>

                                        </a>


                                        {{-- Modifier --}}
                                        <a href="{{ route('matieres.edit', $matiere->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Modifier">

                                            <i class="fa-regular fa-pen-to-square"></i>

                                        </a>


                                        {{-- Supprimer --}}
                                        <form
                                            action="{{ route('matieres.destroy', $matiere->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');"
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

                                <td colspan="4"
                                    class="text-center py-5">

                                    <div class="empty-state">

                                        <i class="fa-regular fa-book-open fs-1 text-muted mb-3"></i>


                                        @if(request('search'))

                                            <h6>
                                                Aucune matière trouvée
                                            </h6>

                                            <p class="text-muted mb-3">
                                                Aucune matière ne correspond à votre recherche.
                                            </p>


                                            <a href="{{ route('matieres.index') }}"
                                               class="btn btn-outline-primary">

                                                Réinitialiser la recherche

                                            </a>

                                        @else

                                            <h6>
                                                Aucune matière enregistrée
                                            </h6>

                                            <p class="text-muted mb-3">
                                                Vous n'avez encore enregistré aucune matière.
                                            </p>


                                            <a href="{{ route('matieres.create') }}"
                                               class="btn btn-primary">

                                                <i class="fa-regular fa-plus me-1"></i>

                                                Ajouter la première matière

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
            @if($matieres->hasPages())

                <div class="mt-4">

                    {{ $matieres->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<style>

.matiere-avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef2ff;
    color: #4361ee;
    font-size: 18px;
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

