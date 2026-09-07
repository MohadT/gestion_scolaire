@extends('admin.layout.master')
@section('content')
<div class="card__wrapper" style="max-width:700px">
    <h4>Accès étudiant</h4>
    <p class="text-muted">Créer les identifiants de connexion pour cet étudiant.</p>
    @if($errors->any()) <div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div> @endif
    <form method="POST" action="{{ route('etudiants.account.store', $etudiant) }}">
        @csrf
        <div class="mb-3"><label class="form-label">Identifiant</label><input class="form-control" name="identifiant" required autocomplete="username"></div>
        <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required autocomplete="email"></div>
        <div class="mb-3"><label class="form-label">Mot de passe</label><input class="form-control" type="password" name="password" required autocomplete="new-password"></div>
        <div class="mb-3"><label class="form-label">Confirmation</label><input class="form-control" type="password" name="password_confirmation" required></div>
        <button class="btn btn-primary">Créer l’accès</button>
    </form>
</div>
@endsection
