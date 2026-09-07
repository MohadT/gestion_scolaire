
@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-xxl-8 col-xl-8">

        <div class="card__wrapper">

            <div class="card__title-wrap mb-20">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="card__heading-title mb-1">
                            Informations de l'utilisateur
                        </h5>

                        <p class="text-muted small mb-0">
                            Consultez les informations du compte.
                        </p>
                    </div>

                    <div>
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
                                <i class="fa-light fa-users me-1"></i>
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
                    </div>

                </div>

            </div>

            <div class="user-profile-header mb-4">

                <div class="user-large-avatar">

                    @if($user->role === 'admin')
                        <i class="fa-light fa-user-shield"></i>
                    @elseif($user->role === 'professeur')
                        <i class="fa-light fa-chalkboard-user"></i>
                    @elseif($user->role === 'comptable')
                        <i class="fa-light fa-calculator"></i>
                    @elseif($user->role === 'secretaire')
                        <i class="fa-light fa-user-pen"></i>
                    @elseif($user->role === 'parent')
                        <i class="fa-light fa-users"></i>
                    @elseif($user->role === 'etudiant')
                        <i class="fa-light fa-graduation-cap"></i>
                    @else
                        <i class="fa-light fa-user"></i>
                    @endif

                </div>

                <div>
                    <h4 class="mb-1">
                        {{ $user->identifiant }}
                    </h4>

                    <p class="text-muted mb-0">
                        {{ $user->email }}
                    </p>
                </div>

            </div>

            <div class="row g-4">

                <div class="col-md-6">

                    <div class="info-box">

                        <div class="info-icon bg-primary bg-opacity-10">
                            <i class="fa-light fa-user text-primary"></i>
                        </div>

                        <div>
                            <span class="info-label">
                                Identifiant
                            </span>

                            <strong>
                                {{ $user->identifiant }}
                            </strong>
                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="info-box">

                        <div class="info-icon bg-info bg-opacity-10">
                            <i class="fa-light fa-envelope text-info"></i>
                        </div>

                        <div>
                            <span class="info-label">
                                Adresse email
                            </span>

                            <strong>
                                {{ $user->email }}
                            </strong>
                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="info-box">

                        <div class="info-icon bg-warning bg-opacity-10">
                            <i class="fa-light fa-user-shield text-warning"></i>
                        </div>

                        <div>
                            <span class="info-label">
                                Rôle
                            </span>

                            <strong>

                                @if($user->role === 'admin')
                                    Administrateur
                                @elseif($user->role === 'professeur')
                                    Professeur
                                @elseif($user->role === 'comptable')
                                    Comptable
                                @elseif($user->role === 'secretaire')
                                    Secrétaire
                                @elseif($user->role === 'parent')
                                    Parent
                                @elseif($user->role === 'etudiant')
                                    Étudiant
                                @else
                                    {{ $user->role }}
                                @endif

                            </strong>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="info-box">

                        <div class="info-icon bg-success bg-opacity-10">
                            <i class="fa-light fa-calendar-plus text-success"></i>
                        </div>

                        <div>
                            <span class="info-label">
                                Compte créé le
                            </span>

                            <strong>
                                {{ $user->created_at ? $user->created_at->format('d/m/Y à H:i') : '-' }}
                            </strong>
                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="info-box">

                        <div class="info-icon bg-secondary bg-opacity-10">
                            <i class="fa-light fa-clock-rotate-left text-secondary"></i>
                        </div>

                        <div>
                            <span class="info-label">
                                Dernière modification
                            </span>

                            <strong>
                                {{ $user->updated_at ? $user->updated_at->format('d/m/Y à H:i') : '-' }}
                            </strong>
                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="info-box">

                        <div class="info-icon bg-dark bg-opacity-10">
                            <i class="fa-light fa-hashtag text-dark"></i>
                        </div>

                        <div>
                            <span class="info-label">
                                Identifiant système
                            </span>

                            <strong>
                                #{{ $user->id }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

            <div class="border-top pt-4 mt-4">

                <div class="d-flex justify-content-end gap-3">

                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="fa-light fa-arrow-left me-1"></i>
                        Retour à la liste
                    </a>

                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                        <i class="fa-light fa-pen me-1"></i>
                        Modifier
                    </a>

                    @if($user->id !== auth()->id())

                        <form action="{{ route('users.destroy', $user->id) }}"
                              method="POST"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">
                                <i class="fa-light fa-trash me-1"></i>
                                Supprimer
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="col-xxl-4 col-xl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">
                    <i class="fa-light fa-circle-info text-primary me-2"></i>
                    Résumé du compte
                </h6>

                <div class="text-center mb-4">

                    <div class="summary-avatar mx-auto mb-3">

                        @if($user->role === 'admin')
                            <i class="fa-light fa-user-shield"></i>
                        @elseif($user->role === 'professeur')
                            <i class="fa-light fa-chalkboard-user"></i>
                        @elseif($user->role === 'comptable')
                            <i class="fa-light fa-calculator"></i>
                        @elseif($user->role === 'secretaire')
                            <i class="fa-light fa-user-pen"></i>
                        @elseif($user->role === 'parent')
                            <i class="fa-light fa-users"></i>
                        @elseif($user->role === 'etudiant')
                            <i class="fa-light fa-graduation-cap"></i>
                        @else
                            <i class="fa-light fa-user"></i>
                        @endif

                    </div>

                    <h5 class="mb-1">
                        {{ $user->identifiant }}
                    </h5>

                    <p class="text-muted small mb-0">
                        {{ $user->email }}
                    </p>

                </div>

                <div class="summary-row">

                    <span>
                        <i class="fa-light fa-user-shield me-2"></i>
                        Rôle
                    </span>

                    <strong>

                        @if($user->role === 'admin')
                            Administrateur
                        @elseif($user->role === 'professeur')
                            Professeur
                        @elseif($user->role === 'comptable')
                            Comptable
                        @elseif($user->role === 'secretaire')
                            Secrétaire
                        @elseif($user->role === 'parent')
                            Parent
                        @elseif($user->role === 'etudiant')
                            Étudiant
                        @else
                            {{ $user->role }}
                        @endif

                    </strong>

                </div>

                <div class="summary-row">

                    <span>
                        <i class="fa-light fa-circle-check me-2"></i>
                        Statut
                    </span>

                    <span class="badge bg-success">
                        Actif
                    </span>

                </div>

                <div class="summary-row">

                    <span>
                        <i class="fa-light fa-calendar me-2"></i>
                        Création
                    </span>

                    <strong>
                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                    </strong>

                </div>

                <div class="alert alert-info mt-4 mb-0">

                    <i class="fa-light fa-shield-check me-2"></i>

                    <small>
                        Ce compte est enregistré dans votre établissement scolaire.
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.user-profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    border-radius: 12px;
    background: #f8f9fa;
}

.user-large-avatar {
    width: 70px;
    height: 70px;
    min-width: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(67, 97, 238, 0.10);
    color: #4361ee;
    font-size: 30px;
}

.info-box {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 18px;
    border: 1px solid #eeeeee;
    border-radius: 10px;
    background: #ffffff;
    height: 100%;
}

.info-icon {
    width: 45px;
    height: 45px;
    min-width: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.info-box > div:last-child {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.info-label {
    color: #8a8a8a;
    font-size: 12px;
}

.info-box strong {
    color: #2c3e50;
    font-size: 14px;
    word-break: break-word;
}

.summary-avatar {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(67, 97, 238, 0.10);
    color: #4361ee;
    font-size: 30px;
}

.summary-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #eeeeee;
    font-size: 14px;
}

.summary-row:last-of-type {
    border-bottom: none;
}

.summary-row span:first-child {
    color: #6c757d;
}

</style>

@endsection

