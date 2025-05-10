<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Salary extends Model
{
    protected $fillable = [
        'employee_id',
        'basic_salary',
        'allowances',
        'deductions',
        'salary_date',
    ];

    // Relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Many-to-Many relationship with Benefit
    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(Benefit::class);
    }

    // Computed total benefit amount
    public function getTotalBenefitsAttribute(): float
    {
        return $this->benefits->sum('amount');
    }

    // Computed net salary: basic + allowances - deductions - total_benefits
    public function getNetSalaryAttribute(): float
    {
        return ($this->basic_salary ?? 0)
             + ($this->allowances ?? 0)
             - ($this->deductions ?? 0)
             - ($this->total_benefits ?? 0);
    }
}