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
    public function positions()
{
    return $this->hasMany(Position::class);
}
    public function jobp()
{
    return $this->hasMany(jobp::class);
}
}
