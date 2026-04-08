<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // la liste des classes
        $classes = Classe::all();
        return view('classes.index', compact('classes'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // formulaire de création d'une classe
        return view('classes.create');  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // traitement de la création d'une nouvelle classe
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
        ]);
        $classe = Classe::create([
            'nom' => $validatedData['nom'],
        ]);     
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // formulaire de modification d'une classe
        $classe = Classe::findOrFail($id);
        return view('classes.edit', compact('classe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // traitement de la suppression d'une classe
        $classe = Classe::findOrFail($id);
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès.');
    }
}
