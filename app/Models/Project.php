<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'skill_category_id',
        'client_id',
        'title',
        'slug',
        'summary',
        'description',
        'key_features',
        'url',
        'github_url',
        'is_software',
        'featured',
        'published',
        'sort_order',
    ];

    protected $casts = [
        'key_features' => 'array',
        'is_software' => 'boolean',
        'featured' => 'boolean',
        'published' => 'boolean',
    ];

    // Auto-generate slug from title
    protected static function booted(): void
    {
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function coverImage()
    {
        return $this->hasOne(ProjectImage::class)->orderBy('sort_order');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skills');
    }

    public function category()
    {
        return $this->belongsTo(SkillCategory::class, 'skill_category_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
