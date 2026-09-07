
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
                            Liste des professeurs
                        </h5>

                        <p class="text-muted small mb-0">
                            Gérez les professeurs enregistrés dans votre établissement.
                        </p>
                    </div>

                    <a href="{{ route('professeurs.create') }}"
                       class="btn btn-primary">

                        <i class="fa-regular fa-plus me-1"></i>

                        Ajouter un professeur

                    </a>

                </div>

            </div>


            {{-- Message de succès --}}
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


            {{-- Message d'erreur --}}
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


            {{-- Barre de recherche --}}
       
        <div class="row mb-4">

        <div class="col-md-8 col-lg-6">

            <form method="GET"
                action="{{ route('professeurs.index') }}">

                <div class="input-group">

                    <span class="input-group-text bg-white">
                        <i class="fa-regular fa-magnifying-glass"></i>
                    </span>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Rechercher par nom, prénom ou téléphone..."
                        value="{{ request('search') }}"
                    >

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fa-regular fa-magnifying-glass me-1"></i>
                        Rechercher

                    </button>

                    @if(request('search'))

                        <a href="{{ route('professeurs.index') }}"
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

                            <th>Professeur</th>

                            <th>Adresse</th>

                            <th>Téléphone</th>

                            <th>Profession</th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($professeurs as $professeur)

                            <tr>

                                {{-- Numéro --}}
                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                {{-- Nom --}}
                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="prof-avatar me-3">

                                            {{ strtoupper(substr($professeur->prenom_prof, 0, 1)) }}

                                        </div>

                                        <div>

                                            <h6 class="mb-0">

                                                {{ $professeur->prenom_prof }}
                                                {{ $professeur->nom_prof }}

                                            </h6>

                                            <small class="text-muted">
                                                Professeur
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- Adresse --}}
                                <td>

                                    {{ $professeur->addresse }}

                                </td>


                                {{-- Téléphone --}}
                                <td>

                                    <span class="phone-number">

                                        <i class="fa-regular fa-phone me-1"></i>

                                        {{ $professeur->telephone }}

                                    </span>

                                </td>


                                {{-- Profession --}}
                                <td>

                                    <span class="badge bg-primary-subtle text-primary">

                                        {{ $professeur->profession }}

                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Voir --}}
                                        <a href="{{ route('professeurs.show', $professeur->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Voir">

                                            <i class="fa-regular fa-eye"></i>

                                        </a>


                                        {{-- Modifier --}}
                                        <a href="{{ route('professeurs.edit', $professeur->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Modifier">

                                            <i class="fa-regular fa-pen-to-square"></i>

                                        </a>


                                        {{-- Supprimer --}}
                                        <form action="{{ route('professeurs.destroy', $professeur->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?');">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Supprimer">

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

                                        <i class="fa-regular fa-user-slash fs-1 text-muted mb-3"></i>

                                        <h6>
                                            Aucun professeur trouvé
                                        </h6>

                                        @if(request('search'))

                                            <p class="text-muted mb-3">
                                                Aucun professeur ne correspond à votre recherche.
                                            </p>

                                            <a href="{{ route('professeurs.index') }}"
                                               class="btn btn-outline-primary">

                                                Réinitialiser la recherche

                                            </a>

                                        @else

                                            <p class="text-muted mb-3">
                                                Aucun professeur n'est encore enregistré.
                                            </p>

                                            <a href="{{ route('professeurs.create') }}"
                                               class="btn btn-primary">

                                                <i class="fa-regular fa-plus me-1"></i>

                                                Ajouter le premier professeur

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
            @if(method_exists($professeurs, 'links'))

                <div class="mt-4">

                    {{ $professeurs->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<style>

.prof-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef2ff;
    color: #4361ee;
    font-weight: 700;
    font-size: 16px;
}

.phone-number {
    white-space: nowrap;
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

