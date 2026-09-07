<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StudentPortalController extends Controller
{
    public function index()
    {
        $student = Auth::user()->etudiant;

        if (!$student) {
            abort(403, 'Votre compte élève n’est pas encore lié à un profil.');
        }

        $inscriptions = $student->inscriptions()
            ->with(['classe','anneeScolaire'])
            ->latest()
            ->get();

        $notes = $student->notes()
            ->with(['evaluation.matiere','evaluation.anneeScolaire','evaluation.classe'])
            ->latest()
            ->get();

        $average = (float) ($notes->avg('note') ?? 0);

        return view('portal.student.index', compact('student','inscriptions','notes','average'));
    }
}
