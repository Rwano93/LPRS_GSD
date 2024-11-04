<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all(); 
        return view('offers.index', compact('offers'));
    }

    public function create()
    {
        return view('offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required|in:alternance,stage,CDD,CDI,Intérim',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'required',
            'salary' => 'nullable|numeric',
        ]);

        Offer::create($request->all());

        return redirect()->route('offers.index')
            ->with('success', 'Offre créée avec succès.');
    }

    public function show(Offer $offer)
    {
        return view('offers.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        return view('offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required|in:alternance,stage,CDD,CDI,Intérim',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'required',
            'salary' => 'nullable|numeric',
        ]);

        $offer->update($request->all());

        return redirect()->route('offers.index')
            ->with('success', 'Offre mise à jour avec succès.');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('offers.index')
            ->with('success', 'Offre supprimée avec succès.');
    }
}