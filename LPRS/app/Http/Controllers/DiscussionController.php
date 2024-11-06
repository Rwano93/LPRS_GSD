<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Discussion;

class DiscussionController extends Controller
{
    public function index(): Factory|View|Application
    {
        $discussions = Discussion::with('category', 'user')->latest()->paginate(10);
        return view('discussions.index', compact('discussions'));

    }
    public function create(): Factory|View|Application
    {
        $categories = Category::all(); // Récupère toutes les catégories
        return view('discussions.create', compact('categories'));
    }



    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'contenu' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Assurez-vous que cette validation est correcte
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
        ]);
        $discussion = new Discussion();
        $discussion->title = $request->title;
        $discussion->content = $request->contenu;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/discussions', 'public');
            $discussion->image = $imagePath;
        }

        $discussion->user_id = auth()->id();
        $discussion->save();

        Discussion::create([
            'title' => $request->title,
            'content' => $request->contenu, // Assurez-vous d'utiliser 'content' pour correspondre au champ
            'category_id' => $request->category_id,
            'user_id' => auth()->id(), // Assignez l'ID de l'utilisateur authentifié
        ]);

        return redirect()->route('discussions.index')->with('success', 'Discussion crée avec succès !');

    }
    public function show($id)
    {
        $discussion = Discussion::with('replies')->find($id);

        if (!$discussion) {
            return redirect()->route('discussions.index')->with('error', 'Discussion not found.');
        }

        return view('discussions.show', compact('discussion'));

    }


}
