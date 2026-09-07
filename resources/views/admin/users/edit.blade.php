@extends('admin.layout.master')

@section('content')

<div class="row">

    {{-- =========================================================
         FORMULAIRE
    ========================================================== --}}
    <div class="col-xxl-8">

        <div class="card__wrapper">

            {{-- EN-TÊTE --}}
            <div class="card__title-wrap mb-20">

                <div>

                    <h5 class="card__heading-title mb-1">

                        Modifier l'utilisateur

                    </h5>

                    <p class="text-muted small mb-0">

                        Modifiez les informations du compte utilisateur.

                    </p>

                </div>

            </div>


            {{-- ERREURS --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Veuillez corriger les erreurs suivantes :
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- SUCCÈS --}}
            @if (session('success'))

                <div class="alert alert-success">

                    <i class="fa-light fa-circle-check me-2"></i>

                    {{ session('success') }}

                </div>

            @endif


            {{-- FORMULAIRE --}}
            <form
                action="{{ route('users.update', $user->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="row g-4">


                    {{-- IDENTIFIANT --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="identifiant">

                                    <i class="fa-light fa-user me-1"></i>

                                    Identifiant

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="text"
                                    name="identifiant"
                                    id="identifiant"
                                    class="form-control"
                                    value="{{ old('identifiant', $user->identifiant) }}"
                                    required
                                >

                                @error('identifiant')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="email">

                                    <i class="fa-light fa-envelope me-1"></i>

                                    Adresse email

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                >

                                @error('email')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- RÔLE --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="role">

                                    <i class="fa-light fa-user-shield me-1"></i>

                                    Rôle

                                    <span class="text-danger">*</span>

                                </label>

                            </div>

                            <div class="form__input">

                                <select
                                    name="role"
                                    id="role"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Sélectionner un rôle
                                    </option>

                                    <option
                                        value="admin"
                                        @selected(old('role', $user->role) === 'admin')
                                    >
                                        Administrateur
                                    </option>

                                    <option
                                        value="professeur"
                                        @selected(old('role', $user->role) === 'professeur')
                                    >
                                        Professeur
                                    </option>

                                    <option
                                        value="comptable"
                                        @selected(old('role', $user->role) === 'comptable')
                                    >
                                        Comptable
                                    </option>

                                    <option
                                        value="parent"
                                        @selected(old('role', $user->role) === 'parent')
                                    >
                                        Parent
                                    </option>

                                </select>

                                @error('role')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- NOUVEAU MOT DE PASSE --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="password">

                                    <i class="fa-light fa-lock me-1"></i>

                                    Nouveau mot de passe

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Laisser vide pour conserver"
                                >

                                @error('password')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- CONFIRMATION --}}
                    <div class="col-md-6">

                        <div class="from__input-box">

                            <div class="form__input-title">

                                <label for="password_confirmation">

                                    <i class="fa-light fa-lock-keyhole me-1"></i>

                                    Confirmer le mot de passe

                                </label>

                            </div>

                            <div class="form__input">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Répétez le nouveau mot de passe"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- BOUTONS --}}
                    <div class="col-12 mt-4">

                        <div class="border-top pt-4">

                            <div class="d-flex justify-content-end gap-3">

                                <a
                                    href="{{ route('users.index') }}"
                                    class="btn btn-outline-secondary"
                                >

                                    <i class="fa-light fa-arrow-left me-1"></i>

                                    Annuler

                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa-light fa-floppy-disk me-1"></i>

                                    Enregistrer les modifications

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         AIDE
    ========================================================== --}}
    <div class="col-xxl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-4">

                    <i class="fa-light fa-circle-info text-primary me-2"></i>

                    Informations du compte

                </h6>


                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-primary bg-opacity-10 rounded-3 me-3">

                        <i class="fa-light fa-user text-primary"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Identifiant
                        </strong>

                        <p class="text-muted small mb-0">

                            {{ $user->identifiant }}

                        </p>

                    </div>

                </div>


                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-info bg-opacity-10 rounded-3 me-3">

                        <i class="fa-light fa-envelope text-info"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Adresse email
                        </strong>

                        <p class="text-muted small mb-0">

                            {{ $user->email }}

                        </p>

                    </div>

                </div>


                <div class="d-flex align-items-start mb-4">

                    <div class="guide-icon bg-warning bg-opacity-10 rounded-3 me-3">

                        <i class="fa-light fa-user-shield text-warning"></i>

                    </div>

                    <div>

                        <strong class="small">
                            Rôle actuel
                        </strong>

                        <p class="text-muted small mb-0">

                            @if($user->role === 'admin')

                                Administrateur

                            @else

                                Professeur

                            @endif

                        </p>

                    </div>

                </div>


                <div class="alert alert-info mb-0">

                    <i class="fa-light fa-lock me-2"></i>

                    <small>

                        Laissez le champ mot de passe vide si vous
                        ne souhaitez pas modifier le mot de passe actuel.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

.form-control {

    border: 1px solid #e0e0e0;

    border-radius: 10px;

    padding: 10px 15px;

    transition: all 0.3s ease;

    font-size: 0.95rem;

    background-color: #ffffff;

}

.form-control:focus {

    border-color: #4361ee;

    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);

}

.form__input-title label {

    font-weight: 600;

    color: #2c3e50;

    margin-bottom: 8px;

    font-size: 0.9rem;

}

.guide-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const role = document.getElementById('role');
    const box = document.getElementById('parentChildrenBox');

    function toggleParentChildren() {
        if (!role || !box) return;
        box.style.display = role.value === 'parent' ? 'block' : 'none';
    }

    role?.addEventListener('change', toggleParentChildren);
    toggleParentChildren();
});
</script>

@endsection
