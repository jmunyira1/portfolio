<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $socials = Social::orderByDesc('is_primary')->orderBy('platform')->get();
        return view('admin.socials.index', compact('socials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|unique:socials,platform',
            'label' => 'required|string|max:100',
            'value' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'is_primary' => 'boolean',
        ]);

        Social::create($request->all());

        return redirect()->route('admin.socials.index')
            ->with('success', 'Social link added.');
    }

    public function create()
    {
        return view('admin.socials.create');
    }

    public function edit(Social $social)
    {
        return view('admin.socials.edit', compact('social'));
    }

    public function update(Request $request, Social $social)
    {
        $request->validate([
            'platform' => 'required|string|unique:socials,platform,' . $social->id,
            'label' => 'required|string|max:100',
            'value' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'is_primary' => 'boolean',
        ]);

        $social->update($request->all());

        return redirect()->route('admin.socials.index')
            ->with('success', 'Social link updated.');
    }

    public function destroy(Social $social)
    {
        $social->delete();
        return back()->with('success', 'Social link deleted.');
    }
}
