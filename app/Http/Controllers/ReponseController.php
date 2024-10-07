<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use App\Models\Post;
use Illuminate\Http\Request;

class ReponseController extends Controller
{
    public function index()
    {
        $reponses = Reponse::with('post')->get();
        return view('reponses.index', compact('reponses'));
    }

    public function create()
    {
        $posts = Post::all();
        return view('reponses.create', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenue' => 'required|string',
            'date_reponse' => 'required|date',
            'id_post' => 'required|exists:posts,id',
        ]);

        Reponse::create($validated);

        return redirect()->route('reponses.index')->with('success', 'Réponse créée avec succès.');
    }

    public function show(Reponse $reponse)
    {
        return view('reponses.show', compact('reponse'));
    }

    public function edit(Reponse $reponse)
    {
        $posts = Post::all();
        return view('reponses.edit', compact('reponse', 'posts'));
    }

    public function update(Request $request, Reponse $reponse)
    {
        $validated = $request->validate([
            'contenue' => 'required|string',
            'date_reponse' => 'required|date',
            'id_post' => 'required|exists:posts,id',
        ]);

        $reponse->update($validated);

        return redirect()->route('reponses.index')->with('success', 'Réponse mise à jour avec succès.');
    }

    public function destroy(Reponse $reponse)
    {
        $reponse->delete();
        return redirect()->route('reponses.index')->with('success', 'Réponse supprimée avec succès.');
    }
}
