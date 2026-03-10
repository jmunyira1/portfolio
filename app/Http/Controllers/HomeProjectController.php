<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use App\Models\Social;

class HomeProjectController extends Controller
{
    public function show(Project $project)
    {
        abort_unless($project->published, 404);

        $project->load(['images', 'skills', 'category', 'client']);
        $settings = Setting::allKeyed();
        $socials = Social::orderByDesc('is_primary')->get();

        $related = Project::with('coverImage')
            ->where('published', true)
            ->where('id', '!=', $project->id)
            ->where('skill_category_id', $project->skill_category_id)
            ->limit(3)
            ->get();

        return view('home.project', compact('project', 'settings', 'socials', 'related'));
    }
}
