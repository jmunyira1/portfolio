<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class RepoProjectService
{
    /**
     * Base path where all repositories live.
     * portfolio is at BASE/portfolio, siblings are other projects.
     */
    protected string $base;

    public function __construct()
    {
        // ~/repositories/
        $this->base = rtrim(config('repos.path', base_path('../')), '/');
    }

    /**
     * Return a single project by slug (folder name).
     */
    public function find(string $slug): ?array
    {
        return $this->all()->firstWhere('slug', $slug);
    }

    /**
     * Return all active repo projects, sorted by order then title.
     */
    public function all(): Collection
    {
        return $this->scan()->sortBy([
            ['order', 'asc'],
            ['title', 'asc'],
        ])->values();
    }

    /**
     * Scan ~/repositories/ and parse each README.
     */
    protected function scan(): Collection
    {
        $dirs = glob($this->base . '/*/README.md');

        if (!$dirs) return collect();

        return collect($dirs)
            ->map(fn($readmePath) => $this->parse($readmePath))
            ->filter(); // remove nulls (no frontmatter / inactive)
    }

    /**
     * Parse a single README.md and return project array or null.
     */
    protected function parse(string $readmePath): ?array
    {
        $folder = basename(dirname($readmePath));

        // Skip the portfolio itself
        if ($folder === 'portfolio') return null;

        $content = file_get_contents($readmePath);

        // Extract YAML frontmatter between --- delimiters
        if (!preg_match('/^---\s*\n(.*?)\n---\s*\n/s', $content, $matches)) {
            return null; // no frontmatter — skip
        }

        try {
            $meta = Yaml::parse($matches[1]);
        } catch (\Exception $e) {
            return null;
        }

        // Skip if not active
        if (isset($meta['active']) && $meta['active'] === false) return null;

        // Extract body (everything after frontmatter)
        $body = preg_replace('/^---\s*\n.*?\n---\s*\n/s', '', $content);

        return [
            'slug' => $folder,
            'title' => $meta['title'] ?? Str::title(str_replace(['-', '_'], ' ', $folder)),
            'summary' => $meta['summary'] ?? '',
            'description' => $meta['description'] ?? '',
            'tech' => $meta['tech'] ?? [],
            'live_url' => $meta['live_url'] ?? null,
            'github_url' => $meta['github_url'] ?? null,
            'featured' => $meta['featured'] ?? false,
            'order' => $meta['order'] ?? 999,
            'readme_body' => $body,
            'screenshots' => $this->screenshots($folder),
            'cover' => $this->cover($folder),
            'source' => 'repo',   // distinguishes from DB projects
        ];
    }

    /**
     * Return all screenshot URLs for a repo.
     */
    protected function screenshots(string $folder): array
    {
        $screenshotsPath = $this->base . '/' . $folder . '/screenshots';

        if (!is_dir($screenshotsPath)) return [];

        $files = glob($screenshotsPath . '/*.{png,jpg,jpeg,webp,gif}', GLOB_BRACE);

        if (!$files) return [];

        sort($files); // alphabetical = predictable order

        return collect($files)
            ->map(fn($file) => route('repo.screenshot', [
                'repo' => $folder,
                'file' => basename($file),
            ]))
            ->values()
            ->toArray();
    }

    /**
     * First screenshot is the cover image.
     */
    protected function cover(string $folder): ?string
    {
        $screenshots = $this->screenshots($folder);
        return $screenshots[0] ?? null;
    }
}
