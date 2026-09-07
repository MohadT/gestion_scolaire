@extends('admin.layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="mb-1">Paramètres système</h4>
                    <p class="text-muted mb-0">Administration technique de votre installation Gestion Scolaire.</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Maintenance et optimisation</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <strong>Optimiser / nettoyer Laravel</strong>
                                <div class="small text-muted">Nettoie configuration, routes, vues, événements et cache.</div>
                            </div>
                            <form method="POST" action="{{ route('settings.clear', 'optimize') }}">
                                @csrf
                                <button class="btn btn-primary btn-sm"><i class="fa-light fa-broom me-1"></i> Optimiser</button>
                            </form>
                        </div>

                        @foreach([
                            ['cache', 'Cache application', 'Vide le cache utilisé par l’application.'],
                            ['config', 'Configuration', 'Recharge la configuration depuis .env.'],
                            ['route', 'Routes', 'Supprime le cache des routes.'],
                            ['view', 'Vues Blade', 'Supprime les vues Blade compilées.'],
                            ['event', 'Événements', 'Supprime le cache des événements.'],
                        ] as [$key, $label, $description])
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <strong>{{ $label }}</strong>
                                    <div class="small text-muted">{{ $description }}</div>
                                </div>
                                <form method="POST" action="{{ route('settings.clear', $key) }}">
                                    @csrf
                                    <button class="btn btn-outline-secondary btn-sm">Nettoyer</button>
                                </form>
                            </div>
                        @endforeach

                        <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <strong>Fichiers publics</strong>
                                <div class="small text-muted">Crée le lien storage pour les logos et fichiers uploadés.</div>
                            </div>
                            <form method="POST" action="{{ route('settings.storage-link') }}">
                                @csrf
                                <button class="btn btn-outline-secondary btn-sm">Vérifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">État de l'installation</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr><th>Laravel</th><td>{{ $laravelVersion }}</td></tr>
                        <tr><th>PHP</th><td>{{ $phpVersion }}</td></tr>
                        <tr><th>Environnement</th><td>{{ $environment }}</td></tr>
                        <tr><th>Debug</th><td>{{ $debug ? 'Activé' : 'Désactivé' }}</td></tr>
                        <tr><th>Cache</th><td>{{ $cacheStore }}</td></tr>
                        <tr><th>Session</th><td>{{ $sessionDriver }}</td></tr>
                        <tr><th>File d’attente</th><td>{{ $queueConnection }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Établissement</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $company?->name ?? 'Aucun établissement' }}</h6>
                    <p class="text-muted small">{{ $company?->email ?? '—' }}</p>
                    <a href="{{ route('company.edit') }}" class="btn btn-outline-primary btn-sm">
                        Modifier les informations de l'école
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
