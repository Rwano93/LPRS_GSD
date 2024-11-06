<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EvenementController extends Controller
{
    public function index(Request $request)
{
    $query = Evenement::query();

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('titre', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
    }

    $evenements = $query->paginate(15);

    if ($request->ajax()) {
        return response()->json($evenements);
    }

    return view('evenement.index', compact('evenements'));
}

public function show(Evenement $evenement)
{
    if (request()->ajax()) {
        return view('evenement._show', compact('evenement'))->render();
    }

    return view('evenement.show', compact('evenement'));
}

public function getInscrits(Evenement $evenement)
{
    \Log::info('Récupération des inscrits pour l\'événement ' . $evenement->id);
    $inscrits = $evenement->users()->select('users.id', 'users.name', 'users.email')->get();
    \Log::info('Nombre d\'inscrits : ' . $inscrits->count());
    return response()->json($inscrits);
}
    public function edit(Evenement $evenement)
    {
        return view('evenement.edit', compact('evenement'));
    }
    
public function store(Request $request)
{
    $validatedData = $request->validate([
        'titre' => 'required|max:255',
        'description' => 'required',
        'date' => 'required|date',
        'adresse' => 'required',
        'nb_place' => 'required|integer|min:1',
        'type' => 'required',
        'elements_requis' => 'nullable',
    ]);

    $evenement = new Evenement($validatedData);
    $evenement->ref_user = Auth::id();
    $evenement->save();

    Session::flash('event_created', true);
    return redirect()->route('evenements.index');
}

    public function create()
    {
        return view('evenement.create');
    }

    public function update(Request $request, Evenement $evenement)
{
    $validatedData = $request->validate([
        'titre' => 'required|max:255',
        'description' => 'required',
        'date' => 'required|date',
        'adresse' => 'required',
        'nb_place' => 'required|integer|min:1',
        'type' => 'required',
        'elements_requis' => 'nullable',
    ]);

    $evenement->update($validatedData);

    return redirect()->route('evenements.index')->with('success', 'Événement mis à jour avec succès.');
}
    public function destroy(Evenement $evenement)
    {
        $evenement->delete();

        return response()->json(['message' => 'Événement supprimé avec succès.'], 200);
    }


  public function inscription(Evenement $evenement)
    {
        if ($evenement->nb_place > 0) {
            $evenement->participants()->attach(Auth::id());
            $evenement->decrement('nb_place');
            return response()->json(['message' => 'Inscription réussie']);
        }
        return response()->json(['message' => 'Plus de places disponibles'], 400);
    }

    public function desinscription(Evenement $evenement)
    {
        $evenement->participants()->detach(Auth::id());
        $evenement->increment('nb_place');
        return response()->json(['message' => 'Désinscription réussie']);
    }
}