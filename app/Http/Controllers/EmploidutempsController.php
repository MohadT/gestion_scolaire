<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emploidutemps;

class EmploidutempsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // la liste des emplois du temps
        $emplois = Emploidutemps::all();
        return view('emplois.index', compact('emplois'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // formulaire de création d'un emploi du temps
        return view('emplois.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        // formulaire de modification d'un emploi du temps
        $emploi = Emploidutemps::findOrFail($id);
        return view('emplois.edit', compact('emploi'));
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
        // traitement de la suppression d'un emploi du temps
        $emploi = Emploidutemps::findOrFail($id);
        $emploi->delete();
        return redirect()->route('emplois.index')->with('success', 'Emploi du temps supprimé avec succès.');
    }
}
