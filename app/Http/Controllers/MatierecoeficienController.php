<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatiereCoeficient;
use App\Models\Matiere;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class MatierecoeficienController extends Controller
{
    /**
     * Afficher la liste des coefficients
     * uniquement pour l'utilisateur connecté.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $matiereCoeficients = MatiereCoeficient::query()
            

            // Recherche par matière ou classe
            ->when($search, function ($query, $search) {

                $query->whereHas('matiere', function ($q) use ($search) {

                    $q->where(
                        'nom_matiere',
                        'like',
                        '%' . $search . '%'
                    );

                })
                ->orWhereHas('classe', function ($q) use ($search) {

                    $q->where(
                        'nom_classe',
                        'like',
                        '%' . $search . '%'
                    );

                });

            })

            ->with(['matiere', 'classe'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.matiere_coeficiens.index',
            compact('matiereCoeficients')
        );
    }


    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        // Uniquement les matières de l'utilisateur connecté
        $matieres = Matiere::query()
            ->orderBy('nom_matiere')
            ->get();

        // Uniquement les classes de l'utilisateur connecté
        $classes = Classe::query()
            ->orderBy('nom_classe')
            ->get();

        return view(
            'admin.matiere_coeficiens.create',
            compact('matieres', 'classes')
        );
    }


    /**
     * Enregistrer une nouvelle association
     * classe / matière.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'classe_id' => 'required|integer',

            'matiere_id' => 'required|integer',

            'coefficient' => 'required|numeric|min:0',

            'nombre_heure' => 'required|string|max:255',

        ]);


        /*
         * Vérification SaaS :
         *
         * La classe doit appartenir
         * à l'utilisateur connecté.
         */
        $classe = Classe::query()
            ->findOrFail($validatedData['classe_id']);


        /*
         * La matière doit également appartenir
         * à l'utilisateur connecté.
         */
        $matiere = Matiere::query()
            ->findOrFail($validatedData['matiere_id']);


        /*
         * Empêcher d'affecter deux fois
         * la même matière à la même classe.
         */
        $existe = MatiereCoeficient::query()
            ->where('classe_id', $classe->id)
            ->where('matiere_id', $matiere->id)
            ->exists();


        if ($existe) {

            return back()
                ->withInput()
                ->with('error', 'Cette matière est déjà affectée à cette classe.');

        }


        // Ajouter automatiquement le propriétaire SaaS
        $validatedData['company_id'] = Auth::user()->company_id;
        $validatedData['user_id'] = Auth::id();


        MatiereCoeficient::create($validatedData);


        return redirect()
            ->route('matiere_coeficients.index')
            ->with(
                'success',
                'La matière a été affectée à la classe avec succès.'
            );
    }


    /**
     * Afficher une affectation.
     */
    public function show(string $id)
    {
        $matiereCoeficient = MatiereCoeficient::where(
                'company_id',
                Auth::user()->company_id
            )
            ->with(['matiere', 'classe'])
            ->findOrFail($id);


        return view(
            'admin.matiere_coeficiens.show',
            compact('matiereCoeficient')
        );
    }


    /**
     * Afficher le formulaire de modification.
     */
    public function edit(string $id)
    {
        $matiereCoeficient = MatiereCoeficient::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        // Matières appartenant au compte connecté
        $matieres = Matiere::query()
            ->orderBy('nom_matiere')
            ->get();


        // Classes appartenant au compte connecté
        $classes = Classe::query()
            ->orderBy('nom_classe')
            ->get();


        return view(
            'admin.matiere_coeficiens.edit',
            compact(
                'matiereCoeficient',
                'matieres',
                'classes'
            )
        );
    }


    /**
     * Mettre à jour une affectation.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([

            'classe_id' => 'required|integer',

            'matiere_id' => 'required|integer',

            'coefficient' => 'required|numeric|min:0',

            'nombre_heure' => 'required|string|max:255',

        ]);


        /*
         * Récupérer uniquement une affectation
         * appartenant à l'utilisateur connecté.
         */
        $matiereCoeficient = MatiereCoeficient::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        /*
         * Vérifier que la nouvelle classe
         * appartient à l'utilisateur.
         */
        $classe = Classe::query()
            ->findOrFail($validatedData['classe_id']);


        /*
         * Vérifier que la nouvelle matière
         * appartient à l'utilisateur.
         */
        $matiere = Matiere::query()
            ->findOrFail($validatedData['matiere_id']);


        /*
         * Vérifier qu'une autre affectation
         * identique n'existe pas.
         */
        $existe = MatiereCoeficient::query()
            ->where('classe_id', $classe->id)
            ->where('matiere_id', $matiere->id)
            ->where('id', '!=', $matiereCoeficient->id)
            ->exists();


        if ($existe) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Cette matière est déjà affectée à cette classe.'
                );

        }


        $matiereCoeficient->update($validatedData);


        return redirect()
            ->route('matiere_coeficients.index')
            ->with(
                'success',
                'L\'affectation de la matière a été modifiée avec succès.'
            );
    }


    /**
     * Supprimer une affectation.
     */
    public function destroy(string $id)
    {
        /*
         * Sécurité SaaS :
         * impossible de supprimer une affectation
         * appartenant à un autre utilisateur.
         */
        $matiereCoeficient = MatiereCoeficient::where(
                'company_id',
                Auth::user()->company_id
            )
            ->findOrFail($id);


        $matiereCoeficient->delete();


        return redirect()
            ->route('matiere_coeficients.index')
            ->with(
                'success',
                'L\'affectation de la matière a été supprimée avec succès.'
            );
    }
}

