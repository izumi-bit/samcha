<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Benefit extends Model
{
    protected $fillable = ['name', 'amount'];
    
    public function salaries(): BelongsToMany
{
    return $this->belongsToMany(Salary::class);
}
}
