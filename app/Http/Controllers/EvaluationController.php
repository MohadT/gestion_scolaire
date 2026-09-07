<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Annee_scolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Liste des évaluations
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $anneeScolaireId = $request->input('annee_scolaire_id');
        $classeId = $request->input('classe_id');
        $matiereId = $request->input('matiere_id');

        $evaluations = Evaluation::where(
                'company_id',
                Auth::user()->company_id
            )
            ->with([
                'classe',
                'matiere',
                'professeur',
                'anneeScolaire',
            ])

            ->when($anneeScolaireId, function ($query) use ($anneeScolaireId) {

                $query->where(
                    'annee_scolaire_id',
                    $anneeScolaireId
                );

            })

            ->when($classeId, function ($query) use ($classeId) {

                $query->where(
                    'classe_id',
                    $classeId
                );

            })

            ->when($matiereId, function ($query) use ($matiereId) {

                $query->where(
                    'matiere_id',
                    $matiereId
                );

            })

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'nom_evaluation',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'type_evaluation',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhereHas('classe', function ($q) use ($search) {

                        $q->where(
                            'nom_classe',
                            'like',
                            '%' . $search . '%'
                        );

                    })

                    ->orWhereHas('matiere', function ($q) use ($search) {

                        $q->where(
                            'nom_matiere',
                            'like',
                            '%' . $search . '%'
                        );

                    });

                });

            })

            ->latest()
            ->paginate(10)
            ->withQueryString();


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


        $anneesScolaires = Annee_scolaire::where(
                'company_id',
                Auth::user()->company_id
            )
            ->latest()
            ->get();


        return view(
            'admin.evaluations.index',
            compact(
                'evaluations',
                'classes',
                'matieres',
                'anneesScolaires',
                'search',
                'anneeScolaireId',
                'classeId',
                'matiereId'
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
            'admin.evaluations.create',
            compact(
                'classes',
                'matieres',
                'professeurs',
                'anneesScolaires'
            )
        );
    }


    /**
     * Enregistrer une évaluation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'matiere_id' => [
                'required',
                'integer',
            ],

            'classe_id' => [
                'required',
                'integer',
            ],

            'professeur_id' => [
                'required',
                'integer',
            ],

            'annee_scolaire_id' => [
                'required',
                'integer',
            ],

            'nom_evaluation' => [
                'required',
                'string',
                'max:255',
            ],

            'type_evaluation' => [
                'required',
                'string',
                'max:255',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Vérifications SaaS
        |--------------------------------------------------------------------------
        */

        Matiere::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validated['matiere_id']
        );


        Classe::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validated['classe_id']
        );


        Professeur::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validated['professeur_id']
        );


        Annee_scolaire::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validated['annee_scolaire_id']
        );


        /*
        |--------------------------------------------------------------------------
        | Création
        |--------------------------------------------------------------------------
        */

        $validated['company_id'] = Auth::user()->company_id;
        $validated['user_id'] = Auth::id();

        Evaluation::create($validated);


        return redirect()
            ->route('evaluations.index')
            ->with(
                'success',
                'Évaluation créée avec succès.'
            );
    }


    /**
     * Afficher une évaluation
     */
    public function show(string $id)
    {
        $evaluation = Evaluation::where(
                'company_id',
                Auth::user()->company_id
            )
            ->with([
                'classe',
                'matiere',
                'professeur',
                'anneeScolaire',
                'notes',
            ])
            ->findOrFail($id);


        return view(
            'admin.evaluations.show',
            compact('evaluation')
        );
    }


    /**
     * Modifier
     */
    public function edit(string $id)
    {
        $evaluation = Evaluation::where(
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
            ->get();


        $anneesScolaires = Annee_scolaire::where(
                'company_id',
                Auth::user()->company_id
            )
            ->latest()
            ->get();


        return view(
            'admin.evaluations.edit',
            compact(
                'evaluation',
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
        $evaluation = Evaluation::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        $validated = $request->validate([

            'matiere_id' => 'required|integer',
            'classe_id' => 'required|integer',
            'professeur_id' => 'required|integer',
            'annee_scolaire_id' => 'required|integer',

            'nom_evaluation' =>
                'required|string|max:255',

            'type_evaluation' =>
                'required|string|max:255',

        ]);


        Matiere::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validated['matiere_id']
        );


        Classe::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validated['classe_id']
        );


        Professeur::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validated['professeur_id']
        );


        Annee_scolaire::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail(
            $validated['annee_scolaire_id']
        );


        $evaluation->update($validated);


        return redirect()
            ->route('evaluations.index')
            ->with(
                'success',
                'Évaluation modifiée avec succès.'
            );
    }


    /**
     * Suppression
     */
    public function destroy(string $id)
    {
        $evaluation = Evaluation::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        $evaluation->delete();


        return redirect()
            ->route('evaluations.index')
            ->with(
                'success',
                'Évaluation supprimée avec succès.'
            );
    }
}
