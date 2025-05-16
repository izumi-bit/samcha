<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Jobp extends Model
{
       protected $fillable = [
        'title', 'department', 'description', 'location', 'deadline', 'is_active',
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];

    // Scope for active jobs
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true)->where('deadline', '>=', now());
    }
}
