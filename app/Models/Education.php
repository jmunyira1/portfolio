<?php

namespace App\Models;

use Database\Factories\EducationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    /** @use HasFactory<EducationFactory> */
    use HasFactory;

    protected $table = 'education';
    protected $fillable = [
        'institution',
        'degree_level',
        'degree',
        'field_of_study',
        'start_year',
        'end_year',
        'is_current',
        'grade',
        'location',
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];
}
