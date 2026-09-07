@extends('admin.layout.master')
@section('content')
<div class="card__wrapper">
    <h4>Mon espace professeur</h4>
    <p class="text-muted">{{ $prof->prenom_prof }} {{ $prof->nom_prof }}</p>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Évaluation</th><th>Classe</th><th>Matière</th><th>Année</th><th></th></tr></thead>
            <tbody>
            @forelse($evaluations as $e)
                <tr>
                    <td>{{ $e->nom_evaluation }}</td>
                    <td>{{ $e->classe->nom_classe }}</td>
                    <td>{{ $e->matiere->nom_matiere }}</td>
                    <td>{{ $e->anneeScolaire->nom_annee_scolaire }}</td>
                    <td><a class="btn btn-sm btn-primary" href="{{ route('teacher.grades', $e) }}">Saisir les notes</a></td>
                </tr>
            @empty <tr><td colspan="5">Aucune évaluation attribuée.</td></tr> @endforelse
            </tbody>
        </table>
    </div>
    {{ $evaluations->links() }}
</div>
@endsection
