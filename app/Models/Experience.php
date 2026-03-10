<?php

namespace App\Models;

use Database\Factories\ExperienceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /** @use HasFactory<ExperienceFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'title',
        'start_date',
        'end_date',
        'is_current',
        'responsibilities',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'responsibilities' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
