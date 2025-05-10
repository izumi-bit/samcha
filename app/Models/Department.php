<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description'];  

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
