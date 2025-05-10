<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'cv',
        'age',
        'status',
        'human_resource_id',
        'password',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function salary()
{
    return $this->hasOne(Salary::class);
}
 public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
     public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }
}
