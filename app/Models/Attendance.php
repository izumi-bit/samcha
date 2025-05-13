<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'department_id',
        'date',
        'time_in',
        'time_out',
        'status',
        'deduction_applied',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

  protected static function booted()
    {
        static::saving(function ($attendance) {
            $officialStart = '00:10:00';
            $officialEnd = '01:00:00';

            $now = now()->format('H:i:s');
            $timeIn = $attendance->time_in ? date('H:i:s', strtotime($attendance->time_in)) : null;
            $timeOut = $attendance->time_out ? date('H:i:s', strtotime($attendance->time_out)) : null;

            if ($timeIn) {
                $attendance->status = ($timeIn > $officialStart) ? 'late' : 'on time';

                if ($timeOut && $timeOut < $officialEnd) {
                    $attendance->status = 'undertime';
                }
            } elseif ($now > $officialEnd) {
                $attendance->status = 'absent';
            }



        // Apply deduction if late
        if ($attendance->status === 'late') {
            $employee = $attendance->employee;
            if ($employee && !$attendance->deduction_applied) {
                $salary = $employee->salary;
                if ($salary) {
                    $deductionAmount = $salary->basic_salary * 0.10;
                    $salary->deductions += $deductionAmount;
                    $salary->net_salary = $salary->basic_salary + $salary->allowances - $salary->deductions;
                    $salary->save();
                    $attendance->deduction_applied = true;
                }
            }
        }
    });
}
}