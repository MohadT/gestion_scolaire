<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\MatiereCoeficient;
use App\Models\Annee_scolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * =========================================================
     * LISTE DES NOTES
     * =========================================================
     */
    public function index(Request $request)
    {
        $notes = Note::query()
            ->with([
                'etudiant',
                'evaluation.matiere',
                'evaluation.classe',
                'evaluation.professeur',
                'evaluation.anneeScolaire',
            ])

            ->when($request->annee_scolaire_id, function ($query, $anneeId) {

                $query->whereHas('evaluation', function ($q) use ($anneeId) {

                    $q->where(
                        'annee_scolaire_id',
                        $anneeId
                    );

                });

            })

            ->when($request->classe_id, function ($query, $classeId) {

                $query->whereHas('evaluation', function ($q) use ($classeId) {

                    $q->where(
                        'classe_id',
                        $classeId
                    );

                });

            })

            ->when($request->matiere_id, function ($query, $matiereId) {

                $query->whereHas('evaluation', function ($q) use ($matiereId) {

                    $q->where(
                        'matiere_id',
                        $matiereId
                    );

                });

            })

            ->when($request->search, function ($query, $search) {

                $query->whereHas('etudiant', function ($q) use ($search) {

                    $q->where(
                        'nom_etudiant',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'prenom_etudiant',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'code_etudiant',
                        'like',
                        '%' . $search . '%'
                    );

                });

            })

            ->latest()
            ->paginate(15)
            ->withQueryString();


        $anneesScolaires = Annee_scolaire::where(
                'company_id',
                Auth::user()->company_id
            )
            ->latest()
            ->get();


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


        return view(
            'admin.notes.index',
            compact(
                'notes',
                'anneesScolaires',
                'classes',
                'matieres'
            )
        );
    }


    /**
     * =========================================================
     * SAISIE DES NOTES
     * =========================================================
     */
    public function create(Request $request)
    {
        if (!$request->evaluation_id) {

            return redirect()
                ->route('evaluations.index')
                ->with(
                    'error',
                    'Veuillez sélectionner une évaluation.'
                );
        }


        $evaluation = Evaluation::where(
                'company_id',
                Auth::user()->company_id
            )
            ->with([
                'matiere',
                'classe',
                'professeur',
                'anneeScolaire',
            ])
            ->findOrFail(
                $request->evaluation_id
            );


        /*
        |--------------------------------------------------------------------------
        | Les étudiants sont récupérés par les inscriptions
        |--------------------------------------------------------------------------
        */

        $etudiants = Inscription::where(
                'company_id',
                Auth::user()->company_id
            )
            ->where(
                'classe_id',
                $evaluation->classe_id
            )
            ->where(
                'annee_scolaire_id',
                $evaluation->annee_scolaire_id
            )
            ->with('etudiant')
            ->get()
            ->pluck('etudiant')
            ->filter()
            ->sortBy(function ($etudiant) {

                return strtolower(
                    $etudiant->nom_etudiant .
                    ' ' .
                    $etudiant->prenom_etudiant
                );

            })
            ->values();


        return view(
            'admin.notes.create',
            compact(
                'evaluation',
                'etudiants'
            )
        );
    }


    /**
     * =========================================================
     * ENREGISTRER LES NOTES
     * =========================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'evaluation_id' => [
                'required',
                'exists:evaluations,id',
            ],

            'notes' => [
                'required',
                'array',
            ],

            'notes.*.note' => [
                'nullable',
                'numeric',
                'min:0',
                'max:20',
            ],

            'notes.*.appreciation' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        $evaluation = Evaluation::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail(
                $validated['evaluation_id']
            );


        /*
        |--------------------------------------------------------------------------
        | Étudiants autorisés
        |--------------------------------------------------------------------------
        */

        $etudiantIds = Inscription::where(
                'company_id',
                Auth::user()->company_id
            )
            ->where(
                'classe_id',
                $evaluation->classe_id
            )
            ->where(
                'annee_scolaire_id',
                $evaluation->annee_scolaire_id
            )
            ->pluck('etudiant_id')
            ->toArray();


        foreach ($validated['notes'] as $etudiantId => $data) {

            if (
                !isset($data['note']) ||
                $data['note'] === '' ||
                $data['note'] === null
            ) {
                continue;
            }


            if (
                !in_array(
                    (int) $etudiantId,
                    array_map('intval', $etudiantIds)
                )
            ) {
                continue;
            }


            Note::updateOrCreate(

                [
                    'etudiant_id' => $etudiantId,
                    'evaluation_id' => $evaluation->id,
                ],

                [
                    'note' => $data['note'],

                    'appreciation' =>
                        $data['appreciation'] ?? null,

                    'user_id' => Auth::id(),
                ]

            );
        }


        return redirect()
            ->route(
                'evaluations.show',
                $evaluation->id
            )
            ->with(
                'success',
                'Les notes ont été enregistrées avec succès.'
            );
    }


    /**
     * =========================================================
     * AFFICHER UNE NOTE
     * =========================================================
     */
    public function show(string $id)
    {
        $note = Note::where(
                'company_id',
                Auth::user()->company_id
            )
            ->with([
                'etudiant',
                'evaluation.matiere',
                'evaluation.classe',
                'evaluation.professeur',
                'evaluation.anneeScolaire',
            ])
            ->findOrFail($id);


        return view(
            'admin.notes.show',
            compact('note')
        );
    }


    /**
     * =========================================================
     * MODIFIER UNE NOTE
     * =========================================================
     */
    public function edit(string $id)
    {
        $note = Note::where(
                'company_id',
                Auth::user()->company_id
            )
            ->with([
                'etudiant',
                'evaluation.matiere',
                'evaluation.classe',
                'evaluation.professeur',
                'evaluation.anneeScolaire',
            ])
            ->findOrFail($id);


        return view(
            'admin.notes.edit',
            compact('note')
        );
    }


    /**
     * =========================================================
     * UPDATE NOTE
     * =========================================================
     */
    public function update(
        Request $request,
        string $id
    ) {

        $validated = $request->validate([

            'note' => [
                'required',
                'numeric',
                'min:0',
                'max:20',
            ],

            'appreciation' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        $note = Note::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        $note->update([

            'note' => $validated['note'],

            'appreciation' =>
                $validated['appreciation'] ?? null,

        ]);


        return redirect()
            ->route(
                'notes.show',
                $note->id
            )
            ->with(
                'success',
                'Note modifiée avec succès.'
            );
    }


    /**
     * =========================================================
     * SUPPRIMER UNE NOTE
     * =========================================================
     */
    public function destroy(string $id)
    {
        $note = Note::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        $note->delete();


        return redirect()
            ->route('notes.index')
            ->with(
                'success',
                'Note supprimée avec succès.'
            );
    }


    /**
     * =========================================================
     * PAGE DE SÉLECTION DU BULLETIN
     * =========================================================
     *
     * Cette méthode est appelée depuis le menu :
     *
     * route('notes.bulletin')
     *
     * Elle affiche simplement les filtres.
     *
     */
  public function bulletin(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | ANNÉES SCOLAIRES
    |--------------------------------------------------------------------------
    */

    $anneesScolaires = Annee_scolaire::where(
            'company_id',
            Auth::user()->company_id
        )
        ->latest()
        ->get();


    /*
    |--------------------------------------------------------------------------
    | CLASSES
    |--------------------------------------------------------------------------
    */

    $classes = Classe::where(
            'company_id',
            Auth::user()->company_id
        )
        ->orderBy('nom_classe')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | ÉTUDIANTS
    |--------------------------------------------------------------------------
    */

    $etudiants = Etudiant::where(
            'company_id',
            Auth::user()->company_id
        )
        ->orderBy('nom_etudiant')
        ->orderBy('prenom_etudiant')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | SI ANNÉE + CLASSE SONT SÉLECTIONNÉES
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('annee_scolaire_id') &&
        $request->filled('classe_id')
    ) {

        $etudiantIds = Inscription::where(
                'company_id',
                Auth::user()->company_id
            )
            ->where(
                'annee_scolaire_id',
                $request->annee_scolaire_id
            )
            ->where(
                'classe_id',
                $request->classe_id
            )
            ->pluck('etudiant_id');


        $etudiants = Etudiant::where(
                'company_id',
                Auth::user()->company_id
            )
            ->whereIn(
                'id',
                $etudiantIds
            )
            ->orderBy('nom_etudiant')
            ->orderBy('prenom_etudiant')
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | SI L'ÉTUDIANT EST SÉLECTIONNÉ
    |--------------------------------------------------------------------------
    |
    | On quitte la page de sélection et on va vers le vrai bulletin.
    |
    */

    if (
        $request->filled('etudiant_id') &&
        $request->filled('annee_scolaire_id')
    ) {

        return redirect()->route(
            'notes.bulletin.afficher',
            [
                'etudiant_id' =>
                    $request->etudiant_id,

                'annee_scolaire_id' =>
                    $request->annee_scolaire_id,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE DE SÉLECTION
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.notes.bulletin-selection',
        compact(
            'anneesScolaires',
            'classes',
            'etudiants'
        )
    );
}

    /**
     * =========================================================
     * AFFICHER LE VRAI BULLETIN
     * =========================================================
     */
    public function bulletinAfficher(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'etudiant_id' => [
                'required',
                'exists:etudiants,id',
            ],

            'annee_scolaire_id' => [
                'required',
                'exists:annee_scolaires,id',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Étudiant
        |--------------------------------------------------------------------------
        */

        $etudiant = Etudiant::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail(
                $validated['etudiant_id']
            );


        /*
        |--------------------------------------------------------------------------
        | Année scolaire
        |--------------------------------------------------------------------------
        */

        $anneeScolaire = Annee_scolaire::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail(
                $validated['annee_scolaire_id']
            );


        /*
        |--------------------------------------------------------------------------
        | Inscription
        |--------------------------------------------------------------------------
        */

        $inscription = Inscription::where(
                'company_id',
                Auth::user()->company_id
            )
            ->where(
                'etudiant_id',
                $etudiant->id
            )
            ->where(
                'annee_scolaire_id',
                $anneeScolaire->id
            )
            ->with('classe')
            ->first();


        if (!$inscription) {

            return back()
                ->with(
                    'error',
                    'Cet étudiant n\'est pas inscrit pour cette année scolaire.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Classe
        |--------------------------------------------------------------------------
        */

        $classe = $inscription->classe;


        if (!$classe) {

            return back()
                ->with(
                    'error',
                    'La classe de cet étudiant est introuvable.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Notes
        |--------------------------------------------------------------------------
        */

        $notes = Note::where(
                'company_id',
                Auth::user()->company_id
            )
            ->where(
                'etudiant_id',
                $etudiant->id
            )
            ->whereHas(
                'evaluation',
                function ($query) use (
                    $classe,
                    $anneeScolaire
                ) {

                    $query
                        ->where(
                            'classe_id',
                            $classe->id
                        )
                        ->where(
                            'annee_scolaire_id',
                            $anneeScolaire->id
                        );

                }
            )
            ->with([
                'evaluation.matiere',
                'evaluation.professeur',
                'evaluation.classe',
                'evaluation.anneeScolaire',
            ])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Regrouper les notes par matière
        |--------------------------------------------------------------------------
        */

        $matieres = $notes->groupBy(
            function ($note) {

                return $note->evaluation->matiere_id;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Construire le bulletin
        |--------------------------------------------------------------------------
        */

        $bulletin = collect();


        foreach (
            $matieres as $matiereId => $notesMatiere
        ) {

            $premiereNote = $notesMatiere->first();


            if (
                !$premiereNote ||
                !$premiereNote->evaluation ||
                !$premiereNote->evaluation->matiere
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Matière
            |--------------------------------------------------------------------------
            */

            $matiere =
                $premiereNote
                    ->evaluation
                    ->matiere;


            /*
            |--------------------------------------------------------------------------
            | Moyenne
            |--------------------------------------------------------------------------
            */

            $moyenne =
                $notesMatiere->avg('note');


            /*
            |--------------------------------------------------------------------------
            | Coefficient
            |--------------------------------------------------------------------------
            */

            $coefficient = MatiereCoeficient::where(
                    'user_id',
                    Auth::id()
                )
                ->where(
                    'classe_id',
                    $classe->id
                )
                ->where(
                    'matiere_id',
                    $matiereId
                )
                ->value('coefficient');


            if (
                $coefficient === null ||
                $coefficient === ''
            ) {

                $coefficient = 1;

            }


            /*
            |--------------------------------------------------------------------------
            | Points
            |--------------------------------------------------------------------------
            */

            $points =
                $moyenne * $coefficient;


            /*
            |--------------------------------------------------------------------------
            | Appréciation
            |--------------------------------------------------------------------------
            */

            if ($moyenne >= 16) {

                $appreciation = 'Excellent';

            } elseif ($moyenne >= 14) {

                $appreciation = 'Très bien';

            } elseif ($moyenne >= 12) {

                $appreciation = 'Bien';

            } elseif ($moyenne >= 10) {

                $appreciation = 'Assez bien';

            } elseif ($moyenne >= 8) {

                $appreciation = 'Insuffisant';

            } else {

                $appreciation = 'Très insuffisant';

            }


            /*
            |--------------------------------------------------------------------------
            | Ajouter au bulletin
            |--------------------------------------------------------------------------
            */

            $bulletin->push([

                'matiere' => $matiere,

                'notes' => $notesMatiere,

                'moyenne' => round(
                    $moyenne,
                    2
                ),

                'coefficient' => $coefficient,

                'points' => round(
                    $points,
                    2
                ),

                'appreciation' => $appreciation,

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Trier les matières
        |--------------------------------------------------------------------------
        */

        $bulletin = $bulletin
            ->sortBy(function ($ligne) {

                return strtolower(
                    $ligne['matiere']->nom_matiere
                );

            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Total coefficients
        |--------------------------------------------------------------------------
        */

        $totalCoefficients =
            $bulletin->sum('coefficient');


        /*
        |--------------------------------------------------------------------------
        | Total points
        |--------------------------------------------------------------------------
        */

        $totalPoints =
            $bulletin->sum('points');


        /*
        |--------------------------------------------------------------------------
        | Moyenne générale
        |--------------------------------------------------------------------------
        */

        if ($totalCoefficients > 0) {

            $moyenneGenerale =
                $totalPoints /
                $totalCoefficients;

        } else {

            $moyenneGenerale = 0;

        }


        $moyenneGenerale =
            round(
                $moyenneGenerale,
                2
            );


        /*
        |--------------------------------------------------------------------------
        | Appréciation générale
        |--------------------------------------------------------------------------
        */

        if ($moyenneGenerale >= 16) {

            $appreciationGenerale =
                'Excellent travail';

        } elseif ($moyenneGenerale >= 14) {

            $appreciationGenerale =
                'Très bon travail';

        } elseif ($moyenneGenerale >= 12) {

            $appreciationGenerale =
                'Bon travail';

        } elseif ($moyenneGenerale >= 10) {

            $appreciationGenerale =
                'Travail satisfaisant';

        } elseif ($moyenneGenerale >= 8) {

            $appreciationGenerale =
                'Travail insuffisant';

        } else {

            $appreciationGenerale =
                'Résultats très insuffisants';

        }


        /*
        |--------------------------------------------------------------------------
        | Vue finale du bulletin
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.notes.bulletin',
            compact(
                'etudiant',
                'anneeScolaire',
                'inscription',
                'classe',
                'bulletin',
                'totalCoefficients',
                'totalPoints',
                'moyenneGenerale',
                'appreciationGenerale'
            )
        );
    }
}
