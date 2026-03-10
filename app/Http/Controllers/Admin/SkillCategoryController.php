<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillCategoryController extends Controller
{
    public function index()
    {
        $categories = SkillCategory::withCount('skills')->orderBy('name')->get();
        return view('admin.skill-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:skill_categories,name',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        SkillCategory::create($request->all());

        return redirect()->route('admin.skill-categories.index')
            ->with('success', 'Skill category created.');
    }

    public function create()
    {
        return view('admin.skill-categories.create');
    }

    public function edit(SkillCategory $skillCategory)
    {
        return view('admin.skill-categories.edit', compact('skillCategory'));
    }

    public function update(Request $request, SkillCategory $skillCategory)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:skill_categories,name,' . $skillCategory->id,
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $skillCategory->update($request->all());

        return redirect()->route('admin.skill-categories.index')
            ->with('success', 'Skill category updated.');
    }

    public function destroy(SkillCategory $skillCategory)
    {
        $skillCategory->delete();
        return back()->with('success', 'Category deleted.');
    }
}
