@extends('admin.layout.master')

@section('content')

<div class="row g-4">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="col-12">

        <div class="card__wrapper">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h5 class="card__heading-title mb-1">
                        Espace parent
                    </h5>

                    <p class="text-muted small mb-0">
                        Consultez les informations scolaires et les notes
                        de vos enfants.
                    </p>

                </div>

                <span class="badge bg-primary">

                    {{ $enfants->count() }}

                    enfant(s)

                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
         AUCUN ENFANT
    ========================================================== --}}

    @if($enfants->isEmpty())

        <div class="col-12">

            <div class="card__wrapper">

                <div class="text-center py-5">

                    <div class="mb-3">

                        <i class="fa-light fa-children fa-3x text-muted"></i>

                    </div>

                    <h5 class="mb-2">
                        Mes enfants
                    </h5>

                    <p class="text-muted mb-0">

                        Aucun enfant n'est encore rattaché
                        à ce compte.

                    </p>

                </div>

            </div>

        </div>

    @else


        {{-- =====================================================
             ENFANTS
        ====================================================== --}}

        @foreach($enfants as $enfant)

            @php

                /*
                |--------------------------------------------------------------------------
                | Dernière inscription
                |--------------------------------------------------------------------------
                */

                $inscription = $enfant->inscriptions
                    ->sortByDesc('created_at')
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | Notes
                |--------------------------------------------------------------------------
                */

                $notes = $enfant->notes;


                /*
                |--------------------------------------------------------------------------
                | Moyenne
                |--------------------------------------------------------------------------
                */

                $moyenne = $enfant->moyenne_parent ?? 0;

            @endphp


            <div class="col-12">

                <div class="card__wrapper">


                    {{-- =================================================
                         INFORMATIONS ENFANT
                    ================================================== --}}

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                        <div class="d-flex align-items-center">


                            {{-- PHOTO --}}

                            @if($enfant->photo)

                                <img
                                    src="{{ asset('storage/' . $enfant->photo) }}"
                                    alt="{{ $enfant->nom_etudiant }}"
                                    class="rounded-circle me-3"
                                    style="
                                        width:65px;
                                        height:65px;
                                        object-fit:cover;
                                    "
                                >

                            @else

                                <div
                                    class="
                                        rounded-circle
                                        bg-primary
                                        bg-opacity-10
                                        d-flex
                                        align-items-center
                                        justify-content-center
                                        me-3
                                    "
                                    style="
                                        width:65px;
                                        height:65px;
                                    "
                                >

                                    <i class="fa-light fa-user text-primary fa-lg"></i>

                                </div>

                            @endif


                            {{-- NOM --}}

                            <div>

                                <h5 class="mb-1">

                                    {{ $enfant->nom_etudiant }}

                                    {{ $enfant->prenom_etudiant }}

                                </h5>


                                @if($enfant->code_etudiant)

                                    <small class="text-muted">

                                        Code :

                                        {{ $enfant->code_etudiant }}

                                    </small>

                                @endif

                            </div>

                        </div>


                        {{-- =================================================
                             MOYENNE
                        ================================================== --}}

                        <div class="text-end">

                            <small class="text-muted d-block">
                                Moyenne générale
                            </small>

                            <strong
                                class="
                                    fs-4
                                    {{ $moyenne >= 10
                                        ? 'text-success'
                                        : 'text-danger'
                                    }}
                                "
                            >

                                {{ number_format($moyenne, 2, ',', ' ') }}/20

                            </strong>

                        </div>

                    </div>


                    {{-- =================================================
                         INFORMATIONS SCOLAIRES
                    ================================================== --}}

                    <div class="row g-3 mb-4">


                        {{-- CLASSE --}}

                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa-light fa-school me-1"></i>

                                    Classe

                                </small>

                                <strong>

                                    {{ $inscription?->classe?->nom_classe ?? 'Non renseignée' }}

                                </strong>

                            </div>

                        </div>


                        {{-- ANNÉE SCOLAIRE --}}

                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa-light fa-calendar me-1"></i>

                                    Année scolaire

                                </small>

                                <strong>

                                    {{ $inscription?->anneeScolaire?->nom_annee_scolaire ?? 'Non renseignée' }}

                                </strong>

                            </div>

                        </div>


                        {{-- NOMBRE DE NOTES --}}

                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa-light fa-file-pen me-1"></i>

                                    Notes

                                </small>

                                <strong>

                                    {{ $notes->count() }}

                                    note(s)

                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         NOTES
                    ================================================== --}}

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>

                            <h5 class="mb-1">

                                <i class="fa-light fa-graduation-cap me-2"></i>

                                Notes de
                                {{ $enfant->prenom_etudiant }}

                            </h5>

                            <small class="text-muted">

                                Résultats scolaires

                            </small>

                        </div>

                    </div>


                    {{-- =================================================
                         TABLE DES NOTES
                    ================================================== --}}

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead>

                                <tr>

                                    <th>
                                        Matière
                                    </th>

                                    <th>
                                        Évaluation
                                    </th>

                                    <th>
                                        Type
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

                                </tr>

                            </thead>


                            <tbody>


                                @forelse($notes as $note)

                                    <tr>


                                        {{-- MATIÈRE --}}

                                        <td>

                                            <strong>

                                                {{ $note->evaluation?->matiere?->nom_matiere ?? 'Non renseignée' }}

                                            </strong>

                                        </td>


                                        {{-- ÉVALUATION --}}

                                        <td>

                                            {{ $note->evaluation?->nom_evaluation ?? 'Évaluation' }}

                                        </td>


                                        {{-- TYPE --}}

                                        <td>

                                            {{ $note->evaluation?->type_evaluation ?? '-' }}

                                        </td>


                                        {{-- CLASSE --}}

                                        <td>

                                            {{ $note->evaluation?->classe?->nom_classe ?? '-' }}

                                        </td>


                                        {{-- ANNÉE --}}

                                        <td>

                                            {{ $note->evaluation?->anneeScolaire?->nom_annee_scolaire ?? '-' }}

                                        </td>


                                        {{-- NOTE --}}

                                        <td class="text-center">

                                            @php

                                                $noteValue = (float) $note->note;

                                            @endphp


                                            <span
                                                class="
                                                    badge
                                                    fs-6
                                                    {{ $noteValue >= 10
                                                        ? 'bg-success'
                                                        : 'bg-danger'
                                                    }}
                                                "
                                            >

                                                {{ $note->note }}/20

                                            </span>

                                        </td>


                                        {{-- APPRÉCIATION --}}

                                        <td>

                                            {{ $note->appreciation ?? '-' }}

                                        </td>


                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="7"
                                            class="text-center py-5"
                                        >

                                            <i
                                                class="
                                                    fa-light
                                                    fa-file-circle-xmark
                                                    fa-2x
                                                    text-muted
                                                    mb-2
                                                "
                                            ></i>

                                            <p class="text-muted mb-0">

                                                Aucune note disponible
                                                pour cet enfant.

                                            </p>

                                        </td>

                                    </tr>

                                @endforelse


                            </tbody>

                        </table>

                    </div>


                    {{-- =================================================
                         DOSSIER COMPLET
                    ================================================== --}}

                    <div class="border-top pt-3 mt-3">

                        <a
                            href="{{ route('parent.child', $enfant->id) }}"
                            class="btn btn-primary btn-sm"
                        >

                            <i class="fa-light fa-eye me-1"></i>

                            Voir le dossier complet

                        </a>

                    </div>


                </div>

            </div>

        @endforeach

    @endif

</div>

@endsection
