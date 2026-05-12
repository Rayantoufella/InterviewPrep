<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConceptRequest;
use App\Models\Concept;

class ConceptController extends Controller
{
    public function index()
    {
        $concepts = Concept::all();

        return view('concepts.index', compact('concepts'));
    }

    public function create()
    {
        return view('concepts.create');
    }

    public function store(ConceptRequest $request)
    {
        Concept::create($request->validated());

        return redirect()->route('concepts.index');
    }

    public function edit(Concept $concept)
    {
        return view('concepts.edit', compact('concept'));
    }

    public function update(ConceptRequest $request, Concept $concept)
    {
        $concept->update($request->validated());

        return redirect()->route('concepts.index');
    }

    public function destroy(Concept $concept)
    {
        $concept->delete();

        return redirect()->route('concepts.index');
    }
}