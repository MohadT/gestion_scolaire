<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Liste des classes de l'utilisateur connecté uniquement
        $classes = Classe::query()->get();

        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Formulaire de création
        return view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // Validation des classes
    $validatedData = $request->validate([
        'classes' => 'required|array|min:1',

        'classes.*.nom_classe' =>
            'required|string|max:255',

        'classes.*.effectif' =>
            'required|integer|min:1',

        'classes.*.prix' =>
            'required|numeric|min:0',
    ]);


    // Utilisateur connecté
    $userId = Auth::id();


    // Création de chaque classe
    foreach ($validatedData['classes'] as $data) {

        Classe::create([
            'nom_classe' => $data['nom_classe'],
            'effectif' => $data['effectif'],
            'prix' => $data['prix'],
            'user_id' => $userId,
        ]);
    }


    // Nombre de classes créées
    $nombre = count($validatedData['classes']);


    // Redirection
    return redirect()
        ->route('classes.index')
        ->with(
            'success',
            $nombre . ' classe(s) ajoutée(s) avec succès.'
        );
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Afficher une classe (vérifier qu'elle appartient à l'utilisateur)
        $classe = Classe::query()
            ->findOrFail($id);

        return view('admin.classes.show', compact('classe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Formulaire de modification (vérifier qu'elle appartient à l'utilisateur)
        $classe = Classe::query()
            ->findOrFail($id);

        return view('admin.classes.edit', compact('classe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation
        $validatedData = $request->validate([
            'nom_classe' => 'required|string|max:255',
            'effectif' => 'required|integer|min:1',
            'prix' => 'required|numeric|min:0',
        ]);

        // Recherche de la classe appartenant à l'utilisateur
        $classe = Classe::query()
            ->findOrFail($id);

        // Mise à jour
        $classe->update($validatedData);

        // Redirection
        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Suppression (vérifier qu'elle appartient à l'utilisateur)
        $classe = Classe::query()->findOrFail($id);

        $classe->delete();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe supprimée avec succès.');
    }
}
