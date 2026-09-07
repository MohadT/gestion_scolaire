<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Emploidutemps;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Annee_scolaire;

class EmploidutempsController extends Controller
{
    /**
     * Liste des emplois du temps
     */
  public function index(Request $request)
{
    $search = $request->input('search');
    $anneeScolaireId = $request->input('annee_scolaire_id');
    $classeId = $request->input('classe_id');
    $jour = $request->input('jour');


    /*
    |--------------------------------------------------------------------------
    | Emplois du temps
    |--------------------------------------------------------------------------
    */

    $emplois = Emploidutemps::where(
            'company_id',
            Auth::user()->company_id
        )

        ->with([
            'anneeScolaire',
            'classe',
            'matiere',
            'professeur',
        ])


        /*
        |--------------------------------------------------------------------------
        | Filtre année scolaire
        |--------------------------------------------------------------------------
        */

        ->when(
            $anneeScolaireId,
            function ($query) use ($anneeScolaireId) {

                $query->where(
                    'annee_scolaire_id',
                    $anneeScolaireId
                );

            }
        )


        /*
        |--------------------------------------------------------------------------
        | Filtre classe
        |--------------------------------------------------------------------------
        */

        ->when(
            $classeId,
            function ($query) use ($classeId) {

                $query->where(
                    'classe_id',
                    $classeId
                );

            }
        )


        /*
        |--------------------------------------------------------------------------
        | Filtre jour
        |--------------------------------------------------------------------------
        */

        ->when(
            $jour,
            function ($query) use ($jour) {

                $query->where(
                    'jour',
                    $jour
                );

            }
        )


        /*
        |--------------------------------------------------------------------------
        | Recherche rapide
        |--------------------------------------------------------------------------
        */

        ->when(
            $search,
            function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'jour',
                        'like',
                        '%' . $search . '%'
                    )


                    ->orWhereHas(
                        'classe',
                        function ($q) use ($search) {

                            $q->where(
                                'nom_classe',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    )


                    ->orWhereHas(
                        'matiere',
                        function ($q) use ($search) {

                            $q->where(
                                'nom_matiere',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    )


                    ->orWhereHas(
                        'professeur',
                        function ($q) use ($search) {

                            $q->where(
                                'nom_prof',
                                'like',
                                '%' . $search . '%'
                            )

                            ->orWhere(
                                'prenom_prof',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    );

                });

            }
        )


        /*
        |--------------------------------------------------------------------------
        | Tri
        |--------------------------------------------------------------------------
        */

        ->orderByRaw("
            CASE jour
                WHEN 'Lundi' THEN 1
                WHEN 'Mardi' THEN 2
                WHEN 'Mercredi' THEN 3
                WHEN 'Jeudi' THEN 4
                WHEN 'Vendredi' THEN 5
                WHEN 'Samedi' THEN 6
                WHEN 'Dimanche' THEN 7
                ELSE 8
            END
        ")

        ->orderBy('heure_debut')

        ->paginate(10)

        ->withQueryString();


    /*
    |--------------------------------------------------------------------------
    | Données des filtres
    |--------------------------------------------------------------------------
    */

    $classes = Classe::where(
            'company_id',
            Auth::user()->company_id
        )
        ->orderBy('nom_classe')
        ->get();


    $anneesScolaires = Annee_scolaire::where(
            'company_id',
            Auth::user()->company_id
        )
        ->latest()
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Vue
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.emploi_du_temps.index',
        compact(
            'emplois',
            'classes',
            'anneesScolaires',
            'anneeScolaireId',
            'classeId',
            'jour',
            'search'
        )
    );
}


    /**
     * Formulaire de création
     */
    public function create()
    {
        $classes = Classe::where(
                'company_id',
                Auth::user()->company_id
            )
            ->orderBy('nom_classe')
            ->get();


        $matieres = Matiere::where(
                'company_id',
                Auth::user()->company_id
            )
            ->orderBy('nom_matiere')
            ->get();


        $professeurs = Professeur::where(
                'company_id',
                Auth::user()->company_id
            )
            ->orderBy('nom_prof')
            ->orderBy('prenom_prof')
            ->get();


        $anneesScolaires = Annee_scolaire::where(
                'company_id',
                Auth::user()->company_id
            )
            ->latest()
            ->get();


        return view(
            'admin.emploi_du_temps.create',
            compact(
                'classes',
                'matieres',
                'professeurs',
                'anneesScolaires'
            )
        );
    }


    /**
     * Enregistrer plusieurs créneaux
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'annee_scolaire_id' => [
                'required',
                'integer',
            ],

            'classe_id' => [
                'required',
                'integer',
            ],

            'emplois' => [
                'required',
                'array',
                'min:1',
            ],

            'emplois.*.jour' => [
                'required',
                'string',
                'max:255',
            ],

            'emplois.*.matiere_id' => [
                'required',
                'integer',
            ],

            'emplois.*.prof_id' => [
                'required',
                'integer',
            ],

            'emplois.*.heure_debut' => [
                'required',
                'date_format:H:i',
            ],

            'emplois.*.heure_fin' => [
                'required',
                'date_format:H:i',
            ],

        ]);


        // Vérifier l'année scolaire
        Annee_scolaire::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validatedData['annee_scolaire_id']
        );


        // Vérifier la classe
        Classe::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validatedData['classe_id']
        );


        foreach ($validatedData['emplois'] as $creneau) {

            // Vérifier les heures
            if (
                $creneau['heure_fin']
                <=
                $creneau['heure_debut']
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'emplois' =>
                            "L'heure de fin doit être supérieure à l'heure de début."
                    ]);
            }


            // Vérifier la matière
            Matiere::where(
                'company_id',
                Auth::user()->company_id
            )->findOrFail(
                $creneau['matiere_id']
            );


            // Vérifier le professeur
            Professeur::where(
                'company_id',
                Auth::user()->company_id
            )->findOrFail(
                $creneau['prof_id']
            );


            // Création
            Emploidutemps::create([

                'annee_scolaire_id' =>
                    $validatedData['annee_scolaire_id'],

                'classe_id' =>
                    $validatedData['classe_id'],

                'matiere_id' =>
                    $creneau['matiere_id'],

                'prof_id' =>
                    $creneau['prof_id'],

                'jour' =>
                    $creneau['jour'],

                'heure_debut' =>
                    $creneau['heure_debut'],

                'heure_fin' =>
                    $creneau['heure_fin'],

                'user_id' =>
                    Auth::id(),

            ]);
        }


        return redirect()
            ->route('emplois.index')
            ->with(
                'success',
                'Emploi du temps créé avec succès.'
            );
    }


    /**
     * Afficher un emploi du temps
     */
    public function show(string $id)
    {
        $emploi = Emploidutemps::where(
                'company_id',
                Auth::user()->company_id
            )
            ->with([
                'anneeScolaire',
                'classe',
                'matiere',
                'professeur',
            ])
            ->findOrFail($id);


        return view(
            'admin.emploi_du_temps.show',
            compact('emploi')
        );
    }


    /**
     * Formulaire de modification
     */
    public function edit(string $id)
    {
        $emploi = Emploidutemps::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        $classes = Classe::where(
                'company_id',
                Auth::user()->company_id
            )
            ->orderBy('nom_classe')
            ->get();


        $matieres = Matiere::where(
                'company_id',
                Auth::user()->company_id
            )
            ->orderBy('nom_matiere')
            ->get();


        $professeurs = Professeur::where(
                'company_id',
                Auth::user()->company_id
            )
            ->orderBy('nom_prof')
            ->orderBy('prenom_prof')
            ->get();


        $anneesScolaires = Annee_scolaire::where(
                'company_id',
                Auth::user()->company_id
            )
            ->latest()
            ->get();


        return view(
            'admin.emploi_du_temps.edit',
            compact(
                'emploi',
                'classes',
                'matieres',
                'professeurs',
                'anneesScolaires'
            )
        );
    }


    /**
     * Mise à jour
     */
    public function update(Request $request, string $id)
    {
        $emploi = Emploidutemps::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        $validatedData = $request->validate([

            'annee_scolaire_id' => [
                'required',
                'integer',
            ],

            'classe_id' => [
                'required',
                'integer',
            ],

            'matiere_id' => [
                'required',
                'integer',
            ],

            'prof_id' => [
                'required',
                'integer',
            ],

            'jour' => [
                'required',
                'string',
                'max:255',
            ],

            'heure_debut' => [
                'required',
                'date_format:H:i',
            ],

            'heure_fin' => [
                'required',
                'date_format:H:i',
            ],

        ]);


        if (
            $validatedData['heure_fin']
            <=
            $validatedData['heure_debut']
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'heure_fin' =>
                        "L'heure de fin doit être supérieure à l'heure de début."
                ]);
        }


        Annee_scolaire::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validatedData['annee_scolaire_id']
        );


