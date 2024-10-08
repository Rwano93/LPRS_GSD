<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('utilisateur')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $utilisateurs = Utilisateur::all();
        return view('posts.create', compact('utilisateurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenue' => 'required|string',
            'date_poste' => 'required|date',
            'canal' => 'required|string|max:100',
            'id_utilisateur' => 'required|exists:utilisateurs,id',
        ]);

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', 'Post créé avec succès.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $utilisateurs = Utilisateur::all();
        return view('posts.edit', compact('post', 'utilisateurs'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenue' => 'required|string',
            'date_poste' => 'required|date',
            'canal' => 'required|string|max:100',
            'id_utilisateur' => 'required|exists:utilisateurs,id',
        ]);

        $post->update($validated);

        return redirect()->route('posts.index')->with('success', 'Post mis à jour avec succès.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès.');
    }
}
