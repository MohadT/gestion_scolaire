<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | On récupère uniquement les étudiants de l'utilisateur connecté
        |--------------------------------------------------------------------------
        */
        $query = Etudiant::query();

        /*
        |--------------------------------------------------------------------------
        | Recherche par code étudiant
        |--------------------------------------------------------------------------
        */
        if ($request->filled('code')) {
            $query->where(
                'code_etudiant',
                'like',
                '%' . $request->code . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Recherche par nom
        |--------------------------------------------------------------------------
        */
        if ($request->filled('nom')) {
            $query->where(
                'nom_etudiant',
                'like',
                '%' . $request->nom . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Recherche par prénom
        |--------------------------------------------------------------------------
        */
        if ($request->filled('prenom')) {
            $query->where(
                'prenom_etudiant',
                'like',
                '%' . $request->prenom . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Recherche par nom du tuteur
        |--------------------------------------------------------------------------
        */
        if ($request->filled('tuteur')) {
            $query->where(
                'nom_du_tuteur',
                'like',
                '%' . $request->tuteur . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Tri
        |--------------------------------------------------------------------------
        */
        $etudiants = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.etudiants.index',
            compact('etudiants')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.etudiants.create');
    }


/**
 * Store newly created students in storage.
 */
public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiants' => 'required|array|min:1',
            'etudiants.*.nom_etudiant' => 'required|string|max:255',
            'etudiants.*.prenom_etudiant' => 'required|string|max:255',
            'etudiants.*.adresse_etudiant' => 'required|string|max:255',
            'etudiants.*.nom_du_tuteur' => 'required|string|max:255',
            'etudiants.*.numero_du_tuteur' => 'required|string|max:255',
            'etudiants.*.identifiant' => 'required|string|max:255|distinct|unique:users,identifiant',
            'etudiants.*.email' => 'required|email|max:255|distinct|unique:users,email',
            'etudiants.*.password' => 'required|string|min:8|confirmed',
        ]);

        $companyId = (int) Auth::user()->company_id;

        DB::transaction(function () use ($validated, $companyId) {
            foreach ($validated['etudiants'] as $data) {
                do {
                    $code = 'ETUDIANT' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
                } while (Etudiant::where('code_etudiant', $code)->exists());

                $user = User::create([
                    'company_id' => $companyId,
                    'identifiant' => $data['identifiant'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => 'etudiant',
                ]);

                Etudiant::create([
                    'company_id' => $companyId,
                    'code_etudiant' => $code,
                    'nom_etudiant' => $data['nom_etudiant'],
                    'prenom_etudiant' => $data['prenom_etudiant'],
                    'adresse_etudiant' => $data['adresse_etudiant'],
                    'nom_du_tuteur' => $data['nom_du_tuteur'],
                    'numero_du_tuteur' => $data['numero_du_tuteur'],
                    'user_id' => $user->id,
                ]);
            }
        });

        return redirect()->route('etudiants.index')->with('success', count($validated['etudiants']) . ' étudiant(s) ajouté(s) avec leur compte de connexion.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Sécurité :
        | l'utilisateur ne peut voir que ses propres étudiants
        |--------------------------------------------------------------------------
        */
        $etudiant = Etudiant::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($id);


        return view(
            'admin.etudiants.show',
            compact('etudiant')
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Sécurité :
        | l'utilisateur ne peut modifier que ses propres étudiants
        |--------------------------------------------------------------------------
        */
        $etudiant = Etudiant::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($id);


        return view(
            'admin.etudiants.edit',
            compact('etudiant')
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Récupérer uniquement un étudiant appartenant
        | à l'utilisateur connecté
        |--------------------------------------------------------------------------
        */
        $etudiant = Etudiant::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */
        $validatedData = $request->validate([
            'nom_etudiant' => 'required|string|max:255',
            'prenom_etudiant' => 'required|string|max:255',
            'adresse_etudiant' => 'required|string|max:255',
            'nom_du_tuteur' => 'required|string|max:255',
            'numero_du_tuteur' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT :
        | Le code étudiant n'est jamais modifié ici.
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | Gestion de la photo
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('photo')) {

            /*
            | Supprimer l'ancienne photo
            */
            if (
                $etudiant->photo &&
                Storage::disk('public')->exists(
                    $etudiant->photo
                )
            ) {
                Storage::disk('public')->delete(
                    $etudiant->photo
                );
            }


            /*
            | Enregistrer la nouvelle photo
            */
            $validatedData['photo'] = $request
                ->file('photo')
                ->store('photos', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Mise à jour
        |--------------------------------------------------------------------------
        */
        $etudiant->update($validatedData);


        return redirect()
            ->route(
                'etudiants.show',
                $etudiant->id
            )
            ->with(
                'success',
                'Étudiant mis à jour avec succès.'
            );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Sécurité :
        | l'utilisateur ne peut supprimer que ses propres étudiants
        |--------------------------------------------------------------------------
        */
        $etudiant = Etudiant::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Supprimer la photo
        |--------------------------------------------------------------------------
        */
        if (
            $etudiant->photo &&
            Storage::disk('public')->exists(
                $etudiant->photo
            )
        ) {
            Storage::disk('public')->delete(
                $etudiant->photo
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer l'étudiant
        |--------------------------------------------------------------------------
        */
        $etudiant->delete();


        return redirect()
            ->route('etudiants.index')
            ->with(
                'success',
                'Étudiant supprimé avec succès.'
            );
    }


    /**
     * Affecter un étudiant à une classe.
     */
    public function affecte_Classe($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Sécurité :
        | l'utilisateur ne peut affecter que ses propres étudiants
        |--------------------------------------------------------------------------
        */
        $etudiant = Etudiant::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($id);


        return view(
            'admin.etudiants.affecte_classe',
            compact('etudiant')
        );
    }
}
