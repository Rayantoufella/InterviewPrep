<?php

namespace App\Http\Controllers;

use App\Http\Requests\DomainRequest;
use App\Models\Domain;

class DomainController extends Controller
{
    public function index()
    {
        $domains = auth()->user()->domains()->get();

        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        return view('domains.create');
    }

    public function store(DomainRequest $request)
    {
        Domain::create([
            'user_id' => auth()->id(),
            'title'   => $request->title,
            'color'   => $request->color,
        ]);

        return redirect()->route('domains.index');
    }

    public function edit(Domain $domain)
    {
        $this->authorize('update', $domain);

        return view('domains.edit', compact('domain'));
    }

    public function update(DomainRequest $request, Domain $domain)
    {
        $this->authorize('update', $domain);

        $domain->update([
            'title' => $request->title,
            'color' => $request->color,
        ]);

        return redirect()->route('domains.index');
    }

    public function destroy(Domain $domain)
    {
        $this->authorize('delete', $domain);

        $domain->delete();

        return redirect()->route('domains.index');
    }
}
