<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Reçu d'inscription -
        {{ str_pad($inscription->id, 6, '0', STR_PAD_LEFT) }}
    </title>

    <style>

        /* =========================================================
           RESET
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #f1f3f5;
            color: #1f2937;
            font-family:
                Arial,
                Helvetica,
                sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }


        /* =========================================================
           CONTENEUR PRINCIPAL
        ========================================================= */

        .page-container {
            width: 100%;
            max-width: 900px;
            margin: 30px auto;
            padding: 0 15px;
        }


        /* =========================================================
           BARRE D'ACTIONS
        ========================================================= */

        .print-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn {
            border: none;
            border-radius: 6px;
            padding: 12px 22px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-print {
            background: #111827;
            color: #ffffff;
        }

        .btn-print:hover {
            background: #000000;
        }

        .btn-close {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-close:hover {
            background: #d1d5db;
        }


        /* =========================================================
           FEUILLE DU REÇU
        ========================================================= */

        .receipt {
            width: 100%;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }


        /* =========================================================
           EN-TÊTE
        ========================================================= */

        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 30px;

            padding-bottom: 20px;
            border-bottom: 2px solid #111827;
        }

        .school-info {
            flex: 1;
        }

        .school-name {
            margin: 0 0 5px 0;

            font-size: 25px;
            font-weight: 800;

            color: #111827;

            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .school-subtitle {
            margin: 0;

            font-size: 13px;
            color: #6b7280;
        }

        .receipt-box {
            min-width: 210px;

            padding: 15px;

            text-align: right;

            border: 1px solid #d1d5db;
            border-radius: 6px;

            background: #f9fafb;
        }

        .receipt-title {
            margin: 0 0 6px 0;

            font-size: 17px;
            font-weight: 800;

            color: #111827;
        }

        .receipt-number {
            margin: 0;

            font-size: 13px;
            color: #374151;
        }

        .receipt-date {
            margin: 4px 0 0 0;

            font-size: 12px;
            color: #6b7280;
        }


        /* =========================================================
           INFORMATIONS
        ========================================================= */

        .section {
            margin-top: 25px;

            page-break-inside: avoid;
            break-inside: avoid;
        }

        .section-title {
            margin: 0 0 10px 0;

            padding: 9px 12px;

            background: #111827;
            color: #ffffff;

            border-radius: 4px;

            font-size: 13px;
            font-weight: 800;

            letter-spacing: 0.4px;
            text-transform: uppercase;
        }


        /* =========================================================
           TABLEAU
        ========================================================= */

        .info-table {
            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;
        }

        .info-table tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .info-table td {
            border: 1px solid #d1d5db;

            padding: 10px 12px;

            vertical-align: middle;
        }

        .label {
            width: 38%;

            background: #f9fafb;

            color: #374151;

            font-weight: 700;
        }

        .value {
            width: 62%;

            color: #111827;

            font-weight: 500;
        }


        /* =========================================================
           PAIEMENT
        ========================================================= */

        .payment-table {
            width: 100%;

            border-collapse: collapse;
        }

        .payment-table td {
            padding: 11px 12px;

            border-bottom: 1px solid #e5e7eb;
        }

        .payment-label {
            font-weight: 600;
            color: #374151;
        }

        .payment-value {
            text-align: right;

            font-weight: 700;

            color: #111827;
        }

        .total-row td {
            padding: 15px 12px;

            border-top: 2px solid #111827;
            border-bottom: none;

            background: #f9fafb;
        }

        .total-label {
            font-size: 14px;
            font-weight: 800;
        }

        .total-value {
            text-align: right;

            font-size: 18px;
            font-weight: 900;

            color: #111827;
        }


        /* =========================================================
           STATUT
        ========================================================= */

        .status {
            display: inline-block;

            padding: 5px 12px;

            border-radius: 20px;

            background: #e8f5e9;

            color: #166534;

            font-size: 12px;
            font-weight: 800;

            text-transform: uppercase;
        }


        /* =========================================================
           SIGNATURES
        ========================================================= */

        .signatures {
            display: flex;

            justify-content: space-between;

            gap: 60px;

            margin-top: 55px;

            page-break-inside: avoid;
            break-inside: avoid;
        }

        .signature-box {
            width: 50%;

            text-align: center;
        }

        .signature-line {
            height: 1px;

            width: 80%;

            margin: 0 auto 8px auto;

            background: #111827;
        }

        .signature-title {
            margin: 0;

            font-size: 12px;

            font-weight: 700;

            color: #374151;
        }

        .signature-space {
            height: 45px;
        }


        /* =========================================================
           PIED DE PAGE
        ========================================================= */

        .receipt-footer {
            margin-top: 30px;

            padding-top: 12px;

            border-top: 1px solid #d1d5db;

            text-align: center;

            font-size: 10px;

            color: #6b7280;
        }

        .footer-note {
            margin: 3px 0;
        }


        /* =========================================================
           IMPRESSION
        ========================================================= */

        @page {
            size: A4 portrait;

            margin: 12mm;
        }


        @media print {

            html,
            body {
                width: 100%;
                margin: 0;
                padding: 0;

                background: #ffffff;
            }

            body {
                font-size: 12px;

                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .page-container {
                width: 100%;
                max-width: none;

                margin: 0;
                padding: 0;
            }

            .print-actions {
                display: none !important;
            }

            .receipt {
                width: 100%;

                margin: 0;
                padding: 0;

                border: none;
                border-radius: 0;

                box-shadow: none;

                background: #ffffff;
            }

            .receipt-header {
                padding-bottom: 15px;
            }

            .school-name {
                font-size: 20px;
            }

            .section {
                margin-top: 18px;
            }

            .section-title {
                padding: 7px 10px;
            }

            .info-table td {
                padding: 7px 9px;
            }

            .payment-table td {
                padding: 8px 9px;
            }

            .signatures {
                margin-top: 40px;
            }

            .receipt-footer {
                margin-top: 20px;
            }

            /* Empêche les éléments importants d'être coupés */
            .receipt-header,
            .section,
            .signatures,
            .receipt-footer {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            /* Les couleurs sont conservées à l'impression */
            .section-title,
            .receipt-box,
            .total-row,
            .label,
            .status {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

    </style>
</head>


<body>

@php

    /*
    |--------------------------------------------------------------------------
    | DONNÉES
    |--------------------------------------------------------------------------
    */

    $etudiant = $inscription->etudiant;

    $classe = $inscription->classe;

    $anneeScolaire = $inscription->anneeScolaire;

    $fraisPaye = (float) ($inscription->frais_scolarite ?? 0);

    $prixClasse = (float) ($classe->prix ?? 0);

    $reste = max(0, $prixClasse - $fraisPaye);

    $numeroRecu = str_pad(
        $inscription->id,
        6,
        '0',
        STR_PAD_LEFT
    );

    $numeroMatricule = str_pad(
        $etudiant->id ?? 0,
        6,
        '0',
        STR_PAD_LEFT
    );

    $dateInscription = $inscription->created_at
        ? $inscription->created_at->format('d/m/Y')
        : 'N/A';

    $dateGeneration = now()->format('d/m/Y à H:i');

@endphp


<div class="page-container">


    <!-- =========================================================
         BOUTONS
    ========================================================== -->

    <div class="print-actions">

        <button
            type="button"
            class="btn btn-print"
            onclick="imprimerRecu()"
        >
            🖨️ &nbsp; IMPRIMER LE REÇU
        </button>


        <button
            type="button"
            class="btn btn-close"
            onclick="window.history.back()"
        >
            ← &nbsp; RETOUR
        </button>

    </div>



    <!-- =========================================================
         REÇU
    ========================================================== -->

    <div class="receipt" id="printArea">


        <!-- =====================================================
             EN-TÊTE
        ====================================================== -->

        <header class="receipt-header">


            @php($company = auth()->user()?->company)

            <div class="school-info">

                <h1 class="school-name">
                    {{ $company?->name ?? 'Établissement d’Enseignement' }}
                </h1>

                <p class="school-subtitle">
                    @if($company?->short_name) {{ $company->short_name }} — @endif
                    Administration &amp; Scolarité
                </p>

                @if($company?->address || $company?->city || $company?->phone || $company?->email)
                    <p class="school-subtitle">
                        {{ $company?->address }}
                        @if($company?->city) — {{ $company->city }} @endif
                        @if($company?->phone) — Tél. {{ $company->phone }} @endif
                        @if($company?->email) — {{ $company->email }} @endif
                    </p>
                @endif

            </div>


            <div class="receipt-box">

                <h2 class="receipt-title">
                    REÇU D'INSCRIPTION
                </h2>

                <p class="receipt-number">
                    N° {{ $numeroRecu }}
                </p>

                <p class="receipt-date">
                    Date : {{ $dateInscription }}
                </p>

            </div>


        </header>



        <!-- =====================================================
             INFORMATIONS ÉTUDIANT
        ====================================================== -->

        <section class="section">

            <h3 class="section-title">
                Informations de l'étudiant
            </h3>


            <table class="info-table">

                <tbody>

                    <tr>

                        <td class="label">
                            Matricule
                        </td>

                        <td class="value">
                            #{{ $numeroMatricule }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Nom complet
                        </td>

                        <td class="value">

                            {{ strtoupper($etudiant->nom_etudiant ?? 'N/A') }}

                            {{ $etudiant->prenom_etudiant ?? '' }}

                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Adresse
                        </td>

                        <td class="value">
                            {{ $etudiant->adresse_etudiant ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Tuteur
                        </td>

                        <td class="value">
                            {{ $etudiant->nom_du_tuteur ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Téléphone du tuteur
                        </td>

                        <td class="value">
                            {{ $etudiant->numero_du_tuteur ?? 'N/A' }}
                        </td>

                    </tr>

                </tbody>

            </table>

        </section>



        <!-- =====================================================
             INFORMATIONS INSCRIPTION
        ====================================================== -->

        <section class="section">

            <h3 class="section-title">
                Détails de l'inscription
            </h3>


            <table class="info-table">

                <tbody>

                    <tr>

                        <td class="label">
                            Classe
                        </td>

                        <td class="value">
                            {{ $classe->nom_classe ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Année scolaire
                        </td>

                        <td class="value">
                            {{ $anneeScolaire->nom_annee_scolaire ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Date d'inscription
                        </td>

                        <td class="value">
                            {{ $dateInscription }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Statut
                        </td>

                        <td class="value">

                            <span class="status">
                                Actif
                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </section>



        <!-- =====================================================
             PAIEMENT
        ====================================================== -->

        <section class="section">

            <h3 class="section-title">
                Situation financière
            </h3>


            <table class="payment-table">

                <tbody>

                    <tr>

                        <td class="payment-label">
                            Frais de scolarité
                        </td>

                        <td class="payment-value">

                            {{ number_format(
                                $prixClasse,
                                0,
                                ',',
                                ' '
                            ) }}

                            F CFA

                        </td>

                    </tr>


                    <tr>

                        <td class="payment-label">
                            Montant payé
                        </td>

                        <td class="payment-value">

                            {{ number_format(
                                $fraisPaye,
                                0,
                                ',',
                                ' '
                            ) }}

                            F CFA

                        </td>

                    </tr>


                    <tr class="total-row">

                        <td class="total-label">

                            {{ $reste > 0
                                ? 'RESTE À PAYER'
                                : 'SITUATION'
                            }}

                        </td>


                        <td class="total-value">

                            @if($reste > 0)

                                {{ number_format(
                                    $reste,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                F CFA

                            @else

                                PAYÉ ✓

                            @endif

                        </td>

                    </tr>

                </tbody>

            </table>

        </section>



        <!-- =====================================================
             SIGNATURES
        ====================================================== -->

        <div class="signatures">


            <div class="signature-box">

                <div class="signature-space"></div>

                <div class="signature-line"></div>

                <p class="signature-title">
                    Signature du tuteur
                </p>

            </div>


            <div class="signature-box">

                <div class="signature-space"></div>

                <div class="signature-line"></div>

                <p class="signature-title">
                    Cachet et signature de l'administration
                </p>

            </div>


        </div>



        <!-- =====================================================
             PIED DE PAGE
        ====================================================== -->

        <footer class="receipt-footer">

            <p class="footer-note">
                {{ $company?->footer_text ?? 'Reçu officiel d’inscription scolaire' }}
            </p>

            <p class="footer-note">
                Document généré le {{ $dateGeneration }}
            </p>

            <p class="footer-note">
                Merci de conserver ce reçu pour toute démarche administrative.
            </p>

        </footer>


    </div>

</div>



<!-- =============================================================
     JAVASCRIPT
============================================================== -->

<script>

    function imprimerRecu() {

        window.print();

    }

</script>


</body>
</html>
