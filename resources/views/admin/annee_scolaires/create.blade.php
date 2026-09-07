@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-xxl-6">
        <div class="card__wrapper">
            <div class="card__title-wrap mb-20">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary bg-opacity-10 me-3">
                        <i class="fa-regular fa-calendar-plus text-primary fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card__heading-title mb-1">Ajouter une année scolaire</h5>
                        <p class="text-muted small mb-0">Créez une nouvelle année scolaire</p>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-regular fa-circle-exclamation me-2"></i>
                    <strong>Erreur !</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('anneescolaire.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <div class="col-12">
                        <div class="from__input-box">
                            <div class="form__input-title">
                                <label for="nom_annee_scolaire">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    Année Scolaire <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="form__input">
                                <input class="form-control @error('nom_annee_scolaire') is-invalid @enderror"
                                       name="nom_annee_scolaire"
                                       id="nom_annee_scolaire"
                                       type="text"
                                       placeholder="Ex: 2025-2026"
                                       value="{{ old('nom_annee_scolaire') }}"
                                       required>
                                @error('nom_annee_scolaire')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="border-top pt-4">
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('anneescolaire.index') }}"
                                   class="btn btn-outline-secondary btn-action">
                                    <i class="fa-regular fa-xmark me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary btn-action">
                                    <i class="fa-regular fa-floppy-disk me-1"></i>Enregistrer
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
.icon-circle {
    width: 45px;
    height: 45px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}
.form-control {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 10px 15px;
    font-size: 0.95rem;
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
.btn-action {
    border-radius: 10px;
    padding: 10px 24px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
.alert {
    border: none;
    border-radius: 12px;
}
.alert ul {
    list-style: none;
    padding-left: 0;
}
.alert ul li::before {
    content: "•";
    margin-right: 8px;
}
.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}
</style>
@endsection
