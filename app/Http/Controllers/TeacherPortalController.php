<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Note;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherPortalController extends Controller
{
    private function professor()
    {
        return Auth::user()->professeur;
    }

    public function index()
    {
        $prof = $this->professor();

        if (!$prof) {
            abort(403, 'Votre compte professeur n’est pas encore lié à un profil.');
        }

        $evaluations = Evaluation::with(['classe','matiere','anneeScolaire'])
            ->where('professeur_id', $prof->id)
            ->latest()
            ->paginate(12);

        return view('portal.teacher.index', compact('evaluations', 'prof'));
    }

    public function grades(Evaluation $evaluation)
    {
        $prof = $this->professor();
        abort_unless($prof && $evaluation->professeur_id === $prof->id, 403);

        $students = Inscription::with('etudiant')
            ->where('classe_id', $evaluation->classe_id)
            ->where('annee_scolaire_id', $evaluation->annee_scolaire_id)
            ->get();

        $notes = Note::where('evaluation_id', $evaluation->id)
            ->get()->keyBy('etudiant_id');

        return view('portal.teacher.grades', compact('evaluation','students','notes'));
    }

    public function saveGrades(Request $request, Evaluation $evaluation)
    {
        $prof = $this->professor();
        abort_unless($prof && $evaluation->professeur_id === $prof->id, 403);

        $data = $request->validate([
            'notes' => 'required|array',
            'notes.*.note' => 'nullable|numeric|min:0|max:20',
            'notes.*.appreciation' => 'nullable|string|max:255',
        ]);

        $studentIds = Inscription::where('classe_id', $evaluation->classe_id)
            ->where('annee_scolaire_id', $evaluation->annee_scolaire_id)
            ->pluck('etudiant_id');

        foreach ($data['notes'] as $studentId => $row) {
            if (!in_array((int) $studentId, $studentIds->map(fn($id)=>(int)$id)->all(), true)) {
                continue;
            }
            if (($row['note'] ?? '') === '') {
                continue;
            }

            Note::updateOrCreate(
                ['etudiant_id' => $studentId, 'evaluation_id' => $evaluation->id],
                [
                    'note' => $row['note'],
                    'appreciation' => $row['appreciation'] ?? null,
                    'user_id' => Auth::id(),
                ]
            );
        }

        return back()->with('success', 'Notes enregistrées.');
    }
}
