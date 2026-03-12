<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RepoProjectService;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class RepoProjectController extends Controller
{
    public function __construct(protected RepoProjectService $service)
    {
    }

    /**
     * List all repo folders (including ones without valid README).
     */
    public function index()
    {
        $base = rtrim(config('repos.path', dirname(base_path())), '/');
        $folders = array_filter(glob($base . '/*'), 'is_dir');

        $projects = collect($folders)
            ->map(function ($path) use ($base) {
                $folder = basename($path);
                if ($folder === 'portfolio') return null;

                $readmePath = $path . '/README.md';
                $hasReadme = file_exists($readmePath);
                $parsed = $hasReadme ? $this->service->find($folder) : null;

                return [
                    'slug' => $folder,
                    'title' => $parsed['title'] ?? $folder,
                    'summary' => $parsed['summary'] ?? null,
                    'active' => $parsed !== null,
                    'has_readme' => $hasReadme,
                    'valid' => $parsed !== null,
                    'screenshots' => count($parsed['screenshots'] ?? []),
                ];
            })
            ->filter()
            ->values();

        return view('admin.repo-projects.index', compact('projects'));
    }

    /**
     * Show edit form for a repo. Pre-fills from existing README or blank defaults.
     */
    public function edit(string $slug)
    {
        $this->guardSlug($slug);

        $base = rtrim(config('repos.path', dirname(base_path())), '/');
        $repoPath = $base . '/' . $slug;
        $readmePath = $repoPath . '/README.md';

        abort_unless(is_dir($repoPath), 404);

        // Parse existing or set blank defaults
        if (file_exists($readmePath)) {
            $content = file_get_contents($readmePath);
            preg_match('/^---\s*\n(.*?)\n---\s*\n/s', $content, $matches);
            $meta = isset($matches[1]) ? Yaml::parse($matches[1]) : [];
            $body = preg_replace('/^---\s*\n.*?\n---\s*\n/s', '', $content);
        } else {
            $meta = [];
            $body = '';
        }

        $project = [
            'slug' => $slug,
            'title' => $meta['title'] ?? ucwords(str_replace(['-', '_'], ' ', $slug)),
            'summary' => $meta['summary'] ?? '',
            'description' => $meta['description'] ?? '',
            'tech' => isset($meta['tech'])
                ? (is_array($meta['tech'])
                    ? implode(', ', $meta['tech'])
                    : $meta['tech'])
                : '',
            'live_url' => $meta['live_url'] ?? '',
            'github_url' => $meta['github_url'] ?? '',
            'featured' => $meta['featured'] ?? false,
            'active' => $meta['active'] ?? true,
            'order' => $meta['order'] ?? '',
            'body' => trim($body),
        ];

        // Screenshots for preview
        $screenshotsPath = $repoPath . '/screenshots';
        $screenshots = [];
        if (is_dir($screenshotsPath)) {
            $files = glob($screenshotsPath . '/*.{png,jpg,jpeg,webp,gif}', GLOB_BRACE);
            sort($files);
            $screenshots = collect($files)
                ->map(fn($f) => [
                    'name' => basename($f),
                    'url' => route('repo.screenshot', ['repo' => $slug, 'file' => basename($f)]),
                ])
                ->values()
                ->toArray();
        }

        return view('admin.repo-projects.edit', compact('project', 'screenshots'));
    }

    protected function guardSlug(string $slug): void
    {
        abort_if(str_contains($slug, ['..', '/', '\\']), 404);
        abort_if($slug === 'portfolio', 404);
    }

    /**
     * Write the form data back to README.md.
     */
    public function update(Request $request, string $slug)
    {
        $this->guardSlug($slug);

        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'description' => 'nullable|string',
            'tech' => 'nullable|string',
            'live_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'order' => 'nullable|integer|min:1',
            'body' => 'nullable|string',
        ]);

        $base = rtrim(config('repos.path', dirname(base_path())), '/');
        $repoPath = $base . '/' . $slug;
        $readmePath = $repoPath . '/README.md';

        abort_unless(is_dir($repoPath), 404);

        // Build tech array from comma-separated string
        $tech = collect(explode(',', $request->input('tech', '')))
            ->map(fn($t) => trim($t))
            ->filter()
            ->values()
            ->toArray();

        // Build frontmatter array
        $meta = [
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'description' => $request->input('description') ?: null,
            'tech' => $tech,
            'live_url' => $request->input('live_url') ?: null,
            'github_url' => $request->input('github_url') ?: null,
            'featured' => $request->boolean('featured'),
            'active' => $request->boolean('active'),
            'order' => $request->input('order')
                ? (int)$request->input('order')
                : null,
        ];

        // Remove null values to keep README clean
        $meta = array_filter($meta, fn($v) => $v !== null);

        $yaml = Yaml::dump($meta, 2, 2);
        $body = trim($request->input('body', ''));

        $readme = "---\n{$yaml}---\n\n{$body}";

        // Create screenshots dir if missing
        if (!is_dir($repoPath . '/screenshots')) {
            mkdir($repoPath . '/screenshots', 0755, true);
        }

        file_put_contents($readmePath, $readme);

        return redirect()
            ->route('admin.repo-projects.index')
            ->with('success', "README for \"{$request->input('title')}\" saved successfully.");
    }

    /**
     * Delete a single screenshot file.
     */
    public function destroyScreenshot(Request $request, string $slug)
    {
        $this->guardSlug($slug);

        $file = basename($request->input('file', ''));
        abort_if(empty($file), 400);

        $base = rtrim(config('repos.path', dirname(base_path())), '/');
        $path = $base . '/' . $slug . '/screenshots/' . $file;

        if (file_exists($path)) {
            unlink($path);
        }

        return back()->with('success', 'Screenshot deleted.');
    }

    /**
     * Upload new screenshots to the repo's screenshots folder.
     */
    public function uploadScreenshots(Request $request, string $slug)
    {
        $this->guardSlug($slug);

        $request->validate([
            'screenshots' => 'required|array',
            'screenshots.*' => 'image|max:4096',
        ]);

        $base = rtrim(config('repos.path', dirname(base_path())), '/');
        $screenshotsPath = $base . '/' . $slug . '/screenshots';

        if (!is_dir($screenshotsPath)) {
            mkdir($screenshotsPath, 0755, true);
        }

        foreach ($request->file('screenshots') as $file) {
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move($screenshotsPath, $name);
        }

        return back()->with('success', 'Screenshots uploaded.');
    }
}
