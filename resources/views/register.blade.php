<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer mon établissement - Gestion Scolaire</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body class="body-area">
<div class="container py-5" style="max-width:850px">
    <div class="card__wrapper">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/images/logo/logo.svg') }}" alt="logo" style="max-width:120px">
            <h3 class="mt-3">Créer votre établissement</h3>
            <p class="text-muted">Le compte créé ici devient l'administrateur principal.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <h5 class="mb-3">Établissement</h5>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Nom de l'établissement *</label>
                    <input class="form-control" name="company_name" value="{{ old('company_name') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nom court</label>
                    <input class="form-control" name="short_name" value="{{ old('short_name') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Adresse</label>
                    <input class="form-control" name="address" value="{{ old('address') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ville</label>
                    <input class="form-control" name="city" value="{{ old('city') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pays</label>
                    <input class="form-control" name="country" value="{{ old('country') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Téléphone</label>
                    <input class="form-control" name="phone" value="{{ old('phone') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email établissement</label>
                    <input class="form-control" type="email" name="company_email" value="{{ old('company_email') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">N° fiscal / NIF</label>
                    <input class="form-control" name="tax_id" value="{{ old('tax_id') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">N° d'immatriculation</label>
                    <input class="form-control" name="registration_number" value="{{ old('registration_number') }}">
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3">Administrateur principal</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Identifiant *</label>
                    <input class="form-control" name="identifiant" value="{{ old('identifiant') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email de connexion *</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mot de passe *</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirmation *</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>
            </div>

            <button class="btn btn-primary w-100 mt-4" type="submit">Créer mon établissement</button>
            <div class="text-center mt-3"><a href="{{ route('login') }}">J'ai déjà un compte</a></div>
        </form>
    </div>
</div>
</body>
</html>
