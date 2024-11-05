<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        // Valider la demande
        $request->validate([
            'contenu' => 'required|string',
            'discussion_id' => 'required|exists:discussions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
        ]);
        $reply = new Reply();
        $reply->content = $request->contenu;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/replies', 'public');
            $reply->image = $imagePath;
        }

        $reply->discussion_id = $request->discussion_id;
        $reply->user_id = auth()->id();
        $reply->save();

        // Créer la réponse
        Reply::create([
            'content' => $request->contenu,
            'discussion_id' => $request->discussion_id,
            'image'=> $request->image,
            'user_id' => auth()->id(),
        ]);

        // Rediriger ou répondre après avoir créé la réponse
        return redirect()->back()->with('success', 'Réponse ajoutée avec succès.');
    }

    // Ajoutez d'autres méthodes ici si nécessaire, comme edit, update, destroy, etc.
}

