<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::with('client')->orderByDesc('start_date')->get();
        return view('admin.experiences.index', compact('experiences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'responsibilities' => 'required|array|min:1',
            'responsibilities.*' => 'required|string',
        ]);

        Experience::create($request->all());

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience added.');
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('admin.experiences.create', compact('clients'));
    }

    public function edit(Experience $experience)
    {
        $clients = Client::orderBy('name')->get();
        return view('admin.experiences.edit', compact('experience', 'clients'));
    }

    public function update(Request $request, Experience $experience)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'responsibilities' => 'required|array|min:1',
            'responsibilities.*' => 'required|string',
        ]);

        $experience->update($request->all());

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Experience deleted.');
    }
}
