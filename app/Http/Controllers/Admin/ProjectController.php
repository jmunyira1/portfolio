<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['coverImage', 'category', 'client'])
            ->orderBy('sort_order')
            ->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function edit(Project $project)
    {
        $categories = SkillCategory::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $skills = Skill::with('category')->orderBy('skill_category_id')->orderBy('sort_order')->get();
        $project->load(['images', 'skills']);

        return view('admin.projects.edit', compact('project', 'categories', 'clients', 'skills'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'skill_category_id' => 'nullable|exists:skill_categories,id',
            'client_id' => 'nullable|exists:clients,id',
            'url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'is_software' => 'boolean',
            'featured' => 'boolean',
            'published' => 'boolean',
            'sort_order' => 'integer',
            'key_features' => 'nullable|array',
            'key_features.*' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'images' => 'nullable|array',
            'images.*' => 'image|max:4096',
        ]);

        $project->update(array_merge(
            $request->except(['skills', 'images', 'key_features']),
            ['key_features' => array_filter($request->key_features ?? [])]
        ));

        // Sync skills
        $project->skills()->sync($request->skills ?? []);

        // Add new images
        if ($request->hasFile('images')) {
            $lastOrder = $project->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('projects', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'path' => $path,
                    'sort_order' => $lastOrder + $i + 1,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'skill_category_id' => 'nullable|exists:skill_categories,id',
            'client_id' => 'nullable|exists:clients,id',
            'url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'is_software' => 'boolean',
            'featured' => 'boolean',
            'published' => 'boolean',
            'sort_order' => 'integer',
            'key_features' => 'nullable|array',
            'key_features.*' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'images' => 'nullable|array',
            'images.*' => 'image|max:4096',
        ]);

        // Generate unique slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $project = Project::create(array_merge(
            $request->except(['skills', 'images', 'key_features']),
            [
                'slug' => $slug,
                'key_features' => array_filter($request->key_features ?? []),
            ]
        ));

        // Sync skills
        $project->skills()->sync($request->skills ?? []);

        // Store images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('projects', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'path' => $path,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created.');
    }

    public function create()
    {
        $categories = SkillCategory::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $skills = Skill::with('category')->orderBy('skill_category_id')->orderBy('sort_order')->get();

        return view('admin.projects.create', compact('categories', 'clients', 'skills'));
    }

    public function destroy(Project $project)
    {
        // Delete images from storage
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $project->delete();

        return back()->with('success', 'Project deleted.');
    }

    public function destroyImage(ProjectImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image deleted.');
    }
}
