<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvenementsController extends Controller
{
    public function index()
    {
        $evenements = Evenement::latest()->get();
        return view('evenements.index', compact('evenements'));
    }

    public function create()
    {
        return view('evenements.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'adresse' => 'required|string|max:255',
            'elements_requis' => 'required|string',
            'nb_place' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        $evenement = new Evenement($validatedData);
        $evenement->ref_user = Auth::id();
        $evenement->save();

        return redirect()->route('evenements.index')->with('status', 'Événement créé avec succès.');
    }

    public function edit(Evenement $evenement)
    {
        return view('evenements.edit', compact('evenement'));
    }

    public function update(Request $request, Evenement $evenement)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'adresse' => 'required|string|max:255',
            'elements_requis' => 'required|string',
            'nb_place' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        $evenement->update($validatedData);

        return redirect()->route('evenements.index')->with('status', 'Événement mis à jour avec succès.');
    }

    public function destroy(Evenement $evenement)
    {
        $evenement->delete();
        return redirect()->route('evenements.index')->with('status', 'Événement supprimé avec succès.');
    }

    public function inscription(Evenement $evenement)
    {
        if ($evenement->nb_place > 0) {
            $evenement->participants()->attach(Auth::id());
            $evenement->decrement('nb_place');
            return redirect()->route('evenements.index')->with('status', 'Inscription réussie.');
        }
        return redirect()->route('evenements.index')->with('error', 'Désolé, l\'événement est complet.');
    }

    public function desinscription(Evenement $evenement)
    {
        $evenement->participants()->detach(Auth::id());
        $evenement->increment('nb_place');
        return redirect()->route('evenements.index')->with('status', 'Désinscription réussie.');
    }
}