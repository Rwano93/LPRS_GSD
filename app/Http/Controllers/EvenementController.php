<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('evenement.show', compact('evenement'));
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

        $evenement = Evenement::create($validatedData);

        return response()->json($evenement, 201);
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

        return response()->json($evenement, 200);
    }

    public function destroy(Evenement $evenement)
    {
        $evenement->delete();

        return response()->json(['message' => 'Événement supprimé avec succès.'], 200);
    }


    public function inscription(Request $request, Evenement $evenement)
{
    $user = Auth::user();
    
    if (!$evenement->isUserInscrit()) {
        $evenement->participants()->attach($user->id);
        return response()->json(['message' => 'Inscription réussie.']);
    }
    
    return response()->json(['message' => 'Vous êtes déjà inscrit à cet événement.'], 422);
}
    public function desinscription(Request $request, Evenement $evenement)
{
    $user = Auth::user();
    
    if ($evenement->isUserInscrit()) {
        $evenement->participants()->detach($user->id);
        return response()->json(['message' => 'Désinscription réussie.']);
    }
    
    return response()->json(['message' => 'Vous n\'êtes pas inscrit à cet événement.'], 422);

}

    
}