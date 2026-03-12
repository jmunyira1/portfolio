<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Setting;
use App\Models\SkillCategory;
use App\Models\Social;
use App\Services\RepoProjectService;

class HomeController extends Controller
{
    public function index(RepoProjectService $repos)
    {
        $settings = Setting::allKeyed();
        $socials = Social::orderByDesc('is_primary')->orderBy('platform')->get();

        // Software projects — from filesystem repos
        $repoProjects = $repos->all();

        // Technical projects — from DB (non-software)
        $dbProjects = Project::with(['coverImage', 'skills', 'category'])
            ->where('published', true)
            ->where('is_software', false)
            ->orderBy('sort_order')
            ->get()
            ->map(fn($p) => [
                'slug' => $p->slug,
                'title' => $p->title,
                'summary' => $p->summary,
                'description' => $p->description,
                'tech' => $p->skills->pluck('name')->toArray(),
                'live_url' => $p->url,
                'github_url' => $p->github_url,
                'featured' => $p->featured,
                'order' => $p->sort_order ?? 999,
                'cover' => $p->coverImage
                    ? asset('storage/' . $p->coverImage->path)
                    : null,
                'screenshots' => $p->images
                    ->map(fn($i) => asset('storage/' . $i->path))
                    ->toArray(),
                'source' => 'db',
            ]);

        // Merge — repo projects first, then DB technical
        $projects = $repoProjects->concat($dbProjects);

        $categories = SkillCategory::with(['skills' => fn($q) => $q->orderBy('sort_order')])
            ->orderBy('name')->get();
        $education = Education::orderByDesc('start_year')->get();
        $experiences = Experience::with('client')->orderByDesc('start_date')->get();

        return view('home.index', compact(
            'settings', 'socials', 'projects',
            'categories', 'education', 'experiences'
        ));
    }
}
