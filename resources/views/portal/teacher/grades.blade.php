@extends('admin.layout.master')
@section('content')
<div class="card__wrapper">
    <h4>Saisie des notes — {{ $evaluation->nom_evaluation }}</h4>
    <p>{{ $evaluation->classe->nom_classe }} · {{ $evaluation->matiere->nom_matiere }}</p>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <form method="POST" action="{{ route('teacher.grades.save', $evaluation) }}">
        @csrf
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Élève</th><th>Note / 20</th><th>Appréciation</th></tr></thead>
                <tbody>
                @foreach($students as $row)
                    @php($n = $notes->get($row->etudiant_id))
                    <tr>
                        <td>{{ $row->etudiant->nom_etudiant }} {{ $row->etudiant->prenom_etudiant }}</td>
                        <td><input class="form-control" type="number" min="0" max="20" step="0.01" name="notes[{{ $row->etudiant_id }}][note]" value="{{ $n?->note }}"></td>
                        <td><input class="form-control" name="notes[{{ $row->etudiant_id }}][appreciation]" value="{{ $n?->appreciation }}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary">Enregistrer les notes</button>
    </form>
</div>
@endsection
