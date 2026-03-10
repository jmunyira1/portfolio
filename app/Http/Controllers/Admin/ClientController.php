<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('experiences')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:clients,name',
        ]);

        Client::create($request->all());

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client added.');
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:clients,name,' . $client->id,
        ]);

        $client->update($request->all());

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('success', 'Client deleted.');
    }
}
