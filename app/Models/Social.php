<?php

namespace App\Models;

use Database\Factories\SocialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    /** @use HasFactory<SocialFactory> */
    use HasFactory;

    protected $fillable = [
        'platform',
        'label',
        'value',
        'url',
        'icon',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];
}
