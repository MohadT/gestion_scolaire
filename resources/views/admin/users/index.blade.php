@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card__wrapper">

            {{-- =====================================================
                 EN-TÊTE
            ====================================================== --}}
            <div class="card__title-wrap mb-20">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div>

                        <h5 class="card__heading-title mb-1">

                            Gestion des utilisateurs

                        </h5>

                        <p class="text-muted small mb-0">

                            Gérez les comptes utilisateurs de votre établissement.

                        </p>

                    </div>

                    <a
                        href="{{ route('users.create') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa-light fa-user-plus me-1"></i>

                        Ajouter un utilisateur

                    </a>

                </div>

            </div>


            {{-- =====================================================
                 MESSAGES
            ====================================================== --}}

            @if (session('success'))

                <div class="alert alert-success">

                    <i class="fa-light fa-circle-check me-2"></i>

                    {{ session('success') }}

                </div>

            @endif


            @if (session('error'))

                <div class="alert alert-danger">

                    <i class="fa-light fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                </div>

            @endif


            {{-- =====================================================
                 ERREURS
            ====================================================== --}}

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =====================================================
                 FILTRES
            ====================================================== --}}

            <form
                action="{{ route('users.index') }}"
                method="GET"
                class="mb-4"
            >

                <div class="row g-3">

                    {{-- RECHERCHE --}}
                    <div class="col-lg-6">

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fa-light fa-magnifying-glass"></i>

                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Rechercher un identifiant ou un email..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    {{-- RÔLE --}}
                    <div class="col-lg-3">

                        <select
                            name="role"
                            class="form-control"
                        >

                            <option value="">
                                Tous les rôles
                            </option>

                            <option
                                value="admin"
                                @selected(request('role') === 'admin')
                            >
                                Administrateurs
                            </option>

                            <option
                                value="professeur"
                                @selected(request('role') === 'professeur')
                            >
                                Professeurs
                            </option>

                            <option
                                value="comptable"
                                @selected(request('role') === 'comptable')
                            >
                                Comptables
                            </option>

                            <option
                                value="secretaire"
                                @selected(request('role') === 'secretaire')
                            >
                                Secrétaires
                            </option>

                            <option
                                value="parent"
                                @selected(request('role') === 'parent')
                            >
                                Parents
                            </option>

                            <option
                                value="etudiant"
                                @selected(request('role') === 'etudiant')
                            >
                                Étudiants
                            </option>

                        </select>

                    </div>


                    {{-- BOUTONS --}}
                    <div class="col-lg-3">

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary flex-fill"
                            >

                                <i class="fa-light fa-filter me-1"></i>

                                Filtrer

                            </button>


                            <a
                                href="{{ route('users.index') }}"
                                class="btn btn-outline-secondary"
                                title="Réinitialiser"
                            >

                                <i class="fa-light fa-rotate-left"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </form>


            {{-- =====================================================
                 TABLEAU
            ====================================================== --}}

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Utilisateur
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Rôle
                            </th>

                            <th>
                                Créé le
                            </th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                {{-- ID --}}
                                <td>

                                    <span class="text-muted">

                                        #{{ $user->id }}

                                    </span>

                                </td>


                                {{-- UTILISATEUR --}}
                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="user-avatar">

                                            @if($user->role === 'admin')

                                                <i class="fa-light fa-user-shield"></i>

                                            @elseif($user->role === 'professeur')

                                                <i class="fa-light fa-chalkboard-user"></i>

                                            @elseif($user->role === 'comptable')

                                                <i class="fa-light fa-calculator"></i>

                                            @elseif($user->role === 'secretaire')

                                                <i class="fa-light fa-user-pen"></i>

                                            @elseif($user->role === 'parent')

                                                <i class="fa-light fa-user-group"></i>

                                            @elseif($user->role === 'etudiant')

                                                <i class="fa-light fa-graduation-cap"></i>

                                            @else

                                                <i class="fa-light fa-user"></i>

                                            @endif

                                        </div>


                                        <div>

                                            <strong class="d-block">

                                                {{ $user->identifiant }}

                                            </strong>

                                            <small class="text-muted">

                                                Utilisateur #{{ $user->id }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- EMAIL --}}
                                <td>

                                    <span>

                                        {{ $user->email }}

                                    </span>

                                </td>


                                {{-- RÔLE --}}
                                <td>

                                    @if($user->role === 'admin')

                                        <span class="badge bg-primary">

                                            <i class="fa-light fa-user-shield me-1"></i>

                                            Administrateur

                                        </span>

                                    @elseif($user->role === 'professeur')

                                        <span class="badge bg-success">

                                            <i class="fa-light fa-chalkboard-user me-1"></i>

                                            Professeur

                                        </span>

                                    @elseif($user->role === 'comptable')

                                        <span class="badge bg-warning text-dark">

                                            <i class="fa-light fa-calculator me-1"></i>

                                            Comptable

                                        </span>

                                    @elseif($user->role === 'secretaire')

                                        <span class="badge bg-info">

                                            <i class="fa-light fa-user-pen me-1"></i>

                                            Secrétaire

                                        </span>

                                    @elseif($user->role === 'parent')

                                        <span class="badge bg-secondary">

                                            <i class="fa-light fa-user-group me-1"></i>

                                            Parent

                                        </span>

                                    @elseif($user->role === 'etudiant')

                                        <span class="badge bg-dark">

                                            <i class="fa-light fa-graduation-cap me-1"></i>

                                            Étudiant

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            {{ $user->role }}

                                        </span>

                                    @endif

                                </td>


                                {{-- DATE --}}
                                <td>

                                    <span class="text-muted">

                                        {{ $user->created_at?->format('d/m/Y') }}

                                    </span>

                                </td>


                                {{-- ACTIONS --}}
                                <td>

                                    <div class="d-flex justify-content-end gap-2">

                                        {{-- VOIR --}}
                                        <a
                                            href="{{ route('users.show', $user->id) }}"
                                            class="btn btn-sm btn-light"
                                            title="Voir"
                                        >

                                            <i class="fa-light fa-eye"></i>

                                        </a>


                                        {{-- MODIFIER --}}
                                        <a
                                            href="{{ route('users.edit', $user->id) }}"
                                            class="btn btn-sm btn-light"
                                            title="Modifier"
                                        >

                                            <i class="fa-light fa-pen"></i>

                                        </a>


                                        {{-- SUPPRIMER --}}
                                        @if($user->id !== auth()->id())

                                            <form
                                                action="{{ route('users.destroy', $user->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-light text-danger"
                                                    title="Supprimer"
                                                >

                                                    <i class="fa-light fa-trash"></i>

                                                </button>

                                            </form>

                                        @else

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-light text-muted"
                                                title="Vous ne pouvez pas supprimer votre propre compte"
                                                disabled
                                            >

                                                <i class="fa-light fa-trash"></i>

                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-5"
                                >

                                    <div class="mb-3">

                                        <i
                                            class="fa-light fa-users-slash"
                                            style="font-size: 45px;"
                                        ></i>

                                    </div>

                                    <h6>

                                        Aucun utilisateur trouvé

                                    </h6>

                                    <p class="text-muted mb-3">

                                        Aucun compte ne correspond
                                        aux critères de recherche.

                                    </p>


                                    <a
                                        href="{{ route('users.create') }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="fa-light fa-user-plus me-1"></i>

                                        Ajouter un utilisateur

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
                 PAGINATION
            ====================================================== --}}

            @if($users->hasPages())

                <div class="d-flex justify-content-between align-items-center mt-4">

                    <div>

                        <span class="text-muted small">

                            Affichage de

                            <strong>
                                {{ $users->firstItem() }}
                            </strong>

                            à

                            <strong>
                                {{ $users->lastItem() }}
                            </strong>

                            sur

                            <strong>
                                {{ $users->total() }}
                            </strong>

                            utilisateurs

                        </span>

                    </div>


                    <div>

                        {{ $users->links() }}

                    </div>

                </div>

            @endif


        </div>

    </div>

</div>


<style>

.user-avatar {

    width: 42px;

    height: 42px;

    min-width: 42px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background: rgba(67, 97, 238, 0.10);

    color: #4361ee;

    font-size: 18px;

}

.table th {

    font-size: 13px;

    font-weight: 600;

    color: #6c757d;

    white-space: nowrap;

}

.table td {

    font-size: 14px;

}

.input-group-text {

    background: #fff;

    border-color: #e0e0e0;

}

.form-control {

    border-color: #e0e0e0;

    border-radius: 8px;

}

.form-control:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);

}

</style>

@endsection
