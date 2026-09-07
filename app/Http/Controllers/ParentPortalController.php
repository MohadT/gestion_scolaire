<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Support\Facades\Auth;

class ParentPortalController extends Controller
{
    /**
     * ============================================================
     * TABLEAU DE BORD DU PARENT
     * ============================================================
     */
    public function index()
    {
        $parent = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Récupération des enfants du parent
        |--------------------------------------------------------------------------
        |
        | On récupère uniquement les enfants rattachés à ce parent
        | et appartenant à son établissement.
        |
        */

        $enfants = $parent->enfants()
            ->wherePivot(
                'company_id',
                $parent->company_id
            )
            ->with([
                /*
                |--------------------------------------------------------------------------
                | INSCRIPTIONS
                |--------------------------------------------------------------------------
                */
                'inscriptions.classe',
                'inscriptions.anneeScolaire',

                /*
                |--------------------------------------------------------------------------
                | NOTES
                |--------------------------------------------------------------------------
                */
                'notes',

                /*
                |--------------------------------------------------------------------------
                | ÉVALUATION DE LA NOTE
                |--------------------------------------------------------------------------
                */
                'notes.evaluation',

                /*
                |--------------------------------------------------------------------------
                | MATIÈRE
                |--------------------------------------------------------------------------
                */
                'notes.evaluation.matiere',

                /*
                |--------------------------------------------------------------------------
                | CLASSE DE L'ÉVALUATION
                |--------------------------------------------------------------------------
                */
                'notes.evaluation.classe',

                /*
                |--------------------------------------------------------------------------
                | ANNÉE SCOLAIRE DE L'ÉVALUATION
                |--------------------------------------------------------------------------
                */
                'notes.evaluation.anneeScolaire',
            ])
            ->orderBy(
                'nom_etudiant'
            )
            ->orderBy(
                'prenom_etudiant'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CALCUL DE LA MOYENNE DE CHAQUE ENFANT
        |--------------------------------------------------------------------------
        */

        foreach ($enfants as $enfant) {

            $notes = $enfant->notes;

            if ($notes->count() > 0) {

                $enfant->moyenne_parent =
                    $notes->avg('note');

            } else {

                $enfant->moyenne_parent = 0;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'portal.parent.index',
            compact('enfants')
        );
    }


    /**
     * ============================================================
     * DOSSIER COMPLET D'UN ENFANT
     * ============================================================
     */
    public function child(Etudiant $etudiant)
    {
        $parent = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DU RATTACHEMENT
        |--------------------------------------------------------------------------
        |
        | Un parent ne doit pouvoir consulter que ses propres enfants.
        |
        */

        $enfantAutorise = $parent->enfants()
            ->wherePivot(
                'company_id',
                $parent->company_id
            )
            ->where(
                'etudiants.id',
                $etudiant->id
            )
            ->exists();


        if (!$enfantAutorise) {

            abort(403);

        }


        /*
        |--------------------------------------------------------------------------
        | CHARGEMENT DES INFORMATIONS DE L'ENFANT
        |--------------------------------------------------------------------------
        */

        $etudiant->load([

            'inscriptions.classe',

            'inscriptions.anneeScolaire',

            'notes',

            'notes.evaluation',

            'notes.evaluation.matiere',

            'notes.evaluation.classe',

            'notes.evaluation.anneeScolaire',

        ]);


        /*
        |--------------------------------------------------------------------------
        | MOYENNE
        |--------------------------------------------------------------------------
        */

        $average = $etudiant->notes->count() > 0
            ? $etudiant->notes->avg('note')
            : 0;


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DU DOSSIER
        |--------------------------------------------------------------------------
        */

        return view(
            'portal.parent.child',
            compact(
                'etudiant',
                'average'
            )
        );
    }
}
