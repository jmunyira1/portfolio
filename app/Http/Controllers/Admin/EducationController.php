<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::orderByDesc('start_year')->get();
        return view('admin.education.index', compact('education'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'institution' => 'required|string|max:255',
            'degree_level' => 'required|string|max:100',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year' => 'required|digits:4|integer',
            'end_year' => 'nullable|digits:4|integer',
            'is_current' => 'boolean',
            'grade' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        Education::create($request->all());

        return redirect()->route('admin.education.index')
            ->with('success', 'Education record added.');
    }

    public function create()
    {
        return view('admin.education.create');
    }

    public function edit(Education $education)
    {
        return view('admin.education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $request->validate([
            'institution' => 'required|string|max:255',
            'degree_level' => 'required|string|max:100',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year' => 'required|digits:4|integer',
            'end_year' => 'nullable|digits:4|integer',
            'is_current' => 'boolean',
            'grade' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        $education->update($request->all());

        return redirect()->route('admin.education.index')
            ->with('success', 'Education record updated.');
    }

    public function destroy(Education $education)
    {
        $education->delete();
        return back()->with('success', 'Education record deleted.');
    }
}
