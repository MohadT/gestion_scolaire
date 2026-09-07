<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Annee_scolaire;
use App\Models\Professeur;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Evaluation;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * ============================================================
     * LISTE DES UTILISATEURS
     * ============================================================
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'identifiant',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $search . '%'
                );

            });
        }

        if ($request->filled('role')) {

            $query->where(
                'role',
                $request->role
            );
        }

        $users = $query
            ->orderBy('identifiant')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.users.index',
            compact('users')
        );
    }


    /**
     * ============================================================
     * FORMULAIRE AJOUT UTILISATEUR
     * ============================================================
     */
    public function createAdmin()
    {
        $etudiants = Etudiant::where('company_id', Auth::user()->company_id)
            ->orderBy('nom_etudiant')
            ->orderBy('prenom_etudiant')
            ->get();

        return view(
            'admin.users.create',
            compact('etudiants')
        );
    }


    /**
     * ============================================================
     * ENREGISTRER UTILISATEUR
     * ============================================================
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'identifiant' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin,professeur,comptable,parent',
            ],

            'etudiant_ids' => [
                'nullable',
                'array',
            ],

            'etudiant_ids.*' => [
                'integer',
                'exists:etudiants,id',
            ],
        ]);

        $companyId = Auth::user()->company_id;

        // Un parent ne peut rattacher que des étudiants de son établissement.
        $etudiantIds = collect($validated['etudiant_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($validated['role'] === 'parent' && $etudiantIds->isNotEmpty()) {
            $validCount = Etudiant::where('company_id', $companyId)
                ->whereIn('id', $etudiantIds)
                ->count();

            if ($validCount !== $etudiantIds->count()) {
                return back()
                    ->withErrors([
                        'etudiant_ids' => 'Un ou plusieurs étudiants ne appartiennent pas à cet établissement.',
                    ])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($validated, $companyId, $etudiantIds) {
            $user = User::create([
                'identifiant' => $validated['identifiant'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'company_id' => $companyId,
            ]);

            if ($user->role === 'parent' && $etudiantIds->isNotEmpty()) {
                $pivotData = $etudiantIds->mapWithKeys(
                    fn ($etudiantId) => [
                        $etudiantId => ['company_id' => $companyId],
                    ]
                )->all();

                $user->enfants()->sync($pivotData);
            }
        });

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Utilisateur ajouté avec succès.'
            );
    }

    /**
     * ============================================================
     * REGISTER
     * ============================================================
     */
    public function create()
    {
        return view('register');
    }


    /**
     * ============================================================
     * ENREGISTREMENT REGISTER
     * ============================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:255',
            'tax_id' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:100',
            'identifiant' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validated) {
            $company = Company::create([
                'name' => $validated['company_name'],
                'short_name' => $validated['short_name'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'country' => $validated['country'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['company_email'] ?? null,
                'tax_id' => $validated['tax_id'] ?? null,
                'registration_number' => $validated['registration_number'] ?? null,
            ]);

            User::create([
                'company_id' => $company->id,
                'identifiant' => $validated['identifiant'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'admin',
            ]);
        });

        return redirect()
            ->route('login')
            ->with('success', 'Établissement créé. Vous pouvez maintenant vous connecter.');
    }


    /**
     * ============================================================
     * AFFICHER UTILISATEUR
     * ============================================================
     */
    public function show(User $user)
    {
        return view(
            'admin.users.show',
            compact('user')
        );
    }


    /**
     * ============================================================
     * FORMULAIRE MODIFICATION
     * ============================================================
     */
    public function edit(User $user)
    {
        $etudiants = Etudiant::where('company_id', Auth::user()->company_id)
            ->orderBy('nom_etudiant')
            ->orderBy('prenom_etudiant')
            ->get();

        $user->load('enfants');

        return view(
            'admin.users.edit',
            compact('user', 'etudiants')
        );
    }


    /**
     * ============================================================
     * MODIFIER UTILISATEUR
     * ============================================================
     */
    public function update(
        Request $request,
        User $user
    ) {
        $validated = $request->validate([
            'identifiant' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin,professeur,comptable,parent',
            ],

            'etudiant_ids' => [
                'nullable',
                'array',
            ],

            'etudiant_ids.*' => [
                'integer',
                'exists:etudiants,id',
            ],
        ]);

        $companyId = Auth::user()->company_id;

        $etudiantIds = collect($validated['etudiant_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($validated['role'] === 'parent' && $etudiantIds->isNotEmpty()) {
            $validCount = Etudiant::where('company_id', $companyId)
                ->whereIn('id', $etudiantIds)
                ->count();

            if ($validCount !== $etudiantIds->count()) {
                return back()
                    ->withErrors([
                        'etudiant_ids' => 'Un ou plusieurs étudiants ne appartiennent pas à cet établissement.',
                    ])
                    ->withInput();
            }
        }

        $data = [
            'identifiant' => $validated['identifiant'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        DB::transaction(function () use ($user, $data, $validated, $companyId, $etudiantIds) {
            $user->update($data);

            // Seul un compte parent possède des rattachements.
            if ($user->role === 'parent') {
                $pivotData = $etudiantIds->mapWithKeys(
                    fn ($etudiantId) => [
                        $etudiantId => ['company_id' => $companyId],
                    ]
                )->all();

                $user->enfants()->sync($pivotData);
            } else {
                $user->enfants()->detach();
            }
        });

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Utilisateur modifié avec succès.'
            );
    }

    /**
     * ============================================================
     * SUPPRIMER UTILISATEUR
     * ============================================================
     */
    public function destroy(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | EMPÊCHER AUTO-SUPPRESSION
        |--------------------------------------------------------------------------
        */

        if (
            $user->id === Auth::id()
        ) {

            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Vous ne pouvez pas supprimer votre propre compte.'
                );
        }


        $user->delete();


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Utilisateur supprimé avec succès.'
            );
    }


    /**
     * ============================================================
     * FORMULAIRE LOGIN
     * ============================================================
     */
    public function loginform()
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user());
        }

        return view('login');
    }


    /**
     * ============================================================
     * TRAITEMENT LOGIN
     * ============================================================
     */
    public function loginstore(
        Request $request
    ) {

        // Un utilisateur non connecté ne doit jamais conserver le contexte d'une ancienne école.
        $request->session()->forget('company_id');

        $validated = $request->validate([
            'login' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $login = trim($validated['login']);
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'identifiant';

        if (Auth::attempt([$field => $login, 'password' => $validated['password']])) {
            $request->session()->regenerate();
            $request->session()->put('company_id', Auth::user()->company_id);

            return $this->redirectForRole(Auth::user());
        }


        return back()
            ->withErrors([

                'login' =>
                    'Identifiant/email ou mot de passe incorrect.',

            ])
            ->onlyInput('email');
    }


    /**
     * ============================================================
     * DASHBOARD
     * ============================================================
     */
    public function dashboard(
        Request $request
    ) {

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION UTILISATEUR
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return redirect()
                ->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION RÔLE
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'professeur') {
            return redirect()->route('teacher.dashboard');
        }

        if ($user->role === 'etudiant') {
            return redirect()->route('student.dashboard');
        }

        if ($user->role === 'comptable') {
            return redirect()->route('accountant.dashboard');
        }

        if ($user->role !== 'admin') {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | ANNÉES SCOLAIRES
        |--------------------------------------------------------------------------
        */

        $anneesScolaires =
            Annee_scolaire::where(
                'user_id',
                $user->id
            )
            ->orderByDesc(
                'created_at'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ANNÉE SÉLECTIONNÉE
        |--------------------------------------------------------------------------
        */

        $anneeId =
            $request->input(
                'annee_scolaire_id'
            );


        /*
        |--------------------------------------------------------------------------
        | ANNÉE ACTIVE
        |--------------------------------------------------------------------------
        */

        if (!$anneeId) {

            $anneeActive =
                $anneesScolaires->first();

        } else {

            $anneeActive =
                $anneesScolaires
                    ->firstWhere(
                        'id',
                        (int) $anneeId
                    );


            /*
            |--------------------------------------------------------------------------
            | SÉCURITÉ
            |--------------------------------------------------------------------------
            */

            if (!$anneeActive) {

                $anneeActive =
                    $anneesScolaires->first();
            }
        }


        $anneeActiveId =
            $anneeActive?->id;


        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES GÉNÉRALES
        |--------------------------------------------------------------------------
        */

        $totalProfesseurs =
            Professeur::where(
                'user_id',
                $user->id
            )->count();


        $totalClasses =
            Classe::where(
                'user_id',
                $user->id
            )->count();


        $totalMatieres =
            Matiere::where(
                'user_id',
                $user->id
            )->count();


        /*
        |--------------------------------------------------------------------------
        | VALEURS PAR DÉFAUT
        |--------------------------------------------------------------------------
        */

        $totalEtudiants = 0;

        $totalInscriptions = 0;

        $totalEvaluations = 0;

        $totalNotes = 0;

        $totalClassesInscrites = 0;

        $moyenneGenerale = 0;

        $meilleureNote = 0;


        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES ANNÉE
        |--------------------------------------------------------------------------
        */

        if ($anneeActiveId) {


            /*
            |--------------------------------------------------------------------------
            | INSCRIPTIONS
            |--------------------------------------------------------------------------
            */

            $totalInscriptions =
                Inscription::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'annee_scolaire_id',
                    $anneeActiveId
                )
                ->count();


            /*
            |--------------------------------------------------------------------------
            | ÉLÈVES UNIQUES
            |--------------------------------------------------------------------------
            */

            $totalEtudiants =
                Inscription::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'annee_scolaire_id',
                    $anneeActiveId
                )
                ->distinct(
                    'etudiant_id'
                )
                ->count(
                    'etudiant_id'
                );


            /*
            |--------------------------------------------------------------------------
            | CLASSES UTILISÉES
            |--------------------------------------------------------------------------
            */

            $totalClassesInscrites =
                Inscription::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'annee_scolaire_id',
                    $anneeActiveId
                )
                ->distinct(
                    'classe_id'
                )
                ->count(
                    'classe_id'
                );


            /*
            |--------------------------------------------------------------------------
            | ÉVALUATIONS
            |--------------------------------------------------------------------------
            */

            $totalEvaluations =
                Evaluation::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'annee_scolaire_id',
                    $anneeActiveId
                )
                ->count();


            /*
            |--------------------------------------------------------------------------
            | NOTES
            |--------------------------------------------------------------------------
            */

            $notesQuery =
                Note::where(
                    'user_id',
                    $user->id
                )
                ->whereHas(
                    'evaluation',
                    function ($query)
                    use ($anneeActiveId) {

                        $query->where(
                            'annee_scolaire_id',
                            $anneeActiveId
                        );

                    }
                );


            $totalNotes =
                $notesQuery->count();


            /*
            |--------------------------------------------------------------------------
            | MOYENNE
            |--------------------------------------------------------------------------
            */

            $moyenneGenerale =
                Note::where(
                    'user_id',
                    $user->id
                )
                ->whereHas(
                    'evaluation',
                    function ($query)
                    use ($anneeActiveId) {

                        $query->where(
                            'annee_scolaire_id',
                            $anneeActiveId
                        );

                    }
                )
                ->avg('note');


            $moyenneGenerale =
                round(
                    $moyenneGenerale ?? 0,
                    2
                );


            /*
            |--------------------------------------------------------------------------
            | MEILLEURE NOTE
            |--------------------------------------------------------------------------
            */

            $meilleureNote =
                Note::where(
                    'user_id',
                    $user->id
                )
                ->whereHas(
                    'evaluation',
                    function ($query)
                    use ($anneeActiveId) {

                        $query->where(
                            'annee_scolaire_id',
                            $anneeActiveId
                        );

                    }
                )
                ->max('note');


            $meilleureNote =
                round(
                    $meilleureNote ?? 0,
                    2
                );
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES PAR CLASSE
        |--------------------------------------------------------------------------
        */

        $classesStatistiques =
            collect();


        if ($anneeActiveId) {

            $classesStatistiques =
                Classe::where(
                    'user_id',
                    $user->id
                )
                ->withCount([

                    'inscriptions' =>
                        function ($query)
                        use ($anneeActiveId) {

                            $query->where(
                                'annee_scolaire_id',
                                $anneeActiveId
                            );

                        }

                ])
                ->orderBy(
                    'nom_classe'
                )
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | DONNÉES GRAPHIQUES
        |--------------------------------------------------------------------------
        */

        $graphClasses =
            $classesStatistiques
                ->pluck(
                    'nom_classe'
                )
                ->values()
                ->toArray();


        $graphEffectifs =
            $classesStatistiques
                ->pluck(
                    'inscriptions_count'
                )
                ->values()
                ->toArray();


        /*
        |--------------------------------------------------------------------------
        | TAUX NOTES
        |--------------------------------------------------------------------------
        */

        $tauxNotes = 0;


        if (
            $totalEvaluations > 0
        ) {

            $tauxNotes =
                min(
                    100,
                    round(
                        (
                            $totalNotes /
                            max(
                                1,
                                $totalEvaluations
                            )
                        ) * 100,
                        1
                    )
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DONNÉES GLOBALES
        |--------------------------------------------------------------------------
        */

        $graphStatistiques = [

            'etudiants' =>
                $totalEtudiants,

            'professeurs' =>
                $totalProfesseurs,

            'classes' =>
                $totalClasses,

            'matieres' =>
                $totalMatieres,

            'inscriptions' =>
                $totalInscriptions,

            'evaluations' =>
                $totalEvaluations,

            'notes' =>
                $totalNotes,

        ];


        /*
        |--------------------------------------------------------------------------
        | VUE
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(

                'user',

                'anneesScolaires',

                'anneeActive',

                'anneeActiveId',

                'totalEtudiants',

                'totalProfesseurs',

                'totalClasses',

                'totalMatieres',

                'totalInscriptions',

                'totalClassesInscrites',

                'totalEvaluations',

                'totalNotes',

                'moyenneGenerale',

                'meilleureNote',

                'tauxNotes',

                'classesStatistiques',

                'graphClasses',

                'graphEffectifs',

                'graphStatistiques'

            )
        );
    }


    private function redirectForRole(User $user)
    {
        return match ($user->role) {
            'professeur' => redirect()->route('teacher.dashboard'),
            'etudiant' => redirect()->route('student.dashboard'),
            'comptable' => redirect()->route('accountant.dashboard'),
            'parent' => redirect()->route('parent.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('login')->withErrors([
                'email' => 'Le rôle de ce compte n’est pas autorisé.'
            ]),
        };
    }

    /**
     * ============================================================
     * LOGOUT
     * ============================================================
     */
    public function logout(
        Request $request
    ) {

        Auth::logout();

        $request->session()->forget('company_id');
        $request->session()->invalidate();


        $request
            ->session()
            ->regenerateToken();


        return redirect()
            ->route('login')
            ->with(
                'success',
                'Vous êtes déconnecté.'
            );
    }
}
