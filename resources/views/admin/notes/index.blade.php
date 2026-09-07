@extends('admin.layout.master')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card__wrapper">

            {{-- =====================================================
                 EN-TÊTE
            ====================================================== --}}

            <div class="card__title-wrap mb-20">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="card__heading-title mb-1">

                            <i class="fa-regular fa-pen-to-square me-1"></i>

                            Gestion des notes

                        </h5>

                        <p class="text-muted small mb-0">

                            Consultez et gérez les notes des élèves.

                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 MESSAGES
            ====================================================== --}}

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    <i class="fa-regular fa-circle-check me-2"></i>

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show">

                    <i class="fa-regular fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif


            {{-- =====================================================
                 FILTRES RAPIDES
            ====================================================== --}}

            <div class="filter-box mb-4">

                <form
                    method="GET"
                    action="{{ route('notes.index') }}"
                >

                    <div class="row g-3 align-items-end">


                        {{-- ANNÉE SCOLAIRE --}}

                        <div class="col-xl-3 col-md-6">

                            <label class="filter-label">

                                <i class="fa-regular fa-calendar me-1"></i>

                                Année scolaire

                            </label>

                            <select
                                name="annee_scolaire_id"
                                class="form-control"
                            >

                                <option value="">

                                    Toutes les années

                                </option>


                                @foreach($anneesScolaires as $annee)

                                    <option
                                        value="{{ $annee->id }}"
                                        {{ (string) request('annee_scolaire_id') === (string) $annee->id ? 'selected' : '' }}
                                    >

                                        {{ $annee->nom_annee_scolaire }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- CLASSE --}}

                        <div class="col-xl-3 col-md-6">

                            <label class="filter-label">

                                <i class="fa-regular fa-school me-1"></i>

                                Classe

                            </label>

                            <select
                                name="classe_id"
                                class="form-control"
                            >

                                <option value="">

                                    Toutes les classes

                                </option>


                                @foreach($classes as $classe)

                                    <option
                                        value="{{ $classe->id }}"
                                        {{ (string) request('classe_id') === (string) $classe->id ? 'selected' : '' }}
                                    >

                                        {{ $classe->nom_classe }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- MATIÈRE --}}

                        <div class="col-xl-3 col-md-6">

                            <label class="filter-label">

                                <i class="fa-regular fa-book me-1"></i>

                                Matière

                            </label>

                            <select
                                name="matiere_id"
                                class="form-control"
                            >

                                <option value="">

                                    Toutes les matières

                                </option>


                                @foreach($matieres as $matiere)

                                    <option
                                        value="{{ $matiere->id }}"
                                        {{ (string) request('matiere_id') === (string) $matiere->id ? 'selected' : '' }}
                                    >

                                        {{ $matiere->nom_matiere }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- RECHERCHE ÉLÈVE --}}

                        <div class="col-xl-2 col-md-6">

                            <label class="filter-label">

                                <i class="fa-regular fa-magnifying-glass me-1"></i>

                                Élève

                            </label>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Nom ou prénom..."
                                value="{{ request('search') }}"
                            >

                        </div>


                        {{-- BOUTONS --}}

                        <div class="col-xl-1 col-md-12">

                            <div class="d-flex gap-2">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    title="Filtrer"
                                >

                                    <i class="fa-regular fa-filter"></i>

                                </button>


                                @if(
                                    request('annee_scolaire_id') ||
                                    request('classe_id') ||
                                    request('matiere_id') ||
                                    request('search')
                                )

                                    <a
                                        href="{{ route('notes.index') }}"
                                        class="btn btn-outline-secondary"
                                        title="Réinitialiser"
                                    >

                                        <i class="fa-regular fa-xmark"></i>

                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                </form>

            </div>


            {{-- =====================================================
                 RÉSULTATS
            ====================================================== --}}

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <span class="text-muted small">

                        {{ $notes->total() }}

                        {{ $notes->total() > 1 ? 'notes' : 'note' }}

                    </span>

                </div>

            </div>


            {{-- =====================================================
                 TABLEAU
            ====================================================== --}}

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="60">
                                #
                            </th>

                            <th>
                                Élève
                            </th>

                            <th>
                                Évaluation
                            </th>

                            <th>
                                Matière
                            </th>

                            <th>
                                Classe
                            </th>

                            <th>
                                Année scolaire
                            </th>

                            <th class="text-center">
                                Note
                            </th>

                            <th>
                                Appréciation
                            </th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($notes as $note)

                            <tr>


                                {{-- NUMÉRO --}}

                                <td>

                                    {{ $notes->firstItem() + $loop->index }}

                                </td>


                                {{-- ÉLÈVE --}}

                                <td>

                                    @if($note->etudiant)

                                        <div class="student-info">

                                            <div class="student-avatar">

                                                {{ strtoupper(
                                                    substr(
                                                        $note->etudiant->prenom
                                                        ?? $note->etudiant->nom,
                                                        0,
                                                        1
                                                    )
                                                ) }}

                                            </div>


                                            <div>

                                                <strong>

                                                    {{ $note->etudiant->prenom }}

                                                    {{ $note->etudiant->nom }}

                                                </strong>


                                                @if(isset($note->etudiant->matricule))

                                                    <small class="d-block text-muted">

                                                        {{ $note->etudiant->matricule }}

                                                    </small>

                                                @endif

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-muted">

                                            Élève supprimé

                                        </span>

                                    @endif

                                </td>


                                {{-- ÉVALUATION --}}

                                <td>

                                    @if($note->evaluation)

                                        <strong>

                                            {{ $note->evaluation->nom_evaluation }}

                                        </strong>


                                        <small class="d-block text-muted">

                                            {{ $note->evaluation->type_evaluation }}

                                        </small>

                                    @else

                                        <span class="text-muted">

                                            Évaluation supprimée

                                        </span>

                                    @endif

                                </td>


                                {{-- MATIÈRE --}}

                                <td>

                                    {{ $note->evaluation->matiere->nom_matiere ?? '—' }}

                                </td>


                                {{-- CLASSE --}}

                                <td>

                                    @if($note->evaluation?->classe)

                                        <span class="classe-badge">

                                            <i class="fa-regular fa-school me-1"></i>

                                            {{ $note->evaluation->classe->nom_classe }}

                                        </span>

                                    @else

                                        —

                                    @endif

                                </td>


                                {{-- ANNÉE --}}

                                <td>

                                    {{ $note->evaluation->anneeScolaire->nom_annee_scolaire ?? '—' }}

                                </td>


                                {{-- NOTE --}}

                                <td class="text-center">

                                    <span
                                        class="note-badge
                                        @if($note->note < 10)
                                            note-danger
                                        @elseif($note->note < 12)
                                            note-warning
                                        @else
                                            note-success
                                        @endif"
                                    >

                                        {{ number_format(
                                            $note->note,
                                            2,
                                            ',',
                                            ' '
                                        ) }}

                                        / 20

                                    </span>

                                </td>


                                {{-- APPRÉCIATION --}}

                                <td>

                                    @if($note->appreciation)

                                        <span class="small">

                                            {{ $note->appreciation }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            —

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTIONS --}}

                                <td>

                                    <div class="d-flex justify-content-center gap-2">


                                        {{-- MODIFIER --}}

                                        <a
                                            href="{{ route(
                                                'notes.edit',
                                                $note->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Modifier"
                                        >

                                            <i class="fa-regular fa-pen-to-square"></i>

                                        </a>


                                        {{-- SUPPRIMER --}}

                                        <form
                                            action="{{ route(
                                                'notes.destroy',
                                                $note->id
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm('Voulez-vous vraiment supprimer cette note ?');"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Supprimer"
                                            >

                                                <i class="fa-regular fa-trash-can"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="fa-regular fa-file-pen"></i>

                                        </div>


                                        <h6>

                                            Aucune note trouvée

                                        </h6>


                                        <p class="text-muted mb-0">

                                            Aucune note ne correspond
                                            aux critères sélectionnés.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
                 PAGINATION
            ====================================================== --}}

            @if($notes->hasPages())

                <div class="mt-4">

                    {{ $notes->withQueryString()->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| FILTRES
|--------------------------------------------------------------------------
*/

.filter-box {

    padding: 18px;

    background: #f8f9fb;

    border: 1px solid #e8eaf0;

    border-radius: 12px;

}


.filter-label {

    display: block;

    margin-bottom: 7px;

    font-size: 13px;

    font-weight: 600;

    color: #374151;

}


.filter-box .form-control {

    min-height: 42px;

    border-radius: 8px;

}


/*
|--------------------------------------------------------------------------
| ÉLÈVE
|--------------------------------------------------------------------------
*/

.student-info {

    display: flex;

    align-items: center;

    gap: 10px;

}


.student-avatar {

    width: 36px;

    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #eef2ff;

    color: #4361ee;

    font-size: 12px;

    font-weight: 700;

    flex-shrink: 0;

}


/*
|--------------------------------------------------------------------------
| CLASSE
|--------------------------------------------------------------------------
*/

.classe-badge {

    display: inline-flex;

    align-items: center;

    padding: 5px 9px;

    border-radius: 20px;

    background: #fff7ed;

    color: #c2410c;

    font-size: 12px;

    font-weight: 600;

}


/*
|--------------------------------------------------------------------------
| NOTES
|--------------------------------------------------------------------------
*/

.note-badge {

    display: inline-block;

    min-width: 72px;

    padding: 6px 10px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 700;

}


.note-success {

    background: #eaf8f0;

    color: #198754;

}


.note-warning {

    background: #fff7df;

    color: #b58105;

}


.note-danger {

    background: #fdecec;

    color: #dc3545;

}


/*
|--------------------------------------------------------------------------
| TABLEAU
|--------------------------------------------------------------------------
*/

.table th {

    font-size: 13px;

    font-weight: 600;

    white-space: nowrap;

}


.table td {

    font-size: 13px;

    vertical-align: middle;

}


/*
|--------------------------------------------------------------------------
| EMPTY
|--------------------------------------------------------------------------
*/

.empty-state {

    text-align: center;

    padding: 60px 20px;

}


.empty-icon {

    width: 65px;

    height: 65px;

    margin: 0 auto 15px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 17px;

    background: #f3f4f6;

    color: #9ca3af;

    font-size: 27px;

}


/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {

    .filter-box {

        padding: 14px;

    }

}

</style>

@endsection
