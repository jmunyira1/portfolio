<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Setting;
use App\Models\SkillCategory;
use App\Models\Social;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::allKeyed();
        $socials = Social::orderByDesc('is_primary')->orderBy('platform')->get();
        $projects = Project::with(['coverImage', 'skills', 'category'])
            ->where('published', true)
            ->orderBy('sort_order')
            ->get();
        $categories = SkillCategory::with(['skills' => fn($q) => $q->orderBy('sort_order')])
            ->orderBy('name')
            ->get();
        $education = Education::orderByDesc('start_year')->get();
        $experiences = Experience::with('client')
            ->orderByDesc('start_date')
            ->get();

        return view('home.index', compact(
            'settings', 'socials', 'projects',
            'categories', 'education', 'experiences'
        ));
    }
}
