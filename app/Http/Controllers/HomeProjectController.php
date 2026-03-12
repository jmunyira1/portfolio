<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use App\Models\Social;
use App\Services\RepoProjectService;

class HomeProjectController extends Controller
{
    public function show(string $slug, RepoProjectService $repos)
    {
        $settings = Setting::allKeyed();
        $socials = Social::orderByDesc('is_primary')->get();

        // Try repo first
        $project = $repos->find($slug);

        if ($project) {
            $related = $repos->all()
                ->where('slug', '!=', $slug)
                ->take(3)
                ->values();

            return view('home.project', compact('project', 'settings', 'socials', 'related'));
        }

        // Fall back to DB (technical projects)
        $dbProject = Project::where('slug', $slug)->where('published', true)->firstOrFail();
        $dbProject->load(['images', 'skills', 'category', 'client']);

        $project = [
            'slug' => $dbProject->slug,
            'title' => $dbProject->title,
            'summary' => $dbProject->summary,
            'description' => $dbProject->description,
            'tech' => $dbProject->skills->pluck('name')->toArray(),
            'live_url' => $dbProject->url,
            'github_url' => $dbProject->github_url,
            'featured' => $dbProject->featured,
            'order' => $dbProject->sort_order ?? 999,
            'cover' => $dbProject->coverImage
                ? asset('storage/' . $dbProject->coverImage->path)
                : null,
            'screenshots' => $dbProject->images
                ->map(fn($i) => asset('storage/' . $i->path))
                ->toArray(),
            'readme_body' => null,
            'source' => 'db',
        ];

        $related = Project::with('coverImage')
            ->where('published', true)
            ->where('id', '!=', $dbProject->id)
            ->where('is_software', false)
            ->limit(3)->get()
            ->map(fn($p) => [
                'slug' => $p->slug,
                'title' => $p->title,
                'summary' => $p->summary,
                'cover' => $p->coverImage ? asset('storage/' . $p->coverImage->path) : null,
                'source' => 'db',
            ]);

        return view('home.project', compact('project', 'settings', 'socials', 'related'));
    }
}
