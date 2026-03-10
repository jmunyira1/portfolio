<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::with('category')->orderBy('skill_category_id')->orderBy('sort_order')->get();
        $categories = SkillCategory::orderBy('name')->get();
        return view('admin.skills.index', compact('skills', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skill_category_id' => 'required|exists:skill_categories,id',
            'name' => 'required|string|max:100',
            'proficiency' => 'required|integer|min:0|max:100',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'integer',
        ]);

        Skill::create($request->all());

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill added.');
    }

    public function create()
    {
        $categories = SkillCategory::orderBy('name')->get();
        return view('admin.skills.create', compact('categories'));
    }

    public function edit(Skill $skill)
    {
        $categories = SkillCategory::orderBy('name')->get();
        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'skill_category_id' => 'required|exists:skill_categories,id',
            'name' => 'required|string|max:100',
            'proficiency' => 'required|integer|min:0|max:100',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'integer',
        ]);

        $skill->update($request->all());

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill deleted.');
    }
}
