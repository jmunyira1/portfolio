<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RepoProjectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillCategoryController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepoScreenshotController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects/{project:slug}', [HomeProjectController::class, 'show'])->name('projects.show');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/repo-screenshot/{repo}/{file}', RepoScreenshotController::class)
    ->name('repo.screenshot')
    ->where('file', '[^/]+');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Settings — single form, no resource
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Socials
        Route::resource('socials', SocialController::class);
        Route::resource('education', EducationController::class);

// Clients
        Route::resource('clients', ClientController::class);

// Experiences
        Route::resource('experiences', ExperienceController::class);

        Route::resource('skill-categories', SkillCategoryController::class);
        Route::resource('skills', SkillController::class);

        Route::resource('projects', ProjectController::class);
        Route::delete('project-images/{image}', [ProjectController::class, 'destroyImage'])
            ->name('project-images.destroy');
        Route::get('repo-projects', [RepoProjectController::class, 'index'])->name('repo-projects.index');
        Route::get('repo-projects/{slug}/edit', [RepoProjectController::class, 'edit'])->name('repo-projects.edit');
        Route::put('repo-projects/{slug}', [RepoProjectController::class, 'update'])->name('repo-projects.update');
        Route::post('repo-projects/{slug}/screenshots', [RepoProjectController::class, 'uploadScreenshots'])->name('repo-projects.screenshots.upload');
        Route::delete('repo-projects/{slug}/screenshots', [RepoProjectController::class, 'destroyScreenshot'])->name('repo-projects.screenshots.destroy');

    });


// Repo projects (software — filesystem based)

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
