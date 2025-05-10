<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'total_earnings',
        'total_deductions',
        'net_pay',
        'payment_date',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

}
