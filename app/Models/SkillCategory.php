<?php

namespace App\Models;

use Database\Factories\SkillCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    /** @use HasFactory<SkillCategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'icon', 'description'];

    public function skills()
    {
        return $this->hasMany(Skill::class)->orderBy('sort_order');
    }
}
