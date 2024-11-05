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
        ]);

        // Créer la réponse
        Reply::create([
            'content' => $request->contenu,
            'discussion_id' => $request->discussion_id,
            'user_id' => auth()->id(),
        ]);

        // Rediriger ou répondre après avoir créé la réponse
        return redirect()->back()->with('success', 'Réponse ajoutée avec succès.');
    }

    // Ajoutez d'autres méthodes ici si nécessaire, comme edit, update, destroy, etc.
}

