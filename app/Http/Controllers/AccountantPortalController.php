<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountantPortalController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $inscriptions = Inscription::query()
            ->with(['etudiant', 'classe', 'anneeScolaire'])
            ->where('company_id', $companyId)
            ->latest()
            ->paginate(15);

        return view('portal.accountant.index', compact('inscriptions'));
    }

    public function storePayment(Request $request)
    {
        $data = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $companyId = Auth::user()->company_id;

        $inscription = Inscription::query()
            ->with(['etudiant', 'classe', 'anneeScolaire'])
            ->where('company_id', $companyId)
            ->findOrFail($data['inscription_id']);

        $total = (float) ($inscription->classe->prix ?? 0);
        $dejaPaye = (float) ($inscription->frais_scolarite ?? 0);
        $reste = max(0, $total - $dejaPaye);
        $montant = (float) $data['amount'];

        if ($montant > $reste) {
            return back()
                ->withInput()
                ->with('error', 'Le montant saisi est supérieur au reste à payer.');
        }

        $nouveauMontant = $dejaPaye + $montant;

        $inscription->update([
            'frais_scolarite' => $nouveauMontant,
            'company_id' => $companyId,
            'user_id' => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Paiement de ' . number_format($montant, 0, ',', ' ') . ' FCFA enregistré avec succès.'
        );
    }
}
