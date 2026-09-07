<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Bulletin de notes -
        {{ $etudiant->nom_etudiant }}
        {{ $etudiant->prenom_etudiant }}
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        html,
        body {

            margin: 0;

            padding: 0;

            background: #e9ecef;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: #111;

        }


        /* =====================================================
           CONTENEUR A4
        ====================================================== */

        .page {

            width: 210mm;

            min-height: 297mm;

            margin: 20px auto;

            padding: 12mm;

            background: #ffffff;

            box-shadow:
                0 3px 20px
                rgba(0, 0, 0, 0.12);

        }


        /* =====================================================
           ACTIONS
        ====================================================== */

        .actions {

            width: 210mm;

            margin: 20px auto;

            display: flex;

            justify-content: space-between;

            align-items: center;

        }


        .btn {

            display: inline-block;

            padding: 10px 18px;

            border-radius: 6px;

            border: none;

            text-decoration: none;

            cursor: pointer;

            font-size: 14px;

        }


        .btn-back {

            background: #6c757d;

            color: #ffffff;

        }


        .btn-print {

            background: #0d6efd;

            color: #ffffff;

        }


        /* =====================================================
           EN-TÊTE ÉTABLISSEMENT
        ====================================================== */

        .header {

            text-align: center;

            border-bottom: 2px solid #111;

            padding-bottom: 12px;

            margin-bottom: 18px;

        }


        .school-name {

            font-size: 21px;

            font-weight: bold;

            text-transform: uppercase;

            margin-bottom: 5px;

        }


        .school-address {

            font-size: 11px;

            color: #555;

            margin-bottom: 10px;

        }


        .title {

            font-size: 20px;

            font-weight: bold;

            text-transform: uppercase;

            margin-top: 8px;

        }


        .school-year {

            font-size: 13px;

            margin-top: 5px;

        }


        /* =====================================================
           INFORMATIONS ÉTUDIANT
        ====================================================== */

        .student-box {

            border: 1px solid #222;

            margin-bottom: 18px;

        }


        .student-title {

            background: #eeeeee;

            border-bottom: 1px solid #222;

            padding: 8px 10px;

            font-size: 12px;

            font-weight: bold;

            text-transform: uppercase;

        }


        .student-grid {

            display: grid;

            grid-template-columns: 1fr 1fr;

        }


        .student-item {

            padding: 8px 10px;

            font-size: 12px;

            border-bottom: 1px solid #ddd;

        }


        .student-item:nth-child(odd) {

            border-right: 1px solid #ddd;

        }


        .student-label {

            font-weight: bold;

        }


        /* =====================================================
           TABLEAU DES NOTES
        ====================================================== */

        .notes-table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 10px;

        }


        .notes-table th,
        .notes-table td {

            border: 1px solid #222;

            padding: 7px;

            font-size: 11px;

        }


        .notes-table th {

            background: #eeeeee;

            text-align: center;

            font-weight: bold;

        }


        .notes-table td {

            vertical-align: middle;

        }


        .center {

            text-align: center;

        }


        .matiere {

            font-weight: bold;

        }


        .total-row td {

            background: #eeeeee;

            font-weight: bold;

        }


        /* =====================================================
           RÉSULTATS
        ====================================================== */

        .results {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 15px;

            margin-top: 18px;

        }


        .result-box {

            border: 1px solid #222;

            padding: 12px;

            min-height: 75px;

        }


        .result-label {

            font-size: 11px;

            font-weight: bold;

            color: #555;

            text-transform: uppercase;

            margin-bottom: 7px;

        }


        .result-value {

            font-size: 22px;

            font-weight: bold;

        }


        .appreciation {

            font-size: 15px;

            font-weight: bold;

        }


        /* =====================================================
           SIGNATURES
        ====================================================== */

        .signatures {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 50px;

            margin-top: 55px;

        }


        .signature {

            text-align: center;

            font-size: 12px;

        }


        .signature-title {

            font-weight: bold;

            margin-bottom: 55px;

        }


        .signature-line {

            width: 75%;

            margin: auto;

            border-top: 1px solid #222;

        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .footer {

            margin-top: 35px;

            padding-top: 8px;

            border-top: 1px solid #ccc;

            text-align: center;

            font-size: 9px;

            color: #666;

        }


        /* =====================================================
           IMPRESSION
        ====================================================== */

        @media print {

            @page {

                size: A4 portrait;

                margin: 0;

            }


            html,
            body {

                width: 210mm;

                min-height: 297mm;

                background: #ffffff;

            }


            .actions {

                display: none !important;

            }


            .page {

                width: 210mm;

                min-height: 297mm;

                margin: 0;

                padding: 12mm;

                box-shadow: none;

            }

        }


    </style>

</head>


<body>


    {{-- =========================================================
        BOUTONS
    ========================================================== --}}

    <div class="actions">

        <a
            href="{{ route('notes.bulletin') }}"
            class="btn btn-back"
        >

            ← Retour

        </a>


        <button
            type="button"
            onclick="window.print()"
            class="btn btn-print"
        >

            🖨 Imprimer

        </button>

    </div>


    {{-- =========================================================
        FICHE A4
    ========================================================== --}}

    <div class="page">


        {{-- =====================================================
            EN-TÊTE
        ====================================================== --}}

        @php($company = auth()->user()?->company)

        <div class="header">

            <div class="school-name">
                {{ $company?->name ?? 'ÉTABLISSEMENT SCOLAIRE' }}
            </div>

            <div class="school-address">
                @if($company?->address) {{ $company->address }} @endif
                @if($company?->city) — {{ $company->city }} @endif
                @if($company?->country) — {{ $company->country }} @endif
                @if($company?->phone) — Tél. {{ $company->phone }} @endif
                @if($company?->email) — {{ $company->email }} @endif
            </div>


            <div class="title">

                BULLETIN DE NOTES

            </div>


            <div class="school-year">

                Année scolaire :

                <strong>

                    {{ $anneeScolaire->nom_annee_scolaire }}

                </strong>

            </div>

        </div>


        {{-- =====================================================
            INFORMATIONS ÉTUDIANT
        ====================================================== --}}

        <div class="student-box">

            <div class="student-title">

                Informations de l'étudiant

            </div>


            <div class="student-grid">


                <div class="student-item">

                    <span class="student-label">
                        Nom :
                    </span>

                    {{ $etudiant->nom_etudiant }}

                </div>


                <div class="student-item">

                    <span class="student-label">
                        Prénom :
                    </span>

                    {{ $etudiant->prenom_etudiant }}

                </div>


                <div class="student-item">

                    <span class="student-label">
                        Matricule :
                    </span>

                    {{ $etudiant->code_etudiant ?? '-' }}

                </div>


                <div class="student-item">

                    <span class="student-label">
                        Classe :
                    </span>

                    {{ $classe->nom_classe }}

                </div>

            </div>

        </div>


        {{-- =====================================================
            TABLEAU DES NOTES
        ====================================================== --}}

        <table class="notes-table">

            <thead>

                <tr>

                    <th style="width: 6%;">
                        N°
                    </th>

                    <th style="width: 34%;">
                        Matière
                    </th>

                    <th style="width: 14%;">
                        Moyenne
                    </th>

                    <th style="width: 12%;">
                        Coef.
                    </th>

                    <th style="width: 14%;">
                        Points
                    </th>

                    <th style="width: 20%;">
                        Appréciation
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($bulletin as $index => $ligne)

                    <tr>

                        <td class="center">

                            {{ $index + 1 }}

                        </td>


                        <td class="matiere">

                            {{ $ligne['matiere']->nom_matiere }}

                        </td>


                        <td class="center">

                            {{ number_format(
                                $ligne['moyenne'],
                                2,
                                ',',
                                ' '
                            ) }}

                            /20

                        </td>


                        <td class="center">

                            {{ $ligne['coefficient'] }}

                        </td>


                        <td class="center">

                            {{ number_format(
                                $ligne['points'],
                                2,
                                ',',
                                ' '
                            ) }}

                        </td>


                        <td>

                            {{ $ligne['appreciation'] }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="center"
                            style="padding: 25px;"
                        >

                            Aucune note disponible.

                        </td>

                    </tr>

                @endforelse


                @if($bulletin->count() > 0)

                    <tr class="total-row">

                        <td
                            colspan="3"
                            style="text-align: right;"
                        >

                            TOTAL

                        </td>


                        <td class="center">

                            {{ $totalCoefficients }}

                        </td>


                        <td class="center">

                            {{ number_format(
                                $totalPoints,
                                2,
                                ',',
                                ' '
                            ) }}

                        </td>


                        <td></td>

                    </tr>

                @endif

            </tbody>

        </table>


        {{-- =====================================================
            RÉSULTATS
        ====================================================== --}}

        <div class="results">


            <div class="result-box">

                <div class="result-label">

                    Moyenne générale

                </div>


                <div class="result-value">

                    {{ number_format(
                        $moyenneGenerale,
                        2,
                        ',',
                        ' '
                    ) }}

                    /20

                </div>

            </div>


            <div class="result-box">

                <div class="result-label">

                    Appréciation générale

                </div>


                <div class="appreciation">

                    {{ $appreciationGenerale }}

                </div>

            </div>

        </div>


        {{-- =====================================================
            SIGNATURES
        ====================================================== --}}

        <div class="signatures">


            <div class="signature">

                <div class="signature-title">

                    Le professeur principal

                </div>


                <div class="signature-line"></div>

            </div>


            <div class="signature">

                <div class="signature-title">

                    Le responsable de l'établissement

                </div>


                <div class="signature-line"></div>

            </div>

        </div>


        {{-- =====================================================
            FOOTER
        ====================================================== --}}

        <div class="footer">

            Bulletin de notes — Année scolaire
            {{ $anneeScolaire->nom_annee_scolaire }}

        </div>


    </div>

</body>

</html>
