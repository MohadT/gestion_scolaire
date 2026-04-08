<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // la liste des inscriptions
        return view('inscriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // formulaire de création d'une inscription
        return view('inscriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // traitement de la création d'une inscription
        // validation des données
        $request->validate([
            'etudiant_id' => 'required|exists:etudiant,id',
            'classe_id' => 'required|exists:classe,id',
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
        // formulaire de modification d'une inscription
        return view('inscriptions.edit');
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
        // traitement de la suppression d'une inscription
        $inscription = Inscription::findOrFail($id);
        $inscription->delete();
        return redirect()->route('inscriptions.index')->with('success', 'Inscription supprimée avec succès.');
    }
}
