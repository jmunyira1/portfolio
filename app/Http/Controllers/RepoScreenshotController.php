<?php

namespace App\Http\Controllers;

use App\Services\RepoProjectService;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RepoScreenshotController extends Controller
{
    public function __invoke(string $repo, string $file, RepoProjectService $service): BinaryFileResponse
    {
        // Sanitise — no path traversal
        abort_if(Str::contains($repo, ['..', '/', '\\']), 404);
        abort_if(Str::contains($file, ['..', '/', '\\']), 404);

        $base = rtrim(config('repos.path', dirname(base_path())), '/');
        $path = $base . '/' . $repo . '/screenshots/' . $file;

        abort_unless(file_exists($path), 404);

        // Only allow image extensions
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        abort_unless(in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'gif']), 404);

        return response()->file($path);
    }
}
