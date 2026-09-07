<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Emploi du temps -
        {{ $classe->nom_classe }}
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            padding: 30px;

            background: #ffffff;

            color: #111827;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

        }


        .document {

            max-width: 1100px;

            margin: 0 auto;

        }


        /* EN-TÊTE */

        .header {

            text-align: center;

            margin-bottom: 25px;

        }


        .header h1 {

            margin: 0 0 10px;

            font-size: 26px;

            text-transform: uppercase;

        }


        .header h2 {

            margin: 0 0 8px;

            font-size: 21px;

        }


        .header p {

            margin: 5px 0;

            font-size: 14px;

        }


        .line {

            border-top: 2px solid #222;

            margin: 20px 0;

        }


        /* TABLEAU */

        table {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

        }


        th,
        td {

            border: 1px solid #222;

        }


        th {

            padding: 12px;

            background: #eeeeee;

            text-align: center;

            font-size: 14px;

        }


        td {

            padding: 8px;

            vertical-align: top;

        }


        .jour {

            width: 14%;

            text-align: center;

            vertical-align: middle;

            font-weight: bold;

            background: #f7f7f7;

        }


        .periode {

            width: 43%;

        }


        /* COURS */

        .cours {

            padding: 10px;

            margin-bottom: 8px;

            border: 1px solid #cccccc;

            border-radius: 5px;

        }


        .cours:last-child {

            margin-bottom: 0;

        }


        .heure {

            font-size: 12px;

            font-weight: bold;

            margin-bottom: 5px;

        }


        .matiere {

            font-size: 14px;

            font-weight: bold;

            margin-bottom: 5px;

        }


        .professeur {

            font-size: 11px;

            color: #555;

        }


        .vide {

            text-align: center;

            padding: 20px;

            color: #999;

        }


        /* FOOTER */

        .footer {

            display: flex;

            justify-content: space-between;

            margin-top: 25px;

            font-size: 11px;

        }


        /* BOUTON */

        .print-button {

            position: fixed;

            top: 20px;

            right: 20px;

            padding: 10px 18px;

            border: none;

            border-radius: 5px;

            background: #111827;

            color: white;

            cursor: pointer;

        }


        /* IMPRESSION */

        @media print {

            @page {

                size: A4 landscape;

                margin: 10mm;

            }


            body {

                padding: 0;

            }


            .print-button {

                display: none;

            }


            .document {

                max-width: none;

            }


            .cours {

                break-inside: avoid;

            }

        }

    </style>

</head>


<body>


<button
    class="print-button"
    onclick="window.print()"
>
    Imprimer
</button>


<div class="document">


    {{-- EN-TÊTE --}}

    <div class="header">

        <h1>
            Emploi du temps
        </h1>


        <h2>

            Classe :

            {{ $classe->nom_classe }}

        </h2>


        <p>

            Année scolaire :

            <strong>
                {{ $anneeScolaire->nom_annee_scolaire }}
            </strong>

        </p>

    </div>


    <div class="line"></div>


    @php

        $jours = [
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi'
        ];


        $emploisParJour =
            $emplois->groupBy('jour');

    @endphp


    {{-- TABLEAU --}}

    <table>

        <thead>

            <tr>

                <th class="jour">
                    JOUR
                </th>

                <th class="periode">
                    MATIN
                </th>

                <th class="periode">
                    APRÈS-MIDI
                </th>

            </tr>

        </thead>


        <tbody>


        @foreach($jours as $jour)

            @php

                $coursDuJour =
                    $emploisParJour->get(
                        $jour,
                        collect()
                    );


                $coursMatin = $coursDuJour
                    ->filter(function ($emploi) {

                        return \Carbon\Carbon::parse(
                            $emploi->heure_debut
                        )->hour < 12;

                    })
                    ->sortBy('heure_debut');


                $coursApresMidi = $coursDuJour
                    ->filter(function ($emploi) {

                        return \Carbon\Carbon::parse(
                            $emploi->heure_debut
                        )->hour >= 12;

                    })
                    ->sortBy('heure_debut');

            @endphp


            <tr>


                {{-- JOUR --}}

                <td class="jour">

                    {{ $jour }}

                </td>


                {{-- MATIN --}}

                <td>

                    @forelse($coursMatin as $emploi)

                        <div class="cours">

                            <div class="heure">

                                {{ \Carbon\Carbon::parse(
                                    $emploi->heure_debut
                                )->format('H\hi') }}

                                -

                                {{ \Carbon\Carbon::parse(
                                    $emploi->heure_fin
                                )->format('H\hi') }}

                            </div>


                            <div class="matiere">

                                {{ $emploi->matiere->nom_matiere
                                    ?? 'Matière supprimée' }}

                            </div>


                            @if($emploi->professeur)

                                <div class="professeur">

                                    Professeur :

                                    {{ $emploi->professeur->prenom_prof }}

                                    {{ $emploi->professeur->nom_prof }}

                                </div>

                            @endif

                        </div>

                    @empty

                        <div class="vide">
                            —
                        </div>

                    @endforelse

                </td>


                {{-- APRÈS-MIDI --}}

                <td>

                    @forelse($coursApresMidi as $emploi)

                        <div class="cours">

                            <div class="heure">

                                {{ \Carbon\Carbon::parse(
                                    $emploi->heure_debut
                                )->format('H\hi') }}

                                -

                                {{ \Carbon\Carbon::parse(
                                    $emploi->heure_fin
                                )->format('H\hi') }}

                            </div>


                            <div class="matiere">

                                {{ $emploi->matiere->nom_matiere
                                    ?? 'Matière supprimée' }}

                            </div>


                            @if($emploi->professeur)

                                <div class="professeur">

                                    Professeur :

                                    {{ $emploi->professeur->prenom_prof }}

                                    {{ $emploi->professeur->nom_prof }}

                                </div>

                            @endif

                        </div>

                    @empty

                        <div class="vide">
                            —
                        </div>

                    @endforelse

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>


    {{-- FOOTER --}}

    <div class="footer">

        <div>

            Nombre de cours :

            <strong>
                {{ $emplois->count() }}
            </strong>

        </div>


        <div>

            Édité le :

            {{ now()->format('d/m/Y') }}

        </div>

    </div>

</div>


<script>

    window.addEventListener('load', function () {

        window.print();

    });

</script>


</body>

</html>