        Classe::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validatedData['classe_id']
        );


        Matiere::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validatedData['matiere_id']
        );


        Professeur::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validatedData['prof_id']
        );


        $emploi->update([

            'annee_scolaire_id' =>
                $validatedData['annee_scolaire_id'],

            'classe_id' =>
                $validatedData['classe_id'],

            'matiere_id' =>
                $validatedData['matiere_id'],

            'prof_id' =>
                $validatedData['prof_id'],

            'jour' =>
                $validatedData['jour'],

            'heure_debut' =>
                $validatedData['heure_debut'],

            'heure_fin' =>
                $validatedData['heure_fin'],

        ]);


        return redirect()
            ->route('emplois.index')
            ->with(
                'success',
                'Emploi du temps modifié avec succès.'
            );
    }


    /**
     * Suppression
     */
    public function destroy(string $id)
    {
        $emploi = Emploidutemps::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        $emploi->delete();


        return redirect()
            ->route('emplois.index')
            ->with(
                'success',
                'Emploi du temps supprimé avec succès.'
            );
    }


    /**
     * Page de sélection de la fiche
     */
    public function fiche()
    {
        $classes = Classe::where(
                'company_id',
                Auth::user()->company_id
            )
            ->orderBy('nom_classe')
            ->get();


        $anneesScolaires = Annee_scolaire::where(
                'company_id',
                Auth::user()->company_id
            )
            ->latest()
            ->get();


        return view(
            'admin.emploi_du_temps.fiche',
            compact(
                'classes',
                'anneesScolaires'
            )
        );
    }


    /**
     * Page blanche de l'emploi du temps
     */
    public function imprimer(Request $request)
    {
        $request->validate([

            'classe_id' => [
                'required',
                'integer',
            ],

            'annee_scolaire_id' => [
                'required',
                'integer',
            ],

        ]);


        // Classe appartenant à l'utilisateur
        $classe = Classe::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail(
                $request->classe_id
            );


        // Année appartenant à l'utilisateur
        $anneeScolaire = Annee_scolaire::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail(
                $request->annee_scolaire_id
            );


        // Récupérer les cours
        $emplois = Emploidutemps::where(
                'company_id',
                Auth::user()->company_id
            )
            ->where(
                'classe_id',
                $classe->id
            )
            ->where(
                'annee_scolaire_id',
                $anneeScolaire->id
            )
            ->with([
                'matiere',
                'professeur',
            ])
            ->orderByRaw("
                CASE jour
                    WHEN 'Lundi' THEN 1
                    WHEN 'Mardi' THEN 2
                    WHEN 'Mercredi' THEN 3
                    WHEN 'Jeudi' THEN 4
                    WHEN 'Vendredi' THEN 5
                    WHEN 'Samedi' THEN 6
                    WHEN 'Dimanche' THEN 7
                    ELSE 8
                END
            ")
            ->orderBy('heure_debut')
            ->get();


        return view(
            'admin.emploi_du_temps.imprimer',
            compact(
                'classe',
                'anneeScolaire',
                'emplois'
            )
        );
    }
}
